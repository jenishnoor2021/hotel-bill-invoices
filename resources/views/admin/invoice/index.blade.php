@extends('layouts.admin')
@section('style')
@stop
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Invoices</b> &nbsp; <a href="{{route('admin.invoice.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Invoices</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header">
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
               @if(count($invoices)>0)
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;margin-top:15px">

                  <table id="invoicesTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Hotel Name</th>
                           <th>Invoice No</th>
                           <th>Invoice Date</th>
                           <th>Guest name</th>
                           <th>Email</th>
                           <th>Contact no</th>
                           <th>Check in</th>
                           <th>Check out</th>
                           <th>GST no</th>
                           <th>GST name</th>
                           <th>PDF</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                           <td>
                              <a href="{{route('admin.invoice.edit', $invoice->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                              <a href="{{route('admin.invoice.destroy', $invoice->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);color:red;padding:8px;"></i></a>
                           </td>
                           <td>{{$invoice->hotel->hotel_name}}</td>
                           <td>{{$invoice->invoice_no}}</td>
                           <td>{{$invoice->invoice_date}}</td>
                           <td>{{$invoice->guest_name1}}</td>
                           <td>{{$invoice->guest_email}}</td>
                           <td>{{$invoice->guest_mobile}}</td>
                           <td>{{$invoice->check_in}}</td>
                           <td>{{$invoice->check_out}}</td>
                           <td>{{$invoice->guest_gst_no}}</td>
                           <td>{{$invoice->guest_gst_name}}</td>
                           <td>
                              @if($invoice->file != '')
                              <a href="{{asset('invoices/'.$invoice->file)}}" target="_blank"><b>PDF</b></a>
                              @endif
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>

               </div>
               <!-- /.box-body -->
               @else
               <center>
                  <h1>No Record found</h1>
               </center>
               @endif
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(document).ready(function() {
      $("#invoicesTable").DataTable();
   });
</script>
@endsection