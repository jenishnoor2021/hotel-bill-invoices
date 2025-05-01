<?php

use App\Models\Invoicedata;
?>

<table>
  <thead>
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
    @foreach($invoices as $invoice)
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
      <td>{{ $invoice->discount_value }}&nbsp;{{ $type }}</td>
      <td>{{ $invoice->final_amount }}</td>
    </tr>
    @endforeach
  </tbody>
</table>