<?php

namespace App\Services;

use App\DTOs\UserDTO;
use App\Exceptions\NotEnoughUsersException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService {

    public function create(UserDTO $dto) : User {

        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);

        return $user;
    }

    public function update(UserDTO $dto, User $user) : User {

        $user->update([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);

        $user->refresh();

        return $user;
    }

    public function delete(Request $request, User $user) : void {
            
        if(User::count() < 2) {
            throw new NotEnoughUsersException('Less than 2 Users ');
        }
            
        $user->delete();
    }

}