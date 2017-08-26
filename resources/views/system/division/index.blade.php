@extends('system.division.base')
@section('action-content')
<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-xs-10">
          <h3 class="box-title">List of divisions</h3>
        </div>
        <div class="col-xs-2">
          <a class="btn btn-primary pull-right" href="{{ route('system.division.create') }}" title="Add new division" data-toggle="tooltip">
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
      <form method="POST" action="{{ route('system.division.search') }}">
       {{ csrf_field() }}
       @component('layouts.search', ['title' => 'Search'])
       @component('layouts.two-cols-search-row', ['items' => ['Name'], 
       'oldVals' => [isset($searchingVals) ? $searchingVals['name'] : '']])
       @endcomponent
       @endcomponent
     </form>
     <div class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="table-division" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="table-division_info">
            <thead>
              <tr role="row">
                <th width="20%" class="sorting" tabindex="0" aria-controls="table-division" rowspan="1" colspan="1" aria-label="division: activate to sort column ascending">Division Name</th>
                <th tabindex="0" aria-controls="table-division" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($divisions as $division)
              <tr role="row" class="odd">
                <td>{{ $division->name }}</td>
                <td>
                  <form class="row" method="POST" action="{{ route('system.division.destroy', ['id' => $division->id]) }}" onsubmit = "return confirm('Are you sure?')">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a href="{{ route('system.division.edit', ['id' => $division->id]) }}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Update">
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
          <div class="dataTables_info" id="table-division_info" role="status" aria-live="polite">Showing 1 to {{count($divisions)}} of {{count($divisions)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="table-division_paginate">
            {{ $divisions->links() }}
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