<?php

namespace App\Http\Controllers;

use Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\EmployeeService;

class ReportController extends Controller
{
    /**
     * Instance of Services.
     */
    protected $employeeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->middleware('auth');
        $this->employeeService  = $employeeService;
    }

    public function index()
    {
        $now     = Carbon::now();
        $filters = [
            'from'       => $now->format('Y/m/d'),
            'to'         => $now->addMonth()->format('Y/m/d')
        ];
        
        $employees = $this->employeeService->getHiredEmployees($filters);

        return view('system.report.index', [
            'employees'     => $employees, 
            'searchingVals' => $filters
        ]);
    }

    public function exportExcel(Request $request)
    {
        $this->prepareExportingData($request)
            ->export('xlsx');

        return redirect()->route('system.report.index');
    }

    public function exportPDF(Request $request)
    {
         $filters = [
            'from' => $request['from'],
            'to'   => $request['to']
        ];
        $employees = $this->getExportingData($filters);
        $pdf = PDF::loadView('system.report.pdf', [
            'employees'     => $employees, 
            'searchingVals' => $filters
        ]);

        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
    }

    /**
     * Get list of filtered hired employees
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request)
    {
        $filters = [
            'from' => $request->get('from'),
            'to'   => $request->get('to')
        ];

        $employees = $this->employeeService->getHiredEmployees($filters);
        
        return view('system.report.index', [
            'employees'     => $employees, 
            'searchingVals' => $filters
        ]);
    }
    
    private function prepareExportingData($request)
    {
        $author    = $request->user()->username;
        $employees = $this->getExportingData(
            [
                'from' => $request['from'], 
                'to'   => $request['to']
            ]
        );

        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], 
            function($excel) use($employees, $request, $author) {
            // Set the title
            $excel->setTitle('List of hired employees from '. $request['from'].' to '. $request['to']);

            // Chain the setters
            $excel->setCreator($author)
                ->setCompany('Schön Technologies');

            // Call them separately
            $excel->setDescription('List of hired employees');
            $excel->sheet('Hired_Employees', function($sheet) use($employees) {
                $sheet->fromArray($employees);
            });
        });
    }

    /**
     * Export data
     * @param $constraints
     * @return mixed
     */
    private function getExportingData($constraints)
    {
        return $this->employeeService->getExportingData($constraints);
    }
}
