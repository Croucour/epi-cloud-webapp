@extends('layouts.dashboard')
@section('page_heading','Vm view')
@section('section')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            @section ('pane1_panel_title', $vm->name)
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
                        <th>Ram</th>
                        <td>{{$vm->ram}}</td>
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
            @section ('pane2_panel_title', 'Direct action on vm')
            @section ('pane2_panel_body')
                <div>
                    <button type="button" class="btn btn-success col-lg-5">Start</button>
                    <button type="button" class="btn btn-warning col-lg-5 col-lg-offset-2">Stop</button>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))

            @section ('pane3_panel_title', 'Edit or delete vm')
            @section ('pane3_panel_body')
                <div>
                    <a href="{{url(Request::url()."/edit")}}"><button type="button" class="btn btn-primary col-lg-5">Edit</button></a>
                    <a href="{{url(Request::url()."/delete")}}"><button type="button" class="btn btn-danger col-lg-5 col-lg-offset-2">Delete</button></a>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane3'))
        </div>

    </div>

    <!-- /.col-lg-4 -->

@stop
