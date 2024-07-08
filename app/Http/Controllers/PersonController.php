<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Models\Person;
use App\States\Active;
use App\States\Banned;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use App\Http\Resources\PersonResource;

class PersonController extends Controller
{
    public function index()
    {
        return Inertia::render('Person/Index', ['person' => Person::get()]);
    }

    public function create()
    {
        return Inertia::render('Person/Create');
    }

    public function store(StorePersonRequest $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'gender' => 'required|string|max:255',
        //     'birthday' => 'required|date',
        //     'email' => 'required|string|lowercase|email|max:255|unique:' . Person::class,
        // ]);
        //dd('fuck1');
        $birthday = date_create($request->birthday);
        $formattedBirthday = $birthday->format('Y-m-d');
        Person::create([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'state' => $request->state,
            'birthday' => $formattedBirthday,
        ]);
        //dd('fuck');
        return redirect(route('person.index'))->with('message', __('messages.create_user'));
    }

    public function show(Person $user)
    {
        return Inertia::render('Person/Show', ['user' => $user]);
    }

    public function edit(Person $user)
    {
        //dd($user);
        return inertia('Person/Edit', [
            'user' => new PersonResource($user),
        ]);
    }

    public function update($request, Person $user)
    {

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect(route('person.index'))->with('message', __('messages.edit_user'));
    }

    public function delete($id)
    {
        $user = Person::findOrFail($id);
        $user->delete();

        return redirect(route('person.index'))->with('message', __('messages.delete_user'));
    }

    public function forceDelete($id)
    {
        $user = Person::withTrashed()->findOrFail($id);
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->forceDelete();

        return redirect(route('person.index'))->with('message', __('messages.delete_user'));
    }

    public function ban($id)
    {
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Banned::class);

        return redirect(route('person.index'))->with('message', __('messages.ban_user'));
    }

    public function unban($id)
    {
        $user = Person::findOrFail($id);
        $user->state->transitionTo(Active::class);

        return redirect(route('person.index'))->with('message', __('messages.unban_user'));
    }

    public function restore($id)
    {
        $user = Person::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect(route('person.index'))->with('message', __('messages.restore_user'));
    }

}
