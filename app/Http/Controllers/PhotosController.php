<?php

namespace App\Http\Controllers;

use App\Album;
use App\Photo;
use Illuminate\Http\Request;
use Storage;
use Auth;

class PhotosController extends Controller
{

    // definisco le regole di validazione per i vari campi
    protected $rules = [
        'album_id'      => 'required|exists:albums,id',
        'name'          => 'required|unique:photos,name',
        'description'   => 'required',
        'img_path'      => 'required|image'
    ];

    // definisco dei messaggi di errore custom
    protected $custom_error_messages = [
        'album_id.required'      => 'Campo album_id obbligatorio',
        'name.required'          => 'Campo name obbligatorio',
        'description.required'   => 'Campo description obbligatorio',
        'img_path.required'      => 'Campo img_path obbligatorio'
    ];


    public function __construct(){
        //proteggo tutti i metodi del controller chiamando authorizeResource nel costruttore passando il modello
        $this->authorizeResource(Photo::class);
        // altrimenti potrei proteggee il singolo metodo chiamando: $this->authorize($photo); all'interno del singolo metodo
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photo = Photo::paginate();

        return $photo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $album_id = $req->has('aid') ? $req->input('aid') : null; // recupero dalla request l'id dell'album che mi sono passato
        $album = Album::firstOrNew(['id' => $album_id]);
        // se l'id esiste mi torno il modello dell'album relativo a quell'id altrimenti creo una nuova instanza,
        // a differenza di firstOrCreate() che crea un nuovo record sul db
        // l'instanza mi serve solo per avere la variabile $album valorizzata

        $photo = new Photo(); // creo una nuova instanza di photo in quanto utilizzo la stessa vista sia per
        // l'edit che per il new photo e nell'edit photo ho l'oggetto photo valorizzato. nel caso nel new photo non ho
        // la variabile $photo valorizzata quindi per evitare l'errore creo un instanza "vuota".

        $albumList = $this->getAlbums($req);

        //dd($album);

        return view('photos.editCreate', compact('album', 'photo', 'albumList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // estendendo la classe controller eredito il traits ValidatesRequests il quale ha un metodo validate
        // che si aspetta un oggetto request, le regole di validazione, eventuali messaggi di errore ed eventuali attributi custom
        // se la validazione fallisce viene ricaricata la pagina e viene automaticamente iniettata nella view un array errors
        $this->validate($request, $this->rules, $this->custom_error_messages);

        $photo = new Photo();
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->img_path = '';
        $photo->album_id = $request->input('album_id');
        $this->processFile($photo);
        $res = $photo->save();

        $message = ($res > 0) ? 'Immagine creata con successo' : 'Immagine non creata';
        session()->flash('message', $message);

        return redirect()->route('albumImages', $photo->album_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        dd($photo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Photo $photo)
    {

        $album = $photo->album; // torna la relazione, i dati dell'album
        $albumList = $this->getAlbums($request);

        return view('photos.editCreate', compact('albumList', 'album', 'photo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {

        $this->validate($request, $this->rules);

        //dd('passato');

        $this->processFile($photo);
        $photo->name = $request->input('name');
        $photo->description = $request->input('description');
        $photo->album_id = $request->input('album_id');
        $res = $photo->save();

        $message = ($res > 0) ? 'Immagine aggiornata con successo' : 'Immagine non aggiornata';
        session()->flash('message', $message);

        return redirect()->route('albumImages', $photo->album_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //return Photo::destroy($id); //questo metodo sarebbe perfetto, però come possiamo vedere per gli album anche qui devo eliminare la thumb se la trovo, quindi effettuo il type hinting del modello Photos, associo il modello ad un parametro della rotta
        $response = $photo->delete();
        if($response){
            $this->deleteImage($photo->img_path);
        }

        return (String) $response;

    }

    public function getAlbums($request){

        // Per RECUPERARE I DATI DELLO USER posso fare in due modi, con la facade Auth, oppure vi viene cmq iniettato nella request
        // 1- tramite Request $request->user();
        // 2- tramite Facade Auth Request Auth::user(); (attenzione che usando la facade deve prima essere importata (=use Auth;))

        return Album::orderBy('album_name')->where('user_id', Auth::user()->id)->get();
    }

    public function deleteImage($thumbnail = null){
        $disc = config('filesystems.default'); // recupero dal file di configurazione il disco utilizzato
        if($thumbnail && Storage::disk($disc)->has($thumbnail)){ // se esiste la thumb sul db e sul disco
            return Storage::disk($disc)->delete($thumbnail); // elimino la thumb da disco
        }
        return false;
    }

    public function processFile(Photo $photo){

        if (!request()->hasFile('img_path')) { //controllo se nella request c'è una chiave album_thumb altrimenti torno false
            return false;
        }

        $file = request()->file('img_path'); // salvo nella variabile l'oggetto uploadedFile
        if (!$file->isValid()) { // controllo se il file contiene errori torno false altrimenti procedo
            return false;
        }

        //avendo impostato come disco di default per il salvataggio il disco public nel file config/filesystem.php non
        // serve che passo alcun parametro aggiuntivo, se in quale caso particolare voglio dichiare un disco diverso
        // da quello di default posso passare come 2° parametro il disco di salvataggio tra quelli configurati (local, public, S3)
        //$filePath = $file->store(env('ALBUM_THUMB_DIR')); // do libertà al laravel di creare un file con un nome random
        $fileName = 'photo_' . $photo->id . '.' . $file->extension();
        $filePath = $file->storeAs(env('IMG_DIR') . '/' . $photo->album_id, $fileName); // imposto il nome del file
        $photo->img_path = $filePath;

        return true;
    }

}
