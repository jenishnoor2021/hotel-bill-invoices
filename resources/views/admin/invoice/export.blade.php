@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/invoice') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Export Invoice
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Export Invoice</li>
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
                  @if (session('success'))
                  <div class="alert pl-3 pt-1 pb-1" style="background-color:green;color:#fff;">
                     {{ session('success') }}
                  </div>
                  @endif
                  @if (session('error'))
                  <div class="alert pl-3 pt-1 pb-1" style="background-color:red;color:#fff;">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               {!! Form::open(['method'=>'GET', 'action'=> 'AdminInvoiceController@export','files'=>true,'class'=>'form-horizontal', 'name'=>'addinvoiceform']) !!}
               @csrf
               <input type="hidden" name="download" id="downloadFlag" value="0">
               <div class="box-body">
                  <div class="form-group">
                     <label for="hotel_id" class="col-sm-2 control-label">Hotel name</label>
                     <div class="col-sm-4">
                        <select name="hotel_id" id="hotel_id" class="custom-select form-control form-control-rounded" required>
                           @foreach($hotels as $hotel)
                           <option value="{{$hotel->id}}" {{ request()->hotel_id == $hotel->id ? 'selected' : '' }}>{{$hotel->hotel_name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('hotel_id'))
                        <div class="error text-danger">{{ $errors->first('hotel_id') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="start_date" class="col-sm-2 control-label">Start Date</label>
                     <div class="col-sm-4">
                        <input type="date" name="start_date" id="start_date" class="form-control border border-dark mb-2" value="{{ request()->start_date }}" placeholder="Enter date" required />
                        @if($errors->has('start_date'))
                        <div class="error text-danger">{{ $errors->first('start_date') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="end_date" class="col-sm-2 control-label">End Dater</label>
                     <div class="col-sm-4">
                        <input type="date" name="end_date" id="end_date" class="form-control border border-dark mb-2" placeholder="Enter date" value="{{ request()->end_date }}" />
                        @if($errors->has('end_date'))
                        <div class="error text-danger">{{ $errors->first('end_date') }}</div>
                        @endif
                     </div>
                  </div>

                  <div class="form-group">
                     <div class="col-md-5 col-sm-2 control-label">
                        <button type="submit" class="btn btn-primary mt-1" onclick="document.getElementById('downloadFlag').value = 0">Preview</button>
                        <button type="submit" class="btn btn-success mt-1" onclick="document.getElementById('downloadFlag').value = 1">Download Excel</button>
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
      @if(isset($data) && count($data) > 0)
      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-body" style="overflow-x:auto;margin-top:15px">

                  <!-- <div class="table-responsive mt-4"> -->
                  <table class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>ID</th>
                           <th>Hotel Name</th>
                           <th>Invoice no</th>
                           <th>Invoice Date</th>
                           <th>Guest name1</th>
                           <th>Guest name2</th>
                           <th>Email</th>
                           <th>mobile</th>
                           <th>GST no</th>
                           <th>GST Name</th>
                           <th>Check-In</th>
                           <th>Check-Out</th>
                           <th>Net Amount</th>
                           <th>Amount with GST</th>
                           <th>Discount</th>
                           <th>Ground Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($data as $invoice)
                        @php
                        $amount = \App\Models\Invoicedata::where('invoice_id', $invoice->id)->sum('amount');
                        $amountWithGst = \App\Models\Invoicedata::where('invoice_id', $invoice->id)->sum('total_amount');
                        $type = $invoice->discount_type === 'fix' ? 'Rs' : '%';
                        @endphp
                        <tr>
                           <td>{{ $invoice->id }}</td>
                           <td>{{ $invoice->hotel->hotel_name ?? '' }}</td>
                           <td>{{ $invoice->invoice_no }}</td>
                           <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</td>
                           <td>{{ $invoice->guest_name1 ?? '' }}</td>
                           <td>{{ $invoice->guest_name2 ?? '' }}</td>
                           <td>{{ $invoice->guest_email ?? '' }}</td>
                           <td>{{ $invoice->guest_mobile ?? '' }}</td>
                           <td>{{ $invoice->guest_gst_no ?? '' }}</td>
                           <td>{{ $invoice->guest_gst_name ?? '' }}</td>
                           <td>{{ \Carbon\Carbon::parse($invoice->check_in)->format('d-m-Y') }}</td>
                           <td>{{ \Carbon\Carbon::parse($invoice->check_out)->format('d-m-Y') }}</td>
                           <td>{{ $amount }}</td>
                           <td>{{ $amountWithGst }}</td>
                           <td>{{ $invoice->discount_value }} {{ $type }}</td>
                           <td>{{ $invoice->final_amount }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <!-- </div> -->
               </div>
            </div>
         </div>
      </div>
      @endif
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   function validateDates() {
      const start_date = new Date(document.getElementById('start_date').value);
      const end_date = new Date(document.getElementById('end_date').value);

      if (start_date && end_date) {
         if (end_date <= start_date) {
            alert('end-date date must be later than start-date date.');
            document.getElementById('end_date').value = ''; // Clear the invalid check-out value
         }
      }
   }

   document.getElementById('start_date').addEventListener('change', validateDates);
   document.getElementById('end_date').addEventListener('change', validateDates);
</script>
@endsection