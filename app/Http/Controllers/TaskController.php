<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Gate;
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
        Gate::authorize('viewAny', Task::class);

        $status = self::$status;

        $tasks = auth()->user()->tasks()->get();

        return view('task.index', compact('tasks', 'status'));
    }

    /**
     * Display a single resource.
     */
    public function show(Task $task): View
    {
        Gate::authorize('view', $task);

        $status = self::$status;

        return view('task.show', compact('task', 'status'));
    }

    /**
     * Show the form for creating the specified resource
     */
    public function create(): Factory|View|Application
    {
        Gate::authorize('create', Task::class);

        $status = self::$status;

        return view('task.create', compact('status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', Task::class);

        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $task = new Task($request->input());
        $task->user()->associate(auth()->user());
        $task->save();

        return redirect()->route('task.show', $task)->with('success', 'Task successfully created!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        Gate::authorize('update', $task);

        $status = self::$status;
        return view('task.edit', compact('task', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        Gate::authorize('update', $task);

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
        Gate::authorize('delete', $task);

        $task->delete();

        return redirect()->route('task.index')->with('success', 'Task successfully deleted!');
    }
}
