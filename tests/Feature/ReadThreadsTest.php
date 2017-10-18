<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;
    

    public function setUp()
    {


        parent::setUp();

        $this->thread = factory( 'App\Thread' )->create();


    }


    /** @test 
	* Can user vie all threads -- Test
    **/
    public function a_user_can_view_all_threads()
    {
        
        //Test 1
        $response = $this->get('/threads');
        // At /threads view, we should see thread title
        $response->assertSee( $this->thread->title );
    }


    /**
     * @test
     * Test 2 -- For individual posts
     * 
     * **/
    function a_user_can_read_a_single_thread()
    {

        $response = $this->get( '/threads/' . $this->thread->channel . '/' . $this->thread->id );
        $response->assertSee( $this->thread->title );
    
    }

    /** 
    *@test
    * Testing -- Can see replies on page
    **/

    function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        
        // Given we have a thread
         // And that thread includes replies
        $reply = factory( 'App\Reply' )->create( [ 'thread_id' => $this->thread->id ] );

       
        $this->get('/threads/' . $this->thread->channel . '/' . $this->thread->id )
            ->assertSee( $reply->body );


    }
}
