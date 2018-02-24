@extends('employees.base')
@section('action-content')
<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-xs-10">
          <h3 class="box-title">List of employees</h3>
        </div>
        <div class="col-xs-2">
          <a class="btn btn-primary pull-right" href="{{ route('employees.create') }}" title="Add new employee" data-toggle="tooltip">
            <i class="fa fa-plus"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('employees.search') }}">
       {{ csrf_field() }}
       @component('layouts.search', ['title' => 'Search'])
       @component('layouts.two-cols-search-row', [
        'fields' => [
            'firstname' => [
              'label' => 'First Name',
              'value' => isset($searchingVals) && isset($searchingVals['firstname']) ? 
                $searchingVals['firstname'] : ''
            ],
            'department_name' => [
              'label' => 'Department Name',
              'value' => isset($searchingVals) && isset($searchingVals['department_name']) ? 
                $searchingVals['department_name'] : ''
            ]            
          ]
        ])
        @endcomponent
       @endcomponent
     </form>
     <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12 table-responsive">
          <table id="table-employee" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th width="8%" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Picture: activate to sort column descending" aria-sort="ascending">Picture</th>
                <th width="10%" class="sorting_asc" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Employee Name</th>
                <th width="12%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending">Age</th>
                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Birthdate: activate to sort column ascending">Birthdate</th>
                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="HiredDate: activate to sort column ascending">Hired Date</th>
                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Department: activate to sort column ascending">Department</th>
                <th width="8%" class="sorting hidden-xs" tabindex="0" aria-controls="table-employee" rowspan="1" colspan="1" aria-label="Division: activate to sort column ascending">Division</th>
                <th tabindex="0" aria-controls="table-employee" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($employees as $employee)
              <tr role="row" class="odd">
                <td><img src="../{{$employee->picture }}" width="50px" height="50px"/></td>
                <td class="sorting_1">{{ $employee->firstname }} {{$employee->middlename}} {{$employee->lastname}}</td>
                <td class="hidden-xs">{{ $employee->address }}</td>
                <td class="hidden-xs">{{ $employee->age }}</td>
                <td class="hidden-xs">{{ $employee->birthdate }}</td>
                <td class="hidden-xs">{{ $employee->date_hired }}</td>
                <td class="hidden-xs">{{ $employee->department_name }}</td>
                <td class="hidden-xs">{{ $employee->division_name }}</td>
                <td>
                  <form method="POST" action="{{ route('employees.destroy', ['id' => $employee->id]) }}" onsubmit = "return confirm('Are you sure?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a href="{{ route('employees.edit', ['id' => $employee->id]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Update">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="table-employee_info" role="status" aria-live="polite">
            Showing 1 to {{count($employees)}} of {{count($employees)}} entries
          </div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="table-employee_paginate">
            {{ $employees->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
</section>
<!-- /.content -->
</div>
@endsection
