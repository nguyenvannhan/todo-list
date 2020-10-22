<?php

namespace App\Http\Controllers;

use App\Core\Businesses\Contracts\TaskInterface as TaskBusiness;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Collections\TaskCollection;
use App\Http\Resources\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskBusiness;

    public function __construct(TaskBusiness $taskBusiness)
    {
        $this->taskBusiness = $taskBusiness;

        $this->middleware('auth.role:admin')->except(['index', 'show', 'markComplete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->taskBusiness->index();

        return new TaskCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateTaskRequest $request)
    {
        $data = $request->only(['title', 'description', 'user_id', 'completed']);

        $result = $this->taskBusiness->store($data);

        if ($result['success']) {
            return new TaskResource($result['task_item']);
        }

        return response()->json(['message' => 'Create User Failed'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new TaskResource($this->taskBusiness->show($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $data = $request->only(['title', 'description', 'user_id', 'completed']);

        $result = $this->taskBusiness->update($id, $data);

        if ($result['success']) {
            return new TaskResource($result['task_item']);
        }

        return response()->json(['message' => 'Update User Failed'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(
            $this->taskBusiness->destroy($id),
        );
    }

    public function markComplete(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $result = $this->taskBusiness->update($request->id, [
            'completed' => true,
        ]);

        if ($result['success']) {
            return new TaskResource($result['task_item']);
        }

        return response()->json(['message' => 'Mark Complete Fail'], 500);
    }
}
