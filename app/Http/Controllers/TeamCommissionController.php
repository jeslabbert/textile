<?php

namespace App\Http\Controllers;

use App\Team;
use App\TeamCommission;
use Illuminate\Http\Request;

class TeamCommissionController extends Controller
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
        $team = Team::where('id', $request->team_id)->first();

        $input = $request->all();
        $firstsplit = 100 - $request->split;
        $secondsplit = $request->split;
        $teamcount = TeamCommission::where('team_id', $request->team_id)->count();

        if($teamcount > 0) {
            $teamcom = TeamCommission::where('team_id', $request->team_id)->update([
                'first_split' => $firstsplit,
                'first_user_id' => $request->first_user_id,
                'second_split' => $secondsplit,
                'second_user_id' => $request->second_user_id,
            ]);
        } else {
            $teamcom = TeamCommission::create([
                'team_id' => $request->team_id,
                'first_split' => $firstsplit,
                'first_user_id' => $request->first_user_id,
                'first_name' => 'Support',
                'second_split' => $secondsplit,
                'second_user_id' => $request->second_user_id,
                'second_name' => 'Sales',
            ]);
        }
        return redirect('/settings/teams/'.$request->team_id.'#/commission');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TeamCommission  $teamCommission
     * @return \Illuminate\Http\Response
     */
    public function show(TeamCommission $teamCommission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TeamCommission  $teamCommission
     * @return \Illuminate\Http\Response
     */
    public function edit(TeamCommission $teamCommission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TeamCommission  $teamCommission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeamCommission $teamCommission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TeamCommission  $teamCommission
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeamCommission $teamCommission)
    {
        //
    }
}
