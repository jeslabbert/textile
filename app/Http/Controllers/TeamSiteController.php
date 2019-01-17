<?php

namespace App\Http\Controllers;

use App\MeteredInvoice;
use App\SiteTotal;
use App\TeamSite;
use App\TeamUser;
use Illuminate\Http\Request;
use Laravel\Cashier\Invoice;
use Laravel\Spark\Team;

class TeamSiteController extends Controller
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
     * @param  \App\TeamSite  $teamSite
     * @return \Illuminate\Http\Response
     */
    public function show(TeamSite $teamSite)
    {

    }
    public function sitebilling()
    {

        $teamsites = TeamSite::where('website_id', '>', 59)->get();
        foreach($teamsites as $teamSite){


        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = 'http://'.$teamSite->fqdn . '/api/sitebilling';
        $tenantresponse = $tenantclient->post($tenanturl);
        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();
        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        foreach($tenantdetails as $tenantdetail){

            $sitetotalcount = SiteTotal::where('bu_id', $tenantdetail->bu_id)->where('billing_month', $tenantdetail->billing_month)->where('billing_year', $tenantdetail->billing_year)->count();
            if ($sitetotalcount > 0){
                $sitetotal = SiteTotal::where('bu_id', $tenantdetail->bu_id)->where('billing_month', $tenantdetail->billing_month)->where('billing_year', $tenantdetail->billing_year)->first()->update([
                    'site_id' => $teamSite->website_id,
                    'portfolio_total' => $tenantdetail->portfolio_total,
                    'company_total' => $tenantdetail->company_total,
                    'bu_id' => $tenantdetail->bu_id,
                    'bu_name' => $tenantdetail->bu_name,
                    'department_total' => $tenantdetail->department_total,
                    'employeelevel_total' => $tenantdetail->employeelevel_total,
                    'task_total' => $tenantdetail->task_total,
                    'task_active' => $tenantdetail->task_active,
                    'billing_month' => $tenantdetail->billing_month,
                    'billing_year' => $tenantdetail->billing_year,
                    'task_transactions_total' => $tenantdetail->task_transactions_total,
                    'mobile_user_total' => $tenantdetail->mobile_user_total,
                    'cloud_user_total' => $tenantdetail->cloud_user_total,
                    'both_user_total' => $tenantdetail->both_user_total,
                    'request_user_total' => $tenantdetail->request_user_total,
                ]);
            } else {
                $sitetotal = SiteTotal::create([
                    'site_id' => $teamSite->website_id,
                    'portfolio_total' => $tenantdetail->portfolio_total,
                    'company_total' => $tenantdetail->company_total,
                    'bu_id' => $tenantdetail->bu_id,
                    'bu_name' => $tenantdetail->bu_name,
                    'department_total' => $tenantdetail->department_total,
                    'employeelevel_total' => $tenantdetail->employeelevel_total,
                    'task_total' => $tenantdetail->task_total,
                    'task_active' => $tenantdetail->task_active,
                    'billing_month' => $tenantdetail->billing_month,
                    'billing_year' => $tenantdetail->billing_year,
                    'task_transactions_total' => $tenantdetail->task_transactions_total,
                    'mobile_user_total' => $tenantdetail->mobile_user_total,
                    'cloud_user_total' => $tenantdetail->cloud_user_total,
                    'both_user_total' => $tenantdetail->both_user_total,
                    'request_user_total' => $tenantdetail->request_user_total,
                ]);
            }
            }
            $team = Team::where('id', $teamSite->team_id)->first();

            $invoiceinfo = $team->invoiceFor('Newsies Fee', 200);
            $invoice = MeteredInvoice::create([
                'team_id' =>$team->id,
                'provider_id'=>$invoiceinfo->transaction->id,
                'description' => 'Newsies Fee',
                'total'=>200
            ]);
//            $team->charge(340);
        }
        $sitetotals = SiteTotal::all();


//        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
//            'fqdn' => $tenantdetails
//        ]);

//        return redirect;
    }

    public function ownerswitch(Request $request)
    {
        $team = Team::where('id', $request->team_id)->first();
        $team->owner_id = $request->owner;
        $team->update();
        $teamuserold = TeamUser::where('team_id', $request->team_id)->where('role', 'owner')->update(['role'=>'member']);
        $teamusernew = TeamUser::where('team_id', $request->team_id)->where('user_id', $request->owner)->update(['role'=>'owner']);

        return back();

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamSite  $teamSite
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamSite $teamSite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamSite  $teamSite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamSite $teamSite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamSite  $teamSite
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamSite $teamSite)
    {
        //
    }
}
