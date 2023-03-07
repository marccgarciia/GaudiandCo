<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new user.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $response = $this->post('/usuarios', [
            'nombre' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'admin' => false
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'nombre' => 'John Doe',
            'email' => 'johndoe@example.com',
            'admin' => false
        ]);
    }

    /**
     * Test getting all users.
     *
     * @return void
     */
    public function testGetUsers()
    {
        factory(\App\User::class, 10)->create();

        $response = $this->get('/usuarios');

        $response->assertStatus(200);
        $response->assertJsonCount(10);
    }

    /**
     * Test updating a user.
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = factory(\App\User::class)->create([
            'nombre' => 'Jane Doe',
            'email' => 'janedoe@example.com',
            'password' => bcrypt('password123'),
            'admin' => false
        ]);

        $response = $this->put('/usuarios/' . $user->id, [
            'nombre' => 'Janet Doe',
            'email' => 'janetdoe@example.com',
            'password' => 'newpassword123',
            'admin' => true
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nombre' => 'Janet Doe',
            'email' => 'janetdoe@example.com',
            'admin' => true
        ]);
    }

    /**
     * Test deleting a user.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->delete('/usuarios/' . $user->id);

        $response->assertStatus(302);
        $response->assertRedirect('/');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }
}