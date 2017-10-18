<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function guests_may_not_create_threads()
    {

        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');


        $this->post('/threads/')
            ->assertRedirect('/login');


    }


    /** @test */
    function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

        // Then, we visit the thread page.
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

}