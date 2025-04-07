<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.view']);

        return view('backend.pages.users.index', [
            'users' => User::all(),
        ]);
    }

    public function create(): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        return view('backend.pages.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.create']);

        // Validate and store the user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', 'User has been created.');
        return redirect()->route('admin.users.index');
    }

    public function show($id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.view']);

        $user = User::findOrFail($id);
        return view('backend.pages.users.show', compact('user'));
    }

    public function edit($id): Renderable
    {
        $this->checkAuthorization(auth()->user(), ['user.edit']);

        $user = User::findOrFail($id);
        return view('backend.pages.users.edit', compact('user'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.edit']);

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        session()->flash('success', 'User has been updated.');
        return redirect()->route('admin.users.index');
    }

    public function destroy($id): RedirectResponse
    {
        $this->checkAuthorization(auth()->user(), ['user.delete']);

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User has been deleted.');
        return redirect()->route('admin.users.index');
    }
}