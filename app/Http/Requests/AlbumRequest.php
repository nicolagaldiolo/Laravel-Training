<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_name'    => 'required|unique:albums:name',
            'description'   => 'required',
            'album_thumb'   => 'required|image'
        ];
    }
}

/*
// definisco dei messaggi di errore custom
protected $custom_error_messages = [
    'album_id.required'      => 'Campo album_id obbligatorio',
    'name.required'          => 'Campo name obbligatorio',
    'description.required'   => 'Campo description obbligatorio',
    'img_path.required'      => 'Campo img_path obbligatorio'
];
*/