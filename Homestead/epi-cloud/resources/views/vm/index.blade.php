@extends('layouts.dashboard')
@section('page_heading','List Vms')
@section('section')

    <!-- /.row -->
    <div class="col-sm-12">
        <div class="row">
            @section ('pane2_panel_title', 'List Vms')
            @section ('pane2_panel_body')
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Os</th>
                        <th>os version</th>
                        <th>Created</th>
                        <th>nb core</th>
                        <th>Ram</th>
                        <th>running</th>
                        <th>action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($vms as $key => $vm)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $vm->name }}</td>
                            <td>{{ $vm->os }}</td>
                            <td>{{ $vm->os_version }}</td>
                            <td>{{ $vm->created_at->format('j F Y') }}</td>
                            <td>{{ $vm->nb_core }}</td>
                            <td>{{ $vm->ram }}</td>
                            <td>{{ $vm->running ? "true" : "false" }}</td>
                            <td><a href="{{url ('/vms/'.$vm->id)}}"><button type="button" class="btn btn-primary btn-circle"><i class="fa fa-list"></i></button></a></td>
                        </tr>
                @endforeach
                    </tbody>
                </table>
            @endsection
        </div>
        @include('widgets.panel', array('header'=>true, "add" => array("name" =>"new Vm", "url" => url('vms/add')), 'as'=>'pane2'))
    </div>

    <!-- /.col-lg-4 -->

@stop
