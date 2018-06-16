<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Album;
use Gate;

class AlbumEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() // definisco se l'utente è autorizzato o meno ad effettuare questa richiesta (in caso contrario solleva un eccezzione)
    {
        /*
        // POSSO CREARMI UN CONTROLLO DI AUTORIZZAZIONE SE L'UTENTE è AUTORIZZATO AD EFFETTUARE QUESTA RICHIESTA QUI NELLA CLASSE DENTRO IL METODO AUTHORIZE
        // OLTRE CHE ALL'INTERNO DEI SINGOLI CONTROLLER, COSì TUTTI I CONTROLLER CHE INCLUDONO QUESTA CLASSE REQUEST AVRANNO IL CONTROLLO DI AUTORIZZAZIONE

        // Devo recuperarmi l'id dell'album per sapere quale album devo passare al gate. Posso recuperarmi l'id dalla request
        $id_album = $this->id;
        $album = Album::find($id_album);

        /// utilizzo un gates utilizzando i metodi denies o allows
        // se il gate manage-album definito in Providers/AuthServiceProvider torna false allora abortisco
        if( Gate::denies('manage-album', $album)){
            return false;
        }
        return true;
        */
        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'album_name'    => 'required',
            'description'   => 'required',
            //'album_thumb'   => 'required|image',
            //'user_id'       => 'required'
        ];
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

}
