<?php

namespace App\Http\Controllers;

use App\CommissionCalculation;
use App\GlobalCommission;
use App\Setting;
use App\Team;
use App\TeamCommission;
use App\TeamSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Spark\Spark;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        $billingPeriods = collect();
        $billingChecks = collect();
        $teamChecks = collect();
        $teamCount = 0;
        $teamPeriods = collect();
        $setInvoiceValues = collect();
        $unsetInvoiceValues = collect();
        $unsettledComm = collect();
        $settledComm = collect();
        $commissions = CommissionCalculation::where('user_id', Auth::user()->id)->orderBy('comcalc_id','desc')->get();
        //dd($commissions);
        foreach($commissions as $commission) {

            if($billingChecks->contains($commission->billing_period)) {

            } else {
                $commissionChecks = CommissionCalculation::where('user_id', Auth::user()->id)->where('billing_period', $commission->billing_period)->orderBy('comcalc_id','desc')->get();
                $unsetcommvalue = 0;
                $setcommvalue = 0;
                $setinvoiceval = 0;
                $unsetinvoiceval = 0;
                foreach($commissionChecks as $commissionCheck) {
                    if($commissionCheck->status === 0) {
                        $unsetinvoiceval = $unsetinvoiceval + $commissionCheck->invoice_value;
                        $unsetcommvalue = $unsetcommvalue + $commissionCheck->comm_value;
                    } elseif($commissionCheck->status === 1) {
                        $setcommvalue = $setcommvalue + $commissionCheck->comm_value;
                        $setinvoiceval = $setinvoiceval + $commissionCheck->invoice_value;
                    }
                    if($teamChecks->contains($commissionCheck->team_id)) {

                    } else {
                        $teamChecks = $teamChecks->push($commissionCheck->team_id);
                        $teamCount++;
                    }

                }
                $setInvoiceValues = $setInvoiceValues->push($setinvoiceval);
                $unsetInvoiceValues = $unsetInvoiceValues->push($unsetinvoiceval);
                $unsettledComm = $unsettledComm->push($unsetcommvalue);
                $settledComm = $settledComm->push($setcommvalue);
                $teamPeriods = $teamPeriods->push($teamCount);
                $billingdate = Carbon::createFromFormat('Y0m', $commission->billing_period)->format('M Y');
                $billingPeriods = $billingPeriods->push($billingdate);
                $billingChecks = $billingChecks->push($commission->billing_period);
            }

        }
//        dd($billingPeriods, $teamPeriods, $unsettledComm, $settledComm);
        return view('home', ['unsetInvoiceValues'=>$unsetInvoiceValues,'setInvoiceValues'=>$setInvoiceValues,'billingPeriods'=>$billingPeriods, 'teamPeriods'=>$teamPeriods, 'unsettledComm'=>$unsettledComm, 'settledComm'=>$settledComm]);
    }

    public function sites()
    {
        return view('vendor.spark.sites');
    }

    public function switchTeamLatest()
    {
        $team = Team::where('owner_id', Auth::user()->id)->latest()->first();
        return Redirect::to('/settings/'.Spark::teamsPrefix().'/'.$team->id);
//        dd($team);
    }

    public function newsite(Request $request)
    {
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = \config('tenancy.url').'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tts000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;









        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::create([
            'fqdn' => $tenantdetails->fqdn,
            'historical_fqdn' => $tenantdetails->fqdn,
            'website_id' => $tenantdetails->website_id,
            'creator' => 'System',
            'creator_email' => 'info@taskmule.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();
        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

//        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
//        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = 'https://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'https://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'https://' . $teamsite->fqdn . '/api/v1/siteparams';
//
//        $countryresponse = $countryclient->get($countryurl);
//        $countrycode = $countryresponse->getStatusCode();
//        $countryresult = $countryresponse->getBody()->getContents();
//
//
//        $languageresponse = $languageclient->get($languageurl);
//        $languagecode = $languageresponse->getStatusCode();
//        $languageresult = $languageresponse->getBody()->getContents();
//
//

//
        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();
//        return Redirect::to('https://' . $tenantdetails->fqdn);
    }

    public function updatesite(Request $request)
    {
        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = \config('tenancy.url').'/api/v1/sites/update';

        $body['_token'] = $request->_token;
        $body['domainname'] = $request->domainname;
        $body['site_id'] = $request->website_id;
        $body['sitename'] = $request->websitename;

        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
            'fqdn' => $tenantdetails
        ]);

        return redirect;
    }

    public function updatesitename(Request $request)
    {


        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = $request->website . '/api/v1/name/update';

        $body['sitename'] = $request->websitename;


        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->first()->update([
            'tenant_sitename' => $request->websitename
        ]);

        return redirect($request->website .'/admin/whitelabelling');
    }

}
