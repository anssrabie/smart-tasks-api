<?php

namespace Tests\Feature\Api\V1;

use App\Models\Task;
use App\Models\User;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    protected array $headers = [];

    protected function setUp(): void
    {
        parent::setUp();

        Status::factory()->create(['name' => 'Pending', 'value' => 'pending']);
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->headers = [
            'x-api-key' => config('app.api_key'),
        ];
    }

    #[Test]
    public function it_can_list_tasks()
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson(route('tasks.index'), $this->headers);

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'message']);
    }

    #[Test]
    public function it_can_show_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.show', $task->id), $this->headers);

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

//    #[Test]
//    public function it_can_create_a_task()
//    {
//        $data = [
//            'title' => 'New Task',
//            'description' => 'Task description',
//        ];
//
//        $response = $this->postJson(route('api.v1.tasks.store'), $data);
//
//        $response->assertStatus(201)
//            ->assertJsonFragment(['title' => 'New Task']);
//    }
//
//    #[Test]
//    public function it_can_update_a_task()
//    {
//        $task = Task::factory()->create();
//
//        $data = [
//            'title' => 'Updated Task',
//            'description' => 'Updated description',
//        ];
//
//        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $data);
//
//        $response->assertStatus(200)
//            ->assertJsonFragment(['title' => 'Updated Task']);
//    }
//
//    #[Test]
//    public function it_can_delete_a_task()
//    {
//        $task = Task::factory()->create();
//
//        $response = $this->deleteJson(route('api.v1.tasks.destroy', $task->id));
//
//        $response->assertStatus(200);
//        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
//    }
}
