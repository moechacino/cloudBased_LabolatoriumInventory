<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PeminjamanMahasiswaCreateRequest extends FormRequest
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
            'alat_lab_id' => ['required', 'integer'],
            'dosen_id' => ['required', 'integer'],
            'mahasiswa_id' => ['required', 'integer'],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'keperluan' => ['required', 'string'],
            'tempat_pemakaian' => ['required', 'string', 'max:100'],
            'tanggal_peminjaman' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_pengembalian' => ['required', 'date', 'after:tanggal_peminjaman'],
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
