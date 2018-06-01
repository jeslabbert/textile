<?php

namespace App\Http\Controllers;

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

    public function newsite(Request $request)
    {
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
    'creator' => $tenantdetails->customer->name,
    'creator_email' => $tenantdetails->customer->email,
    'team_id' => $request->team_id
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
        $sitedetails = \GuzzleHttp\json_decode($siteresult);

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        return Redirect::to('http://' . $tenantdetails->fqdn);
    }

    public function updatesite(Request $request)
    {
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

        return Redirect::to('http://' . $tenantdetails);
    }
}
