<?php

namespace App\Http\Controllers;

use App\TeamSite;
use Illuminate\Http\Request;

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
    public function sitebilling(TeamSite $teamSite)
    {
        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = 'http://'.$teamSite->fqdn;

//        $body['_token'] = $request->_token;
//        $body['domainname'] = $request->domainname;
//        $body['site_id'] = $request->website_id;


        $url = 'http://'.$teamSite->fqdn;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $billingResponseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        dd($billingResponseData);
        $responseResult = \GuzzleHttp\json_decode($billingResponseData);


        dd($responseResult);


        $tenantresponse = $tenantclient->post($tenanturl);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();
dd($tenantcode, $tenantresult);
        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
            'fqdn' => $tenantdetails
        ]);

        return redirect;
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
