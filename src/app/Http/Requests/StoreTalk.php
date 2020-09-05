<?php
namespace App\Http\Requests;

use App\Rules\TalkDate;
use App\Rules\TalkDescription;
use Illuminate\Foundation\Http\FormRequest;

class StoreTalk extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'topic' => 'required|max:80',
            'description' => ['required', new TalkDescription],
            'date' => ['required', new TalkDate],
        ];
    }
}
