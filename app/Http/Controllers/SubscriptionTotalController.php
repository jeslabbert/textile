<?php

namespace App\Http\Controllers;

use App\SubscriptionTotal;
use Illuminate\Http\Request;

class SubscriptionTotalController extends Controller
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


    public function updateLimit(SubscriptionTotal $subTotal, Request $request)
    {
        $input = $request->all();
        $subTotal = SubscriptionTotal::where('subscription_total_id', $request->subscription_total_id)->first()->update($input);
        return redirect('/spark/kiosk');
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
     * @param  \App\SubscriptionTotal  $subscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionTotal $subscriptionTotal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubscriptionTotal  $subscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscriptionTotal $subscriptionTotal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubscriptionTotal  $subscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscriptionTotal $subscriptionTotal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubscriptionTotal  $subscriptionTotal
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriptionTotal $subscriptionTotal)
    {
        //
    }
}
