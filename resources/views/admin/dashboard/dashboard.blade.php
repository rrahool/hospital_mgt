@extends('admin.master')
@section('mainContend')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            @if($status)
                            @foreach($status as $v)
                            <div class="huge">{{ $v->p_in }}</div>
                            @endforeach
                            @endif
                            <div>New Product In!</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('product_status') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            @if($status)
                                @foreach($status as $v)
                                    <div class="huge">{{ $v->p_out }}</div>
                                @endforeach
                            @endif
                            <div>Products Out</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('sale_list') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            @if($status)
                                @foreach($status as $v)
                                    <div class="huge">{{ $v->avail }}</div>
                                @endforeach
                            @endif
                            <div>Available Product !</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('product_status') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
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
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            @if($client)
                                @foreach($client as $value)
                            <div class="huge">{{ $value->total }}</div>
                                @endforeach
                            @endif
                            <div>Total Client !</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('client_list') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Sales Progressive Line Chart
                    <div class="pull-right">
                        <!-- <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                    data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Day Wise Sales
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                    data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li><a href="#">Action</a>
                                </li>
                                <li><a href="#">Another action</a>
                                </li>
                                <li><a href="#">Something else here</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">

                        </div>
                        <!-- /.col-lg-4 (nested) -->
                        <div class="col-lg-8">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.col-lg-8 (nested) -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bell fa-fw"></i>&nbsp;Information Panel
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Latest Due Payments
                            <!-- <span class="pull-right text-muted small"><em>updated 4 minutes ago</em>
                            </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Latest Sales
                            <!--  <span class="pull-right text-muted small"><em>updated 12 minutes ago</em>
                             </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i> Recent Quotations
                            <!-- <span class="pull-right text-muted small"><em>27 minutes ago</em>
                            </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Recent Purchases
                            <!-- <span class="pull-right text-muted small"><em>43 minutes ago</em>
                            </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Last 5 Returned Products
                            <!-- <span class="pull-right text-muted small"><em>11:32 AM</em>
                            </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Last Week Expenses
                            <!--    <span class="pull-right text-muted small"><em>11:13 AM</em>
                               </span> -->
                        </a>
                        <a href="#" class="list-group-item">
                            <i class="fa fa-tags"></i>&nbsp;Last Month Status
                            <!--  <span class="pull-right text-muted small"><em>10:57 AM</em>
                             </span> -->
                        </a>

                    </div>
                    <!-- /.list-group -->
                    <!-- <a href="#" class="btn btn-default btn-block">View All Alerts</a> -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
                </div>
                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                    <a href="#" class="btn btn-default btn-block">View Details</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
@endsection