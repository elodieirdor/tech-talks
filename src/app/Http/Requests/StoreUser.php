<?php
namespace App\Http\Requests;

use App\Rules\AppPassword;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:4',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', new AppPassword],
        ];
    }
}
