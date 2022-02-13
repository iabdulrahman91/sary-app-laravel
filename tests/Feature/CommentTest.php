<?php

namespace Tests\Feature;

use App\Models\Answer;
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

    public function test_a_comment_can_be_created_for_question()
    {
        $question = Question::factory()->create();


        $response = $this->post("api/questions/" . $question->id . '/comments' , [
            'text' => 'niceee',
        ]);

        $response->assertStatus(201);
    }

    public function test_a_comment_can_be_created_for_answer()
    {
        $answer = Answer::factory()->forQuestion()->create();


        $response = $this->post("api/answers/" . $answer->id . '/comments' , [
            'text' => 'niceee',
        ]);

        $response->assertStatus(201);
    }

    public function test_a_comment_can_be_updated()
    {
        $comment = Comment::factory()->make();
        $question = Question::factory()->create();
        $question->comments()->save($comment);

        $response = $this->patch('api/comments/'.$comment->id, [
            'text' => 'good comment'
        ]);
        $response->assertStatus(200);
    }

    
    public function test_a_comment_can_be_updated_content()
    {
        $comment = Comment::factory()->make();
        $question = Question::factory()->create();
        $question->comments()->save($comment);

        $response = $this->patch('api/comments/'.$comment->id, [
            'text' => 'good comment'
        ]);
        
        $response->assertSeeText('good comment');
    }

    public function test_a_comment_can_be_deleted()
    {
        $comment = Comment::factory()->make();
        $question = Question::factory()->create();
        $question->comments()->save($comment);

        $response = $this->delete('api/comments/'.$comment->id);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

    }
}
