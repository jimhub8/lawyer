<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Task;

class EventController extends Controller
{
    public function events()
    {
        $tasks = Task::all();
        $tasks->transform(function ($task) {
            $task->title = $task->task;
            $task->details = $task->priority;
            $task->date = $task->due_date;
            $task->open = false;
            return $task;
        });
        return $tasks;
    }
}
