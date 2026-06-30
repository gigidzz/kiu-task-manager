<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * The root URL redirects visitors toward the dashboard.
     */
    public function test_the_root_redirects(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/dashboard');
    }

    /**
     * Guests cannot reach the task list and are sent to the login page.
     */
    public function test_guests_are_redirected_to_login(): void
    {
        $response = $this->get('/tasks');

        $response->assertRedirect('/login');
    }
}
