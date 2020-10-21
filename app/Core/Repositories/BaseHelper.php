<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\BaseInterface;
use Illuminate\Support\Collection;

abstract class BaseHelper implements BaseInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get Model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    abstract public function getModel();

    /**
     * Set Model
     */
    public function setModel()
    {
        $this->model = app()->make($this->getModel());
    }

    /**
     * Get Model Query Object to query database
     */
    public function getModelToQuery($withTrashed = false)
    {
        return ($this->checkUsingSoftDeletes() && $withTrashed) ? $this->setCommonQueries($this->model->withTrashed()) : $this->setCommonQueries($this->model);
    }

    /**
     * Get Model Query Object with not Common Conditions
     *
     */
    public function getPurgeModelToQuery($withTrashed = false)
    {
        return ($this->checkUsingSoftDeletes() && $withTrashed) ? $this->model->withTrashed() : $this->model;
    }

    public function checkUsingSoftDeletes()
    {
        return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model)) && !$this->model->forceDeleting;
    }

    /**
     * Custom some conditions for query
     *
     * @param $query
     * @return mixed
     */
    public function setCommonQueries($query)
    {
        return $query;
    }

    /**
     * Find item with ID
     *
     * @param $id ID of Eloquent
     * @param $with Eager Loading Array
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, $withTrashed = false, $with = [], $columns = ['*'])
    {
        return $this->getModelToQuery($withTrashed)->with($with)->find($id, $columns);
    }

    /**
     * Find item with ID Or Fail
     *
     * @param $id ID of Eloquent
     * @param $with Eager Loading Array
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrFail($id, $withTrashed = false, $with = [], $columns = ['*'])
    {
        return $this->getModelToQuery($withTrashed)->with($with)->findOrFail($id, $columns);
    }

    /**
     * Find or Create New Item
     *
     * @param $id ID of Eloquent
     * @param $with Eager Loading Array
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrNew($id, $withTrashed = false, $with = [], $columns = ['*'])
    {
        return $this->getModelToQuery($withTrashed)->with($with)->findOrNew($id, $columns);
    }

    /**
     * Create item
     *
     * @param
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($data)
    {
        return $this->getModelToQuery()->create($data);
    }

    /**
     * Update item
     *
     * @param $id ID of Eloquent
     * @param $data Array of updated data
     *
     * @return bool
     */
    public function update($id, $data, $withTrashed = false)
    {
        return $this->getModelToQuery($withTrashed)->findOrFail($id)->update($data);
    }

    /**
     * Get List
     *
     * @param $columns List of Column
     * @param array $options Options of query
     *
     * @return Collection
     */
    public function getList($columns = ['*'], $options = [])
    {
        $options['columns'] = $columns;

        $query = $this->getModelToQuery();

        return $this->buildQuery($query, $options);
    }

    public function getFirst($columns = ['*'], $options = [])
    {
        $options['getFirst'] = true;

        return $this->getList($columns, $options);
    }

    /**
     * Get List with Many Ids
     */
    public function findMany($ids, $options = [])
    {
        $query = $this->getModelToQuery();

        $query = $query->whereIn('id', $ids);

        return $this->buildQuery($query, $options);
    }

    /**
     * Helper function to build query
     */
    public function buildQuery($query, $options = [])
    {
        if (count($options) === 0) {
            return $query->get();
        }

        if (isset($options['withTrashed']) && $this->checkUsingSoftDeletes()) {
            $query = $query->withTrashed();
        }

        if (isset($options['with'])) {
            $query = $query->with($options['with']);
        }

        if (isset($options['has']) && is_array($options['has'])) {
            foreach ($options['has'] as $has) {
                $query = $query->has($has);
            }
        }

        if (isset($options['whereHas']) && is_array($options['whereHas'])) {
            foreach ($options['whereHas'] as $has) {
                $query = $query->whereHas($has);
            }
        }

        if (isset($options['except_ids'])) {
            if (is_array($options['except_ids'])) {
                $query = $query->whereNotIn('id', $options['except_ids']);
            } else {
                $query = $query->where('id', '<>', $options['except_ids']);
            }
        }

        if (!isset($options['paginate'])) {
            // Skip Query
            if (isset($options['skip']) && is_numeric($options['skip'])) {
                $query = $query->skip($options['skip']);
                unset($options['skip']);
            }
            // Take Query
            if (isset($options['take']) && is_numeric($options['take'])) {
                $query = $query->take($options['take']);
                unset($options['take']);
            }
        }

        //OrderBy
        if (isset($options['orders'])) {
            if (is_string($options['orders']) && $options['orders'] == 'RAND') {
                $query = $query->inRandomOrder();
            } else {
                if (is_array($options['orders']) && count($options['orders']) > 0) {
                    foreach ($options['orders'] as $order) {
                        $query = $query->orderBy($order[0], $order[1]);
                    }
                }
            }
            unset($options['orders']);
        }

        return $this->checkPaginate($query, $options);
    }

    /**
     * Helper function to build columns array to get when query
     */
    public function getColumnsInfo($options)
    {
        if (!isset($options['columns'])) {
            return ['*'];
        }

        if (is_string($options['columns'])) {
            if (!empty($options['columns'])) {
                return explode(',', $options['columns']);
            }
            return ['*'];
        }

        if (is_array($options['columns']) && count($options['columns']) == 0) {
            return ['*'];
        }

        return $options['columns'];
    }

    /**
     * Check Paginate and Get List
     */
    public function checkPaginate($query, $options = [])
    {
        $columns = $this->getColumnsInfo($options);

        if (isset($options['paginate'])) {
            return $query->paginate($options['paginate'], $columns);
        }

        if (isset($options['getFirst'])) {
            return $query->first($columns);
        }

        if (isset($options['checkExists']) && $options['checkExists']) {
            return $query->exists();
        }

        if (isset($options['getCount']) && $options['getCount']) {
            return $query->count();
        }

        return $query->get($columns);
    }
}
