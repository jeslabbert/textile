<?php

namespace App\Console\Commands;

use App\ModuleTotal;
use App\SubscriptionTotal;
use App\Team;
use App\TeamSite;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Laravel\Spark\TeamSubscription;

class GetSiteStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:SiteStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all Site Statistics';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$sites = TeamSite::all();
        $sites = TeamSite::where('id', '>', 20)->get();
        $now = Carbon::now();
        foreach($sites as $site) {
            $team = Team::where('id', $site->team_id)->first();
            if($site->id != 22) {
                $setupclient = new \GuzzleHttp\Client();
                $setupurl = 'http://' . $site->fqdn . '/api/v1/stats';
                $setupresponse = $setupclient->get($setupurl);
                $setupcode = $setupresponse->getStatusCode();
                $setupresult = $setupresponse->getBody()->getContents();
                $stats = \GuzzleHttp\json_decode($setupresult);
                $stats->site_id = $site->id;
                $statistics['site_id'] = $site->id;
                $statistics['doc_exported_total'] = $stats->exported;
                $statistics['doc_viewed_total'] = $stats->viewed;
                $statistics['doc_edited_total'] = $stats->edited;
                $statistics['doc_created_total'] = $stats->created;
                $statistics['doc_total'] = $stats->document_count;
                $statistics['doc_active_total'] = $stats->active_count;
                $statistics['user_total'] = $stats->users;
                $statistics['billing_year'] = $stats->year;
                $statistics['billing_month'] = $stats->month;
            } else {

                $statistics['site_id'] = $site->id;
                $statistics['doc_exported_total'] = 60;
                $statistics['doc_viewed_total'] = 82;
                $statistics['doc_edited_total'] = 23;
                $statistics['doc_created_total'] = 18;
                $statistics['doc_total'] = 20;
                $statistics['doc_active_total'] = 20;
                $statistics['user_total'] = 15;
                $statistics['billing_year'] = 2019;
                $statistics['billing_month'] = 12;
            }
            $moduleCountExists = ModuleTotal::where('site_id', $site->id)->where('billing_year', $statistics['billing_year'])->where('billing_month', $statistics['billing_month'])->count();
            if($moduleCountExists > 0) {

            } else {
                $siteSubscriptions = TeamSubscription::where('team_id', $site->team_id)->get();
                $addUsage = 0;
                $userUsage = 0;
                $exportUsage = 0;
                foreach($siteSubscriptions as $siteSubscription) {
                    if(isset($siteSubscription->ends_at)) {
                        if($siteSubscription->ends_at > $now) {

                        } else {

                        }
                    } else {
                        $subTotal = SubscriptionTotal::where('plan', $siteSubscription->braintree_plan)->first();



                        if($subTotal->user_total > $statistics['user_total']) {

                        } else {
                            $userUsage = $statistics['doc_active_total'] - $subTotal->doc_active_total;
                            $userExtra = $userUsage * $subTotal->add_user_price;
                        }

                        if($subTotal->doc_exported_total > $statistics['doc_exported_total']) {

                        } else {
                            $exportUsage = $statistics['doc_exported_total'] - $subTotal->doc_exported_total;
                            $exportedExtra = $exportUsage * $subTotal->add_doc_price;
                        }



                        if($subTotal->add_user_price != 0 && $subTotal->add_user_price > 0) {

                            $team->invoiceFor('Additional Users', $userUsage);
                        } else {

                        }

                        if($subTotal->add_doc_price != 0 && $subTotal->add_doc_price > 0) {
                            $team->invoiceFor('Additional Document Units', $exportUsage);
                        } else {

                        }

                    }
                }
                $module = ModuleTotal::create($statistics);
            }

        }
        return 'Completed Successfully';
    }
}
