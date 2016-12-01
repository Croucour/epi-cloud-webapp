@extends('layouts.dashboard')
@section('page_heading','Dashboard')
@section('section')

    <!-- /.row -->
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$nb_vms}}</div>
                                <div>Number of Vms</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('vms')}}">
                        <div class="panel-footer">
                            <span class="pull-left">View List</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>

            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{$nb_boxes_waiting}}</div>
                                <div>Number of Vms waiting</div>
                            </div>
                        </div>
                    </div>
                    <a href="{{url('vms')}}">
                        <div class="panel-footer">
                            <span class="pull-left">View List</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>

            </div>
            @if(Entrust::hasRole('SysAdmin'))

            @else

            @endif

        </div>
    </div>

    <!-- /.col-lg-4 -->

@stop
