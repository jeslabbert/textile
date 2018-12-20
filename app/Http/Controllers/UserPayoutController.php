<?php

namespace App\Http\Controllers;

use App\UserPayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPayoutController extends Controller
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
        $payoutcount = UserPayout::where('user_id', Auth::user()->id)->count();
        if( $payoutcount > 0) {
            $payout = UserPayout::where('user_id', Auth::user()->id)->first();
            $payout->payoutprovider_id = $request->payoutprovider_id;
            $payout->provider_user_details = $request->user_details;
            $payout->update();
        } else {
            $payout = UserPayout::create([
                'user_id' => Auth::user()->id,
                'payoutprovider_id' => $request->payoutprovider_id,
                'provider_user_details' => $request->user_details
            ]);
        }

return redirect('/settings#/profile');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserPayout  $userPayout
     * @return \Illuminate\Http\Response
     */
    public function show(UserPayout $userPayout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserPayout  $userPayout
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPayout $userPayout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserPayout  $userPayout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPayout $userPayout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserPayout  $userPayout
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPayout $userPayout)
    {
        //
    }
}
