<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DosenCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "rfid_uid" => ["required", "string", "min:1", "max:100"],
            "name" => ["required", "string", "min:1", "max:100"],
            "nidn" => ["required", "string", "min:1", "max:100"]
        ];
    }
//    Overriding
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw  new HttpResponseException(response([
            "code"=> 400,
            "status"=> "BAD_REQUEST",
            "success"=> false,
            "errors" => [
                $validator->getMessageBag()
            ],
        ], 400));

    }
}
