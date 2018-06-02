<?php

namespace App\Http\Controllers;

use App\Album;
use Illuminate\Http\Request;
use Storage;
//use DB; // non uso più la facade DB perchè utilizzo sempre il Model

class AlbumsController extends Controller
{
    function index(Request $request)
    {

        //Posso recuperare i dati in 3 modi, utilizzando model, utilizzando direttamente il query builder o con delle query grezze:

        // MODEL
        $queryBuilder = Album::orderBy('id', 'desc');
        if ($request->has('id')) {
            //$album -> where('id', '=', $request->input('id'));
            $queryBuilder->where('id', $request->get('id')); // se la condizione è uguale posso omettere il segno uguale
        }
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->get('album_name') . '%');
        }
        $album = $queryBuilder->get(); // creo la collection (array di dati), altrimenti senza il get sarebbe l'oggetto query builder

        /*
        // QUERY BUILDER
        $queryBuilder = DB::table('albums')->orderBy('id', 'desc');
        if ($request->has('id')) {
        //$album -> where('id', '=', $request->input('id'));
        $queryBuilder -> where('id', $request->get('id')); // se la condizione è uguale posso omettere il segno uguale
        }
        if ($request->has('album_name')) {
        $queryBuilder -> where('album_name', 'like', '%' . $request->get('album_name') . '%');
        }
        $album = $queryBuilder->get(); // creo la collection (array di dati), altrimenti senza il get sarebbe l'oggetto query builder
        */

        // QUERY GREZZE
        // utilizzo uno statement così da essere più sicuro ed evitare la sequel injection
        /*
        $sql = "SELECT * FROM albums WHERE 1=1";
        $where = [];
        if ($request->has('id')) {
          $where['id'] = $request->get('id'); // posso usare anche il metodo input $request->input('id')
          $sql .= " AND id = :id";
        }
        if ($request->has('album_name')) {
          $where['album_name'] = $request->get('album_name'); // posso usare anche il metodo input $request->input('album_name')
          $sql .= " AND album_name = :album_name";
        }
        $sql .= " ORDER BY id DESC";
        $album = DB::select($sql, $where);
        //dd($album);
        */

        return view('albums.albums', ['data' => $album]);
    }

    function show($id = '')
    {

        //$sql = "SELECT album_name, description FROM albums WHERE id = :id";
        //$album = DB::select($sql, ['id' => $id]);

        //$album = DB::table('albums')->where('id', $id)->get();

        //$album = Album::where('id', $id)->get(); // torna la collection con il dato
        $album = Album::find($id); // torna l'oggetto Album

        return view('albums.edit', ['data' => $album]);
    }

    function create($id = '')
    {

        return view('albums.create');
    }

    function save()
    {

        // PER RECUPERARE I VALORI DALLA REQUEST POSSO FARE IN VARI MODI:
        // 1: passo la request nel metodo, es: function update(Request, $request){
        // 2: estraggo dalla request tutti i valori, es: $response = request()->all();
        // 3: estraggo dalla request sono alcuni campi, es: $response = request()->only('album_name', 'description');


// QUERY GREZZA
        //$response = request()->only('album_name', 'description');
        //$response['user_id'] = 1;
        /*$sql = "INSERT INTO albums (album_name, description, user_id) VALUES (:album_name, :description, :user_id)";
        $res = DB::insert($sql, $response);*/

// QUERY BUILDER
        /*
        $res = DB::table('albums')->insert([
            'album_name' => request()->get('album_name'),
            'description' => request()->get('description'),
            'user_id' => 1
        ]); // posso inserire anche più record contemporaneamente passando un array di array
        */

// MODEL 1
        // per inserire i record senza alcun controllo potrei usare il metodo insert, mentre se uso il metodo create
        // laravel controller se i campi indicati sono fillable ossia riepibili, per rendere un campo riempibile devo aggiungerlo all'array
        // fillable, ossia una proprietà del modello Album
        /*$res = Album::create([
            'album_name' => request()->get('album_name'),
            'description' => request()->get('description'),
            'user_id' => 1
        ]);*/

// MODEL 2
        //in alternativa posso creare una nuova instanza del model Album e creare il record, in qeusto modo non devo neanche dichiarare i campi fillable
        $album = new Album;
        $album->album_name = request()->get('album_name');
        $album->description = request()->get('description');
        $album->album_thumb = '';
        $album->user_id = 1;
        $res = $album->save();

        // siccome ho precedentemente salvato l'album, e quindi ho un id lo posso passare alla funzione
        if( $this->processFile($album->id, $album)){
            $res = $album->save();
        }

        $message = ($res > 0) ? 'Album creato con successo' : 'Album non creato';
        session()->flash('message', $message);

        return redirect()->route('albums');

    }

    function update($id = '')
    { // avrei potuto passarmi l'id come campo input ma lo posso estrarre dall'url

        // PER RECUPERARE I VALORI DALLA REQUEST POSSO FARE IN VARI MODI:
        // 1: passo la request nel metodo, es: function update(Request, $request){
        // 2: estraggo dalla request tutti i valori, es: $response = request()->all();
        // 3: estraggo dalla request sono alcuni campi, es: $response = request()->only('album_name', 'description');

        /*
        $response = request()->only('album_name', 'description');
        $response['id'] = $id;

// QUERY GREZZA
        $sql = "UPDATE albums SET album_name = :album_name, description = :description WHERE id = :id";
        $res = DB::update($sql, $response);
        */

// QUERY BUILDER
        /*
        $res = DB::table('albums')->where('id', $id)->update([
            'album_name' => request()->get('album_name'),
            'description' => request()->get('description'),
        ]);*/


// MODEL 1
        /*$res = Album::where('id', $id)->update([
            'album_name' => request()->get('album_name'),
            'description' => request()->get('description'),
        ]);*/

// MODEL 2
        /*$res = Album::find($id)->update([
            'album_name' => request()->get('album_name'),
            'description' => request()->get('description'),
        ]);
        */

// MODEL 3
        $album = Album::find($id);
        $album->album_name = request()->get('album_name');
        $album->description = request()->get('description');

        $this->processFile($id, $album);

        $res = $album->save();

        $message = ($res > 0) ? 'Album aggiornato con successo' : 'Album non aggiornato';
        session()->flash('message', $message);

        return redirect()->route('albums');

    }

    function delete(Album $id) // effettuo il type hinting dell'album, associo il modello ad un parametro della rotta,
        // gratis laravel associa alla variabile id l'album e me lo filtra già con la primaryKey ricevuta dalla rotta.
    {
        /*$response = '';
        if ($id) {
          $sql = "DELETE FROM albums WHERE id = :id";
          $response = DB::delete($sql, ['id' => $id]);
        }*/

        //return redirect('albums'); //ridirigo manualemente metodo 1
        //return redirect()->route('albums'); //ridirigo manualemente metodo 2
        //return redirect()->back(); //ridirigo da dove sono venuto

        //$response = DB::table('albums')->where('id', $id)->delete();

        //$response = Album::where('id', $id)->delete();
        // torna il valore 1 in caso di successo

        // se non passo l'oggetto album al metodo (facendo il type hint) dovrei create un instanza dell'album
        //$album = Album::find($id);
        //$response = $album->delete();

        $response = $id->delete();
        if($response){
            $disc = config('filesystems.default'); // recupero dal file di configurazione il disco utilizzato
            $thumbnail = $id->album_thumb;
            if($thumbnail && Storage::disk($disc)->has($thumbnail)){ // se esiste la thumb sul db e sul disco
                Storage::disk($disc)->delete($thumbnail); // elimino la thumb da disco
            }
        }

        // dato che viene invocato via ajax torno $response
        return (string) $response;

    }

    public function processFile($id, $album){

        if (!request()->hasFile('album_thumb')) { //controllo se nella request c'è una chiave album_thumb altrimenti torno false
            return false;
        }

        $file = request()->file('album_thumb'); // salvo nella variabile l'oggetto uploadedFile
        if (!$file->isValid()) { // controllo se il file contiene errori torno false altrimenti procedo
            return false;
        }

        //avendo impostato come disco di default per il salvataggio il disco public nel file config/filesystem.php non
        // serve che passo alcun parametro aggiuntivo, se in quale caso particolare voglio dichiare un disco diverso
        // da quello di default posso passare come 2° parametro il disco di salvataggio tra quelli configurati (local, public, S3)
        //$filePath = $file->store(env('ALBUM_THUMB_DIR')); // do libertà al laravel di creare un file con un nome random
        $fileName = "album_" . $id . '.' . $file->extension();
        $filePath = $file->storeAs(env('ALBUM_THUMB_DIR'), $fileName); // imposto il nome del file
        $album->album_thumb = $filePath;

        return true;
    }
}
