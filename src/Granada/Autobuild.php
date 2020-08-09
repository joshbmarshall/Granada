<?php

namespace Granada;

class Autobuild extends ORM {

	private static $_use_namespaces = false;
	private static $_default_namespace = 'Auto';
	private static $_plural_tables = [];

	public static function setUseNamespaces($val) {
		self::$_use_namespaces = $val;
	}

	public static function setDefaultNamespace($val) {
		self::$_default_namespace = $val;
	}

	public static function setPluralTables($val) {
		self::$_plural_tables = $val;
	}

	public static function getNamespace($tablename) {
		if (self::$_use_namespaces) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}

			$tablename_split = preg_split("/_/", $tablename, 2);
			$namespace = ucfirst($tablename_split[0]);
		} else {
			$namespace = self::$_default_namespace;
		}
		return $namespace;
	}

	public static function getModelName($tablename) {
		if (self::$_use_namespaces) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}

			$tablename_split = preg_split("/_/", $tablename, 2);
			$modelname = ucfirst(\Granada\Autobuild::to_camel_case($tablename_split[1]));
		} else {
			$modelname = ucfirst(\Granada\Autobuild::to_camel_case($tablename));
		}
		if (in_array($tablename, self::$_plural_tables)) {
			$modelname = \Granada\Autobuild::singularize($modelname);
		}
		// Ensure no numeric-starting models
		if (is_numeric(substr($modelname, 0, 1))) {
			$modelname = 'A' . $modelname;
		}
		return $modelname;
	}

	public static function getHumanName($tablename) {
		if (self::$_use_namespaces) {
			if (strpos($tablename, '_') === FALSE) {
				// Avoid tables that don't need a model as not a namespace
				return '';
			}

			$tablename_split = preg_split("/_/", $tablename, 2);
			$humanName = ucwords(str_replace('_', ' ', $tablename_split[1]));
		} else {
			$humanName = ucwords(str_replace('_', ' ', $tablename));
		}
		if (in_array($tablename, self::$_plural_tables)) {
			$humanName = \Granada\Autobuild::singularize($humanName);
		}
		return $humanName;
	}

	/**
	 * Translates a string with underscores into camel case (e.g. first_name -> firstName)
	 * @param string $str String in underscore format
	 * @return string
	 */
	public static function to_camel_case($str) {
		return \Doctrine\Inflector\InflectorFactory::create()->build()->camelize($str);
	}

	/**
	 * Converts a word to its plural form.
	 * @param string $name the word to be pluralized
	 * @param integer $count Optional - if set to 1 will not pluralize
	 * @return string the pluralized word
	 */
	public static function pluralize($name, $count = 0) {
		if ($count == 1) {
			return $name;
		}
		return \Doctrine\Inflector\InflectorFactory::create()->build()->pluralize($name);
	}

	/**
	 * Converts a word to its singular form
	 * @param mixed $name
	 * @return string
	 */
	public static function singularize($name) {
		return \Doctrine\Inflector\InflectorFactory::create()->build()->singularize($name);
	}

	public static function getTables() {

		$tables = array();
		$result = self::for_table('post')->raw_query('SHOW TABLES')->find_array();

		foreach ($result as $table) {
			$tables[] = array_pop($table);
		}

		return $tables;
	}

	public static function getCurDB() {
		$dbname = self::for_table('ost')->raw_query('SELECT DATABASE() as dbname')->find_one();

		return $dbname['dbname'];
	}

	public static function getBelongsTo($tablename) {
		$tablefields = self::for_table('ost')->raw_query('
			SELECT
				table_name,
				column_name,
				referenced_table_name,
				referenced_column_name
			FROM
				information_schema.key_column_usage
			WHERE
				referenced_table_name is not null
			AND
				constraint_schema="' . self::getCurDB() . '"
			AND
				table_name="' . $tablename . '"')->find_array();

		$belongsTo = array();
		foreach ($tablefields as $tablefield) {
			$namespace = \Granada\Autobuild::getNamespace($tablefield['referenced_table_name']);
			$modelname = \Granada\Autobuild::getModelName($tablefield['referenced_table_name']);
			$varname = $tablefield['column_name'];
			if (substr($varname, -3) == '_id') {
				$arvarname = substr($varname, 0, -3);
			} else {
				$arvarname = $varname;
			}

			$belongsTo[] = array(
				'varname' => $varname,
				'namespace' => $namespace,
				'modelname' => $modelname,
				'arvarname' => $arvarname,
			);
		}

		return $belongsTo;
	}

	public static function getHasMany($tablename) {
		$tablefields = self::for_table('ost')->raw_query('
			SELECT
				table_name,
				column_name,
				referenced_table_name,
				referenced_column_name
			FROM
				information_schema.key_column_usage
			WHERE
				constraint_schema="' . self::getCurDB() . '"
			AND
				referenced_table_name="' . $tablename . '"')->find_array();

		$hasMany = array();
		$arvars = array();
		foreach ($tablefields as $tablefield) {
			$namespace = \Granada\Autobuild::getNamespace($tablefield['table_name']);
			$modelname = \Granada\Autobuild::getModelName($tablefield['table_name']);
			$arvarname = lcfirst(self::pluralize($modelname));
			$varname = $tablefield['column_name'];
			if (!array_key_exists($arvarname, $arvars)) {
				$arvars[$arvarname] = 0;
			}

			$foreigntablefields = self::for_table('ost')->raw_query('SHOW FULL COLUMNS FROM `' . $tablefield['table_name'] . '`')->find_array();
			$defaultorder = '';
			foreach ($foreigntablefields as $foreigntablefield) {
				if ($foreigntablefield['Field'] == 'sort_order') {
					$defaultorder = 'sort_order';
				}
			}
			$hasMany[] = array(
				'varname' => $varname,
				'namespace' => $namespace,
				'modelname' => $modelname,
				'arvarname' => $arvarname . ($arvars[$arvarname] ? $arvars[$arvarname] : ''),
				'defaultorder' => $defaultorder,
			);
			$arvars[$arvarname]++;
		}

		return $hasMany;
	}

	/**
	 * Get the table structure from the database
	 *
	 * @param string $tablename
	 * @return Array Structure of the table
	 */
	public static function getStructure($tablename, $namespace, $modelname, $humanName) {
		$tablefields = self::for_table('ost')->raw_query('SHOW FULL COLUMNS FROM `' . $tablename . '`')->find_array();

		// Build model files for table

		$representation = '';
		$defaultorder = '';

		$structure = array();
		$fieldnames = array();
		$canSendMessage = false;
		$deleteForReal = true;
		foreach ($tablefields as $tablefield) {
			if ($tablefield['Null'] == 'NO') {
				$notnull = true;
			} else {
				$notnull = false;
			}
			$trimmed = trim($tablefield['Type']);
			if (strpos($trimmed, ')') === FALSE) {
				$first = $trimmed;
				$length = 0;
			} else {
				list($first, $length) = explode('(', trim($trimmed, ')'));
			}

			$comment = $tablefield['Comment'];
			// Get all the flags from the comment
			$commentwords = explode(' ', trim($comment));
			$helptext = '';
			$commentflags = '';
			$formtab = 'General';
			$cflags = array();
			$file_suffix = '';
			$formfeature = '';
			$formpermission = '';
			$formpermissionNamespace = '';
			$formpermissionModel = '';
			$join_table_checkboxes = '';
			foreach ($commentwords as $commentword) {
				if (substr($commentword, 0, 1) == '_') {
					$commentflags .= ' ' . $commentword;
					$cflags[$commentword] = true;
				} else {
					$helptext .= ' ' . $commentword;
				}
				if (substr($commentword, 0, 5) == '_tab_') {
					$formtab = str_replace('_', ' ', substr($commentword, 5));
				}
				if (substr($commentword, 0, 13) == '_file_suffix_') {
					$file_suffix = '.' . substr($commentword, 13);
				}
				if (substr($commentword, 0, 9) == '_feature_') {
					$formfeature = substr($commentword, 9);
				}
				if (substr($commentword, 0, 12) == '_permission_') {
					$testpermission = substr($commentword, 12);

					list($formpermissionNamespace, $formpermissionModel, $formpermission) = explode('\\', $testpermission);
				}
				if (substr($commentword, 0, 23) == '_join_table_checkboxes_') {
					$join_table_checkboxes = substr($commentword, 23);
				}
			}
			$required = ($tablefield['Null'] == 'NO') ? 'true' : 'false';

			$tablefieldname = $tablefield['Field'];
			$displayname = ucwords(str_replace('_', ' ', $tablefieldname));

			$hasMany = self::getHasMany($tablename);
			$belongsTo = self::getBelongsTo($tablename);

			$ref_fields = array();
			foreach ($belongsTo as $btitem) {
				$ref_fields[] = $btitem['varname'];
			}

			if (!$representation) {
				if ($tablefield['Null'] == 'NO') {
					if ($tablefield['Key'] != 'PRI') {
						if (!array_key_exists('_imageupload', $cflags)) {
							if (!array_key_exists('_fileupload', $cflags)) {
								if (!in_array($tablefieldname, $ref_fields)) {
									$representation = $tablefieldname;
								}
							}
						}
					}
				}
			}
			if ($tablefieldname == 'sort_order') {
				$defaultorder = 'sort_order';
			}
			$belongsToModel = '';
			$belongsToModelURL = '';

			$options = array();
			$unique = false;
			$doctype = 'string';
			$tftype = '';
			if ($tablefieldname == 'url') {
				$unique = true;
			}
			if ($tablefield['Key'] == 'UNI') {
				$unique = true;
			}
			if (array_key_exists('_imagehidden', $cflags)) {
				$imagehidden = true;
			} else {
				$imagehidden = false;
			}
			if (array_key_exists('_noxss', $cflags)) {
				$ignorexss = true;
			} else {
				$ignorexss = false;
			}
			if (array_key_exists('_readonly', $cflags)) {
				$readonly = true;
			} else {
				$readonly = false;
			}
			if (array_key_exists('_remove_prefix', $cflags)) {
				$remove_prefix = true;
			} else {
				$remove_prefix = false;
			}
			if ($tablefieldname == 'is_deleted') {
				$readonly = true;
				$deleteForReal = false;
			}
			if (array_key_exists('_capitalise', $cflags)) {
				$capitalise = true;
			} else {
				$capitalise = false;
			}
			if (array_key_exists('_ucfirst', $cflags)) {
				$ucfirst = true;
			} else {
				$ucfirst = false;
			}
			if (array_key_exists('_currency', $cflags)) {
				$tftype = 'currency';
				$doctype = 'string';
			} else if (array_key_exists('_percent', $cflags)) {
				$tftype = 'percent';
				$doctype = 'string';
			} else if ($tablefieldname == 'email') {
				$tftype = 'email';
				$doctype = 'string';
			} else if (array_key_exists('_email', $cflags)) {
				$tftype = 'email';
				$doctype = 'string';
			} else if (array_key_exists('_json', $cflags)) {
				$tftype = 'json';
				$doctype = 'string';
				$ignorexss = true;
			} else if (array_key_exists('_serialize', $cflags)) {
				$tftype = 'serialize';
				$doctype = 'string';
				$ignorexss = true;
			} else if (array_key_exists('_phone', $cflags)) {
				$tftype = 'phone';
				$doctype = 'string';
			} else if (array_key_exists('_telephone', $cflags)) {
				$tftype = 'phone';
				$doctype = 'string';
			} else if (array_key_exists('_abn', $cflags)) {
				$tftype = 'abn';
				$doctype = 'string';
			} else if (array_key_exists('_dob', $cflags)) {
				$tftype = 'dob';
				$doctype = 'date';
			} else if (array_key_exists('_signature', $cflags)) {
				$tftype = 'signature';
				$doctype = '\Cognito\ImageOutput';
				$ignorexss = true;
			} else if (array_key_exists('_cameraupload', $cflags)) {
				$tftype = 'cameraupload';
				$doctype = '\Cognito\ImageOutput';
				$ignorexss = true;
			} else if (array_key_exists('_imageupload', $cflags)) {
				$tftype = 'imageupload';
				$doctype = '\Cognito\ImageOutput';
				$ignorexss = true;
			} else if (array_key_exists('_fileupload', $cflags)) {
				if (array_key_exists('_compressfile', $cflags)) {
					$tftype = 'fileuploadcompressed';
				} else {
					$tftype = 'fileupload';
				}
				$doctype = '\Cognito\FileOutput';
				$ignorexss = true;
			} else if ($first == 'timestamp') {
				$tftype = 'datetime';
				$doctype = 'string';
			} else if ($first == 'datetime') {
				$tftype = 'datetime';
				$doctype = 'string';
			} else if ($first == 'time') {
				$tftype = 'time';
				$doctype = 'string';
			} else if ($first == 'date') {
				$tftype = 'date';
				$doctype = 'string';
			} else if ($first == 'float') {
				$tftype = 'float';
				$doctype = 'float';
			} else if ($first == 'decimal') {
				$tftype = 'float';
				$doctype = 'float';
			} else if (($first == 'int') || ($first == 'tinyint')) {
				if ($length == '1') {
					if (isset($tablefield['Default'])) {
						$tftype = 'bool';
						$doctype = 'bool';
						$required = 'false';
					} else {
						$tftype = 'booltristate';
						$doctype = 'bool';
					}
				} else {
					$tftype = 'integer';
					$doctype = 'integer';
					foreach ($belongsTo as $belongsToItem) {
						if ($belongsToItem['varname'] == $tablefieldname) {
							$tftype = 'reference';
							$belongsToModel = '\\' . $belongsToItem['namespace'] . '\\' . $belongsToItem['modelname'];
							$belongsToModelURL = lcfirst($belongsToItem['namespace']) . '/' . lcfirst($belongsToItem['modelname']);
							if (substr($tablefieldname, -3) == '_id') {
								$displayname = ucwords(str_replace('_', ' ', substr($tablefieldname, 0, -3)));
							} else {
								$displayname = ucwords(str_replace('_', ' ', $tablefieldname));
							}
							if ($belongsToModel == '\\Cognito\\User') {
								$canSendMessage = $tablefieldname;
							}
						}
					}
				}
			} else if ($first == 'enum') {
				$tftype = 'enum'; //todo rest of options
				$doctype = 'string';
				$options = trim(substr($tablefield['Type'], 4), '()');
			} else if ($first == 'varchar') {
				if ($length == '1') {
					$tftype = 'character';
					$doctype = 'string';
				} else if (array_key_exists('_modelpicker', $cflags)) {
					$tftype = 'model';
				} else if (array_key_exists('_colorpicker', $cflags)) {
					$tftype = 'color';
				} else if (array_key_exists('_colour', $cflags)) {
					$tftype = 'color';
				} else if (array_key_exists('_address', $cflags)) {
					$tftype = 'address';
				} else if ($length <= 255) {
					$tftype = 'string';
					$doctype = 'string';
				} else if ($length <= 2048) {
					$tftype = 'text';
					$doctype = 'string';
				}
			} else if (($first == 'text') || ($first == 'mediumtext')) {
				if (array_key_exists('_csssource', $cflags)) {
					$tftype = 'css';
				} else if (array_key_exists('_jssource', $cflags)) {
					$tftype = 'js';
					$ignorexss = true;
				} else if (array_key_exists('_jsonld', $cflags)) {
					$tftype = 'jsonld';
				} else if (array_key_exists('_htmlsource', $cflags)) {
					$tftype = 'html';
				} else if (array_key_exists('_pagebuilder', $cflags)) {
					$tftype = 'pagebuilder';
				} else if (array_key_exists('_formbuilder', $cflags)) {
					$tftype = 'formbuilder';
				} else if (array_key_exists('_image', $cflags)) {
					$tftype = 'image';
					$ignorexss = true;
				} else {
					$tftype = 'richtext';
				}
				$doctype = 'string';
			}
			$hidden_in_forms = false;
			if ($tablefieldname == 'id') {
				$hidden_in_forms = true;
			}
			if (array_key_exists('_hidden', $cflags)) {
				$hidden_in_forms = true;
			}

			if (array_key_exists('_timezone_none', $cflags)) {
				$timezone_mode = 'none';
			} else if (array_key_exists('_timezone_sitewide', $cflags)) {
				$timezone_mode = 'site';
			} else {
				$timezone_mode = 'user';
			}

			if (array_key_exists('_timezone_compare_user', $cflags)) {
				$timezone_comparison_mode = 'user';
			} else if (array_key_exists('_timezone_compare_sitewide', $cflags)) {
				$timezone_comparison_mode = 'site';
			} else {
				$timezone_comparison_mode = 'none';
			}

			if ($tftype == 'time') {
				// Force no timezone for time
				$timezone_mode = 'none';
				$timezone_comparison_mode = 'none';
			}
			if ($remove_prefix) {
				$displayname = substr($displayname, strpos($displayname, ' ') + 1);
			}
			if ($tablefieldname == 'created_by_id') {
				$readonly = true;
			}
			$structure[$tablefieldname] = array(
				'name' => $tablefieldname,
				'arvarname' => substr($tablefieldname, 0, -3),
				'displayname' => $displayname,
				'helptext' => trim($helptext),
				'formtab' => $formtab,
				'formpermissionNamespace' => $formpermissionNamespace,
				'formpermissionModel' => $formpermissionModel,
				'formpermission' => $formpermission,
				'formfeature' => $formfeature,
				'file_suffix' => $file_suffix,
				'type' => $tftype,
				'ignorexss' => $ignorexss,
				'doctype' => $doctype,
				'capitalise' => $capitalise,
				'readonly' => $readonly,
				'imagehidden' => $imagehidden,
				'remove_prefix' => $remove_prefix,
				'unique' => $unique,
				'ucfirst' => $ucfirst,
				'belongsToModel' => $belongsToModel,
				'belongsToModelURL' => $belongsToModelURL,
				'options' => $options,
				'length' => $length,
				'notnull' => $notnull,
				'required' => $required,
				'hidden_in_forms' => $hidden_in_forms,
				'default_value' => $tablefield['Default'],
				'timezone_mode' => $timezone_mode,
				'timezone_comparison_mode' => $timezone_comparison_mode,
				'join_table_checkboxes' => $join_table_checkboxes,
			);
			$fieldnames[] = $tablefieldname;
		}

		if ((in_array('created_at', $fieldnames)) && (in_array('updated_at', $fieldnames))) {
			$trackChangeTime = true;
			$structure['created_at']['hidden_in_forms'] = true;
			$structure['updated_at']['hidden_in_forms'] = true;
		} else {
			$trackChangeTime = false;
		}

		if ((in_array('root', $fieldnames)) && (in_array('level', $fieldnames)) && (in_array('lft', $fieldnames)) && (in_array('rgt', $fieldnames))) {
			$nestedSet = true;
			$structure['root']['hidden_in_forms'] = true;
			$structure['lft']['hidden_in_forms'] = true;
			$structure['rgt']['hidden_in_forms'] = true;
			$structure['level']['hidden_in_forms'] = true;
		} else {
			$nestedSet = false;
		}

		// Do some checks

		$model_vars = array();
		foreach ($structure as $var) {
			$model_vars[$var['name']] = 'structure';
		}

		foreach ($hasMany as $var) {
			$vname = $var['arvarname'];
			if (array_key_exists($vname, $model_vars)) {
				echo '\\' . $namespace . '\\' . $modelname . '::$' . $vname . ' already exists as a ' . $model_vars[$vname] . PHP_EOL;
			}
			$model_vars[$vname] = 'hasMany';
		}

		foreach ($belongsTo as $var) {
			$vname = $var['arvarname'];
			if (array_key_exists($vname, $model_vars)) {
				echo '\\' . $namespace . '\\' . $modelname . '::$' . $vname . ' already exists as a ' . $model_vars[$vname] . PHP_EOL;
			}
			$model_vars[$vname] = 'belongsTo';
		}

		if (!$representation) {
			$representation = 'id';
		}
		return array(
			'humanName' => $humanName,
			'representation' => $representation,
			'defaultorder' => $defaultorder ? $defaultorder : $representation,
			'tablename' => $tablename,
			'namespace' => $namespace,
			'modelname' => $modelname,
			'fields' => $tablefields,
			'structure' => $structure,
			'hasMany' => $hasMany,
			'belongsTo' => $belongsTo,
			'trackChangeTime' => $trackChangeTime,
			'canSendMessage' => $canSendMessage,
			'deleteForReal' => $deleteForReal,
			'nestedSet' => $nestedSet,
		);
	}

	/**
	 * Create the model files
	 * @param array $tabledata Information about the table
	 * @param string $modelpath path to output models to
	 * @param string $controllerpath path to output controllers to
	 */
	public static function createModels($tabledata, $model_base_path) {
		static $classmap = NULL;
		if (is_null($classmap)) {
			$classmap = array();
		}
		if (!$tabledata['modelname']) {
			return false;
		}

		$modelpath = $model_base_path . '/' . $tabledata['namespace'] . '/Models';
		$controllerpath = $model_base_path . '/' . $tabledata['namespace'] . '/Controllers';

		if (!file_exists($controllerpath)) {
			mkdir($controllerpath, 0755, true);
			// Only create the Models subfolder if we are creating a new Module, to support existing Modules with no Models subfolder
			if (!file_exists($modelpath)) {
				mkdir($modelpath, 0755, true);
			}
		}
		if (!file_exists($modelpath)) {
			$modelpath = dirname($modelpath);
		}

		$controllerfile = $controllerpath . '/' . $tabledata['modelname'] . 'Controller.php';
		$modelfile = $modelpath . '/' . $tabledata['modelname'] . '.php';
		$basefile = $modelpath . '/_base/Base' . $tabledata['modelname'] . '.php';
		$queryfile = $modelpath . '/_base/Query' . $tabledata['modelname'] . '.php';

		$basepath = dirname($basefile);
		if (!file_exists($basepath)) {
			mkdir($basepath, 0755, true);
		}

		// initialize Twig environment
		$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(__DIR__ . '/../autotemplates'));
		$twig->addFilter(new \Twig\TwigFilter('lcfirst', 'lcfirst'));

		file_put_contents($basefile, $twig->render('baseModelTemplate.twig', $tabledata));
		file_put_contents($queryfile, $twig->render('queryModelTemplate.twig', $tabledata));

		if (!file_exists($modelfile)) {
			file_put_contents($modelfile, $twig->render('modelTemplate.twig', $tabledata));
		}

		if (!file_exists($controllerfile)) {
			file_put_contents($controllerfile, $twig->render('controllerTemplate.twig', $tabledata));
		}
	}

	/**
	 * Entrypoint
	 */
	public static function doBuild($models_output_dir, $model_to_extend, $controller_model_to_extend, $use_namespaces, $default_namespace, $plural_tables) {

		$tables = \Granada\Autobuild::getTables($plural_tables);
		\Granada\Autobuild::setPluralTables($plural_tables);
		\Granada\Autobuild::setDefaultNamespace($default_namespace);
		\Granada\Autobuild::setUseNamespaces($use_namespaces);

		foreach ($tables as $table) {
			$namespace = \Granada\Autobuild::getNamespace($table);
			$modelname = \Granada\Autobuild::getModelName($table);
			$humanName = \Granada\Autobuild::getHumanName($table);

			$tabledata = \Granada\Autobuild::getStructure($table, $namespace, $modelname, $humanName);
			$tabledata['controllerToExtend'] = $controller_model_to_extend;
			$tabledata['modelToExtend'] = $model_to_extend;

			\Granada\Autobuild::createModels($tabledata, $models_output_dir);
		}
	}
}
