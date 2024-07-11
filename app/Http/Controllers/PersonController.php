<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
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
        $query = Person::query();

        $persons = $query->paginate(10);
        $person = Person::all();
        return Inertia::render('Person/Index', ['person' => $person]);

        // return inertia('Person/Index', [
        //     'person' => PersonResource::collection($persons),
        //     'queryParams' => request()->query() ?: null,
        //     'success' => session('success'),
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Person/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Person::create($data);

        return to_route('person.index')->with('success', 'Создан новый пользователь!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        // return inertia('Person/Show', [
        //     'person' => new PersonResource($person)
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person)
    {
        //dd($person);
        return Inertia::render('Person/Edit', ['user' => $person]);
        /* return inertia('Person/Edit', [
            'person' => new PersonResource($person),
        ]); */
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        
        $data = $request->validated();
        dd($data);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $person->update($data);

        return to_route('person.index')->with('success', "Данные пользователя \"{$person->name}\" успешно обновлены!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();
        return redirect(route('person.index'));
    }

    public function ban($id)
    {
        //dd($id);
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Banned::class);
        //dd($user);
        
        
        return redirect(route('person.index'));
    }

    public function unban($id)
    {
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Active::class);
        //return Inertia::render('Person/Index', ['person' => Person::all()]);
        return redirect(route('person.index'));
    }
}
