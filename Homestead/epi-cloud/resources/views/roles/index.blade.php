@extends('layouts.dashboard')
@section('page_heading','List Vms')
@section('section')

    <div class="col-sm-12">
        <div class="row">
            @section ('pane2_panel_title', 'Users roles')
            @section ('pane2_panel_body')
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Last name</th>
                        <th>First name</th>
                        <th>Role</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td class="col-lg-3">{{ Form::select('size', $roles, $user->role->first()->id, ['class' => 'form-control ']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endsection
        </div>
        @include('widgets.panel', array('header'=>true, "add" => array("name" =>"new Vm", "url" => route('vm.create')), 'as'=>'pane2'))
    </div>

    <!-- /.col-lg-4 -->

@stop
