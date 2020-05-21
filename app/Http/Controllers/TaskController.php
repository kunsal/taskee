<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController
{
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->get();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $request['user_id'] = auth()->user()->id;
        Task::create($request->only('title', 'content', 'user_id', 'due_date'));
        return redirect('tasks')->with('success', 'Task created successfully');
    }

    public function edit(Task $task)
    {
        if (!$this->myTask($task)) return redirect('tasks')->with('error', 'Invalid task');
        return view('tasks.edit', ['task' => $task]);
    }

    public function update(Task $task, Request $request) {
        if (!$this->myTask($task)) return redirect('tasks')->with('error', 'Invalid task');
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);
        $task->update($request->only('title', 'content', 'due_date', 'done'));
        return redirect()->back()->with('success', 'Task updated successfully');
    }

    public function updateStatus(Task $task, $status)
    {
        if (!$this->myTask($task)) return redirect('tasks')->with('error', 'Invalid task');
        switch($status) {
            case 'done':
                $task->done = 1;
                $task->save();
                return redirect('tasks')->with('success', 'Task marked as done');
            case 'open':
                $task->done = 0;
                $task->save();
                return redirect('tasks')->with('success', 'Task marked as open');
            default:
                return redirect('tasks');
        }
    }

    private function myTask($task)
    {
        if ($task->user->id === auth()->user()->id) {
            return true;
        }
        return false;
    }
}
