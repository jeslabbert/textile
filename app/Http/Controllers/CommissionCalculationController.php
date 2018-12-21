<?php

namespace App\Http\Controllers;

use App\CommissionCalculation;
use App\GlobalCommission;
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
