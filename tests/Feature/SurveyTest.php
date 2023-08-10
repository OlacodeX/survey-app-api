<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Survey;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SurveyTest extends TestCase
{
    /**
     * This tests a logged in user can add survey.
     */
    public function test_logged_in_user_can_add_survey(): void
    {
        $user = User::factory()->create();

        // Test validation works
        $response = $this->actingAs($user)->postJson('/api/v1/admin/surveys', [
            'title' => 'Survey from test',
        ]);

        $response->assertStatus(422);

        // Test survey is created with valid data
        $response = $this->actingAs($user)->postJson('/api/v1/admin/surveys', [
            'title' => 'Survey from test',
            'expires_at' => now()->toDateString(),
        ]);
        $response->assertStatus(201);

        $response = $this->get('/api/v1/surveys');
        $response->assertJsonFragment(['title' => 'Survey from test']);
    }
     /**
     * This tests a user not logged in cannot add survey.
     */
    public function test_public_user_cannot_add_survey(): void
    {
        $response = $this->postJson('/api/v1/admin/surveys');

        $response->assertStatus(401);
    } 

    /**
     * This tests if the data is returned correctly i.e paginated with 200 code
     */
    public function test_surveys_list_returns_paginated_data_correctly(): void
    {
        
       // create fake survey and questions
       $survey = Survey::factory(16)->create();
       $response = $this->get('/api/v1/surveys/');

        $response->assertStatus(200);
        $response->assertJsonCount(15, 'data');
    }

}
