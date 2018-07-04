<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminFormRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function getActionButton(User $user){
        $button = [
            '<a href="' . route('users.edit', $user->id) . '" class="btn btn-primary"><i class="fa fa-edit"></i></a>',
            '<a data-method="delete" href="' . route('users.destroy', $user->id) . '" class="btn btn-secondary ajax-action"><i class="fa fa-minus"></i></a>',
            '<a data-method="delete" href="' . route('users.destroy', $user->id) . '?forceDelete" class="btn btn-danger ajax-action"><i class="fa fa-trash-alt"></i></a>'
        ];
        if($user->deleted_at) {
            $button[1] = '<a data-method="patch" href="' . route('users.restore', $user->id) . '" class="btn btn-secondary ajax-action"><i class="fa fa-plus"></i></a>';
        }

        return implode(" ", $button);
    }

    public function index(Request $request)
    {
        if($request->expectsJson()){
            $users = User::select(['id', 'name','email','created_at','updated_at', 'deleted_at'])->withTrashed();
            return DataTables::of($users)->addColumn('action', function($user){
                return $this->getActionButton($user);
            })->editColumn('created_at', function($user){
                return ($user->created_at) ? $user->created_at->diffForHumans() : '';
            })->editColumn('updated_at', function($user){
                return ($user->updated_at) ? $user->updated_at->diffForHumans() : '';
            })->editColumn('deleted_at', function($user){
                return ($user->deleted_at) ? $user->deleted_at->diffForHumans() : '';
            })->make(true);
        }
        return view('admin.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFormRequest $request, User $user)
    {

        (bool) $res = $user->update( $request->validated());
        $message = ($res) ? 'User modificato con successo' : 'User non modificato';
        session()->flash('message', $message);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        (bool) $res = User::withTrashed()->findOrFail($id)->restore();
        return [
            'message' => $res ? 'User Restored' : 'User not Restored',
            'status'   => $res
        ];
    }

    public function destroy($id, Request $request)
    {

        $user = User::withTrashed()->findOrFail($id);
        (bool) $res = ($request->has('forceDelete')) ? $user->forceDelete() : $user->delete();

        return [
            'message' => $res ? 'User deleted' : 'User not deleted',
            'status'   => $res
        ];
    }

}
