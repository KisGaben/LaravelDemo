<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->actingAs($user);
    }

    public function test_task_can_be_created(): void
    {
        $task = Task::factory()->make()->only(['title', 'description']);

        $this->post(route('task.store'), $task);

        $this->assertDatabaseHas('tasks', $task);
    }

    public function test_task_can_be_updated(): void
    {
        $task = Task::factory()->create(['user_id' => auth()->id()]);

        $updatedTask = Task::factory()->make()->only(['title', 'description', 'status']);;

        $this->put(route('task.update', $task), $updatedTask);

        $this->assertDatabaseHas('tasks', $updatedTask);
    }

    public function test_task_can_be_deleted(): void
    {
        $task = Task::factory()->create(['user_id' => auth()->id()]);

        $this->delete(route('task.destroy', $task));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
