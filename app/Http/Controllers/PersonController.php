<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Person;
use App\States\Active as Active;
use App\States\Banned as Banned;
use Inertia\Inertia;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::all();

        return Inertia::render('People/Index', ['persons' => $person]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('People/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        Person::create($data);

        return to_route('people.index')->with('success', 'Создан новый пользователь!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return inertia('People/Show', ['person' => $person]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        return Inertia::render('People/Edit', ['person' => $person]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        $person->update($data);

        return to_route('people.index')->with('success', "Данные пользователя \"{$person->name}\" успешно обновлены!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect(route('people.index'));
    }

    public function ban($id)
    {
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Banned::class);

        return redirect(route('people.index'));
    }

    public function unban($id)
    {
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Active::class);

        return redirect(route('people.index'));
    }
}
