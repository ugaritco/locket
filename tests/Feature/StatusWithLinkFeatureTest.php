<?php

use App\Models\Link;
use App\Models\User;

it('can create status with extracted URL and thoughts', function () {
    $user = User::factory()->create();

    // Simulate what the frontend would send after URL extraction
    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => 'https://ugarit.com',
        'thoughts' => 'This is an awesome framework for web development',
    ]);

    $response->assertRedirect();

    // Verify the link was created
    $link = Link::where('url', 'https://ugarit.com')->first();
    expect($link)->not->toBeNull();
    expect($link->url)->toBe('https://ugarit.com');

    // Verify user has the link
    expect($user->fresh()->userLinks)->toHaveCount(1);
    expect($user->fresh()->userLinks->first()->link->url)->toBe('https://ugarit.com');
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);

it('can create status with URL only (no thoughts)', function () {
    $user = User::factory()->create();

    // Simulate URL-only input
    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => 'https://example.com',
        'thoughts' => '',
    ]);

    $response->assertRedirect();

    // Verify the link was created
    $link = Link::where('url', 'https://example.com')->first();
    expect($link)->not->toBeNull();
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);

it('validates that URL is required', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => '',
        'thoughts' => 'Just thoughts without URL',
    ]);

    $response->assertSessionHasErrors(['url']);
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);

it('validates that URL must be valid format', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => 'not-a-valid-url-format',
        'thoughts' => 'Some thoughts',
    ]);

    $response->assertSessionHasErrors(['url']);
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);

it('handles long thoughts within limit', function () {
    $user = User::factory()->create();

    $longThoughts = str_repeat('a', 200); // Exactly at the limit

    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => 'https://example.com',
        'thoughts' => $longThoughts,
    ]);

    $response->assertRedirect(); // Should succeed
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);

it('rejects thoughts that exceed character limit', function () {
    $user = User::factory()->create();

    $tooLongThoughts = str_repeat('a', 201); // Over the limit

    $response = $this->actingAs($user)->post('/status-with-link', [
        'url' => 'https://example.com',
        'thoughts' => $tooLongThoughts,
    ]);

    $response->assertSessionHasErrors(['thoughts']);
})->uses(Heritage\Foundation\Testing\RefreshDatabase::class);
