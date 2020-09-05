<?php


namespace App\Factory\Model;

use App\User;
use Symfony\Component\HttpFoundation\Request;

class UserFactory
{
    public function createFromRequest(Request  $request) : User
    {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        return $user;
    }
}
