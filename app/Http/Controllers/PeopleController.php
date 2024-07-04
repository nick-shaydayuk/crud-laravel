<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePeopleRequest;
use App\Http\Requests\UpdatePeopleRequest;
use App\Models\People;
use App\States\Active;
use App\States\Banned;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PeopleController extends Controller
{
    public function index()
    {
        return Inertia::render('People/Index', ['people' => People::get()]);
    }

    public function create()
    {
        return Inertia::render('People/Create');
    }

    public function store(StorePeopleRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        People::create($data);

        return redirect(route('people.index'))->with('message', __('messages.create_user'));
    }

    public function show(People $user)
    {
        return Inertia::render('People/Show', ['user' => $user]);
    }

    public function edit(People $user)
    {
        return Inertia::render('People/Edit', ['user' => $user]);
    }

    public function update($request, People $user)
    {

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect(route('people.index'))->with('message', __('messages.edit_user'));
    }

    public function delete($id)
    {
        $user = People::findOrFail($id);
        $user->delete();

        return redirect(route('people.index'))->with('message', __('messages.delete_user'));
    }

    public function forceDelete($id)
    {
        $user = People::withTrashed()->findOrFail($id);
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->forceDelete();

        return redirect(route('people.index'))->with('message', __('messages.delete_user'));
    }

    public function ban($id)
    {
        $user = People::findOrFail($id);
        $user->state->transitionTo(Banned::class);

        return redirect(route('people.index'))->with('message', __('messages.ban_user'));
    }

    public function unban($id)
    {
        $user = People::findOrFail($id);
        $user->state->transitionTo(Active::class);

        return redirect(route('people.index'))->with('message', __('messages.unban_user'));
    }

    public function restore($id)
    {
        $user = People::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect(route('people.index'))->with('message', __('messages.restore_user'));
    }
}
