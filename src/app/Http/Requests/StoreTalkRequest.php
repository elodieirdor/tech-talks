<?php
namespace App\Http\Requests;

use App\Rules\TalkDate;
use App\Rules\TalkDescription;
use App\Talk;
use Illuminate\Foundation\Http\FormRequest;

class StoreTalkRequest extends FormRequest
{
    protected Talk $talk;

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

        $this->talk = $talk;

        return true;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->talk->status === Talk::STATUS_PUBLISHED) {
                $validator->errors()->add('status', 'Published talk can not be updated');
            }
        });
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
