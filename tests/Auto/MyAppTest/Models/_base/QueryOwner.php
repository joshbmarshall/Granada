<?php

/**
 * This is the base model class for the database table 'owner'
 *
 * Do not modify this file, it is overwritten via the db2model script
 */

namespace MyAppTest;

/**
 *
 * @method \MyAppTest\Owner find_pairs_representation(integer $limit) List of items in an array using the representation string
 * @method \MyAppTest\Owner find_one(integer $id) Find one matching record. If $id is set, get the pk record
 * @method \MyAppTest\Owner[] find_many() Find all matching records
 * @method \MyAppTest\QueryOwner raw_query(string $query, array $parameters) Perform a raw query. The query can contain placeholders in either named or question mark style. If placeholders are used, the parameters should be an array of values which will be bound to the placeholders in the query. If this method is called, all other query building methods will be ignored.
 * @method \MyAppTest\QueryOwner table_alias(string $alias) Add an alias for the main table to be used in SELECT queries
 * @method \MyAppTest\QueryOwner select(string $column, string $alias) Add a column to the list of columns returned by the SELECT query. This defaults to '*'. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryOwner select_expr(string $expr, string $alias) Add an unquoted expression to the list of columns returned by the SELECT query. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryOwner distinct() Add a DISTINCT keyword before the list of columns in the SELECT query
 * @method \MyAppTest\QueryOwner join(string $table, string $constraint, string $table_alias) Add a simple JOIN source to the query
 * @method \MyAppTest\QueryOwner inner_join(string $table, string[] $constraint, string) Add an INNER JOIN source to the query
 * @method \MyAppTest\QueryOwner left_outer_join(string $table, string[] $constraint, string $table_alias) Add a LEFT OUTER JOIN source to the query
 * @method \MyAppTest\QueryOwner limit(integer $number)Add a LiMiT to the query
 * @method \MyAppTest\QueryOwner offset(integer $offset) Add an OFFSET to the query
 * @method \MyAppTest\QueryOwner group_by(string $column_name) Add a column to the list of columns to GROUP BY
 * @method \MyAppTest\QueryOwner group_by_expr(string $expr) Add an unquoted expression to the list of columns to GROUP BY
 * @method \MyAppTest\QueryOwner having(string $column_name, string $value) Add a HAVING column = value clause to your query. Each time this is called in the chain, an additional HAVING will be added, and these will be ANDed together when the final query is built.
 * @method \MyAppTest\QueryOwner having_equal(string $column_name, string $value) More explicitly named version of for the having() method. Can be used if preferred.
 * @method \MyAppTest\QueryOwner having_not_equal(string $column_name, string $value) Add a HAVING column != value clause to your query.
 * @method \MyAppTest\QueryOwner having_id_is(integer $id) Special method to query the table by its primary key
 * @method \MyAppTest\QueryOwner having_like(string $column_name, string $value) Add a HAVING ... LIKE clause to your query.
 * @method \MyAppTest\QueryOwner having_not_like(string $column_name, string $value) Add where HAVING ... NOT LIKE clause to your query.
 * @method \MyAppTest\QueryOwner having_gt(string $column_name, integer $value) Add a HAVING ... > clause to your query
 * @method \MyAppTest\QueryOwner having_lt(string $column_name, string $value) Add a HAVING ... < clause to your query
 * @method \MyAppTest\QueryOwner having_gte(string $column_name, string $value) Add a HAVING ... >= clause to your query
 * @method \MyAppTest\QueryOwner having_lte(string $column_name, string $value) Add a HAVING ... <= clause to your query
 * @method \MyAppTest\QueryOwner having_in(string $column_name, string[] $values) Add a HAVING ... IN clause to your query
 * @method \MyAppTest\QueryOwner having_not_in(string $column_name, string[] $values) Add a HAVING ... NOT IN clause to your query
 * @method \MyAppTest\QueryOwner having_null(string $column_name) Add a HAVING column IS NULL clause to your query
 * @method \MyAppTest\QueryOwner having_not_null(string $column_name) Add a HAVING column IS NOT NULL clause to your query
 * @method \MyAppTest\QueryOwner having_raw(string $clause, string[] $parameters) Add a raw HAVING clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryOwner where_id(string $value) Add a WHERE id = clause to your query
 * @method \MyAppTest\QueryOwner where_id_not_equal(string $value) Add a WHERE id != clause to your query
 * @method \MyAppTest\QueryOwner where_id_like(string $value) Add a WHERE id LIKE clause to your query.
 * @method \MyAppTest\QueryOwner where_id_not_like(string $value) Add where WHERE id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryOwner where_id_gt(string $value) Add a WHERE id > clause to your query
 * @method \MyAppTest\QueryOwner where_id_lt(string $value) Add a WHERE id < clause to your query
 * @method \MyAppTest\QueryOwner where_id_gte(string $value) Add a WHERE id >= clause to your query
 * @method \MyAppTest\QueryOwner where_id_lte(string $value) Add a WHERE id <= clause to your query
 * @method \MyAppTest\QueryOwner where_id_in(string $values) Add a WHERE id IN clause to your query
 * @method \MyAppTest\QueryOwner where_id_not_in(string[] $values) Add a WHERE id NOT IN clause to your query
 * @method \MyAppTest\QueryOwner where_id_null() Add a WHERE id IS NULL clause to your query
 * @method \MyAppTest\QueryOwner where_id_not_null() Add a WHERE id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryOwner where_name(string $value) Add a WHERE name = clause to your query
 * @method \MyAppTest\QueryOwner where_name_not_equal(string $value) Add a WHERE name != clause to your query
 * @method \MyAppTest\QueryOwner where_name_like(string $value) Add a WHERE name LIKE clause to your query.
 * @method \MyAppTest\QueryOwner where_name_not_like(string $value) Add where WHERE name NOT LIKE clause to your query.
 * @method \MyAppTest\QueryOwner where_name_gt(string $value) Add a WHERE name > clause to your query
 * @method \MyAppTest\QueryOwner where_name_lt(string $value) Add a WHERE name < clause to your query
 * @method \MyAppTest\QueryOwner where_name_gte(string $value) Add a WHERE name >= clause to your query
 * @method \MyAppTest\QueryOwner where_name_lte(string $value) Add a WHERE name <= clause to your query
 * @method \MyAppTest\QueryOwner where_name_in(string $values) Add a WHERE name IN clause to your query
 * @method \MyAppTest\QueryOwner where_name_not_in(string[] $values) Add a WHERE name NOT IN clause to your query
 * @method \MyAppTest\QueryOwner where_name_null() Add a WHERE name IS NULL clause to your query
 * @method \MyAppTest\QueryOwner where_name_not_null() Add a WHERE name IS NOT NULL clause to your query
 * @method \MyAppTest\QueryOwner where_raw(string $clause, array $parameters = NULL) Add a raw WHERE clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryOwner with(string $name) Eager-load data from another table
 * @method \MyAppTest\QueryOwner defaultFilter() Add a query to get default filter. Use as $items = Owner::model()->defaultFilter()->find_many();
 * @method \MyAppTest\QueryOwner order_by_id_asc() Add an ORDER BY column ASC clause for id
 * @method \MyAppTest\QueryOwner order_by_id_desc() Add an ORDER BY column DESC clause for id
 * @method \MyAppTest\QueryOwner order_by_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for id
 * @method \MyAppTest\QueryOwner order_by_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for id
 * @method \MyAppTest\QueryOwner order_by_name_asc() Add an ORDER BY column ASC clause for name
 * @method \MyAppTest\QueryOwner order_by_name_desc() Add an ORDER BY column DESC clause for name
 * @method \MyAppTest\QueryOwner order_by_name_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for name
 * @method \MyAppTest\QueryOwner order_by_name_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for name
 * @method \MyAppTest\QueryOwner order_by_rand() Fetch items in a random order. Use sparingly and ensure a LIMIT is placed
 * @method \MyAppTest\QueryOwner order_by_expr(string $clause) Add an unquoted expression as an ORDER BY clause
 * @method \MyAppTest\QueryOwner order_by_list(string $column_name, integer[] $list) Add an ORDER BY FIELD column clause to make the ordering a specific sequence
 * @method \MyAppTest\QueryOwner onlyif(bool $condition, callable $query) Add a WHERE, ORDER BY or LIMIT clause only if the condition is true
 */

abstract class QueryOwner extends \MyAppTest\ORMBaseClass {
}
