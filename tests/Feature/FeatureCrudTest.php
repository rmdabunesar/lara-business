<?php

use App\Models\User;
use App\Models\Feature;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

beforeEach(function () {
    $this->withoutMiddleware(PreventRequestForgery::class);
});

function cleanupFeatureIcon(?string $icon): void
{
    if ($icon && file_exists(public_path($icon))) {
        @unlink(public_path($icon));
    }
}

test('add feature stores record with uploaded icon', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('store.feature'), [
        'title'       => 'Fast Delivery',
        'description' => 'We deliver your products quickly.',
        'photo'       => UploadedFile::fake()->image('icon.png', 100, 100),
    ]);

    $response->assertRedirect(route('all.feature'));

    $feature = Feature::first();
    expect($feature)->not->toBeNull();
    expect($feature->title)->toBe('Fast Delivery');
    expect($feature->icon)->toStartWith('upload/feature/');
    expect(file_exists(public_path($feature->icon)))->toBeTrue();

    cleanupFeatureIcon($feature->icon);
});

test('edit feature page renders existing feature', function () {
    $user = User::factory()->create();
    $feature = Feature::create(['title' => 'Old', 'description' => 'Old desc']);

    $this->actingAs($user)->get(route('edit.feature', $feature->id))
        ->assertStatus(200)
        ->assertSee('Old');
});

test('update feature changes fields and replaces icon', function () {
    $user = User::factory()->create();
    $feature = Feature::create(['title' => 'Old', 'description' => 'Old desc', 'icon' => null]);

    $response = $this->actingAs($user)->post(route('update.feature'), [
        'id'          => $feature->id,
        'title'       => 'New Title',
        'description' => 'New description',
        'photo'       => UploadedFile::fake()->image('new.png', 100, 100),
    ]);

    $response->assertRedirect(route('all.feature'));

    $feature->refresh();
    expect($feature->title)->toBe('New Title');
    expect($feature->description)->toBe('New description');
    expect($feature->icon)->toStartWith('upload/feature/');
    expect(file_exists(public_path($feature->icon)))->toBeTrue();

    cleanupFeatureIcon($feature->icon);
});

test('delete feature removes record and its icon file', function () {
    $user = User::factory()->create();

    // create a feature with a real icon file to confirm cleanup
    $this->actingAs($user)->post(route('store.feature'), [
        'title'       => 'To Delete',
        'description' => 'bye',
        'photo'       => UploadedFile::fake()->image('del.png', 100, 100),
    ]);
    $feature = Feature::first();
    $iconPath = public_path($feature->icon);
    expect(file_exists($iconPath))->toBeTrue();

    $response = $this->actingAs($user)->post(route('delete.feature', $feature->id));
    $response->assertRedirect(route('all.feature'));

    expect(Feature::find($feature->id))->toBeNull();
    expect(file_exists($iconPath))->toBeFalse();
});

