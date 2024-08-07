@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/room') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Room
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Room</li>
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
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminRoomController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addroomform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="rtypes_id" class="col-sm-2 control-label">Hotel name</label>
                     <div class="col-sm-4">
                        <select name="hotel_id" id="hotel_id" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select hotel</option>
                           @foreach($hotels as $hotel)
                           <option value="{{$hotel->id}}">{{$hotel->hotel_name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('hotel_id'))
                        <div class="error text-danger">{{ $errors->first('hotel_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="room_no" class="col-sm-2 control-label">Room No</label>
                     <div class="col-sm-4">
                        <input type="number" name="room_no" id="room_no" class="form-control border border-dark mb-2" placeholder="Enter Room No">
                        @if($errors->has('room_no'))
                        <div class="error text-danger">{{ $errors->first('room_no') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="category_id" class="col-sm-2 control-label">Room Type</label>
                     <div class="col-sm-4">
                        <select name="category_id" id="category_id" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select Category</option>
                           @foreach($categorys as $category)
                           <option value="{{$category->id}}">{{$category->c_name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('category_id'))
                        <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="total_amount" class="col-sm-2 control-label">Total amount</label>
                     <div class="col-sm-4">
                        <input type="number" name="total_amount" id="total_amount" class="form-control border border-dark mb-2" placeholder="Enter with gst amount">
                        @if($errors->has('total_amount'))
                        <div class="error text-danger">{{ $errors->first('total_amount') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="gst_percentage" class="col-sm-2 control-label">GST Percentage:</label>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" name="gst_percentage" id="gst_percentage" placeholder="Enter GST Percentage">
                        @if($errors->has('gst_percentage'))
                        <div class="error text-danger">{{ $errors->first('gst_percentage') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="amount" class="col-sm-2 control-label">Amount:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter without GST amount">
                        @if($errors->has('amount'))
                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-3 col-sm-2 control-label">
                        {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1']) !!}
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
      $("form[name='addroomform']").validate({
         rules: {
            hotel_id: {
               required: true,
            },
            room_no: {
               required: true,
            },
            category_id: {
               required: true,
            },
            total_amount: {
               required: true,
            },
            gst_percentage: {
               required: true,
            },
            amount: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });

   function calculateAmount() {
      var totalAmount = parseFloat(document.getElementById('total_amount').value);
      var gstPercentage = parseFloat(document.getElementById('gst_percentage').value);

      if (!isNaN(totalAmount) && !isNaN(gstPercentage) && gstPercentage != 0) {
         var amountWithoutGST = totalAmount / (1 + gstPercentage / 100);
         document.getElementById('amount').value = amountWithoutGST.toFixed(2);
      } else {
         document.getElementById('amount').value = '';
      }
   }

   document.getElementById('total_amount').addEventListener('input', calculateAmount);
   document.getElementById('gst_percentage').addEventListener('input', calculateAmount);
</script>
</script>
@endsection