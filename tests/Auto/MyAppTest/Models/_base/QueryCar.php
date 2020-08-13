<?php

/**
 * This is the base model class for the database table 'car'
 *
 * Do not modify this file, it is overwritten via the db2model script
 */

namespace MyAppTest;

/**
 *
 * @method \MyAppTest\Car find_pairs_representation(integer $limit) List of items in an array using the representation string
 * @method \MyAppTest\Car find_one(integer $id) Find one matching record. If $id is set, get the pk record
 * @method \MyAppTest\Car[] find_many() Find all matching records
 * @method \MyAppTest\QueryCar raw_query(string $query, array $parameters) Perform a raw query. The query can contain placeholders in either named or question mark style. If placeholders are used, the parameters should be an array of values which will be bound to the placeholders in the query. If this method is called, all other query building methods will be ignored.
 * @method \MyAppTest\QueryCar table_alias(string $alias) Add an alias for the main table to be used in SELECT queries
 * @method \MyAppTest\QueryCar select(string $column, string $alias) Add a column to the list of columns returned by the SELECT query. This defaults to '*'. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryCar select_expr(string $expr, string $alias) Add an unquoted expression to the list of columns returned by the SELECT query. The second optional argument is the alias to return the column as.
 * @method \MyAppTest\QueryCar distinct() Add a DISTINCT keyword before the list of columns in the SELECT query
 * @method \MyAppTest\QueryCar join(string $table, string $constraint, string $table_alias) Add a simple JOIN source to the query
 * @method \MyAppTest\QueryCar inner_join(string $table, string[] $constraint, string) Add an INNER JOIN source to the query
 * @method \MyAppTest\QueryCar left_outer_join(string $table, string[] $constraint, string $table_alias) Add a LEFT OUTER JOIN source to the query
 * @method \MyAppTest\QueryCar limit(integer $number)Add a LiMiT to the query
 * @method \MyAppTest\QueryCar offset(integer $offset) Add an OFFSET to the query
 * @method \MyAppTest\QueryCar group_by(string $column_name) Add a column to the list of columns to GROUP BY
 * @method \MyAppTest\QueryCar group_by_expr(string $expr) Add an unquoted expression to the list of columns to GROUP BY
 * @method \MyAppTest\QueryCar having(string $column_name, string $value) Add a HAVING column = value clause to your query. Each time this is called in the chain, an additional HAVING will be added, and these will be ANDed together when the final query is built.
 * @method \MyAppTest\QueryCar having_equal(string $column_name, string $value) More explicitly named version of for the having() method. Can be used if preferred.
 * @method \MyAppTest\QueryCar having_not_equal(string $column_name, string $value) Add a HAVING column != value clause to your query.
 * @method \MyAppTest\QueryCar having_id_is(integer $id) Special method to query the table by its primary key
 * @method \MyAppTest\QueryCar having_like(string $column_name, string $value) Add a HAVING ... LIKE clause to your query.
 * @method \MyAppTest\QueryCar having_not_like(string $column_name, string $value) Add where HAVING ... NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar having_gt(string $column_name, integer $value) Add a HAVING ... > clause to your query
 * @method \MyAppTest\QueryCar having_lt(string $column_name, string $value) Add a HAVING ... < clause to your query
 * @method \MyAppTest\QueryCar having_gte(string $column_name, string $value) Add a HAVING ... >= clause to your query
 * @method \MyAppTest\QueryCar having_lte(string $column_name, string $value) Add a HAVING ... <= clause to your query
 * @method \MyAppTest\QueryCar having_in(string $column_name, string[] $values) Add a HAVING ... IN clause to your query
 * @method \MyAppTest\QueryCar having_not_in(string $column_name, string[] $values) Add a HAVING ... NOT IN clause to your query
 * @method \MyAppTest\QueryCar having_null(string $column_name) Add a HAVING column IS NULL clause to your query
 * @method \MyAppTest\QueryCar having_not_null(string $column_name) Add a HAVING column IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar having_raw(string $clause, string[] $parameters) Add a raw HAVING clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryCar where_id(string $value) Add a WHERE id = clause to your query
 * @method \MyAppTest\QueryCar where_id_not_equal(string $value) Add a WHERE id != clause to your query
 * @method \MyAppTest\QueryCar where_id_like(string $value) Add a WHERE id LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_id_not_like(string $value) Add where WHERE id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_id_gt(string $value) Add a WHERE id > clause to your query
 * @method \MyAppTest\QueryCar where_id_lt(string $value) Add a WHERE id < clause to your query
 * @method \MyAppTest\QueryCar where_id_gte(string $value) Add a WHERE id >= clause to your query
 * @method \MyAppTest\QueryCar where_id_lte(string $value) Add a WHERE id <= clause to your query
 * @method \MyAppTest\QueryCar where_id_in(string $values) Add a WHERE id IN clause to your query
 * @method \MyAppTest\QueryCar where_id_not_in(string[] $values) Add a WHERE id NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_id_null() Add a WHERE id IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_id_not_null() Add a WHERE id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_name(string $value) Add a WHERE name = clause to your query
 * @method \MyAppTest\QueryCar where_name_not_equal(string $value) Add a WHERE name != clause to your query
 * @method \MyAppTest\QueryCar where_name_like(string $value) Add a WHERE name LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_name_not_like(string $value) Add where WHERE name NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_name_gt(string $value) Add a WHERE name > clause to your query
 * @method \MyAppTest\QueryCar where_name_lt(string $value) Add a WHERE name < clause to your query
 * @method \MyAppTest\QueryCar where_name_gte(string $value) Add a WHERE name >= clause to your query
 * @method \MyAppTest\QueryCar where_name_lte(string $value) Add a WHERE name <= clause to your query
 * @method \MyAppTest\QueryCar where_name_in(string $values) Add a WHERE name IN clause to your query
 * @method \MyAppTest\QueryCar where_name_not_in(string[] $values) Add a WHERE name NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_name_null() Add a WHERE name IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_name_not_null() Add a WHERE name IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id(string $value) Add a WHERE manufactor_id = clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_not_equal(string $value) Add a WHERE manufactor_id != clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_like(string $value) Add a WHERE manufactor_id LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_manufactor_id_not_like(string $value) Add where WHERE manufactor_id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_manufactor_id_gt(string $value) Add a WHERE manufactor_id > clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_lt(string $value) Add a WHERE manufactor_id < clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_gte(string $value) Add a WHERE manufactor_id >= clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_lte(string $value) Add a WHERE manufactor_id <= clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_in(string $values) Add a WHERE manufactor_id IN clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_not_in(string[] $values) Add a WHERE manufactor_id NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_null() Add a WHERE manufactor_id IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_manufactor_id_not_null() Add a WHERE manufactor_id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_owner_id(string $value) Add a WHERE owner_id = clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_not_equal(string $value) Add a WHERE owner_id != clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_like(string $value) Add a WHERE owner_id LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_owner_id_not_like(string $value) Add where WHERE owner_id NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_owner_id_gt(string $value) Add a WHERE owner_id > clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_lt(string $value) Add a WHERE owner_id < clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_gte(string $value) Add a WHERE owner_id >= clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_lte(string $value) Add a WHERE owner_id <= clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_in(string $values) Add a WHERE owner_id IN clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_not_in(string[] $values) Add a WHERE owner_id NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_null() Add a WHERE owner_id IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_owner_id_not_null() Add a WHERE owner_id IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_enabled(string $value) Add a WHERE enabled = clause to your query
 * @method \MyAppTest\QueryCar where_enabled_not_equal(string $value) Add a WHERE enabled != clause to your query
 * @method \MyAppTest\QueryCar where_enabled_like(string $value) Add a WHERE enabled LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_enabled_not_like(string $value) Add where WHERE enabled NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_enabled_gt(string $value) Add a WHERE enabled > clause to your query
 * @method \MyAppTest\QueryCar where_enabled_lt(string $value) Add a WHERE enabled < clause to your query
 * @method \MyAppTest\QueryCar where_enabled_gte(string $value) Add a WHERE enabled >= clause to your query
 * @method \MyAppTest\QueryCar where_enabled_lte(string $value) Add a WHERE enabled <= clause to your query
 * @method \MyAppTest\QueryCar where_enabled_in(string $values) Add a WHERE enabled IN clause to your query
 * @method \MyAppTest\QueryCar where_enabled_not_in(string[] $values) Add a WHERE enabled NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_enabled_null() Add a WHERE enabled IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_enabled_not_null() Add a WHERE enabled IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_stealth(string $value) Add a WHERE stealth = clause to your query
 * @method \MyAppTest\QueryCar where_stealth_not_equal(string $value) Add a WHERE stealth != clause to your query
 * @method \MyAppTest\QueryCar where_stealth_like(string $value) Add a WHERE stealth LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_stealth_not_like(string $value) Add where WHERE stealth NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_stealth_gt(string $value) Add a WHERE stealth > clause to your query
 * @method \MyAppTest\QueryCar where_stealth_lt(string $value) Add a WHERE stealth < clause to your query
 * @method \MyAppTest\QueryCar where_stealth_gte(string $value) Add a WHERE stealth >= clause to your query
 * @method \MyAppTest\QueryCar where_stealth_lte(string $value) Add a WHERE stealth <= clause to your query
 * @method \MyAppTest\QueryCar where_stealth_in(string $values) Add a WHERE stealth IN clause to your query
 * @method \MyAppTest\QueryCar where_stealth_not_in(string[] $values) Add a WHERE stealth NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_stealth_null() Add a WHERE stealth IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_stealth_not_null() Add a WHERE stealth IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted(string $value) Add a WHERE is_deleted = clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_not_equal(string $value) Add a WHERE is_deleted != clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_like(string $value) Add a WHERE is_deleted LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_is_deleted_not_like(string $value) Add where WHERE is_deleted NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_is_deleted_gt(string $value) Add a WHERE is_deleted > clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_lt(string $value) Add a WHERE is_deleted < clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_gte(string $value) Add a WHERE is_deleted >= clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_lte(string $value) Add a WHERE is_deleted <= clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_in(string $values) Add a WHERE is_deleted IN clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_not_in(string[] $values) Add a WHERE is_deleted NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_null() Add a WHERE is_deleted IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_is_deleted_not_null() Add a WHERE is_deleted IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_sort_order(string $value) Add a WHERE sort_order = clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_not_equal(string $value) Add a WHERE sort_order != clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_like(string $value) Add a WHERE sort_order LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_sort_order_not_like(string $value) Add where WHERE sort_order NOT LIKE clause to your query.
 * @method \MyAppTest\QueryCar where_sort_order_gt(string $value) Add a WHERE sort_order > clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_lt(string $value) Add a WHERE sort_order < clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_gte(string $value) Add a WHERE sort_order >= clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_lte(string $value) Add a WHERE sort_order <= clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_in(string $values) Add a WHERE sort_order IN clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_not_in(string[] $values) Add a WHERE sort_order NOT IN clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_null() Add a WHERE sort_order IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_sort_order_not_null() Add a WHERE sort_order IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_created_at(\Cake\Chronos\Chronos $value) Add a WHERE created_at = clause to your query
 * @method \MyAppTest\QueryCar where_created_at_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE created_at != clause to your query
 * @method \MyAppTest\QueryCar where_created_at_gt(\Cake\Chronos\Chronos $value) Add a WHERE created_at > clause to your query
 * @method \MyAppTest\QueryCar where_created_at_lt(\Cake\Chronos\Chronos $value) Add a WHERE created_at < clause to your query
 * @method \MyAppTest\QueryCar where_created_at_gte(\Cake\Chronos\Chronos $value) Add a WHERE created_at >= clause to your query
 * @method \MyAppTest\QueryCar where_created_at_lte(\Cake\Chronos\Chronos $value) Add a WHERE created_at <= clause to your query
 * @method \MyAppTest\QueryCar where_created_at_null() Add a WHERE created_at IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_created_at_not_null() Add a WHERE created_at IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_updated_at(\Cake\Chronos\Chronos $value) Add a WHERE updated_at = clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_not_equal(\Cake\Chronos\Chronos $value) Add a WHERE updated_at != clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_gt(\Cake\Chronos\Chronos $value) Add a WHERE updated_at > clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_lt(\Cake\Chronos\Chronos $value) Add a WHERE updated_at < clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_gte(\Cake\Chronos\Chronos $value) Add a WHERE updated_at >= clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_lte(\Cake\Chronos\Chronos $value) Add a WHERE updated_at <= clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_null() Add a WHERE updated_at IS NULL clause to your query
 * @method \MyAppTest\QueryCar where_updated_at_not_null() Add a WHERE updated_at IS NOT NULL clause to your query
 * @method \MyAppTest\QueryCar where_raw(string $clause, array $parameters = NULL) Add a raw WHERE clause to the query. The clause should contain question mark placeholders, which will be bound to the parameters supplied in the second argument.
 * @method \MyAppTest\QueryCar with(string $name) Eager-load data from another table
 * @method \MyAppTest\QueryCar defaultFilter() Add a query to get default filter. Use as $items = Car::model()->defaultFilter()->find_many();
 * @method \MyAppTest\QueryCar order_by_id_asc() Add an ORDER BY column ASC clause for id
 * @method \MyAppTest\QueryCar order_by_id_desc() Add an ORDER BY column DESC clause for id
 * @method \MyAppTest\QueryCar order_by_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for id
 * @method \MyAppTest\QueryCar order_by_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for id
 * @method \MyAppTest\QueryCar order_by_name_asc() Add an ORDER BY column ASC clause for name
 * @method \MyAppTest\QueryCar order_by_name_desc() Add an ORDER BY column DESC clause for name
 * @method \MyAppTest\QueryCar order_by_name_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for name
 * @method \MyAppTest\QueryCar order_by_name_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for name
 * @method \MyAppTest\QueryCar order_by_manufactor_id_asc() Add an ORDER BY column ASC clause for manufactor_id
 * @method \MyAppTest\QueryCar order_by_manufactor_id_desc() Add an ORDER BY column DESC clause for manufactor_id
 * @method \MyAppTest\QueryCar order_by_manufactor_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for manufactor_id
 * @method \MyAppTest\QueryCar order_by_manufactor_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for manufactor_id
 * @method \MyAppTest\QueryCar order_by_owner_id_asc() Add an ORDER BY column ASC clause for owner_id
 * @method \MyAppTest\QueryCar order_by_owner_id_desc() Add an ORDER BY column DESC clause for owner_id
 * @method \MyAppTest\QueryCar order_by_owner_id_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for owner_id
 * @method \MyAppTest\QueryCar order_by_owner_id_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for owner_id
 * @method \MyAppTest\QueryCar order_by_enabled_asc() Add an ORDER BY column ASC clause for enabled
 * @method \MyAppTest\QueryCar order_by_enabled_desc() Add an ORDER BY column DESC clause for enabled
 * @method \MyAppTest\QueryCar order_by_enabled_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for enabled
 * @method \MyAppTest\QueryCar order_by_enabled_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for enabled
 * @method \MyAppTest\QueryCar order_by_stealth_asc() Add an ORDER BY column ASC clause for stealth
 * @method \MyAppTest\QueryCar order_by_stealth_desc() Add an ORDER BY column DESC clause for stealth
 * @method \MyAppTest\QueryCar order_by_stealth_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for stealth
 * @method \MyAppTest\QueryCar order_by_stealth_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for stealth
 * @method \MyAppTest\QueryCar order_by_is_deleted_asc() Add an ORDER BY column ASC clause for is_deleted
 * @method \MyAppTest\QueryCar order_by_is_deleted_desc() Add an ORDER BY column DESC clause for is_deleted
 * @method \MyAppTest\QueryCar order_by_is_deleted_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for is_deleted
 * @method \MyAppTest\QueryCar order_by_is_deleted_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for is_deleted
 * @method \MyAppTest\QueryCar order_by_sort_order_asc() Add an ORDER BY column ASC clause for sort_order
 * @method \MyAppTest\QueryCar order_by_sort_order_desc() Add an ORDER BY column DESC clause for sort_order
 * @method \MyAppTest\QueryCar order_by_sort_order_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for sort_order
 * @method \MyAppTest\QueryCar order_by_sort_order_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for sort_order
 * @method \MyAppTest\QueryCar order_by_created_at_asc() Add an ORDER BY column ASC clause for created_at
 * @method \MyAppTest\QueryCar order_by_created_at_desc() Add an ORDER BY column DESC clause for created_at
 * @method \MyAppTest\QueryCar order_by_created_at_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for created_at
 * @method \MyAppTest\QueryCar order_by_created_at_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for created_at
 * @method \MyAppTest\QueryCar order_by_updated_at_asc() Add an ORDER BY column ASC clause for updated_at
 * @method \MyAppTest\QueryCar order_by_updated_at_desc() Add an ORDER BY column DESC clause for updated_at
 * @method \MyAppTest\QueryCar order_by_updated_at_natural_asc() Add an ORDER BY column ASC clause using natural sorting method for updated_at
 * @method \MyAppTest\QueryCar order_by_updated_at_natural_desc() Add an ORDER BY column DESC clause using natural sorting method for updated_at
 * @method \MyAppTest\QueryCar order_by_rand() Fetch items in a random order. Use sparingly and ensure a LIMIT is placed
 * @method \MyAppTest\QueryCar order_by_expr(string $clause) Add an unquoted expression as an ORDER BY clause
 * @method \MyAppTest\QueryCar order_by_list(string $column_name, integer[] $list) Add an ORDER BY FIELD column clause to make the ordering a specific sequence
 * @method \MyAppTest\QueryCar onlyif(bool $condition, callable $query) Add a WHERE, ORDER BY or LIMIT clause only if the condition is true
 */

abstract class QueryCar extends \MyAppTest\ORMBaseClass {
}
