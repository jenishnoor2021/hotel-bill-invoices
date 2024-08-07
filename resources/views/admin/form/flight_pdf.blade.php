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
  <div class="ticket">
    <table class="header">
      <tr>
        <td width="50%">
          <img src="https://sunrisegroupofschools.org/tickets-travel-logo.jpg" alt="Logo" style="width: 200px;">
        </td>
        <td style="text-align:right" width="50%">
          <div class="booking-info">
            <h1>Flight Ticket</h1>
            <p><strong>Booking ID:</strong> {{ $booking_id }}</p>
            <p>(Booked on {{ $b_date }})</p>
            <p>Tripzetta</p>
            <p>{{ $email }},</p>
            <p>{{ $address }}</p>
          </div>
        </td>
      </tr>
    </table>

    <div class="barcode-section" style="padding:5px">
      <table width="100%" style="align-items: center;">
        <tr>
          <td width="50%">
            <p style="margin: 0;"><?= $passenger_name[0]; ?></p>
          </td>
          <td width="50%" style="text-align: right;">
            <img src="https://sunrisegroupofschools.org/barcode-numbers-png.png" alt="Barcode" style="width: 150px;">
          </td>
        </tr>
      </table>
    </div>

    <div class="booking-details">
      <table>
        <thead class="std1">
          <tr>
            <th><b>BOOKING DETAILS</b></th>
          </tr>
        </thead>
      </table>
      <!-- <h2>Booking Details</h2> -->
      <?php foreach ($journey as $key => $jou) { ?>
        <h3><?= $jou ?></h3>
        <p><?= $journy_date[$key] ?> • Non stop • <?= $duration[$key] ?> duration</p>
        <table class="flight-info" width="100%" cellpadding="10" cellspacing="0">
          <tr>
            <td width="30%" class="" style="border: 1px solid #ddd;">
              <div style="display: inline-block; vertical-align: middle;">
                <!-- <img src="https://sunrisegroupofschools.org/tickets-travel-logo-old.jpg" alt="IndiGo" style="width: 60px;"> -->
                @if(!empty($flogo) && isset($flogo[$key]))
                <img src="https://test.noorinfotech.in/flightbarcode/{{$flogo[$key]}}" alt="IndiGo" style="width: 60px;">
                @else
                <img src="https://sunrisegroupofschools.org/tickets-travel-logo-old.jpg" alt="IndiGo" style="width: 60px;">
                @endif
              </div>
              <div style="display: inline-block; vertical-align: middle; margin-left: 10px;">
                <p style="margin: 0;"><?= $air_lines[$key] ?> <br /><?= $flight_number[$key] ?></p>
              </div>
            </td>
            <td width="30%" class="" style="border: 1px solid #ddd;">
              <p><strong><?= $departure[$key] ?></strong></p>
              <p><?= $short_from[$key] ?> <strong><?= $departure_time[$key] ?> hrs</strong></p>
              <p><?= $d_date[$key] ?></p>
            </td>
            <td width="10%" class="" style="border: 1px solid #ddd;">
              <div class="duration">
                <h6>-<?= $duration[$key] ?>-</h6>
              </div>
            </td>
            <td width="30%" class="" style="border: 1px solid #ddd;text-align:right">
              <p><strong><?= $arrival[$key] ?></strong></p>
              <p><strong><?= $arrival_time[$key] ?> hrs</strong> <?= $short_to[$key] ?> </p>
              <p><?= $a_date[$key] ?></p>
            </td>
          </tr>
          <tr>
            <td class="" colspan="1" style="border: 1px solid #ddd; text-align: center;">
              <div class="pnr">
                <p>PNR</p>
                <p><?= $pnr_no ?></p>
              </div>
            </td>
            <td class="" colspan="1" style="border: 1px solid #ddd;">
              <p><?= $airport_name[$key] ?> <br />Terminal <?= $terminal[$key] ?></p>
            </td>
            <td>

            </td>
            <td class="" colspan="1" style="border: 1px solid #ddd;text-align:right">
              <p><?= $airport_name_to[$key] ?> <br />Terminal <?= $to_terminal[$key] ?></p>
            </td>
          </tr>
          <tr>
            <td width="50%" class="" colspan="2" style="border: 1px solid #ddd;">
              <p><?= $check_in_weight[$key] ?> Kgs (1 piece only)* check-in</p>
            </td>
            <td width="50%" class="" colspan="2" style="border: 1px solid #ddd;">
              <p><?= $cabin_weight[$key] ?> Kgs (1 piece only)* cabin</p>
            </td>
          </tr>
          <tr>
            <td class="" colspan="1">
              <p style="color:#000"><b>TRAVELLER</b></p>
            </td>
            <td class="" colspan="1" style="text-align: center">
              <p style="color:#000"><b>SEAT</b></p>
            </td>
            <td class="" colspan="1" style="text-align: center">
              <p style="color:#000"><b>MEAL</b></p>
            </td>
            <td class="" colspan="1" style="text-align: center">
              <p style="color:#000"><b>E-TICKET NO</b></p>
            </td>
          </tr>
          <?php foreach ($passenger_name as $ind => $passe) { ?>
            <tr>
              <td class="" colspan="1">
                <p><?= $passe ?> </p>
              </td>
              <td class="" colspan="1" style="text-align: center">
                <p><?= $seat[$ind] ?></p>
              </td>
              <td class="" colspan="1" style="text-align: center">
                <p><?= $meal[$ind] ?></p>
              </td>
              <td class="" colspan="1" style="text-align: center">
                <p><?= $passenger_pnr[$ind] ?></p>
              </td>
            </tr>
          <?php } ?>
        </table>
      <?php } ?>
    </div>

    <div class="prohibited-items">
      <!-- <h2>Items not allowed in the aircraft</h2> -->
      <div class="items">
        <div class="item">
          <img src="https://sunrisegroupofschools.org/not-allow-items.png" alt="Icon">
        </div>
        <!-- Add more items as needed -->
      </div>
    </div>

    <div class="important-info">
      <h2>Important Information</h2>
      <ul>
        <li>Check-in Time: Passenger to report 2 hours before departure. Check-in procedure and baggage drop will close 1 hour before departure.</li>
        <li>DGCA passenger charter: Please refer to passenger charter by clicking <a href="" target="_blank">Here</a></li>
        <li>Check travel guidelines and baggage information below: Carry no more than 1 check-in baggage and 1 hand baggage per passenger. If violated, airline may levy extra charges. Wearing a mask/face cover is no longer mandatory. However, all travellers are advised to do so as a precautionary measure.</li>
        <li>Valid ID proof needed: Carry a valid photo identification proof (Driver Licence, Aadhar Card, Pan Card or any other Government recognised photo identification)</li>
      </ul>
    </div>
  </div>
</body>

</html>