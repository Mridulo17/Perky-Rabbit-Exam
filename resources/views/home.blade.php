@extends('layouts.app')

@section('css-section')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('admin/buttons/1.2.2/css/buttons.dataTables.min.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <a href="{{ route('create', app()->getLocale()) }}">{{ __('Create') }}</a>
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  @if(Session::get('message'))
                    <div class="alert alert-{{ Session::get('alert-status') }}" role="alert">
                        {{ Session::get('message') }}
                    </div>
                  @endif
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>{{ __('SL No.') }}</th>
                          <th>{{ __('Name') }}</th>
                          <th>{{ __('Contact') }}</th>
                          <th>{{ __('Email') }}</th>
                          <th>{{ __('dob') }}</th>
                          <th>{{ __('Image') }}</th>
                          <th>{{ __('Created By') }}</th>
                          <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($employees as $employee)
                        <tr>
                          <td>{{ $loop->index+1 }}</td>
                          <td>{{ $employee->name }}</td>
                          <td>{{ $employee->contact }}</td>
                          <td>{{ $employee->email }}</td>
                          <td>{{ $employee->date_of_birth }}</td>
                          <td><img src="{{asset($employee->picture_path)}}" width=60px; height=40px;></td>  
                          <td>{{ $employee->user ? $employee->user->name : '' }}</td>
                          <td>
                            {{-- <a href="{{ route('edit',[$employee->id, app()->getLocale()]) }}">{{ __('Edit') }}</a> --}}
                            <a href="{{ route('edit',[ app()->getLocale(), $employee->id]) }}">{{ __('Edit') }}</a>
                            <a href="{{ route('delete',[$employee->id, app()->getLocale()]) }}">{{ __('Delete') }}</a>
                          </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script-section')
<script src="{{ asset('admin/plugins/jquery/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('admin/buttons/1.2.2/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('admin/buttons/1.2.2/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('admin/ajax/libs/jszip/2.5.0/jszip.min.js') }}"></script>
<script src="{{ asset('admin/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('admin/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('admin/buttons/1.2.2/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('admin/buttons/1.2.2/js/buttons.print.min.js') }}"></script>
<script>
  $(function () {
    $.noConflict();
    $("#example2").DataTable({
        destroy: true,
        dom: "rBftlip",
        buttons: [
          {
            extend: "excel",
            text:
              '<i class="fa fa-file-text-o" aria-hidden="true">Export (Excel)</i>',
            title: "Employees List",
            exportOptions: {
              columns: ":not(:last-child)",
            },
          },
        ],
        lengthMenu: [
          [10, 20, 50, 100, -1],
          [10, 20, 50, 100, "All"],
        ],
        pageLength: 10,
    });

    $(".alert").delay(5000).slideUp(300);

  });
</script>
@endsection
