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
                                <i class="fa fa-comments fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">26</div>
                                <div>New Comments!</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
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
        <!-- /.row -->
        <div class="row">
            @section ('pane2_panel_title', 'List Vms')
            @section ('pane2_panel_body')
                <div>toto</div>
            @endsection
        </div>
        @include('widgets.panel', array('header'=>true, 'as'=>'pane2'))
    </div>

    <!-- /.col-lg-4 -->

@stop
