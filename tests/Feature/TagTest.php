<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tags_can_be_retreived()
    {
        $response = $this->get('api/tags');

        $response->assertStatus(200);
    }

    public function test_a_tag_can_be_retreived()
    {
        $tag = Tag::factory()->create();

        $response = $this->get('api/tags/'.$tag->id);

        $response->assertStatus(200);
    }

    public function test_a_tag_can_be_created()
    {
        $response = $this->post('api/tags/', [
            'text' => 'general'
        ]);

        $response->assertStatus(201);
    }

    public function test_a_tag_can_be_updated()
    {
        $tag = Tag::factory()->create();

        $response = $this->patch('api/tags/'.$tag->id, [
            'text' => 'new'
        ]);
        $response->assertStatus(200);
    }

    
    public function test_a_tag_can_be_updated_content()
    {
        $tag = Tag::factory()->create();

        $response = $this->patch('api/tags/'.$tag->id, [
            'text' => 'new_tag'
        ]);
        
        $response->assertSeeText('new_tag');
    }

    public function test_a_tag_can_be_deleted_db()
    {
        $tag = Tag::factory()->create();

        $response = $this->delete('api/tags/'.$tag->id);

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);

    }

    public function test_a_tag_can_be_deleted()
    {
        $tag = Tag::factory()->create();

        $response = $this->delete('api/tags/'.$tag->id);

        $response->assertStatus(204);

    }


    public function test_a_tag_can_be_assigned_to_a_question()
    {
        $tag = Tag::factory()->create();
        $question = Question::factory()->create(['text' => 'text to be seen']);

        $response = $this->patch('api/tags/'.$tag->id, [
            'text' => 'new_tag',
            'questions' => [$question->id]
        ]);

        $response->assertSeeText($question->text);

    }

    public function test_a_tag_can_be_assigned_to_questions()
    {
        $tag = Tag::factory()->create();

        $question_1 = Question::factory()->create();
        $question_2 = Question::factory()->create();

        $response = $this->patch('api/tags/'.$tag->id, [
            'text' => 'new_tag',
            'questions' => [$question_1->id, $question_2->id]
        ]);

        $tag->refresh();
        $this->assertCount(2, $tag->questions);
    }
}
