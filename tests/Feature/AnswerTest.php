<?php

namespace Tests\Feature;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswerTest extends TestCase
{
    use RefreshDatabase;


    public function test_answers_can_be_retreived()
    {
        
        $response = $this->get('api/answers');

        $response->assertStatus(200);
    }

    public function test_a_answer_can_be_retreived()
    {

        $answer = Answer::factory()->forQuestion()->create();

        $response = $this->get('api/answers/'.$answer->id);

        $response->assertStatus(200);
    }

    public function test_a_answer_can_be_created()
    {
        $question = Question::factory()->create();

        $response = $this->post('api/answers/', [
            'text' => 'Blue',
            'question_id' => $question->id,
        ]);

        $response->assertStatus(201);
    }

    public function test_a_answer_can_be_updated()
    {
        $answer = Answer::factory()->forQuestion()->create();

        $response = $this->patch('api/answers/'.$answer->id, [
            'text' => 'No, it Red'
        ]);
        $response->assertStatus(200);
    }

    
    public function test_a_answer_can_be_updated_content()
    {
        $answer = Answer::factory()->forQuestion()->create();

        $response = $this->patch('api/answers/'.$answer->id, [
            'text' => 'No, it is Red'
        ]);
        
        $response->assertSeeText('it is Red');
    }

    public function test_a_answer_can_be_deleted()
    {
        $answer = Answer::factory()->forQuestion()->create();

        $response = $this->delete('api/answers/'.$answer->id);

        $this->assertDatabaseMissing('answers', ['id' => $answer->id]);

    }
}
