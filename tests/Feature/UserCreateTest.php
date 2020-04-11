<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserCreateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create test user in Database
     *
     * @return void
     */
    public function testCreateUser()
    {
        $user = factory(User::class, 1)->states('testUser')->create();
        
        $this->assertDatabaseHas('users', ['email' => $user[0]->email]);
    }
}
