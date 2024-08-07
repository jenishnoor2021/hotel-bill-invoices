@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/doctors') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit setting
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit setting</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
               <div class="box-header with-border">
                  @if (session('error'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:red;color:#fff;">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               {!! Form::model($setting, ['method'=>'PATCH', 'action'=> ['AdminSettingController@update', $setting->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editSettingForm']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="rtypes_id" class="col-sm-2 control-label">Hotel name</label>
                     <div class="col-sm-4">
                        <select name="hotel_id" id="hotel_id" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select hotel</option>
                           @foreach($hotels as $hotel)
                           <option value="{{$hotel->id}}" {{$setting->hotel_id == $hotel->id ? 'selected' : ''}}>{{$hotel->hotel_name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('hotel_id'))
                        <div class="error text-danger">{{ $errors->first('hotel_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="email" class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-4">
                        <input type="email" name="email" id="email" class="form-control border border-dark mb-2" placeholder="Enter email" value="{{$setting->email}}">
                        @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="address" class="col-sm-2 control-label">Address</label>
                     <div class="col-sm-4">
                        <textarea name="address" id="address" value="" class="form-control border border-dark mb-2" placeholder="Enter Address">{{$setting->address}}</textarea>
                        @if($errors->has('address'))
                        <div class="error text-danger">{{ $errors->first('address') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="contact" class="col-sm-2 control-label">Contact No</label>
                     <div class="col-sm-4">
                        <input type="text" name="contact" id="contact" class="form-control border border-dark mb-2" placeholder="Enter contact no" value="{{$setting->contact}}">
                        @if($errors->has('contact'))
                        <div class="error text-danger">{{ $errors->first('contact') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="gst_no" class="col-sm-2 control-label">GST No:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="Enter Gst No" value="{{$setting->gst_no}}">
                        @if($errors->has('gst_no'))
                        <div class="error text-danger">{{ $errors->first('gst_no') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="gst_name" class="col-sm-2 control-label">GST Name:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="gst_name" id="gst_name" placeholder="Enter GST Name" value="{{$setting->gst_name}}">
                        @if($errors->has('gst_name'))
                        <div class="error text-danger">{{ $errors->first('gst_name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="invoice_code" class="col-sm-2 control-label">Invoice Code:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="invoice_code" id="invoice_code" placeholder="Enter invoice code" value="{{$setting->invoice_code}}">
                        @if($errors->has('invoice_code'))
                        <div class="error text-danger">{{ $errors->first('invoice_code') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="invoice_series" class="col-sm-2 control-label">Invoice Series:</label>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" name="invoice_series" id="invoice_series" placeholder="Enter invoice series" value="{{$setting->invoice_series}}">
                        @if($errors->has('invoice_series'))
                        <div class="error text-danger">{{ $errors->first('invoice_series') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-3 col-sm-2 control-label">
                        {!! Form::submit('update', ['class'=>'btn btn-success text-white mt-1']) !!}
                     </div>
                  </div>
               </div>
               {!! Form::close() !!}
            </div>
            <!-- /.box -->
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='editSettingForm']").validate({
         rules: {
            hotel_id: {
               required: true,
            },
            gst_no: {
               required: true,
            },
            address: {
               required: true,
            },
            contact: {
               required: true,
            },
            email: {
               required: true,
            },
            invoice_code: {
               required: true,
            },
            invoice_series: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection