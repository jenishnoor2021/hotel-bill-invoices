<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Flight;
use App\Models\Sample;
use App\Models\Morehotel;
use App\Models\Singlehotel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AdminSamplesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $string = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 20);
        return view('admin.form.index', compact('string'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($file = $request->file('barcode')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('flightbarcode', $name);
        }

        if ($request->hasFile('flogo')) {
            $logos = $request->file('flogo');
            $flogos = []; // Array to store file names

            foreach ($logos as $logo) {
                if ($logo->isValid()) {
                    $str = $logo->getClientOriginalName();
                    $str = str_replace(' ', '_', $str);

                    $fileName = time() . '_' . $str;

                    $logo->move('flightbarcode', $fileName);

                    $flogos[] = $fileName;
                }
            }
        }

        $data = [
            'booking_id' => $request->booking_id ?? '',
            'b_date' => $request->b_date ?? '',
            'address' => $request->address ?? '',
            'email' => $request->email ?? '',
            'mobile' => $request->mobile ?? '',
            'barcode' => $name ?? '',
            'pnr_no' => $request->pnr_no ?? '',
            'passenger_name' => $request->passenger_name ?? [],
            'seat' => $request->seat ?? [],
            'meal' => $request->meal ?? [],
            'passenger_pnr' => $request->passenger_pnr ?? [],
            'flogo' => $flogos ?? [],
            'journey' => $request->journey ?? [],
            'air_lines' => $request->air_lines ?? [],
            'journy_date' => $request->journy_date ?? [],
            'duration' => $request->duration ?? [],
            'flight_number' => $request->flight_number ?? [],
            'departure' => $request->departure ?? [],
            'short_from' => $request->short_from ?? [],
            'departure_time' => $request->departure_time ?? [],
            'd_date' => $request->d_date ?? [],
            'airport_name' => $request->airport_name ?? [],
            'terminal' => $request->terminal ?? [],
            'arrival' => $request->arrival ?? [],
            'short_to' => $request->short_to ?? [],
            'arrival_time' => $request->arrival_time ?? [],
            'a_date' => $request->a_date ?? [],
            'airport_name_to' => $request->airport_name_to ?? [],
            'to_terminal' => $request->to_terminal ?? [],
            'check_in_weight' => $request->check_in_weight ?? [],
            'cabin_weight' => $request->cabin_weight ?? [],
            'generation' => $request->generation ?? '',
        ];

        // dd($data);

        $pdf = PDF::loadView('admin.form.flight_pdf', $data);

        $fileName = time() . '-' . str_replace(' ', '-', $request->passenger_name[0]) . '.pdf';
        $pdf->save(public_path('flightPDF/') . $fileName);
        $fileNames[] = $fileName;

        // dd($fileName);

        $flightpdfcreate = new Flight([
            'booking_id' => $request->booking_id ?? '',
            'b_date' => $request->b_date ?? '',
            'address' => $request->address ?? '',
            'email' => $request->email ?? '',
            'mobile' => $request->mobile ?? '',
            'barcode' => $name ?? '',
            'pnr_no' => $request->pnr_no ?? '',
            'passenger_name' => json_encode($request->passenger_name ?? []),
            'seat' => json_encode($request->seat ?? []),
            'meal' => json_encode($request->meal ?? []),
            'passenger_pnr' => json_encode($request->passenger_pnr ?? []),
            'flogo' => json_encode($flogos ?? []),
            'journey' => json_encode($request->journey ?? []),
            'air_lines' => json_encode($request->air_lines ?? []),
            'journy_date' => json_encode($request->journy_date ?? []),
            'duration' => json_encode($request->duration ?? []),
            'flight_number' => json_encode($request->flight_number ?? []),
            'departure' => json_encode($request->departure ?? []),
            'short_from' => json_encode($request->short_from ?? []),
            'departure_time' => json_encode($request->departure_time ?? []),
            'd_date' => json_encode($request->d_date ?? []),
            'airport_name' => json_encode($request->airport_name ?? []),
            'terminal' => json_encode($request->terminal ?? []),
            'arrival' => json_encode($request->arrival ?? []),
            'short_to' => json_encode($request->short_to ?? []),
            'arrival_time' => json_encode($request->arrival_time ?? []),
            'a_date' => json_encode($request->a_date ?? []),
            'airport_name_to' => json_encode($request->airport_name_to ?? []),
            'to_terminal' => json_encode($request->to_terminal ?? []),
            'check_in_weight' => json_encode($request->check_in_weight ?? []),
            'cabin_weight' => json_encode($request->cabin_weight ?? []),
            'generation' => $request->generation ?? '',
            'file' => $fileName,
        ]);
        $flightpdfcreate->save();

        // return $pdf->download($fileName);

        return redirect()->route('admin.flight.edit', ['id' => $flightpdfcreate->id])
            ->with('success', 'PDF generated and flight data saved successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flight = Flight::findOrFail($id);
        return view('admin.form.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        // dd($request->all());

        $flight = Flight::findOrFail($id);

        if ($file = $request->file('barcode')) {

            $str = $file->getClientOriginalName();
            $str = str_replace(' ', '_', $str);

            $name = time() . $str;

            $file->move('flightbarcode', $name);

            if ($flight->barcode != '/flightbarcode/') {
                if (file_exists(public_path() . $flight->barcode)) {
                    unlink(public_path() . $flight->barcode);
                }
            }

            $flight->update([
                'barcode' => $name ?? '',
            ]);
        }

        $flogos = [];
        if ($request->hasFile('flogo')) {
            $logos = $request->file('flogo');

            foreach ($logos as $key => $logo) {
                if ($logo->isValid()) {
                    $str = $logo->getClientOriginalName();
                    $str = str_replace(' ', '_', $str);

                    $fileName = time() . '_' . $str;

                    $logo->move('flightbarcode', $fileName);

                    $flogos[$key] = $fileName;
                }
            }
        }

        $existingLogos = json_decode(str_replace('/flightbarcode/', '', $flight->flogo), true) ?? [];

        $mergedLogos = array_replace($existingLogos, $flogos);

        // Retain existing logos or use new ones if uploaded
        foreach ($flogos as $key => $newLogo) {
            if (isset($existingLogos[$key]) && $existingLogos[$key] !== $newLogo) {
                if (file_exists(public_path('flightbarcode/' . $existingLogos[$key]))) {
                    unlink(public_path('flightbarcode/' . $existingLogos[$key]));
                }
            }
        }

        $flight->update([
            'flogo' => json_encode(array_values($mergedLogos)),
        ]);

        $data = [
            'booking_id' => $request->booking_id ?? '',
            'b_date' => $request->b_date ?? '',
            'address' => $request->address ?? '',
            'email' => $request->email ?? '',
            'mobile' => $request->mobile ?? '',
            'barcode' => $name ?? '',
            'pnr_no' => $request->pnr_no ?? '',
            'passenger_name' => $request->passenger_name ?? [],
            'seat' => $request->seat ?? [],
            'meal' => $request->meal ?? [],
            'passenger_pnr' => $request->passenger_pnr ?? [],
            'flogo' => $mergedLogos ?? [],
            'journey' => $request->journey ?? [],
            'air_lines' => $request->air_lines ?? [],
            'journy_date' => $request->journy_date ?? [],
            'duration' => $request->duration ?? [],
            'flight_number' => $request->flight_number ?? [],
            'departure' => $request->departure ?? [],
            'short_from' => $request->short_from ?? [],
            'departure_time' => $request->departure_time ?? [],
            'd_date' => $request->d_date ?? [],
            'airport_name' => $request->airport_name ?? [],
            'terminal' => $request->terminal ?? [],
            'arrival' => $request->arrival ?? [],
            'short_to' => $request->short_to ?? [],
            'arrival_time' => $request->arrival_time ?? [],
            'a_date' => $request->a_date ?? [],
            'airport_name_to' => $request->airport_name_to ?? [],
            'to_terminal' => $request->to_terminal ?? [],
            'check_in_weight' => $request->check_in_weight ?? [],
            'cabin_weight' => $request->cabin_weight ?? [],
            'generation' => $request->generation ?? '',
        ];

        // dd($data);

        // dd($flight->file);

        if ($flight->file != '/flightPDF/') {
            if (file_exists(public_path() . $flight->file)) {
                unlink(public_path() . $flight->file);
            }
        }

        $pdf = PDF::loadView('admin.form.flight_pdf', $data);

        $fileName = time() . '-' . str_replace(' ', '-', $request->passenger_name[0]) . '.pdf';
        $pdf->save(public_path('flightPDF/') . $fileName);

        // dd($fileName);

        $flight->update([
            'booking_id' => $request->booking_id ?? '',
            'b_date' => $request->b_date ?? '',
            'address' => $request->address ?? '',
            'email' => $request->email ?? '',
            'mobile' => $request->mobile ?? '',
            'pnr_no' => $request->pnr_no ?? '',
            'passenger_name' => json_encode($request->passenger_name ?? []),
            'seat' => json_encode($request->seat ?? []),
            'meal' => json_encode($request->meal ?? []),
            'passenger_pnr' => json_encode($request->passenger_pnr ?? []),
            'journey' => json_encode($request->journey ?? []),
            'air_lines' => json_encode($request->air_lines ?? []),
            'journy_date' => json_encode($request->journy_date ?? []),
            'duration' => json_encode($request->duration ?? []),
            'flight_number' => json_encode($request->flight_number ?? []),
            'departure' => json_encode($request->departure ?? []),
            'short_from' => json_encode($request->short_from ?? []),
            'departure_time' => json_encode($request->departure_time ?? []),
            'd_date' => json_encode($request->d_date ?? []),
            'airport_name' => json_encode($request->airport_name ?? []),
            'terminal' => json_encode($request->terminal ?? []),
            'arrival' => json_encode($request->arrival ?? []),
            'short_to' => json_encode($request->short_to ?? []),
            'arrival_time' => json_encode($request->arrival_time ?? []),
            'a_date' => json_encode($request->a_date ?? []),
            'airport_name_to' => json_encode($request->airport_name_to ?? []),
            'to_terminal' => json_encode($request->to_terminal ?? []),
            'check_in_weight' => json_encode($request->check_in_weight ?? []),
            'cabin_weight' => json_encode($request->cabin_weight ?? []),
            'generation' => $request->generation ?? '',
            'file' => $fileName,
        ]);

        // return $pdf->download($fileName);

        return redirect()->route('admin.flight.edit', ['id' => $flight->id])
            ->with('success', 'PDF generated and flight data saved successfully!');
    }

    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        if ($flight->file != '/flightPDF/') {
            if (file_exists(public_path() . $flight->file)) {
                unlink(public_path() . $flight->file);
            }
        }
        if ($flight->barcode != '/flightbarcode/') {
            if (file_exists(public_path() . $flight->barcode)) {
                unlink(public_path() . $flight->barcode);
            }
        }
        $flight->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
}
