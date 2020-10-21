<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\TaskInterface;

class TaskRepository extends BaseHelper implements TaskInterface
{
    public function getModel()
    {
        return \App\Models\Task::class;
    }
}
