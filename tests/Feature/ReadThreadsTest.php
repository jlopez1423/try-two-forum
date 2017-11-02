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

    /** @test */
    function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');

        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);

        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {

        $this->signIn( create('App\User', ['name' => 'JohnDoe' ] ) );

        $threadByJohn = create( 'App\Thread', [ 'user_id' => auth()->id() ] );
        $threadNotByJohn = create( 'App\Thread' );

        $this->get(  'threads?by=JohnDoe' )
            ->assertSee( $threadByJohn->title )
            ->assertDontSee( $threadNotByJohn->title );


    }


    /** @test */
    function a_user_can_filter_threads_by_popularity()
    {
        //Given we have three threads

        //With 2 replies, 3 replies and 0 replies respectively.
        $threadWithTwoReplies = create( )




        //When I filter all threads by popularity
        $response = $this->getJson( 'threads?popularity=1' )->json();

        //Then they should be returned from most replies to least.
        array_column( $response, 'replies_count' );
        $this->assertEquals([3, 2, 0], array_column( $response, 'replies_count' ) );
    }

}
