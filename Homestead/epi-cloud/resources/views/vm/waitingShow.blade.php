@extends('layouts.dashboard')
@section('page_heading','Vm view')
@section('section')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            @section ('pane32_panel_title', "Creator")
            @section ('pane32_panel_body')
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>Last Name</th>
                        <td>{{$box_waiting->user->last_name}}</td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td>{{$box_waiting->user->first_name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$box_waiting->user->email}}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{$box_waiting->user->role->first()->name}}</td>
                    </tr>


                    </tbody>
                </table>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane32'))
            @section ('pane1_panel_title', $box_waiting->name)
            @section ('pane1_panel_body')
                <table class="table table-hover">
                    <tbody>
                    <tr>
                        <th>Os</th>
                        <td>{{$box_waiting->os}}</td>
                    </tr>
                    <tr>
                        <th>Os version</th>
                        <td>{{$box_waiting->os_version}}</td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{$box_waiting->created_at->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <th>Updated</th>
                        <td>{{$box_waiting->updated_at->format('j F Y')}}</td>
                    </tr>
                    <tr>
                        <th>nb_core</th>
                        <td>{{$box_waiting->nb_core}}</td>
                    </tr>
                    <tr>
                        <th>Ram</th>
                        <td>{{$box_waiting->ram}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{$box_waiting->status}}</td>
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
                    <a href="{{ route('vm_waiting.update', ['id' => $box_waiting->id, "status" => "1"]) }}"><button type="button" class="btn btn-success col-lg-5">Accept</button></a>
                    <a href="{{ route('vm_waiting.update', ['id' => $box_waiting->id, "status" => "0"]) }}"><button type="button" class="btn btn-danger col-lg-5 col-lg-offset-2">Refuse</button></a>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))

        </div>

    </div>

    <!-- /.col-lg-4 -->

@stop
