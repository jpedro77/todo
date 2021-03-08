<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TodoPriority;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_todo_can_add_task()
    {
        $user = User::factory()->create();
        $todoPriority = TodoPriority::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/todo', [
            'title' => 'password',
            'description' => 'new-password',
            'id_user' => $user->id,
            'id_todo_priority' => $todoPriority->id,
            'deadline_at' => '2021-03-07',
            'completed_at' => '',
        ], ['Accept' => 'application/json']);

        $response->assertStatus(200);
    }
}
