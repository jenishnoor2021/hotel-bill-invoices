@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/extra') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Extra Service
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Extra Service</li>
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
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminExtraServiceController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addextraserviceform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Extra service name</label>
                     <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control border border-dark mb-2" placeholder="Enter extra service name">
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
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
                     <label for="gst_percentage" class="col-sm-2 control-label">GST Percentage:</label>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" name="gst_percentage" id="gst_percentage" placeholder="Enter GST Percentage">
                        @if($errors->has('gst_percentage'))
                        <div class="error text-danger">{{ $errors->first('gst_percentage') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="total_amount" class="col-sm-2 control-label">Total Amount</label>
                     <div class="col-sm-4">
                        <input type="number" name="total_amount" id="total_amount" class="form-control border border-dark mb-2" placeholder="Enter with gst amount">
                        @if($errors->has('total_amount'))
                        <div class="error text-danger">{{ $errors->first('total_amount') }}</div>
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
      $("form[name='addextraserviceform']").validate({
         rules: {
            name: {
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
      var totalAmount = parseFloat(document.getElementById('amount').value);
      var gstPercentage = parseFloat(document.getElementById('gst_percentage').value);

      if (!isNaN(totalAmount) && !isNaN(gstPercentage)) {
         var amountWithGST = totalAmount * (1 + gstPercentage / 100);
         document.getElementById('total_amount').value = amountWithGST.toFixed(2);
      } else {
         document.getElementById('total_amount').value = '';
      }
   }

   document.getElementById('amount').addEventListener('input', calculateAmount);
   document.getElementById('gst_percentage').addEventListener('input', calculateAmount);
</script>
</script>
@endsection