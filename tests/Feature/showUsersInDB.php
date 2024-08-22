<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class showUsersInDB extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_all_users_in_database()
    {
        // Insert some test data
        \DB::table('users')->insert([
            [
                'name' => 'name',
                'email' => 'akherati@gmail.com',
                'bio' => 'bio',
                'phoneNumber' => '09157982447',
                'password' => 'password',
            ],
        ]);

        // Fetch all users from the database
        $users = \DB::table('users')->get();

        // Output the users for inspection
        foreach ($users as $user) {
            echo "User ID: {$user->id}, Name: {$user->name}, Email: {$user->email}\n";
        }

        // Optionally, assert database state
        $this->assertCount(1, $users);
    }
}
