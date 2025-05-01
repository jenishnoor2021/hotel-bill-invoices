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