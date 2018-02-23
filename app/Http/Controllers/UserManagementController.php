<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserFormRequest;

class UserManagementController extends Controller
{
    /**
     * Instance of UserService.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/user-management';


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userService->getAll($request);

        return view('users.index', compact('users'));
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
        $response = $this->userService->create($request);
        if (!$response['status']) {
            return redirect()
                ->back()
                ->with('response', $response);
        }

        return redirect()->route('user.index')
            ->with('response', $response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UserFormRequest $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, User $user)
    {
        $response = $this->userService->update($request, $user);
        if (!$response['status']) {
            return redirect()
                ->back()
                ->with('response', $response);
        }

        return redirect()->route('user.index')
            ->with('response', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\UserFormRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserFormRequest $request, User $user)
    {
        $response = $this->userService->delete($user);

        return redirect()->route('user.index')
            ->with('response', $response);
    }

    /**
     * Search user from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
       $users = $this->userService->getAll($request);

       return view('users.index', [
            'users'         => $users, 
            'searchingVals' => $request->only(['username', 'first_name', 'last_name'])
        ]);
    }
}
