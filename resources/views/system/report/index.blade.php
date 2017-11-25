@extends('system.report.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-xs-8">
          <h3 class="box-title">List of hired employees</h3>
        </div>
        <div class="col-xs-2">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('system.report.excel') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <button type="submit" class="btn btn-primary">
                  Export to Excel
                </button>
            </form>
        </div>
        <div class="col-xs-2">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('system.report.pdf') }}">
                {{ csrf_field() }}
                <input type="hidden" value="{{$searchingVals['from']}}" name="from" />
                <input type="hidden" value="{{$searchingVals['to']}}" name="to" />
                <button type="submit" class="btn btn-info">
                  Export to PDF
                </button>
            </form>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('system.report.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-date-search-row', [
          'fields' => [
            'from' => [
              'label' => 'From',
              'value' => isset($searchingVals) && isset($searchingVals['from']) ? 
                $searchingVals['from'] : ''
            ],
            'to' => [
              'label' => 'To',
              'value' => isset($searchingVals) && isset($searchingVals['to']) ? 
                $searchingVals['to'] : ''
            ]          
          ]
        ])
         @endcomponent
        @endcomponent
      </form>
    <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="table-report" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="table-report_info">
            <thead>
              <tr role="row">
                <th width = "20%" tabindex="0" aria-controls="table-report" rowspan="1" colspan="1" aria-label="Name: activate to sort column ascending">Employee Name</th>
                <th width = "20%" tabindex="1" aria-controls="table-report" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Birthday</th>
                <th width = "40%" tabindex="2" aria-controls="table-report" rowspan="1" colspan="1" aria-label="Address: activate to sort column ascending">Address</th>
                <th width = "20%" tabindex="3" aria-controls="table-report" rowspan="1" colspan="1" aria-label="Birthday: activate to sort column ascending">Hired Day</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
                <tr role="row" class="odd">
                  <td>{{ $employee->firstname }} {{ $employee->middlename }} {{ $employee->lastname }}</td>
                  <td>{{ $employee->birthdate }}</td>
                  <td>{{ $employee->address }}</td>
                  <td>{{ $employee->date_hired }}</td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="dataTables_info" id="table-report_info" role="status" aria-live="polite">Showing 1 to {{count($employees)}} of {{count($employees)}} entries</div>
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
