@extends('layouts.admin')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>


  <!-- Main content -->
  <section class="content">
    @if(Session::get('user')['role'] == 'admin')
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$heaven_count}}</h3>
            <p>Heaven</p>
          </div>
          <div class="icon">
            <span style="font-size:20px;color:white">{{$heaven_amount}}</span>
          </div>
          <!-- <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{$orbit_count}}</h3>
            <p>Orbit</p>
          </div>
          <div class="icon">
            <span style="font-size:20px;color:white">{{$orbit_amount}}</span>
          </div>
          <!-- <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{$olympia_count}}</h3>
            <p>Olympia</p>
          </div>
          <div class="icon">
            <span style="font-size:20px;color:white">{{$olympia_amount}}</span>
          </div>
          <!-- <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
        </div>
      </div>
      <!-- ./col -->

    </div>
    <!-- /.row -->
    @else
    <h3>Welcome {{Session::get('user')['name']}}</h3>
    @endif
  </section>
  <!-- /.content -->

</div>

@endsection