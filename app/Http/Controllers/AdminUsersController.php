<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Hotel;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = Hotel::get();
        return view('admin.user.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        // dd($input);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $input['password'] = Hash::make($request->password);
        User::create($input);

        return redirect('admin/users')->with('success', "Add Record Successfully");
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
    public function edit($id)
    {
        $hotels = Hotel::get();
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user', 'hotels'));
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $user = User::findOrFail($id);
        $input = $request->all();
        if (isset($request->password)) {
            $input['password'] = Hash::make($request->password);
        }
        $user->update($input);
        return redirect('admin/users')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function userActive($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->is_active == 1) {
            $user->is_active = 0;
        } else {
            $user->is_active = 1;
        }
        $user->save();
        return redirect()->back()->with('success', "update Record Successfully");
    }
}
