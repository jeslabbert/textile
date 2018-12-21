<?php

namespace App\Http\Controllers;

use App\CommissionCalculation;
use App\GlobalCommission;
use App\Setting;
use App\Team;
use App\TeamCommission;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Invoice;

class CommissionCalculationController extends Controller
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

    }

    public function setGlobalComms() {
        $comm1 = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first()->setting_value;
        $comm2 = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first()->setting_value;
        $comm3 = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first()->setting_value;
        $globcomm = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first()->setting_value;
        $teams = Team::all();
        $settings = Setting::where('setting_type', 'Commission')->get();
//        foreach($settings as $setting) {
//            if($setting->name == ) {
//                $comm1 = $setting->setting_value;
//            } elseif($setting->name == 'Marketing') {
//                $comm2 = $setting->setting_value;
//            } elseif($setting->name == 'IT Support') {
//                $comm3 = $setting->setting_value;
//            } elseif($setting->name, 'Global Commission') {
//                dd($setting->setting_value);
//                $globcomm = $setting->setting_value;
//            }
//        }
        foreach($teams as $team) {
            if(TeamCommission::where('team_id', $team->id)->count() > 0) {

            } else {
                TeamCommission::create([
                    'team_id'=>$team->id,
                    'first_name'=>'Support',
                    'first_user_id'=>$team->owner_id,
                    'first_split'=>50,
                    'second_name'=>'Sales',
                    'second_split'=>50,
                    'second_user_id'=>$team->owner_id,
                ]);
            }
            if(GlobalCommission::where('team_id', $team->id)->count() > 0) {

            } else {
                GlobalCommission::create([
                    'team_id'=>$team->id,
                    'comm1'=>$comm1,
                    'comm2'=>$comm2,
                    'comm3'=>$comm3,
                    'global_commission'=>$globcomm
                ]);
            }

        }
    }
    public function calculate()
    {
        $teams = Team::where('braintree_id', '!=', null)->get();
        foreach($teams as $team) {

$invoices = $team->invoices();
$globalcheck = GlobalCommission::where('team_id', $team->id)->count();
if($globalcheck > 0) {

    $globalcomm = GlobalCommission::where('team_id', $team->id)->first();
    $conscomm = GlobalCommission::where('team_id', $team->id)->first()->comm1;
    $commsplit = TeamCommission::where('team_id', $team->id)->first();
    $firstuser = User::where('id', $commsplit->first_user_id)->first();
    $seconduser = User::where('id', $commsplit->second_user_id)->first();
foreach($invoices as $invoice) {
    $commcheck = CommissionCalculation::where('invoice_id', $invoice->id)->count();
    if($commcheck > 0) {

    } else {
        $amount = $invoice->amount;

        $commtest = 100 - $globalcomm->global_commission;
        $commvalue = $amount * ((100 - $commtest) / 100);

        $comm2test = 100 - $globalcomm->comm2;
        $comm3test = 100 - $globalcomm->comm3;

        $comm2value = $commvalue * ((100 - $comm2test) / 100);
        $comm3value = $commvalue * ((100 - $comm3test) / 100);

        $constest = 100 - $conscomm;
        $consvalue = $commvalue * ((100 - $constest) / 100);
        if ($invoice->status === 'settled') {
            $status = 1;
        } else {
            $status = 0;
        }


        $firstTest = 100 - $commsplit->first_split;
        $secondTest = 100 - $commsplit->second_split;

        $firstvalue = $consvalue * ((100 - $firstTest) / 100);
        $secondvalue = $consvalue * ((100 - $secondTest) / 100);
        if (isset($invoice->subscription['billingPeriodStartDate'])) {

            $bpdate = $invoice->subscription['billingPeriodStartDate']->format('Y0m');

            $commcalc1 = CommissionCalculation::create([
                'invoice_id' => $invoice->id,
                'invoice_value' => $invoice->amount,
                'billing_period' => $bpdate,
                'team_id' => $team->id,
                'global_percentage' => $globalcomm->global_commission,
                'comm_percentage' => $globalcomm->comm1,
                'comm_split' => $commsplit->first_split,
                'comm_type' => 1,
                'comm_value' => $firstvalue,
                'user_id' => $firstuser->id,
                'status' => $status,
            ]);
            $commcalc2 = CommissionCalculation::create([
                'invoice_id' => $invoice->id,
                'invoice_value' => $invoice->amount,
                'billing_period' => $bpdate,
                'team_id' => $team->id,
                'global_percentage' => $globalcomm->global_commission,
                'comm_percentage' => $globalcomm->comm1,
                'comm_split' => $commsplit->second_split,
                'comm_type' => 1,
                'comm_value' => $secondvalue,
                'user_id' => $seconduser->id,
                'status' => $status,
            ]);
            $comm2calc = CommissionCalculation::create([
                'invoice_id' => $invoice->id,
                'invoice_value' => $invoice->amount,
                'billing_period' => $bpdate,
                'team_id' => $team->id,
                'global_percentage' => $globalcomm->global_commission,
                'comm_percentage' => $globalcomm->comm2,
                'comm_type' => 2,
                'comm_value' => $comm2value,
                'status' => $status,
            ]);
            $comm3calc = CommissionCalculation::create([
                'invoice_id' => $invoice->id,
                'invoice_value' => $invoice->amount,
                'billing_period' => $bpdate,
                'team_id' => $team->id,
                'global_percentage' => $globalcomm->global_commission,
                'comm_percentage' => $globalcomm->comm3,
                'comm_type' => 3,
                'comm_value' => $comm3value,
                'status' => $status,
            ]);
        }
    }
    }
}

}
//dd($invoices);
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
     * @param  \App\CommissionCalculation  $commissionCalculation
     * @return \Illuminate\Http\Response
     */
    public function show(CommissionCalculation $commissionCalculation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommissionCalculation  $commissionCalculation
     * @return \Illuminate\Http\Response
     */
    public function edit(CommissionCalculation $commissionCalculation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommissionCalculation  $commissionCalculation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommissionCalculation $commissionCalculation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommissionCalculation  $commissionCalculation
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommissionCalculation $commissionCalculation)
    {
        //
    }
}
