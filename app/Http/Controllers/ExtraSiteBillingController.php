<?php

namespace App\Http\Controllers;

use App\ExtraSiteBilling;
use App\TeamSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtraSiteBillingController extends Controller
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

    public function addSiteExtra(TeamSite $site, Request $request)
    {
        $input = $request->all();
        $input['site_id'] = $site->id;

        $siteExtra = ExtraSiteBilling::create($input);
        return redirect()->back();
    }

    public function updateSiteExtra(ExtraSiteBilling $extraBilling, Request $request)
    {
        $input = $request->all();

        $extraBilling->update($input);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExtraSiteBilling  $extraSiteBilling
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraSiteBilling $extraSiteBilling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraSiteBilling  $extraSiteBilling
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraSiteBilling $extraSiteBilling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtraSiteBilling  $extraSiteBilling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraSiteBilling $extraSiteBilling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraSiteBilling  $extraSiteBilling
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraSiteBilling $extraBilling)
    {
        $oldBilling = $extraBilling;
        $extraBilling->delete();
        return redirect()->back();
    }
}
