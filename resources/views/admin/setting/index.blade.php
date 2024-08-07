@extends('layouts.admin')
@section('style')
@stop
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Setting</b> &nbsp; <a href="{{route('admin.setting.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Setting</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header">
                  @if (session('success'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:green;color:#fff;">
                     {{ session('success') }}
                  </div>
                  @endif

                  @if (session('error'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:red;color:#fff;">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               @if(count($settings)>0)
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;margin-top:15px">

                  <table id="settingTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Hotel Name</th>
                           <th>Email</th>
                           <th>Contact no</th>
                           <th>GST no</th>
                           <th>GST name</th>
                           <th>Code</th>
                           <th>Series</th>
                           <th>Address</th>
                           <th>Active/De-active</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($settings as $setting)
                        <td>
                           <a href="{{route('admin.setting.edit', $setting->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           <a href="{{route('admin.setting.destroy', $setting->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);color:red;padding:8px;"></i></a>
                        </td>
                        <td>{{$setting->hotel->hotel_name}}</td>
                        <td>{{$setting->email}}</td>
                        <td>{{$setting->contact}}</td>
                        <td>{{$setting->gst_no}}</td>
                        <td>{{$setting->gst_name}}</td>
                        <td>{{$setting->invoice_code}}</td>
                        <td>{{$setting->invoice_series}}</td>
                        <td>@if(strlen($setting->address) > 50)
                           {!!substr($setting->address,0,50)!!}
                           <span class="read-more-show hide_content">More<i class="fa fa-angle-down"></i></span>
                           <span class="read-more-content"> {{substr($setting->address,50,strlen($setting->address))}}
                              <span class="read-more-hide hide_content">Less <i class="fa fa-angle-up"></i></span> </span>
                           @else
                           {{$setting->address}}
                           @endif
                        </td>
                        <td>
                           @if($setting->is_active == 1)
                           <a href="/admin/hotel/active/{{$setting->id}}" class="btn btn-success">Active</a>
                           @else
                           <a href="/admin/hotel/active/{{$setting->id}}" class="btn btn-danger">De-active</a>
                           @endif
                        </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>

               </div>
               <!-- /.box-body -->
               @else
               <center>
                  <h1>No Record found</h1>
               </center>
               @endif
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(document).ready(function() {
      $("#settingTable").DataTable();
   });
</script>
@endsection