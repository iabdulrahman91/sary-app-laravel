<?php

namespace Tests\Feature;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    
    public function test_questions_can_be_retreived()
    {
        $response = $this->get('api/questions');

        $response->assertStatus(200);
    }

    public function test_a_quesion_can_be_retreived()
    {
        $question = Question::factory()->create();

        $response = $this->get('api/questions/'.$question->id);

        $response->assertStatus(200);
    }

    public function test_a_quesion_can_be_created()
    {
        $response = $this->post('api/questions/', [
            'text' => 'what is fav team?'
        ]);

        $response->assertStatus(201);
    }

    public function test_a_quesion_can_be_updated()
    {
        $question = Question::factory()->create();

        $response = $this->patch('api/questions/'.$question->id, [
            'text' => 'what is fav team?'
        ]);
        $response->assertStatus(200);
    }

    
    public function test_a_quesion_can_be_updated_content()
    {
        $question = Question::factory()->create();

        $response = $this->patch('api/questions/'.$question->id, [
            'text' => 'what is fav team?'
        ]);
        
        $response->assertSeeText('what is fav team?');
    }

    public function test_a_quesion_can_be_deleted()
    {
        $question = Question::factory()->create();

        $response = $this->delete('api/questions/'.$question->id);

        $this->assertDatabaseMissing('questions', ['id' => $question->id]);

    }
}
