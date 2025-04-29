<?php

use App\Models\Room;
use App\Models\Extra;
use App\Models\Category;
use Carbon\Carbon;
?>

@extends('layouts.admin')
@section('style')
<style>
   /* Add your styling here */
   .accordion {
      display: flex;
      flex-direction: column;
      max-width: 100%;
      margin: 0px 10px;
      /* Adjust as needed */
   }

   .accordion-item {
      border: 1px solid #000;
      margin-bottom: 5px;
      overflow: hidden;
   }

   .accordion-header {
      background-color: transparent;
      padding: 10px;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
   }

   .accordion-content {
      display: none;
      padding: 10px;
   }

   .accordion-arrow {
      transition: transform 0.3s ease-in-out;
   }

   .accordion-item.active .accordion-arrow {
      transform: rotate(180deg);
   }

   .remove-bottom-space {
      margin-bottom: 0px;
   }

   .tox .tox-notification--in {
      opacity: 0 !important;
   }

   .box-body {
      padding: 10px 20px;
   }
</style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/invoice') }}"><i class="fa fa-arrow-circle-left"
            style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Invoice
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Invoice</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-12" style="margin-left:10px; margin-right:10px;">
            <!-- Horizontal Form -->
            <div class="box box-info" style="margin-left:15px; margin-right:15px;">
               <div class="box-header with-border">
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
               <!-- form start -->
               <div class="accordion p-3">
                  <div class="accordion-item">
                     <div class="accordion-header">
                        <span><b>Invoice and Customer Detail</b></span>
                        <span class="accordion-arrow">&#9658;</span>
                     </div>
                     <div class="accordion-content">

                        {!! Form::model($invoice, [
                        'method' => 'PATCH',
                        'action' => ['AdminInvoiceController@update', $invoice->id],
                        'files' => true,
                        'class' => 'form-horizontal',
                        'name' => 'editInvoiceForm',
                        ]) !!}
                        @csrf
                        <div class="box-body">
                           <div class="form-group">
                              <label for="hotel_id" class="col-sm-2 control-label">Hotel name</label>
                              <div class="col-sm-4">
                                 <select name="hotel_id" id="hotel_id"
                                    class="custom-select form-control form-control-rounded"
                                    onchange="getDetail(this.value)" readonly>
                                    @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}"
                                       {{ $invoice->hotel_id == $hotel->id ? 'selected' : '' }}>
                                       {{ $hotel->hotel_name }}
                                    </option>
                                    @endforeach
                                 </select>
                                 @if ($errors->has('hotel_id'))
                                 <div class="error text-danger">{{ $errors->first('hotel_id') }}</div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="invoice_no" class="col-sm-2 control-label">Invoice number</label>
                              <div class="col-sm-4">
                                 <input type="text" name="invoice_no" id="invoice_no"
                                    class="form-control border border-dark mb-2"
                                    placeholder="Enter Invoice number" value="{{ $invoice->invoice_no }}"
                                    readonly>
                                 @if ($errors->has('invoice_no'))
                                 <div class="error text-danger">{{ $errors->first('invoice_no') }}</div>
                                 @endif
                              </div>
                           </div>

                           <div class="form-group">
                              <label for="invoice_date" class="col-sm-2 control-label">Date</label>
                              <div class="col-sm-4">
                                 <input type="date" name="invoice_date" id="invoice_date"
                                    class="form-control border border-dark mb-2"
                                    value="{{ $invoice->invoice_date }}" required>
                                 @if ($errors->has('invoice_date'))
                                 <div class="error text-danger">{{ $errors->first('invoice_date') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_name1" class="col-sm-2 control-label">Guest Name 1:</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" name="guest_name1"
                                    id="guest_name1" placeholder="Enter Guest Name 1"
                                    value="{{ $invoice->guest_name1 }}" required>
                                 @if ($errors->has('guest_name1'))
                                 <div class="error text-danger">{{ $errors->first('guest_name1') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_name2" class="col-sm-2 control-label">Guest Name 2:</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" name="guest_name2"
                                    id="guest_name2" placeholder="Enter Guest Name 2"
                                    value="{{ $invoice->guest_name2 }}">
                                 @if ($errors->has('guest_name2'))
                                 <div class="error text-danger">{{ $errors->first('guest_name2') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_email" class="col-sm-2 control-label">Email</label>
                              <div class="col-sm-4">
                                 <input type="email" name="guest_email" id="guest_email"
                                    class="form-control border border-dark mb-2"
                                    value="{{ $invoice->guest_email }}" placeholder="Enter email" required>
                                 @if ($errors->has('guest_email'))
                                 <div class="error text-danger">{{ $errors->first('guest_email') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_mobile" class="col-sm-2 control-label">Mobile No</label>
                              <div class="col-sm-4">
                                 <input type="number" name="guest_mobile" id="guest_mobile"
                                    class="form-control border border-dark mb-2"
                                    value="{{ $invoice->guest_mobile }}" placeholder="Enter mobile no"
                                    required>
                                 @if ($errors->has('guest_mobile'))
                                 <div class="error text-danger">{{ $errors->first('guest_mobile') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="check_in" class="col-sm-2 control-label">Check in :</label>
                              <div class="col-sm-4">
                                 <input type="datetime-local" class="form-control" name="check_in"
                                    id="check_in" value="{{ $invoice->check_in }}">
                                 @if ($errors->has('check_in'))
                                 <div class="error text-danger">{{ $errors->first('check_in') }}</div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="check_out" class="col-sm-2 control-label">Check Out :</label>
                              <div class="col-sm-4">
                                 <input type="datetime-local" class="form-control" name="check_out"
                                    id="check_out" value="{{ $invoice->check_out }}">
                                 @if ($errors->has('check_out'))
                                 <div class="error text-danger">{{ $errors->first('check_out') }}</div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_gst_no" class="col-sm-2 control-label">Customer GST
                                 No:</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" name="guest_gst_no"
                                    id="guest_gst_no" placeholder="Enter Gst No"
                                    value="{{ $invoice->guest_gst_no }}" maxlength="15"
                                    oninput="this.value = this.value.toUpperCase()">
                                 @if ($errors->has('guest_gst_no'))
                                 <div class="error text-danger">{{ $errors->first('guest_gst_no') }}
                                 </div>
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="guest_gst_name" class="col-sm-2 control-label">Customer GST
                                 Name:</label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control" name="guest_gst_name"
                                    id="guest_gst_name" placeholder="Enter Gst Name"
                                    value="{{ $invoice->guest_gst_name }}">
                                 @if ($errors->has('guest_gst_name'))
                                 <div class="error text-danger">{{ $errors->first('guest_gst_name') }}
                                 </div>
                                 @endif
                              </div>
                           </div>

                           <div class="form-group">
                              <div class="col-md-3 col-sm-2 control-label">
                                 {!! Form::submit('Update', ['class' => 'btn btn-success text-white mt-1']) !!}
                              </div>
                           </div>
                        </div>
                        {!! Form::close() !!}
                     </div>
                  </div>
               </div>

               <a href="#" class="btn btn-success" onclick="location.reload(); return false;">New</a>

               <div class="box-body" id="addInvoiceDetail">

                  {!! Form::open([
                  'method' => 'POST',
                  'action' => 'AdminInvoiceController@storeInvoiceData',
                  'files' => true,
                  'class' => 'form-horizontal',
                  'name' => 'addInvoiceDetailForm',
                  ]) !!}
                  @csrf
                  <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                  <div class="form-group row">
                     <div class="col-sm-2">
                        <label for="type" class="control-label">Type :</label>
                        <select name="type" id="type"
                           class="custom-select form-control form-control-rounded"
                           onchange="toggleSelectDivs(this.value)" required>
                           <option value="">Type</option>
                           <option value="room">Room</option>
                           <option value="extra">Extra Service</option>
                        </select>
                        @if ($errors->has('type'))
                        <div class="error text-danger">{{ $errors->first('type') }}</div>
                        @endif
                     </div>

                     <div id="room_select" style="display:none;">
                        <div class="col-sm-2">
                           <label for="category_id" class="control-label">Category:</label>
                           <select name="category_id" id="category_id"
                              class="custom-select form-control form-control-rounded"
                              onchange="filterRooms(this.value)">
                              <option value="">Select category</option>
                              @foreach ($categorys as $category)
                              <option value="{{ $category->id }}">{{ $category->c_name }}</option>
                              @endforeach
                           </select>
                           @if ($errors->has('category_id'))
                           <div class="error text-danger">{{ $errors->first('category_id') }}</div>
                           @endif
                        </div>
                        <div class="col-sm-2">
                           <label for="room_no" class="control-label">Room Number :</label>
                           <select name="room_no" id="room_no"
                              class="custom-select form-control form-control-rounded"
                              onchange="getRoomDetail(this.value)">
                              <option value="">Select type</option>
                              @foreach ($rooms as $room)
                              <option value="{{ $room->id }}"
                                 data-category="{{ $room->category_id }}">{{ $room->room_no }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('room_no'))
                           <div class="error text-danger">{{ $errors->first('room_no') }}</div>
                           @endif
                        </div>
                     </div>

                     <div id="extra_select" style="display:none;">
                        <div class="col-sm-2">
                           <label for="extra_id" class="control-label">Extra services :</label>
                           <select name="extra_id" id="extra_id"
                              class="custom-select form-control form-control-rounded"
                              onchange="getExtraDetail(this.value)">
                              <option value="">Select Service</option>
                              @foreach ($extras as $extra)
                              <option value="{{ $extra->id }}">{{ $extra->name }}</option>
                              @endforeach
                           </select>
                           @if ($errors->has('room_no'))
                           <div class="error text-danger">{{ $errors->first('room_no') }}</div>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-sm-2">
                        <label for="days" class="control-label">No. of days/Quntity:</label>
                        <input type="number" class="form-control" name="days" id="days"
                           placeholder="Enter days" oninput="calculateAmounts()" required>
                        @if ($errors->has('days'))
                        <div class="error text-danger">{{ $errors->first('days') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="amount" class="control-label">Amount :</label>
                        <input type="number" class="form-control" name="amount" id="amount"
                           placeholder="Enter amount" required readonly>
                        @if ($errors->has('amount'))
                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="gst_percentage" class="control-label">GST :</label>
                        <input type="number" class="form-control" name="gst_percentage" id="gst_percentage"
                           placeholder="Enter amount" required readonly>
                        @if ($errors->has('gst_percentage'))
                        <div class="error text-danger">{{ $errors->first('gst_percentage') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="total_amount" class="control-label">Total :</label>
                        <input type="number" class="form-control" name="total_amount" id="total_amount"
                           placeholder="Enter Total amout" oninput="changeTotal()" required>
                        @if ($errors->has('total_amount'))
                        <div class="error text-danger">{{ $errors->first('total_amount') }}</div>
                        @endif
                     </div>
                     <div class="col-md-3 col-sm-2 control-label">
                        <div class="col-md-3 col-sm-2 control-label">
                           {!! Form::submit('Add', ['class' => 'btn btn-success text-white mt-1']) !!}
                        </div>
                     </div>
                  </div>
                  {!! Form::close() !!}
               </div>

               @if (count($invoicedatas) > 0)
               @foreach ($invoicedatas as $invoicedata)
               <div class="box-body" id="editInvoiceDetail{{ $invoicedata->id }}"
                  style="display:none;">
                  {!! Form::model($invoicedata, [
                  'method' => 'PATCH',
                  'action' => ['AdminInvoiceController@updateInvoiceData', $invoicedata->id],
                  'files' => true,
                  'class' => 'form-horizontal',
                  'name' => 'editInvoiceDataForm',
                  ]) !!}
                  @csrf
                  <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                  <input type="hidden" name="data_id" value="{{ $invoicedata->id }}">

                  <div class="form-group row">
                     <div class="col-sm-2">
                        <label for="type" class="control-label">Type :</label>
                        <select name="type" id="type{{ $invoicedata->id }}"
                           class="custom-select form-control form-control-rounded"
                           onchange="toggleSelectDivs(this.value)" required readonly>
                           <option value="">Type</option>
                           <option value="room"
                              {{ $invoicedata->type == 'room' ? 'selected' : '' }}>Room</option>
                           <option value="extra"
                              {{ $invoicedata->type == 'extra' ? 'selected' : '' }}>Extra Service
                           </option>
                        </select>
                        @if ($errors->has('type'))
                        <div class="error text-danger">{{ $errors->first('type') }}</div>
                        @endif
                     </div>

                     <div id="edit_room_select{{ $invoicedata->id }}" style="display:none;">
                        <div class="col-sm-2">
                           <label for="category_id" class="control-label">Category:</label>
                           <select name="category_id" id="category_id{{ $invoicedata->id }}"
                              onchange="editfilterRooms(this.value,{{ $invoicedata->id }})"
                              class="custom-select form-control form-control-rounded">
                              <option value="">Select category</option>
                              @foreach ($categorys as $category)
                              <option value="{{ $category->id }}"
                                 {{ $category->id == $invoicedata->category_id ? 'selected' : '' }}>
                                 {{ $category->c_name }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('category_id'))
                           <div class="error text-danger">{{ $errors->first('category_id') }}
                           </div>
                           @endif
                        </div>
                        <div class="col-sm-2">
                           <label for="room_no" class="control-label">Room Number :</label>
                           <select name="room_no" id="room_no{{ $invoicedata->id }}"
                              class="custom-select form-control form-control-rounded"
                              onchange="editgetRoomDetail(this.value,{{ $invoicedata->id }})">
                              <option value="">Select type</option>
                              @foreach ($rooms as $room)
                              <option value="{{ $room->id }}"
                                 data-category="{{ $room->category_id }}"
                                 {{ $invoicedata->room_no == $room->id ? 'selected' : '' }}>
                                 {{ $room->room_no }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('room_no'))
                           <div class="error text-danger">{{ $errors->first('room_no') }}</div>
                           @endif
                        </div>
                        <!-- <div class="col-sm-2">
                               <label for="check_in" class="control-label">Check in :</label>
                               <input type="datetime-local" class="form-control" name="check_in" id="check_in{{ $invoicedata->id }}" value="{{ $invoicedata->check_in }}">
                               @if ($errors->has('check_in'))
                                 <div class="error text-danger">{{ $errors->first('check_in') }}</div>
                              @endif
                            </div>
                            <div class="col-sm-2">
                               <label for="check_out" class="control-label">Check Out :</label>
                               <input type="datetime-local" class="form-control" name="check_out" id="check_out{{ $invoicedata->id }}" value="{{ $invoicedata->check_out }}">
                               @if ($errors->has('check_out'))
                                 <div class="error text-danger">{{ $errors->first('check_out') }}</div>
                              @endif
                            </div> -->
                     </div>

                     <div id="edit_extra_select{{ $invoicedata->id }}" style="display:none;">
                        <div class="col-sm-2">
                           <label for="extra_id" class="control-label">Extra services :</label>
                           <select name="extra_id" id="extra_id{{ $invoicedata->id }}"
                              class="custom-select form-control form-control-rounded"
                              onchange="editgetExtraDetail(this.value,{{ $invoicedata->id }})">
                              <option value="">Select Service</option>
                              @foreach ($extras as $extra)
                              <option value="{{ $extra->id }}"
                                 {{ $invoicedata->extra_id == $extra->id ? 'selected' : '' }}>
                                 {{ $extra->name }}
                              </option>
                              @endforeach
                           </select>
                           @if ($errors->has('room_no'))
                           <div class="error text-danger">{{ $errors->first('room_no') }}</div>
                           @endif
                        </div>
                     </div>
                  </div>

                  <div class="form-group row">
                     <div class="col-sm-2">
                        <label for="days" class="control-label">No. of days/quntity:</label>
                        <input type="number" class="form-control" name="days"
                           id="days{{ $invoicedata->id }}" placeholder="Enter days"
                           value="{{ $invoicedata->days }}"
                           oninput="editcalculateAmounts({{ $invoicedata->id }})" required>
                        @if ($errors->has('days'))
                        <div class="error text-danger">{{ $errors->first('days') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="amount" class="control-label">Amount :</label>
                        <input type="text" class="form-control" name="amount"
                           id="amount{{ $invoicedata->id }}" placeholder="Enter amount"
                           value="{{ $invoicedata->amount }}" required readonly>
                        @if ($errors->has('amount'))
                        <div class="error text-danger">{{ $errors->first('amount') }}</div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="gst_percentage" class="control-label">GST :</label>
                        <input type="number" class="form-control" name="gst_percentage"
                           id="gst_percentage{{ $invoicedata->id }}" placeholder="Enter amount"
                           value="{{ $invoicedata->gst_percentage }}" required readonly>
                        @if ($errors->has('gst_percentage'))
                        <div class="error text-danger">{{ $errors->first('gst_percentage') }}
                        </div>
                        @endif
                     </div>
                     <div class="col-sm-2">
                        <label for="total_amount" class="control-label">Total :</label>
                        <input type="text" class="form-control" name="total_amount"
                           id="total_amount{{ $invoicedata->id }}" placeholder="Enter Total amout"
                           value="{{ $invoicedata->total_amount }}"
                           oninput="editchangeTotal({{ $invoicedata->id }})" required>
                        @if ($errors->has('total_amount'))
                        <div class="error text-danger">{{ $errors->first('total_amount') }}</div>
                        @endif
                     </div>
                     <div class="col-md-3 col-sm-2 control-label">
                        <div class="col-md-3 col-sm-2 control-label">
                           {!! Form::submit('Update', ['class' => 'btn btn-success text-white mt-1']) !!}
                        </div>
                     </div>
                  </div>
                  {!! Form::close() !!}
               </div>
               @endforeach
               @endif

            </div>
            <!-- /.box -->

            <div class="box box-info" style="margin-left:15px; margin-right:15px;">
               <div class="box-header with-border">
                  <a href="{{ route('admin.invoice.pdf', $invoice->id) }}"
                     class="bg-success text-white text-decoration-none"
                     style="padding:8px 12px;margin-left:15px;font-size:20px">Generate Bill</a>
                  @if ($invoice->file != '')
                  <a href="{{ asset('invoices/' . $invoice->file) }}" target="_blank"
                     class="bg-info text-white text-decoration-none"
                     style="padding:8px 12px;margin-left:15px;font-size:20px">View Bill</a>
                  @endif
               </div>

               <div class="box-body">
                  @if (count($invoicedatas) > 0)
                  <table id="" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Room Number</th>
                           <th>Category</th>
                           <th>Extra service</th>
                           <th>Days</th>
                           <!-- <th>Check in</th>
                               <th>Check out</th> -->
                           <th>Amount</th>
                           <th>GST</th>
                           <th>Total Amount</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($invoicedatas as $invoicedata)
                        <?php
                        $room_no = '';
                        $category_name = '';
                        $extra_name = '';
                        if ($invoicedata->room_no) {
                           $room = Room::where('id', $invoicedata->room_no)->first();
                           $room_no = $room->room_no;
                        }
                        if ($invoicedata->category_id) {
                           $category = Category::where('id', $invoicedata->category_id)->first();
                           $category_name = $category->c_name;
                        }
                        if ($invoicedata->extra_id) {
                           $extra = Extra::where('id', $invoicedata->extra_id)->first();
                           $extra_name = $extra->name;
                        }
                        ?>
                        <tr>
                           <td>
                              <!-- <a id="{{ $invoicedata->id }}" onclick="editfun(this.id)"
                                 style="cursor: pointer;"><i class="fa fa-edit"
                                    style="color:white;font-size:15px;background-color:rgba(255, 255, 255, 0.25);color:blue;padding:8px;"></i></a> -->
                              <a href="{{ route('admin.invoice.editdata', $invoicedata->id) }}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                              <a href="{{ route('admin.invoicedata.destroy', $invoicedata->id) }}"
                                 onclick="return confirm('Sure ! You want to delete reocrd ?');"><i
                                    class="fa fa-trash"
                                    style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);color:red;padding:8px;"></i></a>
                           </td>
                           <td>{{ $room_no }}</td>
                           <td>{{ $category_name }}</td>
                           <td>{{ $extra_name }}</td>
                           <td>{{ $invoicedata->days }}</td>
                           <!-- <td>{{ $invoicedata->check_in }}</td>
                               <td>{{ $invoicedata->check_out }}</td> -->
                           <td>{{ $invoicedata->amount }}</td>
                           <td>{{ $invoicedata->gst_percentage }}</td>
                           <td>{{ $invoicedata->total_amount }}</td>
                        </tr>
                        @endforeach
                        <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <!-- <td></td>
                               <td></td> -->
                           <td></td>
                           <td></td>
                           <td></td>
                           <td>
                              <h4><b>Discount</b></h4>
                           </td>
                           <td>
                              <h4>

                                 <form action="/admin/invoice/add-discount" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

                                    <input type="text" name="discount_value" value="{{ $invoice->discount_value }}"
                                       placeholder="Discount" class="form-control w-25"
                                       onkeypress='return (event.charCode >= 45 && event.charCode <= 57 && event.charCode != 47) || event.charCode == 46'>

                                    <select name="discount_type" id="discount_type" class="custom-select form-control w-25">
                                       <option value="fix" {{ $invoice->discount_type == 'fix' ? 'selected' : '' }}>Fix</option>
                                       <option value="percentage" {{ $invoice->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>

                                    <input type="submit" class="btn btn-success" value="Apply">
                                 </form>

                              </h4>
                           </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td></td>
                           <td></td>
                           <!-- <td></td>
                               <td></td> -->
                           <td></td>
                           <td></td>
                           <td></td>
                           <td>
                              <h4><b>Total</b></h4>
                           </td>
                           <td>
                              <h4><b>{{ $invoice->final_amount }}</b></h4>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  @endif
               </div>
            </div>
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
      $("form[name='editInvoiceForm']").validate({
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
      $("form[name='addInvoiceDetailForm']").validate({
         rules: {
            type: {
               required: true,
            },
            // check_in: {
            //    required: true,
            // },
            // check_out: {
            //    required: true,
            // },
            days: {
               required: true,
            },
            amount: {
               required: true,
            },
            gst_percentage: {
               required: true,
            },
            total_amount: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
      $("form[name='editInvoiceDataForm']").validate({
         rules: {
            type: {
               required: true,
            },
            // check_in: {
            //    required: true,
            // },
            // check_out: {
            //    required: true,
            // },
            days: {
               required: true,
            },
            amount: {
               required: true,
            },
            gst_percentage: {
               required: true,
            },
            total_amount: {
               required: true,
            },
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });

   $(document).ready(function() {
      // Toggle accordion content and arrow rotation when clicking on the header
      $('.accordion-header').click(function() {
         $(this).parent('.accordion-item').toggleClass('active');
         $(this).find('.accordion-arrow').text(function(_, text) {
            return text === '►' ? '▼' : '►';
         });
         $(this).next('.accordion-content').slideToggle();
         $(this).parent('.accordion-item').siblings('.accordion-item').removeClass('active').find(
            '.accordion-content').slideUp();
         $(this).parent('.accordion-item').siblings('.accordion-item').find('.accordion-arrow').text(
            '►');
      });
   });

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

   function toggleSelectDivs(type) {
      if (type === 'room') {
         document.getElementById('room_select').style.display = 'block';
         document.getElementById('extra_select').style.display = 'none';
      } else if (type === 'extra') {
         document.getElementById('room_select').style.display = 'none';
         document.getElementById('extra_select').style.display = 'block';
      } else {
         document.getElementById('room_select').style.display = 'none';
         document.getElementById('extra_select').style.display = 'none';
      }
   }

   function filterRooms(category_id) {
      const selectedCategory = category_id;
      const roomSelect = document.getElementById('room_no');
      const roomOptions = roomSelect.querySelectorAll('option');

      if (selectedCategory === '') {
         roomOptions.forEach(option => {
            option.style.display = '';
         });
      } else {
         roomOptions.forEach(option => {
            if (option.getAttribute('data-category') === selectedCategory) {
               option.style.display = '';
            } else {
               option.style.display = 'none';
            }
         });

         roomSelect.value = '';
      }
   }

   function editfilterRooms(category_id, id) {
      const selectedCategory = category_id;
      const roomSelect = document.getElementById('room_no' + id);
      const roomOptions = roomSelect.querySelectorAll('option');

      if (selectedCategory === '') {
         roomOptions.forEach(option => {
            option.style.display = '';
         });
      } else {
         roomOptions.forEach(option => {
            if (option.getAttribute('data-category') === selectedCategory) {
               option.style.display = '';
            } else {
               option.style.display = 'none';
            }
         });

         roomSelect.value = '';
      }
   }

   function getRoomDetail(room_id) {
      $('#days').val('');
      $.ajax({
         type: 'GET',
         url: '/admin/get-room-detail',
         data: {
            '_token': '{{ csrf_token() }}',
            'room_id': room_id
         },
         success: function(response) {
            console.log(response);
            if (response.error) {
               console.error(response.error);
            } else {
               // Update room details
               // $('#category_id').val(response.category_id);
               $('#amount').val(response.amount);
               $('#gst_percentage').val(response.gst_percentage);
               $('#total_amount').val(response.total_amount);
               $('#days').val(1);

               // Set the selected category name
               // let categorySelect = $('#category_id');
               // categorySelect.empty(); // Clear current options
               // categorySelect.append('<option value="">Select Category</option>');

               // response.categories.forEach(category => {
               //    let selected = category.id == response.category_id ? 'selected' : '';
               //    categorySelect.append(`<option value="${category.id}" ${selected}>${category.c_name}</option>`);
               // });
            }
         },
         error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
         }
      });
   }

   function editgetRoomDetail(room_id, id) {
      $('#days' + id).val('');
      $.ajax({
         type: 'GET',
         url: '/admin/get-room-detail',
         data: {
            '_token': '{{ csrf_token() }}',
            'room_id': room_id
         },
         success: function(response) {
            console.log(response);
            if (response.error) {
               console.error(response.error);
            } else {
               // Update room details
               $('#category_id' + id).val(response.category_id);
               $('#amount' + id).val(response.amount);
               $('#gst_percentage' + id).val(response.gst_percentage);
               $('#total_amount' + id).val(response.total_amount);
               $('#days' + id).val(1);

               // Set the selected category name
               // let categorySelect = $('#category_id' + id);
               // categorySelect.empty(); // Clear current options
               // categorySelect.append('<option value="">Select Category</option>');

               // response.categories.forEach(category => {
               //    let selected = category.id == response.category_id ? 'selected' : '';
               //    categorySelect.append(`<option value="${category.id}" ${selected}>${category.c_name}</option>`);
               // });
            }
         },
         error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
         }
      });
   }

   function getExtraDetail(extra_id) {
      $('#days').val('');
      $.ajax({
         type: 'GET',
         url: '/admin/get-extra-detail',
         data: {
            '_token': '{{ csrf_token() }}',
            'extra_id': extra_id
         },
         success: function(response) {
            console.log(response);
            if (response.error) {
               console.error(response.error);
            } else {
               // Update room details
               $('#amount').val(response.amount);
               $('#gst_percentage').val(response.gst_percentage);
               $('#total_amount').val(response.total_amount);
               $('#days').val(1);
            }
         },
         error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
         }
      });
   }

   function editgetExtraDetail(extra_id, id) {
      $('#days' + id).val('');
      $.ajax({
         type: 'GET',
         url: '/admin/get-extra-detail',
         data: {
            '_token': '{{ csrf_token() }}',
            'extra_id': extra_id
         },
         success: function(response) {
            console.log(response);
            if (response.error) {
               console.error(response.error);
            } else {
               // Update room details
               $('#amount' + id).val(response.amount);
               $('#gst_percentage' + id).val(response.gst_percentage);
               $('#total_amount' + id).val(response.total_amount);
               $('#days' + id).val(1);
            }
         },
         error: function(xhr, status, error) {
            console.error('AJAX Error:', error);
         }
      });
   }

   function calculateAmounts() {
      const days = parseFloat(document.getElementById('days').value) || 0;
      const amount = parseFloat(document.getElementById('amount').value) || 0;
      const gstPercentage = parseFloat(document.getElementById('gst_percentage').value) || 0;

      // Calculate the total amount before GST
      const totalBeforeGst = days * amount;

      // Calculate the GST amount
      const gstAmount = totalBeforeGst * (gstPercentage / 100);

      // Calculate the total amount including GST
      const totalAmount = totalBeforeGst + gstAmount;

      // Update the total_amount field
      document.getElementById('total_amount').value = totalAmount.toFixed(2);
   }

   function editcalculateAmounts(id) {
      const days = parseFloat(document.getElementById('days' + id).value) || 0;
      const amount = parseFloat(document.getElementById('amount' + id).value) || 0;
      const gstPercentage = parseFloat(document.getElementById('gst_percentage' + id).value) || 0;

      // Calculate the total amount before GST
      const totalBeforeGst = days * amount;

      // Calculate the GST amount
      const gstAmount = totalBeforeGst * (gstPercentage / 100);

      // Calculate the total amount including GST
      const totalAmount = totalBeforeGst + gstAmount;

      // Update the total_amount field
      document.getElementById('total_amount' + id).value = totalAmount.toFixed(2);
   }

   function changeTotal() {
      // Get the manually entered total amount
      const totalAmount = parseFloat(document.getElementById('total_amount').value) || 0;

      // Get the GST percentage and ensure it's valid
      const gstPercentage = parseFloat(document.getElementById('gst_percentage').value) || 0;

      // Recalculate the amount based on the new total and GST
      const totalBeforeGst = totalAmount / (1 + (gstPercentage / 100));
      const amountPerDay = totalBeforeGst / (parseFloat(document.getElementById('days').value) || 1);

      // Update the amount field (assuming it's per day)
      document.getElementById('amount').value = amountPerDay.toFixed(2);
   }

   function editchangeTotal(id) {
      // Get the manually entered total amount
      const totalAmount = parseFloat(document.getElementById('total_amount' + id).value) || 0;

      // Get the GST percentage and ensure it's valid
      const gstPercentage = parseFloat(document.getElementById('gst_percentage' + id).value) || 0;

      // Recalculate the amount based on the new total and GST
      const totalBeforeGst = totalAmount / (1 + (gstPercentage / 100));
      const amountPerDay = totalBeforeGst / (parseFloat(document.getElementById('days' + id).value) || 1);

      // Update the amount field (assuming it's per day)
      document.getElementById('amount' + id).value = amountPerDay.toFixed(2);
   }

   function editfun(element) {
      var id = element;
      var div = document.getElementById("editInvoiceDetail" + id);
      var divadd = document.getElementById("addInvoiceDetail");
      var typ = document.getElementById("type" + id).value;

      alert(typ);

      @foreach($invoicedatas as $invoicedata)
      document.getElementById('editInvoiceDetail{{ $invoicedata->id }}').style.display = 'none';
      document.getElementById('edit_room_select{{ $invoicedata->id }}').style.display = 'none';
      document.getElementById('edit_extra_select{{ $invoicedata->id }}').style.display = 'none';
      @endforeach

      if (typ === 'room') {
         document.getElementById('edit_room_select' + id).style.display = 'block';
         document.getElementById('edit_extra_select' + id).style.display = 'none';
      } else if (typ === 'extra') {
         document.getElementById('edit_room_select' + id).style.display = 'none';
         document.getElementById('edit_extra_select' + id).style.display = 'block';
      } else {
         document.getElementById('edit_room_select' + id).style.display = 'none';
         document.getElementById('edit_extra_select' + id).style.display = 'none';
      }

      if (div.style.display !== "block") {
         div.style.display = "block";
         divadd.style.display = "none";
      } else {
         div.style.display = "none";
         divadd.style.display = "block";
      }
   }
</script>
@endsection