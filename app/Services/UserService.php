<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserService
{
    public $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll(Request $request = null)
    {
        $filters = [];
        if (!is_null($request)) {
            $limit  = $request->get('page');
            $filters['email']      = $request->get('email');
            $filters['username']   = $request->get('username');
            $filters['first_name'] = $request->get('first_name');
            $filters['last_name']  = $request->get('last_name');            
        }

        return $this->userRepository->getAll($filters, $limit);
    }

    public function create(Request $request)
    {
        $input    = $request->except(['_token', '_method', 'id']);
        $response = $this->userRepository->create($input);

        return $response;
    }

    public function update(User $user, Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->userRepository->update($user, $input);
    }

    public function delete(User $user)
    {
        return $this->userRepository->delete($user);
    }
}
