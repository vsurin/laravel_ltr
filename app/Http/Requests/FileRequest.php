<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    protected $errorMessageType = 'The file must be a file of type: csv, xlsx.';
    protected $errorMessageEmpty = 'Select a file';

    protected $rules = ['csv', 'xlsx'];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'file',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (empty($this->file())) {
                $validator->errors()->add('file', $this->errorMessageEmpty);

                return false;
            }

            if( ! in_array($this->file('file')->getClientOriginalExtension(), $this->rules) ) {
                $validator->errors()->add('file', $this->errorMessageType);
            }
        });
    }
}
