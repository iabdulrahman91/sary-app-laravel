<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;


    public function test_comments_can_be_retreived()
    {
        
        $response = $this->get('api/comments');

        $response->assertStatus(200);
    }

    public function test_a_comment_can_be_retreived()
    {

        $comment = Comment::factory()->make();
        $question = Question::factory()->create();
        $question->comments()->save($comment);

        $response = $this->get('api/comments/'.$comment->id);

        $response->assertStatus(200);
    }

    // public function test_a_comment_can_be_created()
    // {
    //     $question = Comment::factory()->create();

    //     $response = $this->post('api/questions/' . $question->id . '/comments/', [
    //         'text' => 'niceee',
    //     ]);

    //     $response->assertStatus(201);
    // }

    // public function test_a_comment_can_be_updated()
    // {
    //     $comment = Comment::factory()->forQuestion()->create();

    //     $response = $this->patch('api/comments/'.$comment->id, [
    //         'text' => 'No, it Red'
    //     ]);
    //     $response->assertStatus(200);
    // }

    
    // public function test_a_comment_can_be_updated_content()
    // {
    //     $comment = Comment::factory()->forQuestion()->create();

    //     $response = $this->patch('api/comments/'.$comment->id, [
    //         'text' => 'No, it is Red'
    //     ]);
        
    //     $response->assertSeeText('it is Red');
    // }

    // public function test_a_comment_can_be_deleted()
    // {
    //     $comment = Comment::factory()->forQuestion()->create();

    //     $response = $this->delete('api/comments/'.$comment->id);

    //     $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

    // }
}
