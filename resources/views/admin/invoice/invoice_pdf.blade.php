<?php

use App\Models\Room;
use App\Models\Extra;
use App\Models\Category;
use Carbon\Carbon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Flight Ticket</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
    }

    .ticket {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 800px;
      margin: 20px auto;
      padding: 10px;
    }

    .header {
      margin-bottom: 20px;
      width: 100%;
    }

    .booking-info h1 {
      font-size: 18px;
      margin: 0 0 10px;
    }

    .booking-info p {
      margin: 5px 0;
      color: #555;
      font-size: 13px;
    }

    .barcode-section {
      border: 1px solid #ddd;
      border-radius: 10px;
    }

    .barcode-section p {
      font-size: 16px;
      color: #333;
    }

    .booking-details h2 {
      font-size: 20px;
      color: #1a1a1a;
      margin-top: 20px;
      border-bottom: 2px solid #ccc;
      padding-bottom: 5px;
    }

    .booking-details h3 {
      font-size: 18px;
      color: #1a1a1a;
      margin-top: 10px;
    }

    .booking-details p {
      margin: 5px 0;
      color: #555;
    }

    .flight-info {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 10px;
      margin-bottom: 20px;
    }

    .flight-segment {
      width: 100%;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-bottom: 10px;
    }

    .flight-segment img {
      width: 60px;
      margin-right: 10px;
    }

    .flight-times {
      width: 100%;
      text-align: center;
    }

    .flight-times p {
      margin: 0;
    }

    .duration {
      text-align: center;
      font-size: 18px;
      color: #333;
      margin: 10px 0;
    }

    .pnr {
      text-align: center;
      background-color: #e0f7fa;
      border-radius: 10px;
      padding: 10px;
      font-size: 16px;
      color: #00796b;
      margin-top: 20px;
    }

    .prohibited-items {
      border-top: 2px solid #ccc;
      padding-top: 20px;
      margin-top: 20px;
    }

    .prohibited-items h2 {
      font-size: 20px;
      color: #1a1a1a;
      margin-bottom: 20px;
    }

    .items {
      display: table;
      width: 100%;
    }

    .item {
      display: table-cell;
      text-align: center;
    }

    .item img {
      width: 100%;
      margin-bottom: 5px;
    }

    .important-info {
      border-top: 2px solid #ccc;
      padding-top: 20px;
      margin-top: 20px;
    }

    .important-info h2 {
      font-size: 20px;
      color: #1a1a1a;
      margin-bottom: 10px;
    }

    .important-info ul {
      padding: 0;
      list-style: none;
    }

    .important-info li {
      margin-bottom: 10px;
      color: #555;
    }

    .important-info a {
      color: #00796b;
      text-decoration: none;
    }

    .important-info a:hover {
      text-decoration: underline;
    }

    table {
      width: 100%;
      padding: 10px 0px;
    }

    .std1 th {
      border-left: 8px solid #00BFA5;
      background-color: #f5f5f5;
      font-weight: bold;
      padding: 10px;
      text-align: left;
    }
  </style>
</head>

<body>
  <?php //dd($invoice); 
  ?>
  <?php // dd($invoicedetail); 
  ?>
  <?php //dd($hoteldetail); 
  ?>
  <?php //dd($hotel); 
  ?>
  <div class="ticket">
    <table class="header">
      <tr>
        <td width="50%">
          <!-- <img src="https://sunrisegroupofschools.org/tickets-travel-logo.jpg" alt="Logo" style="width: 200px;"> -->
          <div class="booking-info">
            <h1>Hotel in {{$hotel->hotel_name}}</h1>
            <p>Hotel Invoice</p>
          </div>
        </td>
        <td style="text-align:right" width="50%">
          <div class="booking-info">
            <p>{{ $hoteldetail->address }} </p>
            <p>{{$hoteldetail->gst_no}}</p>
            <p>{{$hoteldetail->email}}</p>
            <p>{{$hoteldetail->contact}}</p>
          </div>
        </td>
      </tr>
    </table>

    <center>Bill No:</center>
    <div class="barcode-section" style="padding:5px">
      <table width="100%" style="align-items: center;">
        <tr>
          <td width="50%">
            <p>Invoice Number: #{{ $invoice->invoice_no }} </p>
            <p>NAME: {{ $invoice->guest_name1 }} </p>
            <p>Date: {{$invoice->invoice_date}}</p>
            <p>Email: {{$invoice->guest_email}}</p>
          </td>
          <td width="50%" style="text-align: right;">
            <p>NAME: {{isset($invoice->guest_name2) ? $invoice->guest_name2 : '' }} </p>
            <p>Mobile: {{$invoice->guest_mobile}}</p>
            <p>GSTIN: {{isset($invoice->guest_gst_no) ? $invoice->guest_gst_no : ''}}</p>
          </td>
        </tr>
      </table>
    </div>

    <div class="booking-details">
      <table width="100%" cellpadding="5" cellspacing="0">
        <tr>
          <th>Type</th>
          <th>Room No</th>
          <th>Category</th>
          <th>Name</th>
          <th>Check in</th>
          <th>Check out</th>
          <th>Days</th>
          <th>Amount</th>
          <th>GST</th>
          <th>Total</th>
        </tr>
        <?php foreach ($invoicedetail as $invoicede) {
          $room_no = '';
          $category_name = '';
          $extra_name = '';
          if ($invoicede->room_no) {
            $room = Room::where('id', $invoicede->room_no)->first();
            $room_no = $room->room_no;
          }
          if ($invoicede->category_id) {
            $category = Category::where('id', $invoicede->category_id)->first();
            $category_name = $category->c_name;
          }
          if ($invoicede->extra_id) {
            $extra = Extra::where('id', $invoicede->extra_id)->first();
            $extra_name = $extra->name;
          }
        ?>
          @php
          $formattedDateTime = Carbon::parse($invoicede->check_in)->format('d-m-Y g:i A');
          $formattedDateTimeout = Carbon::parse($invoicede->check_out)->format('d-m-Y g:i A');
          @endphp
          <tr>
            <td><?= $invoicede->type ?></td>
            <td><?= $room_no ?></td>
            <td><?= $category_name ?></td>
            <td><?= $extra_name ?></td>
            <td><?= $formattedDateTime ?></td>
            <td><?= $formattedDateTimeout ?></td>
            <td><?= $invoicede->days ?></td>
            <td><?= $invoicede->amount ?></td>
            <td><?= $invoicede->gst_percentage ?>&nbsp;%</td>
            <td><?= $invoicede->total_amount ?></td>
          </tr>
        <?php } ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td>Total</td>
          <td><?= $invoice->invoice_total ?></td>
        </tr>
      </table>
    </div>

  </div>
</body>

</html>