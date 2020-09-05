<?php
namespace App\Http\Requests;

use App\Rules\TalkDate;
use App\Rules\TalkDescription;
use App\Talk;
use Illuminate\Foundation\Http\FormRequest;

class StoreTalk extends FormRequest
{
    public function authorize()
    {
        $id = $this->route('id');
        if (null === $id) {
            return true;
        }

        $talk = $this->user()->talks->find($id);
        if (null === $talk) {
            return false;
        }

        if ($talk->status === Talk::STATUS_PUBLISHED) {
            return false;
        }

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
