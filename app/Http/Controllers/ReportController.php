<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Excel;
use Illuminate\Support\Facades\DB;
use Auth;
use PDF;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        date_default_timezone_set('asia/karachi');
        $format      = 'Y/m/d';
        $now         = date($format);
        $to          = date($format, strtotime("+30 days"));
        $constraints = [
            'from'       => $now,
            'to'         => $to
        ];
        
        $employees = (new Employee)->getHiredEmployees($constraints);
        return view('system.report.index', [
            'employees'     => $employees, 
            'searchingVals' => $constraints
        ]);
    }

    public function exportExcel(Request $request) {
        $this->prepareExportingData($request)->export('xlsx');
        redirect()->intended('system-management/report');
    }

    public function exportPDF(Request $request) {
         $constraints = [
            'from' => $request['from'],
            'to'   => $request['to']
        ];
        $employees = $this->getExportingData($constraints);
        $pdf = PDF::loadView('system/report/pdf', [
            'employees'     => $employees, 
            'searchingVals' => $constraints
        ]);
        return $pdf->download('report_from_'. $request['from'].'_to_'.$request['to'].'pdf');
        // return view('system/report/pdf', ['employees' => $employees, 'searchingVals' => $constraints]);
    }
    
    private function prepareExportingData($request) {
        $author    = Auth::user()->username;
        $employees = $this->getExportingData(['from'=> $request['from'], 'to' => $request['to']]);
        return Excel::create('report_from_'. $request['from'].'_to_'.$request['to'], 
            function($excel) use($employees, $request, $author) {

            // Set the title
            $excel->setTitle('List of hired employees from '. $request['from'].' to '. $request['to']);

            // Chain the setters
            $excel->setCreator($author)
                ->setCompany('Schön Technologies');

            // Call them separately
            $excel->setDescription('The list of hired employees');

            $excel->sheet('Hired_Employees', function($sheet) use($employees) {
                $sheet->fromArray($employees);
            });
        });
    }

    public function search(Request $request) {
        $constraints = [
            'from' => $request['from'],
            'to'   => $request['to']
        ];

        $employees = (new Employee)->getHiredEmployees($constraints);
        return view('system.report.index', ['employees' => $employees, 'searchingVals' => $constraints]);
    }

    private function getExportingData($constraints) {
        return (new Employee)->getExportingData($constraints);
    }
}
