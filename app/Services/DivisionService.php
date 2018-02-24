<?php
namespace App\Services;

use App\Models\Division;
use Illuminate\Http\Request;
use App\Repositories\DivisionRepository;

class DivisionService
{
    protected $divisionRepository;

    public function __construct(DivisionRepository $divisionRepository)
    {
        $this->divisionRepository = $divisionRepository;
    }

    public function getAll($filters = [])
    {
        return $this->divisionRepository->getAll($filters);
    }

    public function create(Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->divisionRepository->create($input);
    }

    public function update(Division $division, Request $request)
    {
        $input = $request->except(['_token', '_method', 'id']);

        return $this->divisionRepository->update($division, $input);
    }

    public function delete(Division $division, Request $request)
    {
        return $this->divisionRepository->delete($division);
    }
}
