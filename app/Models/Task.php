<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    protected $fillable = ['task'];

    public static function getTasks()
    {
        return Task::all();
    }

    public static function addTask($task)
    {
        try {
            $newTask = new self();
            $newTask->task = $task;
            return $newTask->save();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;

        }

    }
}
