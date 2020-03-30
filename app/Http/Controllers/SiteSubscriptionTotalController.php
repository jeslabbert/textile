<?php

namespace App\Http\Controllers;

use App\SiteSubscriptionTotal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteSubscriptionTotalController extends Controller
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

    public function updateSiteLimit(SiteSubscriptionTotal $subTotal, Request $request)
    {
        $input = $request->all();

        $subTotal = SiteSubscriptionTotal::where('site_subscription_total_id', $request->site_subscription_total_id)->first()->update($input);
        return redirect('/spark/kiosk');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\SiteSubscriptionTotal  $siteSubscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function show(SiteSubscriptionTotal $subTotal)
    {
        return view('spark::kiosk-site-limits', ['subTotal'=>$subTotal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteSubscriptionTotal  $siteSubscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSubscriptionTotal $siteSubscriptionTotal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteSubscriptionTotal  $siteSubscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSubscriptionTotal $siteSubscriptionTotal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteSubscriptionTotal  $siteSubscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSubscriptionTotal $siteSubscriptionTotal)
    {
        //
    }
}
