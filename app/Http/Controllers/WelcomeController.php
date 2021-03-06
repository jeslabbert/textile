<?php

namespace App\Http\Controllers;

use App\ModuleTotal;
use App\Setting;
use App\SiteSubscriptionTotal;
use App\SubscriptionTotal;
use App\Team;
use App\TeamSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\TeamSubscription;

class WelcomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {


$subscriptions = TeamSubscription::all();

//dd($subscriptions);
foreach($subscriptions as $subscription) {
    $default = SubscriptionTotal::where('plan', $subscription->braintree_plan)->first();
    if(isset($default)) {
        $setup = $default->toArray();
        $teamSite = TeamSite::where('team_id', $subscription->team_id)->first();
        $setup['site_id'] = $teamSite->id;
        $siteDefault = SiteSubscriptionTotal::where('site_id', $teamSite->id)->whereDate('created_at', '>=', $subscription->created_at)->first();
        if(isset($siteDefault)) {

        } else {
            $oldSiteSubscriptions = SiteSubscriptionTotal::where('site_id', $teamSite->id)->delete();
            $newDefault = SiteSubscriptionTotal::create($setup);
        }
    } else {

    }




}



        if(Auth::user()) {
            return redirect('/login');
        } else {
            return redirect('/home');
        }

    }

    public function setup() {
        $comm1 = Setting::create([
            'setting_type' => 'Commission',
            'setting_name' => 'Consultant',
            'setting_value' => 30
        ]);
        $comm2 = Setting::create([
            'setting_type' => 'Commission',
            'setting_name' => 'Marketing',
            'setting_value' => 20
        ]);
        $comm3 = Setting::create([
            'setting_type' => 'Commission',
            'setting_name' => 'IT Support',
            'setting_value' => 10
        ]);
        $global = Setting::create([
            'setting_type' => 'Commission',
            'setting_name' => 'Global Commission',
            'setting_value' => 40
        ]);
        $global = Setting::create([
            'setting_type' => 'Commission',
            'setting_name' => 'PayPal',
            'setting_string' => 'paypal@cmspdf.com'
        ]);
        return redirect('/home');
    }

    public function checkSubscription(Request $request)
    {

        $now = Carbon::now();
        $team = Team::where('name', $request->sitename)->first();
        $status = false;
        $subs = TeamSubscription::where('team_id', $team->id)->get();
        foreach($subs as $sub) {
            if($sub->ends_at != null) {
                if(Carbon::parse($sub->ends_at) < $now) {
                    $status = false;
                } else {
                    $status = true;
                }
            } else {
                if(isset($sub->trial_ends_at)) {
                if(Carbon::parse($sub->trial_ends_at) < $now) {

                        if(Carbon::parse($sub->ends_at) < $now) {
                            $status = false;
                        } else {
                            $status = true;
                        }
                    }

                } else {
                    $status = true;
                }

            }

        }

        return response()->json($status, 201);

    }

}
