<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function getTasks()
    {
        return response(['message' => 'success', 'payload' => Task::getTasks()]);
    }

    public function addTask(Request $request)
    {
        $rules = [
            'task' => 'required|string|max:250',
        ];

        $this->validate($request, $rules);

        $task = $request->post('task');
        dd(Task::addTask($task));
        if(Task::addTask($task)) {
            response(['message' => 'success']);
        } else {
            response(['message' => 'failed']);
        }

    }

    public function delete()
    {
        dd();
    }


}
