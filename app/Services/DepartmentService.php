<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Repositories\DepartmentRepository;

class DepartmentService
{
    public $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getAll($filters = [])
    {
        return $this->departmentRepository->getAll($filters);
    }

    public function getDepartmentList()
    {
        return $this->departmentRepository->getDepartmentList();
    }

    public function create(Request $request)
    {
        $input = $request->except(['_method', '_token', 'id']);

        return $this->departmentRepository->create($input);
    }

    public function update(Department $department, Request $request)
    {
        $input = $request->except(['_method', '_token', 'id']);

        return $this->departmentRepository->update($department, $input);
    }

    public function delete(Department $department)
    {
        return $this->departmentRepository->delete($department);
    }
}
