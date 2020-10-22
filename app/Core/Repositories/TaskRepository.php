<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\TaskInterface;

class TaskRepository extends BaseHelper implements TaskInterface
{
    public function getModel()
    {
        return \App\Models\Task::class;
    }

    public function getListByStatus($status, $options = [])
    {
        if (is_null($status)) {
            return $this->getList(['*'], $options);
        } elseif ($status == 'completed') {
            return $this->buildQuery($this->getModelToQuery()->whereCompleted(true), $options);
        } else {
            return $this->buildQuery($this->getModelToQuery()->whereCompleted(false), $options);
        }
    }
}
