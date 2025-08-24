<?php

namespace Tests\Unit\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;


class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(TaskService::class);

        // Ensure default status exists
        Status::factory()->create(['name' => 'Pending','value' => 'pending']);

        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    #[Test]
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
        ];

        $task = $this->service->storeResource($data);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }

    #[Test]
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create();

        $updated = $this->service->updateResource($task->id, [
            'title' => 'Updated Task',
            'description' => 'Updated description',
        ]);

        $this->assertEquals('Updated Task', $updated->title);
        $this->assertDatabaseHas('tasks', ['title' => 'Updated Task']);
    }

    #[Test]
    public function it_can_delete_a_task()
    {
        $task = Task::factory()->create();

        $this->service->deleteResource($task->id);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    #[Test]
    public function it_can_assign_a_task_to_user()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $updated = $this->service->updateResource($task->id, [
            'assigned_to' => $user->id,
        ]);

        $this->assertEquals($user->id, $updated->assigned_to);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'assigned_to' => $user->id,
        ]);
    }

    #[Test]
    public function it_can_change_task_status()
    {
        $task = Task::factory()->create();

        // Create a new status
        $newStatus = Status::factory()->create(['name' => 'Completed', 'value' => 'completed']);

        // Update the task status
        $updated = $this->service->updateResource($task->id, [
            'status_id' => $newStatus->id,
        ]);

        $this->assertEquals($newStatus->id, $updated->status_id);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status_id' => $newStatus->id,
        ]);
    }
}
