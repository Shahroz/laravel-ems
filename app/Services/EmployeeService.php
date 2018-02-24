<?php
namespace App\Services;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    public $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function getAll(Request $request = null)
    {
        $filters = [];
        if (!is_null($request)) {
            $filters['firstname']       = $request->get('firstname');
            $filters['department.name'] = $request->get('department_name');
        }

        return $this->employeeRepository->getAll($filters);
    }

    public function create(Request $request)
    {
        // Upload image
        $path            = $request->file('avatar')
            ->store('avatars');
        $input           = $request->except(['_method', '_token', 'id']);
        $input['avatar'] = $path;

        return $this->employeeRepository->create($input);
    }

    public function update(Employee $employee, Request $request)
    {
        $input = $request->except(['_method', '_token', 'id']);
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store('avatars');
            $input['avatar'] = $path;
        }

        return $this->employeeRepository->update($employee, $input);
    }

    public function delete(Employee $employee)
    {
        return $this->employeeRepository->delete($employee);
    }

    public function getHiredEmployees($filters = [])
    {
        if (empty($filters)) {
            return [];
        }

        return $this->employeeRepository->getHiredEmployees($filters);
    }

    public function getExportingData($filters = [])
    {
        if (empty($filters)) {
            return [];
        }

        return $this->employeeRepository->getExportingData($filters);
    }
}
