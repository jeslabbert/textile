<?php

namespace App\Http\Controllers;

use App\GlobalCommission;
use App\Setting;
use App\SubscriptionTotal;
use App\TeamCommission;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    public function updateCommission(Request $request)
    {
        $settings = Setting::where('setting_type', 'Commission')->get();

        foreach($settings as $setting) {
            if($setting->setting_name === 'Consultant') {
                $setting->setting_value = $request->consultant_value;
                $setting->update();
            } elseif($setting->setting_name === 'Marketing') {
                $setting->setting_value = $request->marketing_value;
                $setting->update();
            } elseif($setting->setting_name === 'IT Support') {
                $setting->setting_value = $request->technical_value;
                $setting->update();
            } elseif($setting->setting_name === 'PayPal') {
                $setting->setting_string = $request->paypal_value;
                $setting->update();
            }
        }
        return redirect('/spark/kiosk#/commission');
    }

    public function updateTeamCommission(Request $request)
    {
        $globalCommCount = GlobalCommission::where('team_id', $request->team_id)->count();
        if($globalCommCount > 0){
            $globalComm = GlobalCommission::where('team_id', $request->team_id)->first();
            $globalComm->comm1 = $request->comm1_value;
            $globalComm->comm2 = $request->comm2_value;
            $globalComm->comm3 = $request->comm3_value;
            $globalComm->update();
        } else {
            $globalComm = GlobalCommission::create([
                'team_id' => $request->team_id,
                'comm1' => $request->comm1_value,
                'comm2' => $request->comm2_value,
                'comm3' => $request->comm3_value
            ]);

        }

        return redirect('/spark/kiosk#/commission');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
