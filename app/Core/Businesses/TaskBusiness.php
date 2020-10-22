<?php

namespace App\Core\Businesses;

use App\Core\Businesses\Contracts\ApiResourceInterface;
use App\Core\Businesses\Contracts\TaskInterface;
use App\Core\Repositories\Contracts\TaskInterface as TaskRepository;

class TaskBusiness implements TaskInterface, ApiResourceInterface
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $options = [
            'paginate' => 10
        ];

        return $this->taskRepository->getListByStatus(Request()->status, array_merge($options, Request()->except(['status'])));
    }

    public function store($data)
    {
        if ($task = $this->taskRepository->create($data)) {
            return [
                'success' => true,
                'task_item' => $task
            ];
        }

        return ['success' => false];
    }

    public function update($id, $data)
    {
        $taskItem = $this->taskRepository->findOrFail($id);

        if ($taskItem->update($data)) {
            $taskItem->refresh();

            return [
                'success' => true,
                'task_item' => $taskItem
            ];
        }

        return ['success' => false];
    }

    public function show($id)
    {
        return $this->taskRepository->findOrFail($id);
    }

    public function destroy($id)
    {
        $taskItem = $this->taskRepository->findOrFail($id);

        return ['success' => $taskItem->delete() ? true : false];
    }
}
