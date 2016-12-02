@extends('layouts.dashboard')
@section('page_heading','Create new vm')
@section('section')

    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            @section ('pane1_panel_body')
                {!! Form::open(['route' => ['vm.store'], "class" => "form-horizontal", 'files' => true]) !!}
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
                        {{Form::select('nb_core', ['1' => '1', '2' => '2', '4' => '4', '6' => '6'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("ram", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{Form::select('ram', ['1024' => '1024', '512' => '512'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label("ssh file", null, ['class' => 'control-label col-sm-2']) }}
                    <div class="col-sm-10">
                        {{ Form::file("ssh_key", ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 ">
                        {{Form::submit('Create', ["class" => 'btn btn-success pull-right'])}}
                    </div>
                </div>
                {!! Form::token() !!}
                {!! Form::close() !!}
            @endsection
            @include('widgets.panel', array('header'=>true, 'as'=>'pane1'))
        </div>
    </div>
@stop