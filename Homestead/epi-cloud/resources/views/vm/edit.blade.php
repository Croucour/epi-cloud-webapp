@extends('layouts.dashboard')
@section('page_heading','Edit vm')
@section('section')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            @section ('pane1_panel_body')
                {!! Form::model($vm, ['route' => ['vm.update', $vm->id], "class" => "form-horizontal"]) !!}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                    {{ Form::label("Name", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{ Form::text("name", null, array_merge(['class' => 'form-control'])) }}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                 <strong>{{ $errors->first('name') }}</strong>
                             </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("os", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{Form::select('os', ['windows' => 'windows', 'ubuntu' => 'ubuntu'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("Os version", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{Form::select('os_version', ['trusty32' => 'trusty32', 'trusty64' => 'trusty64'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("Nb core", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{Form::select('nb_core', ['2' => '2', '4' => '4', '6' => '6'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("ram", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{Form::select('ram', ['1024' => '1024', '512' => '512'], null, ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        {{Form::submit('Edit', ["class" => 'btn btn-success pull-right'])}}
                    </div>
                </div>
                {!! Form::token() !!}
                {!! Form::close() !!}
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane1'))
        </div>
        <div class="col-lg-4">
            @section ('pane2_panel_title', 'Direct action on vm')
            @section ('pane2_panel_body')
                <div>
                    <a href="{{ route('vm.start', ['id' => $vm->id]) }}"><button type="button" class="btn btn-success col-lg-5 @if($vm->running == true) disabled @endif ">Start</button></a>
                    <a href="{{ route('vm.start', ['id' => $vm->id]) }}"><button type="button" class="btn btn-warning col-lg-5 col-lg-offset-2 @if($vm->running == false) disabled @endif ">Stop</button></a>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))

            @section ('pane3_panel_title', 'Delete vm')
            @section ('pane3_panel_body')
                <div>
                    <a href="{{url(Request::url()."/delete")}}"><button type="button" class="btn btn-danger col-lg-12">Delete</button></a>
                </div>
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane3'))
        </div>

    </div>

    <!-- /.col-lg-4 -->

@stop
