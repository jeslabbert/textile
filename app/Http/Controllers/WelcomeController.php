<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
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
            'setting_string' => 'cmspaypal@tartancms.com'
        ]);
        return redirect('/home');
    }
}
