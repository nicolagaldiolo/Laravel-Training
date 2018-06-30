<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $rules = [
        'name' => 'required|min:3|max:50',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = auth()->user()->categories()->withCount('album')->latest()->paginate();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $res = auth()->user()->categories()->create( $request->only('name'));

        // controllo se la richiesta si aspetta un json quindi è una chiamata ajax altrimenti faccio il redirect
        if($request->expectsJson()){

            $categories = auth()->user()->categories()->withCount('album')->latest()->paginate();

            $message = ($res) ? 'Categoria creata con successo' : 'Categoria non creata';
            session()->flash('message', $message);

            return [
                'message'   => (bool) $res ? 'Category created' : 'Category not created',
                'status'    => (bool) $res,
                'data'      => view('categories._list', compact('categories'))->render(),
            ];

        }
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = auth()->user()->categories()->find($id);
        $category->name = $request->get('name');
        $res = $category->save();


        // controllo se la richiesta si aspetta un json quindi è una chiamata ajax altrimenti faccio il redirect
        if($request->expectsJson()){

            $categories = auth()->user()->categories()->withCount('album')->latest()->paginate();
            $message = ($res) ? 'Categoria aggiornata con successo' : 'Categoria non aggiornato';
            session()->flash('message', $message);
            return [
                'message'   => (bool) $res ? 'Category updated' : 'Category not updated',
                'status'    => (bool) $res,
                'data'      => view('categories._list', compact('categories'))->render(),
            ];
        }
        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        (bool) $res = $category->delete();

        // controllo se la richiesta si aspetta un json quindi è una chiamata ajax altrimenti faccio il redirect
        if($request->expectsJson()){
            return [
                'message' => $res ? 'Category deleted' : 'Category not deleted',
                'status'   => (bool) $res
            ];
        }
        return;


    }
}
