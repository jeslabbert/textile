<?php

namespace App\Http\Controllers;

use App\RuncloudServer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RuncloudServerController extends Controller
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
        $runcloud = RuncloudServer::create($input);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RuncloudServer  $runcloudServer
     * @return \Illuminate\Http\Response
     */
    public function show(RuncloudServer $runcloudServer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RuncloudServer  $runcloudServer
     * @return \Illuminate\Http\Response
     */
    public function edit(RuncloudServer $runcloudServer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RuncloudServer  $runcloudServer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RuncloudServer $runcloudServer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RuncloudServer  $runcloudServer
     * @return \Illuminate\Http\Response
     */
    public function destroy(RuncloudServer $runcloudServer)
    {
        //
    }
}
