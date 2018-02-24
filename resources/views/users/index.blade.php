@extends('users.base')
@section('action-content')
<!-- Main content -->
<section class="content">
  <div class="box">
    <div class="box-header">
      <div class="row">
        <div class="col-xs-10">
          <h3 class="box-title">List of users</h3>
        </div>
        <div class="col-xs-2">
          <a class="btn btn-primary pull-right" href="{{ route('users.create') }}" title="Add new user" data-toggle="tooltip">
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
      <form method="POST" action="{{ route('users.search') }}">
       {{ csrf_field() }}
       @component('layouts.search', ['title' => 'Search'])
       @component('layouts.two-cols-search-row', [
        'fields' => [
            'username' => [
              'label' => 'User Name',
              'value' => isset($searchingVals) && isset($searchingVals['username']) ? 
                $searchingVals['username'] : ''
            ],
            'first_name' => [
              'label' => 'First Name',
              'value' => isset($searchingVals) && isset($searchingVals['first_name']) ? 
                $searchingVals['first_name'] : ''
            ]            
          ]
        ])
        @endcomponent
     </br>
     @component('layouts.two-cols-search-row', [
        'fields' => [
            'last_name' => [
              'label' => 'Last Name',
              'value' => isset($searchingVals) && isset($searchingVals['last_name']) ? 
                $searchingVals['last_name'] : ''
            ],
            'email' => [
              'label' => 'Email',
              'value' => isset($searchingVals) && isset($searchingVals['email']) ? 
                $searchingVals['email'] : ''
            ]            
          ]
        ])
       @endcomponent
     @endcomponent
   </form>
   <div class="dataTables_wrapper form-inline dt-bootstrap">
    <div class="row">
      <div class="col-sm-12">
        <table id="table-users" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="table-users_info">
          <thead>
            <tr role="row">
              <th width="10%" class="sorting_asc" tabindex="0" aria-controls="table-users" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">User Name</th>
              <th width="20%" class="sorting" tabindex="0" aria-controls="table-users" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Email</th>
              <th width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="table-users" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">First Name</th>
              <th width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="table-users" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Last Name</th>
              <th tabindex="0" aria-controls="table-users" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr role="row" class="odd">
              <td class="sorting_1">{{ $user->username }}</td>
              <td>{{ $user->email }}</td>
              <td class="hidden-xs">{{ $user->first_name }}</td>
              <td class="hidden-xs">{{ $user->last_name }}</td>
              <td>
                <form class="row" method="POST" action="{{ route('users.destroy', ['id' => $user->id]) }}" onsubmit = "return confirm('Are you sure?')">
                  <input type="hidden" name="_method" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-warning col-sm-3 col-xs-5 btn-margin" data-toggle="tooltip" title="Update">
                    <i class="fa fa-pencil"></i>
                  </a>
                  @if ($user->username != Auth::user()->username)
                  <button type="submit" class="btn btn-danger col-sm-3 col-xs-5 btn-margin">
                    <i class="fa fa-trash"></i>
                  </button>
                  @endif
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <th width="10%" rowspan="1" colspan="1">User Name</th>
              <th width="20%" rowspan="1" colspan="1">Email</th>
              <th class="hidden-xs" width="20%" rowspan="1" colspan="1">First Name</th>
              <th class="hidden-xs" width="20%" rowspan="1" colspan="1">Last Name</th>
              <th rowspan="1" colspan="2">Action</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-5">
        <div class="dataTables_info" id="table-users_info" role="status" aria-live="polite">Showing 1 to {{count($users)}} of {{count($users)}} entries</div>
      </div>
      <div class="col-sm-7">
        <div class="dataTables_paginate paging_simple_numbers" id="table-users_paginate">
          {{ $users->links() }}
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
