<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserFormRequest;

class UserManagementController extends Controller
{
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user-management';
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = (new User)->getUserList(5);

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $input  = $request->except(['_token', '_method']);
        $status = (new User)->addUser($input); 
        return redirect()->intended('/user-management');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $id)
    {
        return view('users.edit', [
            'user' => (object) $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', [
            'user' => (object) $user->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserFormRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        $input  = $request->except(['_token', '_method']);
        $status = (new User)->updateUser($id, $input);
        return redirect()->intended('/user-management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\UserFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFormRequest $request, User $user)
    {
        $result = (new User)->deleteUser($id);
        return redirect()->intended('/user-management');
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $constraints = [
            'username'   => $request->get('username'),
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name')
        ];

       $users        = (new User)->getSearchingQuery($constraints);
       return view('users.index', [
            'users'         => $users, 
            'searchingVals' => $constraints
        ]);
    }
}
