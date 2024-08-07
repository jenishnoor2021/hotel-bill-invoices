<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;

class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::orderBy('id', 'DESC')->get();
        return view('admin.setting.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hotels = Hotel::get();
        return view('admin.setting.create', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required',
            'email' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'gst_no' => 'required',
            'invoice_code' => 'required',
            'invoice_series' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $input['invoice_code'] = strtoupper($request->invoice_code);
        Setting::create($input);

        return redirect('admin/setting')->with('success', "Add Record Successfully");
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
        $hotels = Hotel::get();
        $setting = Setting::findOrFail($id);
        return view('admin.setting.edit', compact('setting', 'hotels'));
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
            'email' => 'required',
            'contact' => 'required',
            'address' => 'required',
            'gst_no' => 'required',
            'invoice_code' => 'required',
            'invoice_series' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput($request->all())->withErrors($validator);
        }
        $setting = Setting::findOrFail($id);
        $input = $request->all();
        $input['invoice_code'] = strtoupper($request->invoice_code);
        $setting->update($input);
        return redirect('admin/setting')->with('success', "Update Record Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();
        return Redirect::back()->with('success', "Delete Record Successfully");
    }

    public function hotelActive($id)
    {
        $setting = Setting::where('id', $id)->first();
        if ($setting->is_active == 1) {
            $setting->is_active = 0;
        } else {
            $setting->is_active = 1;
        }
        $setting->save();
        return redirect()->back()->with('success', "update Record Successfully");
    }
}
