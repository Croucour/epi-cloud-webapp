@extends('layouts.dashboard')
@section('page_heading','Vm view')
@section('section')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            @section ('pane1_panel_title', 'name of vm')
            @section ('pane1_panel_body')
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>Os</th>
                        <td>{{$vm->os}}</td>
                    </tr>
                    <tr>
                        <th>Os version</th>
                        <td>{{$vm->os_version}}</td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{$vm->created_at->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <th>Updated</th>
                        <td>{{$vm->updated_at->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <th>nb_core</th>
                        <td>{{$vm->nb_core}}</td>
                    </tr>
                    <tr>
                        <th>running</th>
                        <td>{{$vm->running ? "true" : "false"}}</td>
                    </tr>
                    <tr>
                        <th>ip</th>
                        <td>{{$vm->ip}}</td>
                    </tr>
                    <tr>
                        <th>port</th>
                        <td>{{$vm->port}}</td>
                    </tr>
                    </tbody>
                </table>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane1'))
        </div>
        <div class="col-lg-4">
            @section ('pane2_panel_title', 'Action')
            @section ('pane2_panel_body')
                <div>
                    <button type="button" class="btn btn-success">Start</button>
                    <button type="button" class="btn btn-warning">Stop</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
        </div>

    </div>

    <!-- /.col-lg-4 -->

@stop
