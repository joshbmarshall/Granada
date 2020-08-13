<?php

/**
 * This is the base model class for the database table 'timezone_test'
 *
 * Do not modify this file, it is overwritten via the db2model script
 */

namespace MyAppTest;

/**
 *
 * @method \MyAppTest\TimezoneTest find_pairs_representation(integer $limit) List of items in an array using the representation string
 * @method \MyAppTest\TimezoneTest find_one(integer $id) Find one matching record. If $id is set, get the pk record
 * @method \MyAppTest\TimezoneTest[] find_many() Find all matching records
 * @method \MyAppTest\QueryTimezoneTest raw_query(string $query, array $parameters) Perform a raw query. The query can contain placeholders in either named or question mark style. If placeholders are used, the parameters should be an array of values which will be bound to the placeholders in the query. If this method is called, all other query building methods will be ignored.
 * @method \MyAppTest\QueryTimezoneTest table_alias(string $alias) Add an alias for the main table to be used in SELECT queries
 * @method \MyAppTest\QueryTimezoneTest select(string $column, string $alias) Add a column to the list of columns returned by the SELECT query. This defaults to '*'. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryTimezoneTest select_expr(string $expr, string $alias) Add an unquoted expression to the list of columns returned by the SELECT query. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryTimezoneTest distinct() Add a DISTINCT keyword before the list of columns in the SELECT query
 * @method \MyAppTest\QueryTimezoneTest join(string $table, string $constraint, string $table_alias) Add a simple JOIN source to the query
 * @method \MyAppTest\QueryTimezoneTest inner_join(string $table, string[] $constraint, string) Add an INNER JOIN source to the query
 * @method \MyAppTest\QueryTimezoneTest left_outer_join(string $table, string[] $constraint, string $table_alias) Add a LEFT OUTER JOIN source to the query
 * @method \MyAppTest\QueryTimezoneTest limit(integer $number)Add a LiMiT to the query
 * @method \MyAppTest\QueryTimezoneTest offset(integer $offset) Add an OFFSET to the query
 * @method \MyAppTest\QueryTimezoneTest group_by(string $column_name) Add a column to the list of columns to GROUP BY
 * @method \MyAppTest\QueryTimezoneTest group_by_expr(string $expr) Add an unquoted expression to the list of columns to GROUP BY
 * @method \MyAppTest\QueryTimezoneTest having(string $column_name, string $value) Add a HAVING column = value clause to your query. Each time this is called in the chain, an additional HAVING will be added, and these will be ANDed together when the final query is built.
 * @method \MyAppTest\QueryTimezoneTest having_equal(string $column_name, string $value) More explicitly named version of for the having() method. Can be used if preferred.
 * @method \MyAppTest\QueryTimezoneTest having_not_equal(string $column_name, string $value) Add a HAVING column != value clause to your query.
 * @method \MyAppTest\QueryTimezoneTest having_id_is(integer $id) Special method to query the table by its primary key
 * @method \MyAppTest\QueryTimezoneTest having_like(string $column_name, string $value) Add a HAVING ... LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest having_not_like(string $column_name, string $value) Add where HAVING ... NOT LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest having_gt(string $column_name, integer $value) Add a HAVING ... > clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_lt(string $column_name, string $value) Add a HAVING ... < clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_gte(string $column_name, string $value) Add a HAVING ... >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_lte(string $column_name, string $value) Add a HAVING ... <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_in(string $column_name, string[] $values) Add a HAVING ... IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_not_in(string $column_name, string[] $values) Add a HAVING ... NOT IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_null(string $column_name) Add a HAVING column IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_not_null(string $column_name) Add a HAVING column IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest having_raw(string $clause, string[] $parameters) Add a raw HAVING clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryTimezoneTest where_id(string $value) Add a WHERE id = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_not_equal(string $value) Add a WHERE id != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_like(string $value) Add a WHERE id LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest where_id_not_like(string $value) Add where WHERE id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest where_id_gt(string $value) Add a WHERE id > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_lt(string $value) Add a WHERE id < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_gte(string $value) Add a WHERE id >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_lte(string $value) Add a WHERE id <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_in(string $values) Add a WHERE id IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_not_in(string[] $values) Add a WHERE id NOT IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_null() Add a WHERE id IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_id_not_null() Add a WHERE id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_gt(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_lt(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_gte(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_lte(\Cake\Chronos\Chronos $value) Add a WHERE datetime1 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_null() Add a WHERE datetime1 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime1_not_null() Add a WHERE datetime1 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_gt(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_lt(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_gte(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_lte(\Cake\Chronos\Chronos $value) Add a WHERE datetime2 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_null() Add a WHERE datetime2 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime2_not_null() Add a WHERE datetime2 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_gt(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_lt(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_gte(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_lte(\Cake\Chronos\Chronos $value) Add a WHERE datetime3 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_null() Add a WHERE datetime3 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime3_not_null() Add a WHERE datetime3 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_gt(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_lt(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_gte(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_lte(\Cake\Chronos\Chronos $value) Add a WHERE datetime4 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_null() Add a WHERE datetime4 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime4_not_null() Add a WHERE datetime4 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_gt(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_lt(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_gte(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_lte(\Cake\Chronos\Chronos $value) Add a WHERE datetime5 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_null() Add a WHERE datetime5 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_datetime5_not_null() Add a WHERE datetime5 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1(\Cake\Chronos\Chronos $value) Add a WHERE date1 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE date1 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_gt(\Cake\Chronos\Chronos $value) Add a WHERE date1 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_lt(\Cake\Chronos\Chronos $value) Add a WHERE date1 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_gte(\Cake\Chronos\Chronos $value) Add a WHERE date1 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_lte(\Cake\Chronos\Chronos $value) Add a WHERE date1 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_null() Add a WHERE date1 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_date1_not_null() Add a WHERE date1 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1(string $value) Add a WHERE time1 = clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_not_equal(string $value) Add a WHERE time1 != clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_like(string $value) Add a WHERE time1 LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest where_time1_not_like(string $value) Add where WHERE time1 NOT LIKE clause to your query.
 * @method \MyAppTest\QueryTimezoneTest where_time1_gt(string $value) Add a WHERE time1 > clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_lt(string $value) Add a WHERE time1 < clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_gte(string $value) Add a WHERE time1 >= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_lte(string $value) Add a WHERE time1 <= clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_in(string $values) Add a WHERE time1 IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_not_in(string[] $values) Add a WHERE time1 NOT IN clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_null() Add a WHERE time1 IS NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_time1_not_null() Add a WHERE time1 IS NOT NULL clause to your query
 * @method \MyAppTest\QueryTimezoneTest where_raw(string $clause, array $parameters = NULL) Add a raw WHERE clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryTimezoneTest with(string $name) Eager-load data from another table
 * @method \MyAppTest\QueryTimezoneTest defaultFilter() Add a query to get default filter. Use as $items = TimezoneTest::model()->defaultFilter()->find_many();
 * @method \MyAppTest\QueryTimezoneTest order_by_id_asc() Add an ORDER BY column ASC clause for id
 * @method \MyAppTest\QueryTimezoneTest order_by_id_desc() Add an ORDER BY column DESC clause for id
 * @method \MyAppTest\QueryTimezoneTest order_by_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for id
 * @method \MyAppTest\QueryTimezoneTest order_by_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for id
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime1_asc() Add an ORDER BY column ASC clause for datetime1
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime1_desc() Add an ORDER BY column DESC clause for datetime1
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime1_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for datetime1
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime1_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for datetime1
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime2_asc() Add an ORDER BY column ASC clause for datetime2
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime2_desc() Add an ORDER BY column DESC clause for datetime2
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime2_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for datetime2
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime2_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for datetime2
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime3_asc() Add an ORDER BY column ASC clause for datetime3
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime3_desc() Add an ORDER BY column DESC clause for datetime3
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime3_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for datetime3
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime3_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for datetime3
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime4_asc() Add an ORDER BY column ASC clause for datetime4
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime4_desc() Add an ORDER BY column DESC clause for datetime4
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime4_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for datetime4
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime4_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for datetime4
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime5_asc() Add an ORDER BY column ASC clause for datetime5
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime5_desc() Add an ORDER BY column DESC clause for datetime5
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime5_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for datetime5
 * @method \MyAppTest\QueryTimezoneTest order_by_datetime5_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for datetime5
 * @method \MyAppTest\QueryTimezoneTest order_by_date1_asc() Add an ORDER BY column ASC clause for date1
 * @method \MyAppTest\QueryTimezoneTest order_by_date1_desc() Add an ORDER BY column DESC clause for date1
 * @method \MyAppTest\QueryTimezoneTest order_by_date1_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for date1
 * @method \MyAppTest\QueryTimezoneTest order_by_date1_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for date1
 * @method \MyAppTest\QueryTimezoneTest order_by_time1_asc() Add an ORDER BY column ASC clause for time1
 * @method \MyAppTest\QueryTimezoneTest order_by_time1_desc() Add an ORDER BY column DESC clause for time1
 * @method \MyAppTest\QueryTimezoneTest order_by_time1_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for time1
 * @method \MyAppTest\QueryTimezoneTest order_by_time1_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for time1
 * @method \MyAppTest\QueryTimezoneTest order_by_rand() Fetch items in a random order. Use sparingly and ensure a LIMIT is placed
 * @method \MyAppTest\QueryTimezoneTest order_by_expr(string $clause) Add an unquoted expression as an ORDER BY clause
 * @method \MyAppTest\QueryTimezoneTest order_by_list(string $column_name, integer[] $list) Add an ORDER BY FIELD column clause to make the ordering a specific sequence
 * @method \MyAppTest\QueryTimezoneTest onlyif(bool $condition, callable $query) Add a WHERE, ORDER BY or LIMIT clause only if the condition is true
 */

abstract class QueryTimezoneTest extends \MyAppTest\ORMBaseClass {
}
