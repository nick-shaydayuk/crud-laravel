<?php

namespace Tests\Feature;

use App\Models\Person;
use App\States\Active;
use App\States\Banned;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->person = Person::factory()->create();
});

it('can show index page', function () {
    $response = $this->get(route('people.index'));

    $response->assertOk();
});

it('can show the form for creating a new resource', function () {
    $response = $this->get(route('people.create'));

    $response->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('People/Create')
        );
});

it('can store', function () {
    Storage::fake('public');

    $data = [
        'name' => 'testuser',
        'email' => 'test@example.com',
        'gender' => 'male',
        'birthday' => '2000-01-01',
    ];

    $response = $this->post(route('people.store'), $data);
    $response->assertRedirect(route('people.index'))
        ->assertStatus(302);

    $this->assertDatabaseHas('people', ['name' => $data['name']]);
});

it('can display the specified person', function () {
    $response = $this->get(route('people.show', $this->person));

    $response->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('People/Show')
            ->has('person')
        );
});

it('can show the form for editing the specified person', function () {
    $response = $this->get(route('people.edit', $this->person));

    $response->assertStatus(200)
        ->assertInertia(fn (Assert $page) => $page
            ->component('People/Edit')
            ->has('person')
        );
});

it('can update the specified person', function () {
    Storage::fake('public');

    $data = Person::factory()->make()->toArray();
    $data['avatar'] = UploadedFile::fake()->image('avatar.jpg');

    $response = $this->put(route('people.update', $this->person), $data);

    $response->assertRedirect(route('people.index'));

    Storage::disk('public')->assertExists('avatars/' . $data['avatar']->hashName());
    $this->assertDatabaseHas('people', ['name' => $data['name']]);
});

it('can remove the specified person', function () {
    $response = $this->delete(route('people.destroy', $this->person->id));
    $response->assertRedirect(route('people.index'));
    $this->assertSoftDeleted($this->person);
});

it('can ban the specified resource', function () {
    $response = $this->post(route('people.ban', $this->person->id));

    $response->assertRedirect(route('people.index'));
    $this->assertEquals(Banned::class, $this->person->fresh()->state);
});

it('can unban the specified resource', function () {
    $this->person->state->transitionTo(Banned::class);

    $response = $this->post(route('people.unban', $this->person->id));

    $response->assertRedirect(route('people.index'));
    $this->assertEquals(Active::class, $this->person->fresh()->state);
});
