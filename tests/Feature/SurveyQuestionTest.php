<?php

namespace Tests\Feature;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyQuestionTest extends TestCase
{
    /**
     * This tests if a logged in user can add questions to an existing survey
     */
    public function test_logged_in_user_can_add_question_to_a_survey(): void
    {
        $user = User::factory()->create();
        
        $survey = Survey::factory()->create();

        // Test validation works
        $response = $this->actingAs($user)->postJson('/api/v1/admin/surveys/'.$survey->id.'/questions', [
            'type' => 'This type',
            'question' => 'This question',
        ]);

        $response->assertStatus(422);

        // Test question gets created with valid data
        $response = $this->actingAs($user)->postJson('/api/v1/admin/surveys/'.$survey->id.'/questions', [
            'type' => '0',
            'question' => 'This question',
        ]);
        $response->assertStatus(201);

        $response = $this->get('/api/v1/surveys/'.$survey->id.'/questions');
        $response->assertJsonFragment(['type' => 'Text']);
    }

     /**
     * This tests user not logged in cannot add question to a survey.
     */
    public function test_public_user_cannot_add_question(): void
    {
        $survey = Survey::factory()->create();

        $response = $this->postJson('/api/v1/admin/surveys/'.$survey->id.'/questions');

        $response->assertStatus(401);
    } 

    /**
     * This tests if the questions returned are correct
     */
    public function test_questions_list_by_survey_id_returns_correct_questions(): void
    {
        // create fake survey and questions
        $survey = Survey::factory()->create();
        $question = SurveyQuestion::factory()->create(['survey_id' => $survey->id]);
        
        $response = $this->get('/api/v1/surveys/'.$survey->id.'/questions');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        // assert the id of returned question is the created question
        $response->assertJsonFragment(['id' => $question->id]);
    }

     /**
     * This tests if the data is returned correctly i.e paginated with 200 code
     */
    public function test_questions_list_returns_paginated_data_correctly(): void
    {
        
       // create fake survey and questions
       $survey = Survey::factory()->create();
       $question = SurveyQuestion::factory(16)->create(['survey_id' => $survey->id]);

       $response = $this->get('/api/v1/surveys/'.$survey->id.'/questions');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
        $response->assertJsonPath('meta.last_page', 2);
    }
}
