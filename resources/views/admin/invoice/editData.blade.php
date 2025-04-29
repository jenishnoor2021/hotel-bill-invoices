<?php

use App\Models\Room;
use App\Models\Extra;
use App\Models\Category;
use Carbon\Carbon;
?>

@extends('layouts.admin')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="/admin/invoice/edit/{{ $invoicedata->invoice_id }}"><i class="fa fa-arrow-circle-left"
            style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Edit Invoice Data
      </h1>
      <ol class="breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Invoice Data</li>
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

               <div class="box-body" id="editInvoiceDetail{{ $invoicedata->id }}">
                  {!! Form::model($invoicedata, [
                  'method' => 'PATCH',
                  'action' => ['AdminInvoiceController@updateInvoiceData', $invoicedata->id],
                  'files' => true,
                  'class' => 'form-horizontal',
                  'name' => 'editInvoiceDataForm',
                  ]) !!}
                  @csrf
                  <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

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

      editfun(<?= $invoicedata->id ?>);
   });

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

   function editfun(id) {
      var div = document.getElementById("editInvoiceDetail" + id);
      var divadd = document.getElementById("addInvoiceDetail");
      var typ = document.getElementById("type" + id).value;

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