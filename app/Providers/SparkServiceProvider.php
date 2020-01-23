<?php

namespace App\Providers;

use App\SubscriptionTotal;
use Carbon\Carbon;
use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'justin@icarative.com';
    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'justin@icarative.com',
        'witkruisarend@gmail.com',
        'gawieh@aigs.co.za',
        'gustavp@aigs.co.za'
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = true;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::validateUsersWith(function () {
            return [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'vat_id' => 'max:50|vat_id',
                'terms' => 'required|accepted',
            ];
        });
        Spark::afterLoginRedirectTo('userdashboard');
        Spark::createUsersWith(function ($request) {
            $user = Spark::user();

            $data = $request->all();

            $user->forceFill([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'last_read_announcements_at' => Carbon::now(),
//                'trial_ends_at' => Carbon::now()->addDays(Spark::trialDays()),
            ])->save();

            return $user;
        });

        Spark::useBraintree()->noCardUpFront()->teamTrialDays(0);

        Spark::freeTeamPlan()
            ->features([
                '1 to 5 Tasks'
            ]);

//        Spark::teamPlan('Bronze Plan', 'taskmule-bronze-eur')
//            ->price(1)
//            ->features([
//                '6 to 20 Tasks', '600 Transactions'
//            ]);
//
//        Spark::teamPlan('Silver Plan', 'taskmule-silver-eur')
//            ->price(10)
//            ->features([
//                '21 to 100 Tasks', '3000 Transactions'
//            ]);
//
//        Spark::teamPlan('Gold Plan', 'taskmule-gold-eur')
//            ->price(100)
//            ->features([
//                '101 to 500 Tasks', '15000 Transactions'
//            ]);
        $bronze = SubscriptionTotal::where('plan', 'taskmule-bronze-eur')->first();
        $silver = SubscriptionTotal::where('plan', 'taskmule-silver-eur')->first();
        $gold = SubscriptionTotal::where('plan', 'taskmule-gold-eur')->first();

        Spark::teamPlan('Bronze Plan', 'taskmule-bronze-eur')
            ->price(1)
            ->features([
                $bronze->doc_active_total.' Documents', $bronze->first()->doc_exported_total.' Exports'
            ]);

        Spark::teamPlan('Silver Plan', 'taskmule-silver-eur')
            ->price(10)
            ->features([
                $silver->doc_active_total.' Documents', $silver->doc_exported_total.' Exports'
            ]);

        Spark::teamPlan('Gold Plan', 'taskmule-gold-eur')
            ->price(100)
            ->features([
                $gold->doc_active_total.' Documents', $gold->doc_exported_total.' Exports'
            ]);

//        Spark::freeTeamPlan()
//            ->features([
//                '1 to 5 Documents (Non Active)'
//            ]);
//        Spark::teamPlan('Basic Plan', 'cmspdf-basic-usd')
//            ->price(20)
//            ->features([
//                '5 Users', '10 Documents', '100 Exports'
//            ]);
//        Spark::teamPlan('Premium Plan', 'cmspdf-premium-usd')
//            ->price(100)
//            ->features([
//                '10 Users', '50 Documents', '500 Exports'
//            ]);

    }
}
