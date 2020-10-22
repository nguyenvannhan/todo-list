<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\TaskInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TaskRepository extends BaseHelper implements TaskInterface
{
    public function getModel()
    {
        return \App\Models\Task::class;
    }

    public function getListByStatus($status, $options = [])
    {
        $query = null;

        if (is_null($status)) {
            $query = $this->getModelToQuery();
        } elseif ($status == 'completed') {
            $query = $this->getModelToQuery()->whereCompleted(true);
        } else {
            $query = $this->getModelToQuery()->whereCompleted(false);
        }

        if (Auth::user()->role_id == User::ROLE_NORMAL) {
            $query = $query->where('user_id', Auth::id());
        }

        return $this->buildQuery($query, $options);
    }
}
