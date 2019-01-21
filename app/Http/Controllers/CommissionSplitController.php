<?php

namespace App\Http\Controllers;

use App\CommissionSplit;
use App\GlobalCommission;
use App\Team;
use App\TeamCommission;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Invoice;
use Laravel\Spark\Spark;

class CommissionSplitController extends Controller
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
     * @param  \App\CommissionSplit  $commissionSplit
     * @return \Illuminate\Http\Response
     */
    public function show(CommissionSplit $commissionSplit)
    {
        //
    }

    public static function commshow($id)
    {
//        $test = Auth::user()->currentTeam;
//        dd($test);
        //$amount = 200;
        $team = Team::where('id', $id)->first();

        $teamplan = $team->sparkPlan();

        $amount = $teamplan->price;
        $globalcomm = GlobalCommission::where('team_id', $id)->first()->global_commission;
        $commtest = 100 - $globalcomm;
        $commvalue = $amount * ((100 - $commtest) / 100);
        $conscomm = GlobalCommission::where('team_id', $id)->first()->comm1;
        $constest = 100 - $conscomm;
        $consvalue = $commvalue * ((100 -$constest) / 100);

        $commsplit = TeamCommission::where('team_id', $id)->first();

        $firstuser = User::where('id', $commsplit->first_user_id)->first();
        $seconduser = User::where('id', $commsplit->second_user_id)->first();

        $firstTest = 100 - $commsplit->first_split;
        $secondTest = 100 - $commsplit->second_split;

        $firstvalue = $consvalue * ((100 -$firstTest) / 100);
        $secondvalue = $consvalue * ((100 -$secondTest) / 100);
        //dd($commsplit, $commvalue, $consvalue, $firstvalue, $secondvalue, $teamplan);
        $html = view('commsplit')
            ->with('id',$id)
            ->with('commsplit',$commsplit)
            ->with('team',$team)
            ->with('commvalue',$commvalue)
            ->with('consvalue', $consvalue)
            ->with('firstvalue',$firstvalue)
            ->with('secondvalue',$secondvalue)
            ->with('teamplan',$teamplan)
            ->with('firstuser',$firstuser)
            ->with('seconduser',$seconduser)
            ->render();

        return $html;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CommissionSplit  $commissionSplit
     * @return \Illuminate\Http\Response
     */
    public function edit(CommissionSplit $commissionSplit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CommissionSplit  $commissionSplit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CommissionSplit $commissionSplit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CommissionSplit  $commissionSplit
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommissionSplit $commissionSplit)
    {
        //
    }
}
