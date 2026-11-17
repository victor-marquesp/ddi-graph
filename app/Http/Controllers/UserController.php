<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\StoreUserRequest;

use App\Services\UserService;
use App\DTOs\UserDTO;
use App\Exceptions\NotEnoughUsersException;

class UserController extends Controller {

    public function __construct(
        private UserService $userService
    ){}
    
    public function index() {

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create() {
        return view('users.create');
    }

    public function store(StoreUserRequest $request) {
        
        $dto = UserDTO::fromArray(
            $request->validated()
        );

        $this->userService->create($dto);

        return redirect()->route('users.index')->with('success', 'User created');
    }

    public function show(User $user) {

        $isLastUser = User::count() < 2;

        return view('users.show', compact('user', 'isLastUser'));
    }

    public function edit(User $user) {
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user) {
        
        $dto = UserDTO::fromArray(
            $request->validated()
        );

        $user = $this->userService->update(
            dto: $dto,
            user: $user
        );

        return redirect()->route('users.show', $user)->with('success', 'User Updated');
    }

    public function destroy(Request $request, User $user) {

        $isCurrentUser = auth()->id() === $user->id;

        try {

            $this->userService->delete(user: $user);

        } catch (NotEnoughUsersException $e) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Não é possível excluir o último usuário.');
        }

        if ($isCurrentUser) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('welcome')
                ->with('success', 'Sua conta foi excluída.');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Usuário excluído com sucesso.');

    }
}
