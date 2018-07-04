<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->id, // mi permette di ignorare i cambiamenti se las mail che stiamo passando appartiene all'utente, se è cambiata allora scatta il controllo di validazione
            'role'  => [
                'required',
                Rule::in(['user','admin'])
            ]
        ];
    }
}
