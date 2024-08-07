@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Edit Flight Ticket
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Edit Flight Ticket</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-primary">
               <div class="box-header">
                  <h3 class="box-title">Edit Flight Ticket</h3>
               </div>
               <div class="box-body">
                  <!-- Horizontal Form -->
                  <div class="box box-info">
                     <div class="box-header with-border">

                     </div>
                     <!-- /.box-header -->
                     <!-- form start -->

                     {!! Form::model($flight, ['method'=>'PATCH', 'action'=> ['AdminSamplesController@update', $flight->id],'files'=>true,'class'=>'form-horizontal', 'name'=>'editFlight']) !!}
                     @csrf

                     <div class="box-body">

                        <a href="{{ $flight->file }}" target="_blank" class="btn btn-default mt-5"><i class="fa fa-download" style="font-size:26px"></i></a>

                        <div class="form-group row">
                           <div class="col-sm-3">
                              <label for="booking_id" class="control-label">Booking ID :</label>
                              <input type="text" class="form-control" name="booking_id" value="{{ $flight->booking_id }}" readonly>
                              @if($errors->has('booking_id'))
                              <div class="error text-danger">{{ $errors->first('booking_id') }}</div>
                              @endif
                           </div>
                           <div class="col-sm-3">
                              <label for="b_date" class="control-label">Date :</label>
                              <input type="date" class="form-control" name="b_date" id="b_date" value="{{ $flight->b_date }}" placeholder="Enter Date" required>
                              @if($errors->has('b_date'))
                              <div class="error text-danger">{{ $errors->first('b_date') }}</div>
                              @endif
                           </div>
                           <div class="col-sm-3">
                              <label for="barcode" class="control-label">Barcode :</label>
                              <input type="file" class="form-control" name="barcode">
                              @if($errors->has('barcode'))
                              <div class="error text-danger">{{ $errors->first('barcode') }}</div>
                              @endif
                           </div>
                           <div class="col-sm-3">
                              <label for="pnr_no" class="control-label">PNR number :</label>
                              <input type="text" class="form-control" name="pnr_no" id="pnr_no" value="{{ $flight->pnr_no }}" placeholder="Enter PNR Number" required>
                              @if($errors->has('pnr_no'))
                              <div class="error text-danger">{{ $errors->first('pnr_no') }}</div>
                              @endif
                           </div>
                        </div>

                        <hr style="border:1px solid #000;" />

                        <div class="table-responsive">
                           <table class="table" id="inputPessengerTable">
                              <thead>
                                 <tr>
                                    <th width="30%">Pessenger name</th>
                                    <th width="10%">SEAT</th>
                                    <th width="10%">MEAL</th>
                                    <th width="20%">Ticket no</th>
                                    <th width="10%">Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $passengers = json_decode($flight->passenger_name, true);
                                 $seat = json_decode($flight->seat, true);
                                 $meal = json_decode($flight->meal, true);
                                 $p_pnr = json_decode($flight->passenger_pnr, true);
                                 $numPassengers = count($passengers);
                                 ?>
                                 <?php foreach ($passengers as $key => $passenger) { ?>
                                    <tr>
                                       <td>
                                          <input type="text" class="form-control" name="passenger_name[]" id="passenger_name" placeholder="Enter pesenger name" value="{{ $passenger }}" required>
                                       </td>
                                       <td>
                                          <input type="text" class="form-control" name="seat[]" id="seat" value="{{ $seat[$key] }}" placeholder="Entaer Seat Number">
                                       </td>
                                       <td>
                                          <input type="text" class="form-control" name="meal[]" value="{{ $meal[$key] }}" id="meal" placeholder="Enter meal">
                                       </td>
                                       <td>
                                          <input type="text" class="form-control" name="passenger_pnr[]" value="{{ $p_pnr[$key] }}" id="passenger_pnr" placeholder="Enter pesenger PNR" required>
                                       </td>
                                       <td>
                                          <?php if ($numPassengers > 1) { ?>
                                             <button type="button" class="btn btn-danger" onclick="removePessenger(this)">Remove</button>
                                          <?php } ?>
                                       </td>
                                    </tr>
                                 <?php } ?>
                              </tbody>
                           </table>
                           <button type="button" class="btn btn-primary" onclick="addPessenger()">+</button>
                        </div>

                        <hr style="border:1px solid #000;" />

                        <?php
                        $journeys = json_decode($flight->journey, true);
                        $flogo = json_decode($flight->flogo, true);
                        $air_lines = json_decode($flight->air_lines, true);
                        $journy_date = json_decode($flight->journy_date, true);
                        $duration = json_decode($flight->duration, true);
                        $flight_number = json_decode($flight->flight_number, true);

                        $departure = json_decode($flight->departure, true);
                        $short_from = json_decode($flight->short_from, true);
                        $departure_time = json_decode($flight->departure_time, true);
                        $d_date = json_decode($flight->d_date, true);
                        $airport_name = json_decode($flight->airport_name, true);
                        $terminal = json_decode($flight->terminal, true);

                        $arrival = json_decode($flight->arrival, true);
                        $short_to = json_decode($flight->short_to, true);
                        $arrival_time = json_decode($flight->arrival_time, true);
                        $a_date = json_decode($flight->a_date, true);
                        $airport_name_to = json_decode($flight->airport_name_to, true);
                        $to_terminal = json_decode($flight->to_terminal, true);

                        $check_in_weight = json_decode($flight->check_in_weight, true);
                        $cabin_weight = json_decode($flight->cabin_weight, true);

                        $numfligts = count($journeys);

                        ?>
                        <div id="addMoreFlightContainer">
                           <?php foreach ($journeys as $key => $journey) { ?>

                              <div class="table-responsive flight-container">
                                 <div class="flight-info" id="addMoreFlight">

                                    <div class="form-group row">
                                       <div class="col-sm-2">
                                          <label for="flogo" class="control-label">Flight Logo :
                                             @if(!empty($flogo) && isset($flogo[$key]))
                                             <img src="https://test.noorinfotech.in/flightbarcode/{{$flogo[$key]}}" alt="IndiGo" style="width: 60px;">
                                             @else
                                             <img src="https://sunrisegroupofschools.org/tickets-travel-logo-old.jpg" alt="IndiGo" style="width: 60px;">
                                             @endif
                                          </label>
                                          <input type="file" class="form-control" name="flogo[]">
                                          @if($errors->has('flogo'))
                                          <div class="error text-danger">{{ $errors->first('flogo') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="journey" class="control-label">Journey :</label>
                                          <input type="text" class="form-control" name="journey[]" value="{{ $journey }}" placeholder="Delhi-Chennai" required>
                                          @if($errors->has('journey'))
                                          <div class="error text-danger">{{ $errors->first('journey') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-1">
                                          <label for="air_lines" class="control-label">Air Lines :</label>
                                          <input type="text" class="form-control" name="air_lines[]" value="{{ $air_lines[$key] }}" id="air_lines" placeholder="IndiGo" required>
                                          @if($errors->has('air_lines'))
                                          <div class="error text-danger">{{ $errors->first('air_lines') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="journy_date" class="control-label">Journy date :</label>
                                          <input type="date" class="form-control" name="journy_date[]" value="{{ $journy_date[$key] }}" id="journy_date" required>
                                          @if($errors->has('journy_date'))
                                          <div class="error text-danger">{{ $errors->first('journy_date') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="duration" class="control-label">Time Duration :</label>
                                          <input type="text" class="form-control" name="duration[]" value="{{ $duration[$key] }}" id="duration" placeholder="2h 55m" required>
                                          @if($errors->has('duration'))
                                          <div class="error text-danger">{{ $errors->first('duration') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="flight_number" class="control-label">Flight Number :</label>
                                          <input type="text" class="form-control" name="flight_number[]" value="{{ $flight_number[$key] }}" placeholder="Enter Flight Number" required>
                                          @if($errors->has('flight_number'))
                                          <div class="error text-danger">{{ $errors->first('flight_number') }}</div>
                                          @endif
                                       </div>
                                    </div>

                                    <center>
                                       <u>
                                          <h3><b>Departure:</b></h3>
                                       </u>
                                    </center>

                                    <div class="form-group row">
                                       <div class="col-sm-2">
                                          <label for="departure" class="control-label">Departure From :</label>
                                          <input type="text" class="form-control" name="departure[]" value="{{ $departure[$key] }}" id="departure" placeholder="Enter departure place" required>
                                          @if($errors->has('departure'))
                                          <div class="error text-danger">{{ $errors->first('departure') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-1">
                                          <label for="short_from" class="control-label">S name :</label>
                                          <input type="text" class="form-control" name="short_from[]" value="{{ $short_from[$key] }}" id="short_from" placeholder="DEL" required>
                                          @if($errors->has('short_from'))
                                          <div class="error text-danger">{{ $errors->first('short_from') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="departure_time" class="control-label">Departure Time :</label>
                                          <input type="text" class="form-control" name="departure_time[]" value="{{ $departure_time[$key] }}" id="departure_time" placeholder="17:15" required>
                                          @if($errors->has('departure_time'))
                                          <div class="error text-danger">{{ $errors->first('departure_time') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="d_date" class="control-label">Departure Date :</label>
                                          <input type="date" class="form-control" name="d_date[]" id="d_date" value="{{ $d_date[$key] }}" placeholder="Enter Departure Date" required>
                                          @if($errors->has('d_date'))
                                          <div class="error text-danger">{{ $errors->first('d_date') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-4">
                                          <label for="airport_name" class="control-label">Airport Name :</label>
                                          <input type="text" class="form-control" name="airport_name[]" value="{{ $airport_name[$key] }}" id="airport_name" placeholder="Entaer Airport name" required>
                                          @if($errors->has('airport_name'))
                                          <div class="error text-danger">{{ $errors->first('airport_name') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-1">
                                          <label for="terminal" class="control-label">Terminal :</label>
                                          <input type="text" class="form-control" name="terminal[]" value="{{ $terminal[$key] }}" id="terminal" placeholder="terminal">
                                          @if($errors->has('terminal'))
                                          <div class="error text-danger">{{ $errors->first('terminal') }}</div>
                                          @endif
                                       </div>
                                    </div>

                                    <center>
                                       <u>
                                          <h3><b>Arrival:</b></h3>
                                       </u>
                                    </center>

                                    <div class="form-group row">
                                       <div class="col-sm-2">
                                          <label for="arrival" class="control-label">Arrival To :</label>
                                          <input type="text" class="form-control" name="arrival[]" value="{{ $arrival[$key] }}" id="arrival" placeholder="Enter arrival place" required>
                                          @if($errors->has('arrival'))
                                          <div class="error text-danger">{{ $errors->first('arrival') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-1">
                                          <label for="short_to" class="control-label">S name :</label>
                                          <input type="text" class="form-control" name="short_to[]" value="{{ $short_to[$key] }}" id="short_to" placeholder="MAA" required>
                                          @if($errors->has('short_to'))
                                          <div class="error text-danger">{{ $errors->first('short_to') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="arrival_time" class="control-label">Arrival Time :</label>
                                          <input type="text" class="form-control" name="arrival_time[]" value="{{ $arrival_time[$key] }}" id="arrival_time" placeholder="17:15" required>
                                          @if($errors->has('arrival_time'))
                                          <div class="error text-danger">{{ $errors->first('arrival_time') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="a_date" class="control-label">Arrival Date :</label>
                                          <input type="date" class="form-control" name="a_date[]" id="a_date" value="{{ $a_date[$key] }}" placeholder="Enter Departure Date" required>
                                          @if($errors->has('a_date'))
                                          <div class="error text-danger">{{ $errors->first('a_date') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-4">
                                          <label for="airport_name_to" class="control-label">Airport Name :</label>
                                          <input type="text" class="form-control" name="airport_name_to[]" value="{{ $airport_name_to[$key] }}" id="airport_name_to" placeholder="Entaer Airport name" required>
                                          @if($errors->has('airport_name_to'))
                                          <div class="error text-danger">{{ $errors->first('airport_name_to') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-1">
                                          <label for="to_terminal" class="control-label">Terminal :</label>
                                          <input type="text" class="form-control" name="to_terminal[]" value="{{ $to_terminal[$key] }}" id="to_terminal" placeholder="to_terminal">
                                          @if($errors->has('to_terminal'))
                                          <div class="error text-danger">{{ $errors->first('to_terminal') }}</div>
                                          @endif
                                       </div>
                                    </div>

                                    <center>
                                       <u>
                                          <h3><b>Weight:</b></h3>
                                       </u>
                                    </center>

                                    <div class="form-group row">
                                       <div class="col-sm-2">
                                          <label for="check_in_weight" class="control-label">Check-in weight:</label>
                                          <input type="text" class="form-control" name="check_in_weight[]" value="{{ $check_in_weight[$key] }}" id="check_in_weight" placeholder="Enter check in weight" required>
                                          @if($errors->has('check_in_weight'))
                                          <div class="error text-danger">{{ $errors->first('check_in_weight') }}</div>
                                          @endif
                                       </div>
                                       <div class="col-sm-2">
                                          <label for="cabin_weight" class="control-label">Cabin weight:</label>
                                          <input type="text" class="form-control" name="cabin_weight[]" value="{{ $cabin_weight[$key] }}" id="cabin_weight" placeholder="Enter cabin weight" required>
                                          @if($errors->has('cabin_weight'))
                                          <div class="error text-danger">{{ $errors->first('cabin_weight') }}</div>
                                          @endif
                                       </div>
                                    </div>

                                 </diV>

                                 <?php if ($numfligts > 1) { ?>
                                    <button type="button" class="btn btn-danger" onclick="removeFlight(this)">Remove</button>
                                 <?php } ?>

                                 <hr style="border:1px solid #000;" />
                              </diV>

                           <?php } ?>
                        </diV>

                        <button type="button" class="btn btn-primary" onclick="addMoreFlight()">Add Flight</button>

                        <div class="form-group">
                           <div class="col-md-6 col-sm-4 control-label">
                              {!! Form::submit('Submit', ['class'=>'btn btn-success text-white mt-1', 'id' => 'submitBtn']) !!}
                              <div id="loader" class="mt-1" style="display: none;">
                                 <i class="fas fa-spinner fa-spin"></i>
                              </div>
                           </div>
                        </div>
                     </div>
                     {!! Form::close() !!}

                  </div>
                  <!-- /.box -->
               </div>
               <!-- /.box-body -->
            </div>
            <!-- /.box -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   function addPessenger() {
      const table = document.getElementById('inputPessengerTable').getElementsByTagName('tbody')[0];
      const newRow = table.insertRow();

      const passengerCell = newRow.insertCell();
      const passengerInput = document.createElement('input');
      passengerInput.type = 'text';
      passengerInput.classList.add('form-control');
      passengerInput.name = 'passenger_name[]';
      passengerInput.placeholder = 'Enter passenger name';
      passengerInput.required = true;
      passengerCell.appendChild(passengerInput);

      const seatCell = newRow.insertCell();
      const seatInput = document.createElement('input');
      seatInput.type = 'text';
      seatInput.classList.add('form-control');
      seatInput.name = 'seat[]';
      seatInput.placeholder = 'Enter Seat Number';
      seatCell.appendChild(seatInput);

      const mealCell = newRow.insertCell();
      const mealInput = document.createElement('input');
      mealInput.type = 'text';
      mealInput.classList.add('form-control');
      mealInput.name = 'meal[]';
      mealInput.placeholder = 'Enter meal';
      mealCell.appendChild(mealInput);

      const pnrCell = newRow.insertCell();
      const pnrInput = document.createElement('input');
      pnrInput.type = 'text';
      pnrInput.classList.add('form-control');
      pnrInput.name = 'passenger_pnr[]';
      pnrInput.placeholder = 'Enter passenger PNR';
      pnrInput.required = true;
      pnrCell.appendChild(pnrInput);

      const actionCell = newRow.insertCell();
      const removeButton = document.createElement('button');
      removeButton.type = 'button';
      removeButton.classList.add('btn', 'btn-danger');
      removeButton.innerText = 'Remove';
      removeButton.onclick = function() {
         removePessenger(this);
      };
      actionCell.appendChild(removeButton);
   }

   function removePessenger(button) {
      const row = button.closest('tr');
      row.remove();

      const rows = document.querySelectorAll('#inputPessengerTable tbody tr');
      if (rows.length === 1) {
         rows[0].querySelector('button.btn-danger').style.display = 'none';
      }
   }
</script>
<script>
   function addMoreFlight() {
      const container = document.getElementById('addMoreFlightContainer');
      const flightContainer = document.querySelector('.flight-container');
      const newFlightContainer = flightContainer.cloneNode(true);

      // Reset the input fields in the cloned element
      const inputs = newFlightContainer.querySelectorAll('input');
      inputs.forEach(input => {
         if (input.type === 'file') {
            input.value = ''; // Clear file input
         } else {
            input.value = ''; // Clear text, date, etc. inputs
         }
      });

      // Remove the previous remove button from the clone, if it exists
      const removeButton = newFlightContainer.querySelector('.btn-danger');
      if (removeButton) {
         removeButton.remove();
      }

      // Add the remove button to the cloned element
      const newRemoveButton = document.createElement('button');
      newRemoveButton.type = 'button';
      newRemoveButton.className = 'btn btn-danger';
      newRemoveButton.textContent = 'Remove';
      newRemoveButton.onclick = function() {
         removeFlight(this);
      };
      newFlightContainer.appendChild(newRemoveButton);

      // Append the new flight container to the main container
      container.appendChild(newFlightContainer);

      // Append a horizontal line to separate flight entries
      const horizontalLine = document.createElement('hr');
      horizontalLine.style = 'border:1px solid #000';
      container.appendChild(horizontalLine);
   }

   function removeFlight(button) {
      const flightContainer = button.closest('.flight-container');
      if (flightContainer) {
         flightContainer.remove();
      }

      const rows = document.querySelectorAll('.flight-container');
      if (rows.length === 1) {
         rows[0].querySelector('button.btn-danger').style.display = 'none';
      }
   }
</script>
@endsection