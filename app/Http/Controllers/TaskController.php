<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    static array $status = [
        Task::NEW => ['title' => 'New', 'class' => 'text-primary'],
        Task::IN_PROGRESS => ['title' => 'In progress', 'class' => 'text-warning'],
        Task::DONE => ['title' => 'Done', 'class' => 'text-secondary']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View|Application
    {
        $status = self::$status;

        $tasks = Task::all();

        return view('pages.index', compact('tasks', 'status'));
    }

    /**
     * Display a single resource.
     */
    public function show(Task $task): View
    {
        $status = self::$status;

        return view('pages.show', compact('task', 'status'));
    }

    /**
     * Show the form for creating the specified resource
     */
    public function create(): Factory|View|Application
    {
        $status = self::$status;

        return view('pages.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = new Task($request->input());
        $task->save();

        return redirect()->route('task.show', $task)->with('success', 'Task successfully created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $status = self::$status;
        return view('pages.edit', compact('task', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => ['required', Rule::in(array_keys(self::$status))]
        ]);

        $task->update($request->input());
        $task->save();

        return redirect()->route('task.show', $task)->with('success', 'Task successfully modified!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task successfully deleted!');
    }
}
