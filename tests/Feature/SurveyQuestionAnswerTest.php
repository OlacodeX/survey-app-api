<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyQuestionAnswerTest extends TestCase
{
    /**
     * This tests if public users can provide answers to survey questions successfully.
     */
    public function test_public_users_can_answer_survey_questions(): void
    {
        // create fake survey and questions
        $survey = Survey::factory()->create();
        $question = SurveyQuestion::factory()->create(['survey_id' => $survey->id]);

        $response = $this->postJson('/api/v1/surveys/'.$survey->id.'/answers', [
            'answer' => [
                $question->id => [
                    'answer' => 'This is my answer'
                ]
            ]
        ]);

        $response->assertStatus(200);
    }

     /**
     * This tests if the questions returned are correct
     */
    public function test_answers_list_by_question_id_returns_correct_answers(): void
    {
        // create fake survey and questions
        $survey = Survey::factory()->create();
        $question = SurveyQuestion::factory()->create([
            'survey_id' => $survey->id,
            'type' => 0,
        ]);
        $user = User::factory()->create();
        $answer = SurveyQuestionAnswer::factory()->create([
            'question_id' => $question->id,
            'survey_id' => $survey->id,
        ]);
        $response = $this->actingAs($user)->get('/api/v1/admin/surveys/'.$survey->id.'/questions'.'/'.$question->id.'/answers');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
        // assert the id of returned question is the created question
        $response->assertJsonFragment(['id' => $answer->id]);
    }
}
