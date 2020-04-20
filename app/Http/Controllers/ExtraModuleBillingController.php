<?php

namespace App\Http\Controllers;

use App\ExtraModuleBilling;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExtraModuleBillingController extends Controller
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
        $input = $request->all();
        ExtraModuleBilling::create($input);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ExtraModuleBilling  $extraModuleBilling
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraModuleBilling $extraModuleBilling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExtraModuleBilling  $extraModuleBilling
     * @return \Illuminate\Http\Response
     */
    public function edit(ExtraModuleBilling $extraModuleBilling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExtraModuleBilling  $extraModuleBilling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExtraModuleBilling $extraModule)
    {
        $input = $request->all();
        $extraModule->update($input);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExtraModuleBilling  $extraModuleBilling
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraModuleBilling $extraModuleBilling)
    {
        //
    }
}
