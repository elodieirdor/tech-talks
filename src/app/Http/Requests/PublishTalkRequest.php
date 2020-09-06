<?php


namespace App\Http\Requests;

use App\Manager\TalkDateManager;
use App\Talk;
use Illuminate\Foundation\Http\FormRequest;

class PublishTalkRequest extends FormRequest
{
    protected Talk $talk;
    protected TalkDateManager $talkDateManager;

    public function __construct(
        array $query = [],
        array $request = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null,
        TalkDateManager $talkDateManager
    ) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        $this->talkDateManager = $talkDateManager;
    }

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
                $validator->errors()->add('status', 'Already published');
            }

            if (false === $this->talkDateManager->isSubmissionDateValid(new \DateTime($this->talk->date))) {
                $validator->errors()->add('date', 'Date does not match the requirements');
            }
        });
    }

    public function rules()
    {
        return [];
    }

}
