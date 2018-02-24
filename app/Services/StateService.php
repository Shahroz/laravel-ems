<?php
namespace App\Services;

use App\Models\State;
use Illuminate\Http\Request;
use App\Repositories\StateRepository;

class StateService
{
    protected $stateRepository;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function getAll($filters = [])
    {
        return $this->stateRepository->getAll($filters);
    }

    public function getStateList()
    {
        return $this->stateRepository->getStateList();
    }

    public function create(Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->stateRepository->create($input);
    }

    public function update(State $state, Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->stateRepository->update($state, $input);
    }

    public function delete(State $state)
    {
        return $this->stateRepository->delete($state);
    }
}
