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

        $content = $request->post('task');
        if($task = Task::addTask($content)) {
            return response(['message' => 'success', 'payload' => $task]);
        } else {
            return response(['message' => 'failed']);
        }

    }

    public function editTask(Request $request, $taskId)
    {
        $rules = [
            'content' => 'required|string|max:250',
        ];

        $this->validate($request, $rules);

        $isSaved = Task::editTask($taskId, $request->post());
        if($isSaved) {
            return response(['message' => 'success']);
        } else {
            return response(['message' => 'failed']);
        }
    }

    public function deleteTask(Task $task)
    {
        if(Task::destroy($task->id)) {
            return response(['message' => 'success']);
        } else {
            return response(['message' => 'failed']);
        };
    }


}
