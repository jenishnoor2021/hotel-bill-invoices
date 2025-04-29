<?php

namespace App\Http\Controllers;

use Validator;
use PDF;
use App\Models\Room;
use App\Models\Extra;
use App\Models\Hotel;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Invoicedata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AdminInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Session::get('user');
        $invoices = Invoice::orderBy('id', 'DESC')->get();
        if ($user->role != 'admin') {
            $hotel = Hotel::where('hotel_name', $user->role)->first();
            $invoices = Invoice::where('hotel_id', $hotel->id)->orderBy('id', 'DESC')->get();
        }

        return view('admin.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Session::get('user');
        $hotels = Hotel::get();
        if ($user->role != 'admin') {
            $hotels = Hotel::where('hotel_name', $user->role)->get();
        }
        $settings = Setting::get();
        $categorys = Category::get();
        $rooms = Room::get();
        $extra = Extra::get();
        return view('admin.invoice.create', compact('hotels', 'categorys', 'rooms', 'extra', 'settings'));
    }

    public function createPDF($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice->file != '') {
            if (file_exists(public_path() . '/invoices/' . $invoice->file)) {
                unlink(public_path() . '/invoices/' . $invoice->file);
            }
        }

        $invoicedetail = Invoicedata::where('invoice_id', $id)->get();
        $hotel = Hotel::where('id', $invoice->hotel_id)->first();
        $hoteldetail = Setting::where('hotel_id', $invoice->hotel_id)->first();

        $data = [
            'invoice' => $invoice,
            'invoicedetail' => $invoicedetail,
            'hoteldetail' => $hoteldetail,
            'hotel' => $hotel,
            'discount_sign' => ($invoice->discount_type == 'fix') ? ' Rs.' : ' %',
        ];

        $pdf = PDF::loadView('admin.invoice.invoice_pdf', $data);

        $fileName = time() . '-' . str_replace(' ', '-', $invoice->invoice_no) . '.pdf';
        $pdf->save(public_path('invoices/') . $fileName);

        $invoice->update(['file' => $fileName]);

        return response()->file(public_path('invoices/' . $fileName));

        // return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "Add Record Successfully");
    }

    public function addDiscount(Request $request)
    {
        $invoice = Invoice::where('id', $request->invoice_id)->first();

        $final = $invoice->invoice_total;

        if ($request->discount_type == "fix") {
            $final -= $request->discount_value;
        }
        if ($request->discount_type == "percentage" && $request->discount_value != 0) {
            $discount_amount = ($invoice->invoice_total * $request->discount_value) / 100;
            $final -= $discount_amount;
        }

        $invoice->update(['discount_value' => $request->discount_value, 'discount_type' => $request->discount_type, 'final_amount' => $final]);

        return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "Add discount successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'guest_name1' => 'required',
            'guest_email' => 'required',
            'guest_mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $invoice = Invoice::create($request->all());

        return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "Add Record Successfully");
    }

    public function storeInvoiceData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            // 'check_in' => 'required',
            // 'check_out' => 'required',
            'days' => 'required',
            'amount' => 'required',
            'gst_percentage' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        Invoicedata::create($request->all());

        $total = 0;

        $getdatas = Invoicedata::where('invoice_id', $request->invoice_id)->get();

        foreach ($getdatas as $getdata) {
            $total += $getdata->total_amount;
        }

        $invoice = Invoice::where('id', $request->invoice_id)->first();
        $final = $total;
        $type = $invoice->discount_type ?? 'fix';
        $value = $invoice->discount_value ?? 0;

        if ($type == "fix") {
            $final = $final - $value;
        }
        if ($type == "percentage" && $value != 0) {
            $discount_amount = ($total * $value) / 100;
            $final -= $discount_amount;
        }

        $invoice->update(['invoice_total' => $total, 'final_amount' => $final]);

        return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "Add Record Successfully");
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
        $invoice = Invoice::findOrFail($id);
        $invoicedatas = Invoicedata::where('invoice_id', $id)->get();
        $user = Session::get('user');
        $hotels = Hotel::get();
        if ($user->role != 'admin') {
            $hotels = Hotel::where('hotel_name', $user->role)->get();
        }
        $categorys = Category::get();
        $rooms = Room::where('hotel_id', $invoice->hotel_id)->get();
        $extras = Extra::get();
        return view('admin.invoice.edit', compact('invoice', 'hotels', 'categorys', 'rooms', 'extras', 'invoicedatas'));
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
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'invoice_no' => 'required',
            'invoice_date' => 'required',
            'guest_name1' => 'required',
            'guest_email' => 'required',
            'guest_mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }

        $invoice = Invoice::findOrFail($id);
        $input = $request->all();
        $invoice->update($input);

        return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "update Record Successfully");
    }

    public function editInvoiceData($id)
    {
        $invoicedata = Invoicedata::findOrFail($id);
        $invoice = Invoice::where('id', $invoicedata->invoice_id)->first();
        $user = Session::get('user');
        $hotels = Hotel::get();
        if ($user->role != 'admin') {
            $hotels = Hotel::where('hotel_name', $user->role)->get();
        }
        $categorys = Category::get();
        $rooms = Room::where('hotel_id', $invoice->hotel_id)->get();
        $extras = Extra::get();
        return view('admin.invoice.editData', compact('invoice', 'hotels', 'categorys', 'rooms', 'extras', 'invoicedata'));
    }

    public function updateInvoiceData(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            // 'check_in' => 'required',
            // 'check_out' => 'required',
            'days' => 'required',
            'amount' => 'required',
            'gst_percentage' => 'required',
            'total_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }


        $invoiceData = Invoicedata::findOrFail($id);
        $input = $request->all();

        $invoiceData->update($input);

        $total = 0;
        $getdatas = Invoicedata::where('invoice_id', $request->invoice_id)->get();

        foreach ($getdatas as $getdata) {
            $total += $getdata->total_amount;
        }

        $invoice = Invoice::where('id', $request->invoice_id)->first();

        $final = $total;
        $type = $invoice->discount_type ?? 'fix';
        $value = $invoice->discount_value ?? 0;

        if ($type == "fix") {
            $final -= $value;
        }
        if ($type == "percentage" && $value != 0) {
            $discount_amount = ($total * $value) / 100;
            $final -= $discount_amount;
        }

        $invoice->update(['invoice_total' => $total, 'final_amount' => $final]);

        return redirect('admin/invoice/edit/' . $request->invoice_id)->with('success', "update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        Invoicedata::where('invoice_id', $invoice->id)->delete();
        $invoice->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function getDetail(Request $request)
    {
        $hotel_id = $request->input('hotel_id');
        $setting = Setting::where('hotel_id', $hotel_id)->first();
        if (!isset($setting)) {
            return response()->json(['error' => 'No data found']);
        }
        $getInvoice = Invoice::where('hotel_id', $hotel_id)->orderBy('id', 'DESC')->first();
        if ($getInvoice) {
            $lastInvoiceNo = $getInvoice->invoice_no;
            $numericPart = (int) substr($lastInvoiceNo, strlen($setting->invoice_code));
            $newNumericPart = $numericPart + 1;
            $paddedNumber = str_pad($newNumericPart, 4, '0', STR_PAD_LEFT);
            $invoice_no = $setting->invoice_code . $paddedNumber;
        } else {
            $invoice_series = 1;
            $paddedNumber = str_pad($invoice_series, 4, '0', STR_PAD_LEFT);
            $invoice_no = $setting->invoice_code . $paddedNumber;
            // $invoice_no = $setting->invoice_code . $setting->invoice_series;
        }
        $rooms = Room::where('hotel_id', $hotel_id)->get();
        return response()->json(['invoice_no' => $invoice_no, 'rooms' => $rooms]);
    }

    public function getRoomDetail(Request $request)
    {
        $room_id = $request->input('room_id');
        $room = Room::find($room_id);
        $categories = Category::all();

        if ($room) {
            return response()->json([
                'category_id' => $room->category_id,
                'amount' => $room->amount,
                'gst_percentage' => $room->gst_percentage,
                'total_amount' => $room->total_amount,
                'categories' => $categories
            ]);
        } else {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }

    public function getExtraDetail(Request $request)
    {
        $extra_id = $request->input('extra_id');
        $extra = Extra::find($extra_id);

        if ($extra) {
            return response()->json($extra);
        } else {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }

    public function destroyInvoiceData($id)
    {
        $invoicedata = Invoicedata::findOrFail($id);
        $invoicedata->delete();

        $total = 0;
        $getdatas = Invoicedata::where('invoice_id', $invoicedata->invoice_id)->get();

        foreach ($getdatas as $getdata) {
            $total += $getdata->total_amount;
        }

        $invoice = Invoice::where('id', $invoicedata->invoice_id)->first();

        $final = $total;
        $type = $invoice->discount_type ?? 'fix';
        $value = $invoice->discount_value ?? 0;

        if ($type == "fix") {
            $final -= $value;
        }
        if ($type == "percentage" && $value != 0) {
            $discount_amount = ($total * $value) / 100;
            $final -= $discount_amount;
        }

        $invoice->update(['invoice_total' => $total, 'final_amount' => $final]);

        return redirect('admin/invoice/edit/' . $invoice->id)->with('success', "Add Record Successfully");
    }
}
