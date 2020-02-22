<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = ['content'];

    public static function getTasks()
    {
        return Task::all();
    }

    public static function addTask($content)
    {
        try {
            $task = new self();
            $task->content = $content;
            $task->save();
            return $task;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

    }

    public static function editTask($taskId, $task)
    {
        try {
            DB::table('tasks')
                ->where('id', $taskId)
                ->update(['content' => $task['content']]);
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

}
