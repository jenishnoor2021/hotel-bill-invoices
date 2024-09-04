@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/invoice') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add Invoice
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add Invoice</li>
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
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminInvoiceController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'addinvoiceform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="hotel_id" class="col-sm-2 control-label">Hotel name</label>
                     <div class="col-sm-4">
                        <select name="hotel_id" id="hotel_id" class="custom-select form-control form-control-rounded" onchange="getDetail(this.value)" required>
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
                     <label for="invoice_no" class="col-sm-2 control-label">Invoice number</label>
                     <div class="col-sm-4">
                        <input type="text" name="invoice_no" id="invoice_no" class="form-control border border-dark mb-2" placeholder="Enter Invoice number" readonly>
                        @if($errors->has('invoice_no'))
                        <div class="error text-danger">{{ $errors->first('invoice_no') }}</div>
                        @endif
                     </div>
                  </div>

                  <h4>Customer Detail</h4>
                  <hr style="border:1px solid #000;" />
                  <div class="form-group">
                     <label for="invoice_date" class="col-sm-2 control-label">Date</label>
                     <div class="col-sm-4">
                        <input type="date" name="invoice_date" id="invoice_date" class="form-control border border-dark mb-2" required>
                        @if($errors->has('invoice_date'))
                        <div class="error text-danger">{{ $errors->first('invoice_date') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_name1" class="col-sm-2 control-label">Guest Name 1:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="guest_name1" id="guest_name1" placeholder="Enter Guest Name 1" required>
                        @if($errors->has('guest_name1'))
                        <div class="error text-danger">{{ $errors->first('guest_name1') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_name2" class="col-sm-2 control-label">Guest Name 2:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="guest_name2" id="guest_name2" placeholder="Enter Guest Name 2">
                        @if($errors->has('guest_name2'))
                        <div class="error text-danger">{{ $errors->first('guest_name2') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_email" class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-4">
                        <input type="email" name="guest_email" id="guest_email" class="form-control border border-dark mb-2" placeholder="Enter email" required>
                        @if($errors->has('guest_email'))
                        <div class="error text-danger">{{ $errors->first('guest_email') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_mobile" class="col-sm-2 control-label">Mobile No</label>
                     <div class="col-sm-4">
                        <input type="number" name="guest_mobile" id="guest_mobile" class="form-control border border-dark mb-2" placeholder="Enter mobile no" required>
                        @if($errors->has('guest_mobile'))
                        <div class="error text-danger">{{ $errors->first('guest_mobile') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="check_in" class="col-sm-2 control-label">Check in :</label>
                     <div class="col-sm-4">
                        <input type="datetime-local" class="form-control" name="check_in" id="check_in">
                        @if($errors->has('check_in'))
                        <div class="error text-danger">{{ $errors->first('check_in') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="check_out" class="col-sm-2 control-label">Check Out :</label>
                     <div class="col-sm-4">
                        <input type="datetime-local" class="form-control" name="check_out" id="check_out">
                        @if($errors->has('check_out'))
                        <div class="error text-danger">{{ $errors->first('check_out') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_gst_no" class="col-sm-2 control-label">Customer GST No:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="guest_gst_no" id="guest_gst_no" placeholder="Enter Gst No" maxlength="15"
                           oninput="this.value = this.value.toUpperCase()">
                        @if($errors->has('guest_gst_no'))
                        <div class="error text-danger">{{ $errors->first('guest_gst_no') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="guest_gst_name" class="col-sm-2 control-label">Customer GST Name:</label>
                     <div class="col-sm-4">
                        <input type="text" class="form-control" name="guest_gst_name" id="guest_gst_name" placeholder="Enter Gst Name">
                        @if($errors->has('guest_gst_name'))
                        <div class="error text-danger">{{ $errors->first('guest_gst_name') }}</div>
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
      $("form[name='addinvoiceform']").validate({
         rules: {
            hotel_id: {
               required: true,
            },
            invoice_no: {
               required: true,
            },
            invoice_date: {
               required: true,
            },
            guest_name1: {
               required: true,
            },
            guest_email: {
               required: true,
            },
            check_in: {
               required: true,
            },
            check_out: {
               required: true,
            },
            guest_mobile: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });

   function getDetail(hotel_id) {
      $.ajax({
         type: 'GET',
         url: '/admin/get-detail',
         data: {
            '_token': '{{ csrf_token() }}',
            'hotel_id': hotel_id
         },
         success: function(response) {
            console.log(response.invoice_no);
            $('#invoice_no').val(response.invoice_no);
         },
         error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
         }
      });
   }

   function validateDates() {
      const checkIn = new Date(document.getElementById('check_in').value);
      const checkOut = new Date(document.getElementById('check_out').value);

      if (checkIn && checkOut) {
         if (checkOut <= checkIn) {
            alert('Check-out date must be later than check-in date.');
            document.getElementById('check_out').value = ''; // Clear the invalid check-out value
         }
      }
   }

   document.getElementById('check_in').addEventListener('change', validateDates);
   document.getElementById('check_out').addEventListener('change', validateDates);
</script>
@endsection