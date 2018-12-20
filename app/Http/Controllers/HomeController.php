<?php

namespace App\Http\Controllers;

use App\GlobalCommission;
use App\Setting;
use App\TeamSite;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        return view('home');
    }

    public function sites()
    {
        return view('vendor.spark.sites');
    }

    public function newsite(Request $request)
    {
        //TODO Add in Site Name to fieldlist through the api
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = 'http://cloud.taskmule.com/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tm000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;


//        $body['grant_type'] = "client_credentials";
//        $body['client_id'] = $this->client_id;
//        $body['client_secret'] = $this->client_secret;








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
            'team_id' => $request->team_id
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

        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = $teamsite->fqdn . '/api/v1/setup';
        $userurl = $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = $teamsite->fqdn . '/api/v1/siteparams';

        $countryresponse = $countryclient->get($countryurl);
        $countrycode = $countryresponse->getStatusCode();
        $countryresult = $countryresponse->getBody()->getContents();


        $languageresponse = $languageclient->get($languageurl);
        $languagecode = $languageresponse->getStatusCode();
        $languageresult = $languageresponse->getBody()->getContents();


        $setupresponse = $setupclient->get($setupurl);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        return Redirect::to('http://' . $tenantdetails->fqdn);
    }

    public function updatesite(Request $request)
    {

        //TODO Add in Site Name to fieldlist through the api
        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = 'http://cloud.taskmule.com/api/v1/sites/update';

        $body['_token'] = $request->_token;
        $body['domainname'] = $request->domainname;
        $body['site_id'] = $request->website_id;

        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
            'fqdn' => $tenantdetails
        ]);

        return redirect;
    }


}
