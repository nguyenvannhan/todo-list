<?php

namespace App\Core\Repositories\Contracts;

interface BaseInterface
{
    /**
     * Find item with ID
     *
     * @param $id ID of Eloquen
     * @param $with Eager Loading Array
     * @param $withTrashed Get Trashed
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, $withTrashed = false, $with = [], $columns = ['*']);

    /**
     * Find item with ID Or Fail
     *
     * @param $id ID of Eloquen
     * @param $with Eager Loading Array
     * @param $withTrashed Get Trashed
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id, $withTrashed = false, $with = [], $columns = ['*']);

    /**
     * Find or Create New Item
     *
     * @param $id ID of Eloquen
     * @param $with Eager Loading Array
     * @param $withTrashed Get Trashed
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrNew($id, $withTrashed = false, $with = [], $columns = ['*']);

    /**
     * Create item
     *
     * @param
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data);

    /**
     * Update item
     *
     * @param $id ID of Eloquen
     * @param $data Array of updated data
     * @param $withTrashed Get Trashed
     *
     * @return bool
     */
    public function update($id, $data, $withTrashed = false);

    /**
     * Get List
     */
    public function getList($columns = ['*'], $options = []);

    /**
     * Get First Element in List
     */
    public function getFirst($columns = ['*'], $option = []);

    /**
     * Get List with Many Ids
     */
    public function findMany($ids, $options = []);

    /**
     * Helper function to build query
     */
    public function buildQuery($query, $option = []);

    /**
     * Helper function to build columns array to get when query
     */
    public function getColumnsInfo($options);

    /**
     * Check Paginate and Get List
     */
    public function checkPaginate($query, $options = []);
}
