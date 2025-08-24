<?php

namespace Tests\Unit\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure default status exists
        Status::factory()->create(['name' => 'Pending','value' => 'pending']);
    }

    #[Test]
    public function it_belongs_to_an_owner()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // الـ Task هيتم عمل owner_id تلقائي من الـ booted
        $task = Task::factory()->create();

        $this->assertInstanceOf(User::class, $task->owner);
        $this->assertEquals($user->id, $task->owner->id);
    }

    #[Test]
    public function it_can_be_assigned_to_a_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();
        $assignedUser = User::factory()->create();

        $task->assigned_to = $assignedUser->id;
        $task->save();

        $this->assertEquals($assignedUser->id, $task->assigned_to);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'assigned_to' => $assignedUser->id,
        ]);
    }

    #[Test]
    public function it_can_have_logs()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();

        activity()
            ->causedBy($user)
            ->performedOn($task)
            ->withProperties(['foo' => 'bar'])
            ->log('Test activity');

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => Task::class,
            'subject_id' => $task->id,
            'description' => 'Test activity',
            'causer_id' => $user->id,
        ]);
    }
}
