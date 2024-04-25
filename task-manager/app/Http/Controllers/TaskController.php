<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Display a listing of the tasks
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    // Show the form for creating a new task
    public function create()
    {
        return view('tasks.create');
    }

    // Store a newly created task in the database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            // Add any other validation rules here
        ]);

        Task::create($validatedData);

        return redirect('/tasks')->with('success', 'Task created successfully!');
    }

    // Show the form for editing the specified task
    public function edit(Task $task)
    {
        return view('tasks.edit', ['task' => $task]);
    }

    // Update the specified task in the database
    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            // Add any other validation rules here
        ]);

        $task->update($validatedData);

        return redirect('/tasks')->with('success', 'Task updated successfully!');
    }

    // Remove the specified task from the database
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect('/tasks')->with('success', 'Task deleted successfully!');

    }
    
    public function updateStatus(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:in_progress,completed', // Define valid status values
        ]);

        $task->status = $validatedData['status'];
        $task->save();

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }
}

