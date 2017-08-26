@extends('system.city.base')
@section('action-content')
<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-xs-10">
          <h3 class="box-title">List of cities</h3>
        </div>
        <div class="col-xs-2">
          <a class="btn btn-primary pull-right" href="{{ route('system.city.create') }}" title="Add new city" data-toggle="tooltip">
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
      <form method="POST" action="{{ route('system.city.search') }}">
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
          <table id="table-city" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="table-city_info">
            <thead>
              <tr role="row">
                <th width="20%" class="sorting" tabindex="0" aria-controls="table-city" rowspan="1" colspan="1" aria-label="city: activate to sort column ascending">City Name</th>
                <th width="20%" class="sorting" tabindex="0" aria-controls="table-city" rowspan="1" colspan="1" aria-label="state: activate to sort column ascending">State Name</th>
                <th tabindex="0" aria-controls="table-city" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
              </tr>
            </thead>
            <tbody>
              {{$cities}}
              @foreach ($cities as $city)
              <tr role="row" class="odd">
                <td>{{ $city->name }}</td>
                <td>{{ $city->state_name }}</td>
                <td>
                  <form method="POST" action="{{ route('system.city.destroy', ['id' => $city->id]) }}" onsubmit = "return confirm('Are you sure?')">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <a href="{{ route('system.city.edit', ['id' => $city->id]) }}" class="btn btn-sm btn-warning btn-margin" data-toggle="tooltip" title="Update">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <button type="submit" class="btn btn-sm btn-danger btn-margin">
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
          <div class="dataTables_info" id="table-city_info" role="status" aria-live="polite">Showing 1 to {{count($cities)}} of {{count($cities)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="table-city_paginate">
            {{ $cities->links() }}
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