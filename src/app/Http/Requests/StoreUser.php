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
        // contain at least 1 uppercase character , 1 lowercase character, 1 digit and a special charact
        //'regex:/^.+@.+$/i'
        return [
            'name' => 'required|min:4',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', new AppPassword],
        ];
    }

}
