<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiModelPreferenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_save_their_ai_provider_and_model(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('home.ai-preferences'), [
            'ai_provider' => 'anthropic',
            'ai_model' => 'claude-3-5-sonnet-latest',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'ai_provider' => 'anthropic',
            'ai_model' => 'claude-3-5-sonnet-latest',
        ]);
    }

    public function test_user_cannot_save_a_model_for_a_different_provider(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('home'))
            ->put(route('home.ai-preferences'), [
                'ai_provider' => 'google',
                'ai_model' => 'gpt-4o',
            ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors('ai_model');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'ai_provider' => null,
            'ai_model' => null,
        ]);
    }

    public function test_ai_preference_update_requires_authentication(): void
    {
        $response = $this->put(route('home.ai-preferences'), [
            'ai_provider' => 'openai',
            'ai_model' => 'gpt-4o-mini',
        ]);

        $response->assertRedirect(route('login'));
    }
}
