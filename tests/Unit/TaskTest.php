<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use App\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testThatUnregisteredUserCanNotViewTasksPage()
    {
        $this->get('tasks')
            ->assertStatus(302)
            ->assertRedirect('/user/login');
    }

    public function testThatTaskListPageCanBeSeenByRegisteredUser()
    {
        $this->loginUser();
        $this->get('tasks')
            ->assertStatus(200)
            ->assertViewIs('tasks.index')
            ->assertViewHas('tasks');
    }

    public function testThatUnregisterdUserCanNotAccessTaskCreationPage()
    {
        $this->get('tasks/create')
            ->assertStatus(302)
            ->assertRedirect('/user/login');
    }

    public function testThatUserCanAccessTaskCreationPage()
    {
        $this->loginUser();
        $this->get('tasks/create')
            ->assertStatus(200)
            ->assertViewIs('tasks.create');
    }

    public function testThatTitleIsRequiredInTaskCreation()
    {
        $this->loginUser();
        $this->post('tasks/create', [
            'title' => '',
            'content' => 'This is a sample description of my task'
        ])
            ->assertSessionHasErrors('title')
            ->assertStatus(302);
    }

    public function testThatContentIsRequiredInTaskCreation()
    {
        $this->loginUser();
        $this->post('tasks/create', [
            'title' => 'First task',
            'content' => ''
        ])
            ->assertSessionHasErrors('content')
            ->assertStatus(302);
    }

    public function testThatUserCanCreateTask()
    {
        $this->withoutExceptionHandling();
        $this->loginUser();
        $due_date = Carbon::now()->addDays(3);
        $response = $this->post('tasks/create', [
            'title' => 'First task',
            'content' => 'This is a sample description of my task',
            'due_date' => $due_date
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'First task',
            'content' => 'This is a sample description of my task',
            'user_id' => auth()->user()->id,
            'due_date' => $due_date,
            'done' => 0
        ]);
        $response->assertSessionHas('success', 'Task created successfully');
        $response->assertStatus(302);
    }

    public function testThatUserCanNotEditAnotherUsersTask()
    {
        //$this->withExceptionHandling();
        $this->loginUser();
        $user2 = $this->createUser([
            'name' => 'Kaytivity',
            'email' => 'kay@email.com',
            'password' => 'pass'
        ]);
        Task::create([
            'title' => 'Third party task',
            'content' => 'I should not see other people\'s tasks',
            'user_id' => $user2->id
        ]);
        $this->get('tasks/edit/1')
            ->assertStatus(302)
            ->assertRedirect('/tasks')
            ->assertSessionHas('error', 'Invalid task');
    }

    public function testThatUserCanEditOwnTask()
    {
        //$this->withExceptionHandling();
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is my own task',
            'user_id' => auth()->user()->id
        ]);
        $this->get('tasks/edit/1')
            ->assertStatus(200)
            ->assertViewIs('tasks.edit')
            ->assertViewHas('task', $task);
    }

    public function testThatTitleIsRequiredToUpdateTask()
    {
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is my own task',
            'user_id' => auth()->user()->id
        ]);
        $this->put('tasks/edit/' . $task->id, [
            'title' => '',
            'content' => 'This is a sample description of my task'
        ])
            ->assertSessionHasErrors('title')
            ->assertStatus(302);
    }

    public function testThatContentIsRequiredToUpdateTask()
    {
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is a sample description of my task',
            'user_id' => auth()->user()->id
        ]);
        $this->put('tasks/edit/' . $task->id, [
            'title' => 'My task',
            'content' => ''
        ])
            ->assertSessionHasErrors('content')
            ->assertStatus(302);
    }

    public function testThatUserCanUpdateTask()
    {
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is a sample description of my task',
            'user_id' => auth()->user()->id
        ]);

        $this->put('tasks/edit/' . $task->id, [
            'title' => 'My task title',
            'content' => 'Another activtiy to be done',
            'done' => 1
        ])
            ->assertSessionHas('success', 'Task updated successfully')
            ->assertStatus(302);
        $updatedTask = Task::find($task->id);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $updatedTask->title,
            'content' => $updatedTask->content,
            'due_date' => $updatedTask->due_date,
            'done' => $updatedTask->done
        ]);
    }

    public function testThatUserCanMarkTaskAsDone()
    {
        $this->withoutExceptionHandling();
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is a sample description of my task',
            'user_id' => auth()->user()->id
        ]);

        $this->patch('tasks/status/' . $task->id . '/done', [])
            ->assertSessionHas('success', 'Task marked as done')
            ->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'done' => 1
        ]);
    }

    public function testThatUserCanMarkTaskAsOpen()
    {
        $this->withoutExceptionHandling();
        $this->loginUser();
        $task = Task::create([
            'title' => 'My task',
            'content' => 'This is a sample description of my task',
            'user_id' => auth()->user()->id
        ]);

        $this->patch('tasks/status/' . $task->id . '/open', [])
            ->assertSessionHas('success', 'Task marked as open')
            ->assertStatus(302);
        $this->assertDatabaseHas('tasks', [
            'done' => 0
        ]);
    }

    private function createUser($data = [])
    {
        if ($data) {
            return \App\User::create($data);
        } else {
            return \App\User::create([
                'name' => 'Olakunle',
                'email' => 'kunsal@gmail.com',
                'password' => 'passw'
            ]);
        }
    }



    private function loginUser()
    {
        $this->createUser();
        $this->post('user/login', [
            'email' => 'kunsal@gmail.com',
            'password' => 'passw'
        ]);
    }
}
