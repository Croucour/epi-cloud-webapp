@extends('layouts.dashboard')
@section('page_heading','Roles')
@section('section')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="col-sm-12">
        <div class="row">
            @section ('pane2_panel_title', 'Users roles')
            @section ('pane2_panel_body')
                <div class="alert alert-success" style="display: none;" id="success">
                    <strong>Success!</strong> Role applied
                </div>
                <div class="alert alert-danger" style="display: none;" id="error">
                    <strong>Error</strong> while applying roles
                </div>
                <div style="display: none;" id="loading">
                   <div class="col-lg-1">
                       <div class="loader"></div>
                   </div>
                   <div class="col-lg-11">
                       <strong>Sending request</strong>
                   </div>
                </div>
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
                            <td>{{ Form::select($user->id, $roles, $user->role->first()->id, ['class' => 'form-control select-role']) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endsection
        </div>
        @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
        {{--@include('rolesUpdate.')--}}
    </div>
    <!-- /.col-lg-4 -->
@stop
