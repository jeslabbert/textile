<?php

namespace App\Http\Controllers;

use App\CommissionCalculation;
use App\GlobalCommission;
use App\RuncloudServer;
use App\Setting;
use App\Team;
use App\TeamCommission;
use App\TeamSite;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Laravel\Spark\Spark;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        $billingPeriods = collect();
        $billingChecks = collect();
        $teamChecks = collect();
        $teamCount = 0;
        $teamPeriods = collect();
        $setInvoiceValues = collect();
        $unsetInvoiceValues = collect();
        $unsettledComm = collect();
        $settledComm = collect();
        $commissions = CommissionCalculation::where('user_id', Auth::user()->id)->orderBy('comcalc_id','desc')->get();
        //dd($commissions);
        foreach($commissions as $commission) {

            if($billingChecks->contains($commission->billing_period)) {

            } else {
                $commissionChecks = CommissionCalculation::where('user_id', Auth::user()->id)->where('billing_period', $commission->billing_period)->orderBy('comcalc_id','desc')->get();
                $unsetcommvalue = 0;
                $setcommvalue = 0;
                $setinvoiceval = 0;
                $unsetinvoiceval = 0;
                foreach($commissionChecks as $commissionCheck) {
                    if($commissionCheck->status === 0) {
                        $unsetinvoiceval = $unsetinvoiceval + $commissionCheck->invoice_value;
                        $unsetcommvalue = $unsetcommvalue + $commissionCheck->comm_value;
                    } elseif($commissionCheck->status === 1) {
                        $setcommvalue = $setcommvalue + $commissionCheck->comm_value;
                        $setinvoiceval = $setinvoiceval + $commissionCheck->invoice_value;
                    }
                    if($teamChecks->contains($commissionCheck->team_id)) {

                    } else {
                        $teamChecks = $teamChecks->push($commissionCheck->team_id);
                        $teamCount++;
                    }

                }
                $setInvoiceValues = $setInvoiceValues->push($setinvoiceval);
                $unsetInvoiceValues = $unsetInvoiceValues->push($unsetinvoiceval);
                $unsettledComm = $unsettledComm->push($unsetcommvalue);
                $settledComm = $settledComm->push($setcommvalue);
                $teamPeriods = $teamPeriods->push($teamCount);
                $billingdate = Carbon::createFromFormat('Y0m', $commission->billing_period)->format('M Y');
                $billingPeriods = $billingPeriods->push($billingdate);
                $billingChecks = $billingChecks->push($commission->billing_period);
            }

        }
//        dd($billingPeriods, $teamPeriods, $unsettledComm, $settledComm);
        return view('home', ['unsetInvoiceValues'=>$unsetInvoiceValues,'setInvoiceValues'=>$setInvoiceValues,'billingPeriods'=>$billingPeriods, 'teamPeriods'=>$teamPeriods, 'unsettledComm'=>$unsettledComm, 'settledComm'=>$settledComm]);
    }

    public function sites()
    {
        return view('vendor.spark.sites');
    }

    public function switchTeamLatest()
    {
        $team = Team::where('owner_id', Auth::user()->id)->latest()->first();
        return Redirect::to('/settings/'.Spark::teamsPrefix().'/'.$team->id);
//        dd($team);
    }

    public function switchDashboard()
    {
        $teamCount = Team::where('owner_id', Auth::user()->id)->count();
        if($teamCount > 1) {
            return Redirect::to('/userdashboard');
        } else {
            $team = Team::where('owner_id', Auth::user()->id)->latest()->first();
            return Redirect::to('/settings/'.Spark::teamsPrefix().'/'.$team->id);
        }


//        dd($team);
    }

    public function newSiteCloud(Request $request)
    {
        $input = $request->all();

        $runcloudUserClient = new \GuzzleHttp\Client();
        $runcloudAppClient = new \GuzzleHttp\Client();
        $runcloudGitClient = new \GuzzleHttp\Client();
        $runcloudDbClient = new \GuzzleHttp\Client();
        $runcloudDbUserClient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $apiKey = '7am578w2eXdPRlpoHar6hpTH726BsYRMaNON005qtDfg';
        $apiSecret = 'vo72pj9jhs9l2ueZFYGFSjkc5du1Irt2biFZlVQNF7JQ4OIj37BF7M7HNJEvSLf6';

        $serverId = '103587';
        $username = 'cmspdf';
        $password = 'T0by&P1per';

        $runcloudUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/users';
        $runcloudAppUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/custom';
        $runcloudDbUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases';

        $team = Team::find($request->team_id);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $team->name)));
        $dbslug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $team->name)));

//        $target = [
//            'host'      => '206.189.126.10',
//
//            'username'  => 'cmspdf',
//            'password'  => 'T0by&P1per',
//            'key'       => '',
//            'keytext'   => '',
//            'keyphrase' => '',
//            'agent'     => '',
//            'timeout'   => 20,
//        ];
////        config([
////            'remote.connections.runtime.host' => $target['host'],
////            'remote.connections.runtime.username' => $target['username'],
////            'remote.connections.runtime.password' => $target['password']
////        ]);

        $siteUrl =
        //SETUP WEBAPP IN RUNCLOUD
        $appUrl = 'tts000' . $request->subname.".cmspdf.com";

            $runcloudAppPost = array(
                "name"=> $slug,
                "domainName"=> $appUrl,
                "user"=> 282158,
                "publicPath"=> '/public',
                "phpVersion"=> "php74rc",
                "stack"=> "hybrid",
                "stackMode"=> "production",
                "clickjackingProtection"=> true,
                "xssProtection"=> true,
                "mimeSniffingProtection"=> true,
                "processManager"=> "ondemand",
                "processManagerMaxChildren"=> 50,
                "processManagerMaxRequests"=> 500,
                "timezone"=> "UTC",
                "disableFunctions"=> "",
                "maxExecutionTime"=> 600,
                "maxInputTime"=> 600,
                "maxInputVars"=> 1000,
                "memoryLimit"=> 256,
                "postMaxSize"=> 256,
                "uploadMaxFilesize"=> 256,
                "sessionGcMaxlifetime"=> 1440,
                "allowUrlFopen"=> true
            );

        $runCloudAppResponse = $runcloudAppClient->post($runcloudAppUrl, [
            'auth' => [
            $apiKey,
            $apiSecret
        ],
            'form_params' => $runcloudAppPost
        ]);

        $runcloudAppCode = $runCloudAppResponse->getStatusCode();
        $runcloudAppResult = $runCloudAppResponse->getBody()->getContents();
        $runcloudAppDetails = \GuzzleHttp\json_decode($runcloudAppResult);

        $runcloudAppId = $runcloudAppDetails->id;
        $runcloudUserId = $runcloudAppDetails->server_user_id;

        //SETUP WEBAPP DATABASE IN RUNCLOUD
        $dbName = $dbslug.$runcloudAppId;
        $dbUser = $dbslug.$runcloudAppId.'dba';
        $dbPassword = uniqid();
        $runcloudDbPost = array(
            "name"=> $dbName
        );
        $runCloudDbResponse = $runcloudDbClient->post($runcloudDbUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbPost
        ]);
        $runcloudDbCode = $runCloudDbResponse->getStatusCode();
        $runcloudDbResult = $runCloudDbResponse->getBody()->getContents();
        $runcloudDbDetails = \GuzzleHttp\json_decode($runcloudDbResult);
        $dbId = $runcloudDbDetails->id;


        //SETUP WEBAPP DATABASE USER IN RUNCLOUD
        $runcloudDbUserPost = array(
            "username"=> $dbUser,
            "password"=> $dbPassword
        );
        $runcloudDbUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databaseusers';
        $runCloudDbUserResponse = $runcloudDbUserClient->post($runcloudDbUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserPost
        ]);
        $runcloudDbUserCode = $runCloudDbUserResponse->getStatusCode();
        $runcloudDbUserResult = $runCloudDbUserResponse->getBody()->getContents();
        $runcloudDbUserDetails = \GuzzleHttp\json_decode($runcloudDbUserResult);
        $dbUserId = $runcloudDbUserDetails->id;


        //ATTACH DATABASE USER TO DATABASE IN RUNCLOUD
        $runcloudDbUserAttachPost = array(
            "id"=> $dbUserId
        );
        $runcloudDbUserAttachUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases/'.$dbId.'/grant';
        $runCloudDbUserAttachResponse = $runcloudDbUserClient->post($runcloudDbUserAttachUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserAttachPost
        ]);
        $runcloudDbUserAttachCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudDbUserAttachResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudDbUserAttachDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);

        //SETUP WEBAPP GIT REPO IN RUNCLOUD
        $runcloudGitUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/'.$runcloudAppId.'/git';
        $runcloudGitPost = array(
            "provider"=> "gitlab",
            "repository"=> "icarative/cmspdf-dev",
            "branch"=> "NoTenant"
        );

        $runCloudGitResponse = $runcloudGitClient->post($runcloudGitUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudGitPost
        ]);
        $runcloudGitCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudGitResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudGitDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);



        $debugStatus = 'true';
        $envFile = 'cat > .env <<EOF
APP_NAME="'.$team->name.'"
APP_ENV=local
APP_KEY=base64:UInV/8MxloQNjf2IdXK2Nf0eYREgx02BxlA5AOHUPYA=
APP_DEBUG='.$debugStatus.'
APP_LOG_LEVEL=debug
APP_URL_BASE='.$appUrl.'
APP_URL='.$appUrl.'
DOC_BASE='.$appUrl.'

PORTAL_URL=https://portal.cmspdf.com

BRAND=logo.png

DB_CONNECTION=system
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='.$dbName.'
DB_USERNAME='.$dbUser.'
DB_PASSWORD='.$dbPassword.'

LIMIT_UUID_LENGTH_32=true

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
SENTRY_LARAVEL_DSN=https://fc26289b081e45f19e868b29c227e0dd@o439251.ingest.sentry.io/5405720

EOF
        ';
        $commands = [
            'cd webapps/'.$slug,
            $envFile,
        ];
        try {
            \SSH::into('cmspdfcloud')->run($commands, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }

        $commandsSecond = [
            'cd webapps/'.$slug,
            'composer install',
            'php artisan migrate'
        ];
        try {
            \SSH::into('cmspdfcloud')->run($commandsSecond, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }


        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $appUrl.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = $appUrl;
        $body['sitename'] = $team->name;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;

        $teamsite = TeamSite::create([
            'fqdn' => $appUrl,
            'historical_fqdn' => $appUrl,
            'website_id' => $runcloudAppId,
            'creator' => 'System',
            'creator_email' => 'info@cmspdf.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();

        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';

        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();

    }

    public function newSiteSubDomain(Request $request)
    {
        $input = $request->all();

        $runcloudUserClient = new \GuzzleHttp\Client();
        $runcloudAppClient = new \GuzzleHttp\Client();
        $runcloudGitClient = new \GuzzleHttp\Client();
        $runcloudDbClient = new \GuzzleHttp\Client();
        $runcloudDbUserClient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $runcloudServer = RuncloudServer::where('id', $request->server_id)->first();

        config(['remote.connections.runtime.host' => $runcloudServer->ip_address]);
        config(['remote.connections.runtime.username' => $runcloudServer->server_user]);
        config(['remote.connections.runtime.password' => $runcloudServer->server_password]);

        $apiKey = $runcloudServer->api_key;
        $apiSecret = $runcloudServer->api_secret;

        $serverId = $runcloudServer->server_id;
        $username = $runcloudServer->server_user;
        $password = $runcloudServer->server_password;
        $serverUserId = 0;

        $runcloudUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/users';
        $runcloudAppUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/custom';
        $runcloudDbUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases';

        $team = Team::find($request->team_id);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $team->name)));
        $dbslug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $team->name)));

        $runCloudSystemUserResponse = $runcloudAppClient->get($runcloudUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ]
        ]);

        $runCloudSystemUserResult = $runCloudSystemUserResponse->getBody()->getContents();
        $runcloudSystemUserDetails = \GuzzleHttp\json_decode($runCloudSystemUserResult);
        foreach($runcloudSystemUserDetails->data as $systemUser) {
            if($username === $systemUser->username) {
                $serverUserId = $systemUser->id;
            }
        }


//        $target = [
//            'host'      => '206.189.126.10',
//
//            'username'  => 'cmspdf',
//            'password'  => 'T0by&P1per',
//            'key'       => '',
//            'keytext'   => '',
//            'keyphrase' => '',
//            'agent'     => '',
//            'timeout'   => 20,
//        ];
////        config([
////            'remote.connections.runtime.host' => $target['host'],
////            'remote.connections.runtime.username' => $target['username'],
////            'remote.connections.runtime.password' => $target['password']
////        ]);

        $siteUrl =
            //SETUP WEBAPP IN RUNCLOUD
        $appUrl = $request->site_url;

        $runcloudAppPost = array(
            "name"=> $slug,
            "domainName"=> $appUrl,
            "user"=> $serverUserId,
            "publicPath"=> '/public',
            "phpVersion"=> "php74rc",
            "stack"=> "hybrid",
            "stackMode"=> "production",
            "clickjackingProtection"=> true,
            "xssProtection"=> true,
            "mimeSniffingProtection"=> true,
            "processManager"=> "ondemand",
            "processManagerMaxChildren"=> 50,
            "processManagerMaxRequests"=> 500,
            "timezone"=> "UTC",
            "disableFunctions"=> "",
            "maxExecutionTime"=> 600,
            "maxInputTime"=> 600,
            "maxInputVars"=> 1000,
            "memoryLimit"=> 256,
            "postMaxSize"=> 256,
            "uploadMaxFilesize"=> 256,
            "sessionGcMaxlifetime"=> 1440,
            "allowUrlFopen"=> true
        );

        $runCloudAppResponse = $runcloudAppClient->post($runcloudAppUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudAppPost
        ]);

        $runcloudAppCode = $runCloudAppResponse->getStatusCode();
        $runcloudAppResult = $runCloudAppResponse->getBody()->getContents();
        $runcloudAppDetails = \GuzzleHttp\json_decode($runcloudAppResult);

        $runcloudAppId = $runcloudAppDetails->id;
        $runcloudUserId = $runcloudAppDetails->server_user_id;

        //SETUP WEBAPP DATABASE IN RUNCLOUD
        $dbName = $dbslug.$runcloudAppId;
        $dbUser = $dbslug.$runcloudAppId.'dba';
        $dbPassword = uniqid();
        $runcloudDbPost = array(
            "name"=> $dbName
        );
        $runCloudDbResponse = $runcloudDbClient->post($runcloudDbUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbPost
        ]);
        $runcloudDbCode = $runCloudDbResponse->getStatusCode();
        $runcloudDbResult = $runCloudDbResponse->getBody()->getContents();
        $runcloudDbDetails = \GuzzleHttp\json_decode($runcloudDbResult);
        $dbId = $runcloudDbDetails->id;


        //SETUP WEBAPP DATABASE USER IN RUNCLOUD
        $runcloudDbUserPost = array(
            "username"=> $dbUser,
            "password"=> $dbPassword
        );
        $runcloudDbUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databaseusers';
        $runCloudDbUserResponse = $runcloudDbUserClient->post($runcloudDbUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserPost
        ]);
        $runcloudDbUserCode = $runCloudDbUserResponse->getStatusCode();
        $runcloudDbUserResult = $runCloudDbUserResponse->getBody()->getContents();
        $runcloudDbUserDetails = \GuzzleHttp\json_decode($runcloudDbUserResult);
        $dbUserId = $runcloudDbUserDetails->id;


        //ATTACH DATABASE USER TO DATABASE IN RUNCLOUD
        $runcloudDbUserAttachPost = array(
            "id"=> $dbUserId
        );
        $runcloudDbUserAttachUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases/'.$dbId.'/grant';
        $runCloudDbUserAttachResponse = $runcloudDbUserClient->post($runcloudDbUserAttachUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserAttachPost
        ]);
        $runcloudDbUserAttachCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudDbUserAttachResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudDbUserAttachDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);

        //SETUP WEBAPP GIT REPO IN RUNCLOUD
        $runcloudGitUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/'.$runcloudAppId.'/git';
        $runcloudGitPost = array(
            "provider"=> "gitlab",
            "repository"=> "icarative/cmspdf-dev",
            "branch"=> "NoTenant"
        );

        $runCloudGitResponse = $runcloudGitClient->post($runcloudGitUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudGitPost
        ]);
        $runcloudGitCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudGitResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudGitDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);
        config(['remote.connections.runtime.server' => $runcloudServer->ip_address]);
        config(['remote.connections.runtime.user' => $runcloudServer->server_user]);
        config(['remote.connections.runtime.pass' => $runcloudServer->server_password]);


        $debugStatus = 'false';
        $envFile = 'cat > .env <<EOF
APP_NAME="'.$team->name.'"
APP_ENV=local
APP_KEY=base64:UInV/8MxloQNjf2IdXK2Nf0eYREgx02BxlA5AOHUPYA=
APP_DEBUG='.$debugStatus.'
APP_LOG_LEVEL=debug
APP_URL_BASE='.$appUrl.'
APP_URL='.$appUrl.'
DOC_BASE='.$appUrl.'

PORTAL_URL=https://portal.cmspdf.com

BRAND=logo.png

DB_CONNECTION=system
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='.$dbName.'
DB_USERNAME='.$dbUser.'
DB_PASSWORD='.$dbPassword.'

LIMIT_UUID_LENGTH_32=true

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
SENTRY_LARAVEL_DSN=https://fc26289b081e45f19e868b29c227e0dd@o439251.ingest.sentry.io/5405720

EOF
        ';
        $commands = [
            'cd webapps/'.$slug,
            $envFile,
        ];
        try {
            \SSH::into('runtime')->run($commands, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            dd($e->getMessage());
            echo $e->getMessage();
        }

        $commandsSecond = [
            'cd webapps/'.$slug,
            'composer install',
            'php artisan migrate',
            'php artisan storage:link'
        ];
        try {
            \SSH::into('runtime')->run($commandsSecond, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }


        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $appUrl.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = $appUrl;
        $body['sitename'] = $team->name;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;

        $teamsite = TeamSite::create([
            'fqdn' => $appUrl,
            'historical_fqdn' => $appUrl,
            'website_id' => $runcloudAppId,
            'creator' => 'System',
            'creator_email' => 'info@cmspdf.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();

        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';

        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();

    }

    public function newSitePort1(Request $request)
    {
        $input = $request->all();

        $runcloudUserClient = new \GuzzleHttp\Client();
        $runcloudAppClient = new \GuzzleHttp\Client();
        $runcloudGitClient = new \GuzzleHttp\Client();
        $runcloudDbClient = new \GuzzleHttp\Client();
        $runcloudDbUserClient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $runcloudServer = RuncloudServer::where('id', $request->server_id)->first();

        config(['remote.connections.runtime.host' => $runcloudServer->ip_address]);
        config(['remote.connections.runtime.username' => $runcloudServer->server_user]);
        config(['remote.connections.runtime.password' => $runcloudServer->server_password]);

        $apiKey = $runcloudServer->api_key;
        $apiSecret = $runcloudServer->api_secret;

        $serverId = $runcloudServer->server_id;
        $username = $runcloudServer->server_user;
        $password = $runcloudServer->server_password;
        $serverUserId = 0;


        $runcloudUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/users';
        $runcloudAppUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/custom';
        $runcloudDbUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases';

        $team = Team::find($request->team_id);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $team->name)));
        $dbslug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $team->name)));

        $runCloudSystemUserResponse = $runcloudAppClient->get($runcloudUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ]
        ]);

        $runCloudSystemUserResult = $runCloudSystemUserResponse->getBody()->getContents();
        $runcloudSystemUserDetails = \GuzzleHttp\json_decode($runCloudSystemUserResult);
        foreach($runcloudSystemUserDetails->data as $systemUser) {
            if($username === $systemUser->username) {
                $serverUserId = $systemUser->id;
            }
        }


//        $target = [
//            'host'      => '206.189.126.10',
//
//            'username'  => 'cmspdf',
//            'password'  => 'T0by&P1per',
//            'key'       => '',
//            'keytext'   => '',
//            'keyphrase' => '',
//            'agent'     => '',
//            'timeout'   => 20,
//        ];
////        config([
////            'remote.connections.runtime.host' => $target['host'],
////            'remote.connections.runtime.username' => $target['username'],
////            'remote.connections.runtime.password' => $target['password']
////        ]);

        $siteUrl =
            //SETUP WEBAPP IN RUNCLOUD
        $appUrl = $request->site_url;
        $input['slug'] = $slug;
        $runcloudAppPost = array(
            "name"=> $slug,
            "domainName"=> $appUrl,
            "user"=> $serverUserId,
            "publicPath"=> '/public',
            "phpVersion"=> "php74rc",
            "stack"=> "hybrid",
            "stackMode"=> "production",
            "clickjackingProtection"=> true,
            "xssProtection"=> true,
            "mimeSniffingProtection"=> true,
            "processManager"=> "ondemand",
            "processManagerMaxChildren"=> 50,
            "processManagerMaxRequests"=> 500,
            "timezone"=> "UTC",
            "disableFunctions"=> "",
            "maxExecutionTime"=> 600,
            "maxInputTime"=> 600,
            "maxInputVars"=> 1000,
            "memoryLimit"=> 256,
            "postMaxSize"=> 256,
            "uploadMaxFilesize"=> 256,
            "sessionGcMaxlifetime"=> 1440,
            "allowUrlFopen"=> true
        );

        $runCloudAppResponse = $runcloudAppClient->post($runcloudAppUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudAppPost
        ]);

        $runcloudAppCode = $runCloudAppResponse->getStatusCode();
        $runcloudAppResult = $runCloudAppResponse->getBody()->getContents();
        $runcloudAppDetails = \GuzzleHttp\json_decode($runcloudAppResult);

        $runcloudAppId = $runcloudAppDetails->id;
        $runcloudUserId = $runcloudAppDetails->server_user_id;

        //SETUP WEBAPP DATABASE IN RUNCLOUD
        $dbName = $dbslug.$runcloudAppId;
        $dbUser = $dbslug.$runcloudAppId.'dba';
        $dbPassword = uniqid();
        $runcloudDbPost = array(
            "name"=> $dbName
        );
        $runCloudDbResponse = $runcloudDbClient->post($runcloudDbUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbPost
        ]);
        $runcloudDbCode = $runCloudDbResponse->getStatusCode();
        $runcloudDbResult = $runCloudDbResponse->getBody()->getContents();
        $runcloudDbDetails = \GuzzleHttp\json_decode($runcloudDbResult);
        $dbId = $runcloudDbDetails->id;


        //SETUP WEBAPP DATABASE USER IN RUNCLOUD
        $runcloudDbUserPost = array(
            "username"=> $dbUser,
            "password"=> $dbPassword
        );
        $runcloudDbUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databaseusers';
        $runCloudDbUserResponse = $runcloudDbUserClient->post($runcloudDbUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserPost
        ]);
        $runcloudDbUserCode = $runCloudDbUserResponse->getStatusCode();
        $runcloudDbUserResult = $runCloudDbUserResponse->getBody()->getContents();
        $runcloudDbUserDetails = \GuzzleHttp\json_decode($runcloudDbUserResult);
        $dbUserId = $runcloudDbUserDetails->id;


        //ATTACH DATABASE USER TO DATABASE IN RUNCLOUD
        $runcloudDbUserAttachPost = array(
            "id"=> $dbUserId
        );
        $runcloudDbUserAttachUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases/'.$dbId.'/grant';
        $runCloudDbUserAttachResponse = $runcloudDbUserClient->post($runcloudDbUserAttachUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserAttachPost
        ]);
        $runcloudDbUserAttachCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudDbUserAttachResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudDbUserAttachDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);

        //SETUP WEBAPP GIT REPO IN RUNCLOUD
        $runcloudGitUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/'.$runcloudAppId.'/git';
        $runcloudGitPost = array(
            "provider"=> "gitlab",
            "repository"=> "icarative/cmspdf",
            "branch"=> "NoTenant"
        );

        $runCloudGitResponse = $runcloudGitClient->post($runcloudGitUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudGitPost
        ]);
        $runcloudGitCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudGitResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudGitDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);
        config(['remote.connections.runtime.server' => $runcloudServer->ip_address]);
        config(['remote.connections.runtime.user' => $runcloudServer->server_user]);
        config(['remote.connections.runtime.pass' => $runcloudServer->server_password]);


        $debugStatus = 'false';
        $envFile = 'cat > .env <<EOF
APP_NAME="'.$team->name.'"
APP_ENV=local
APP_KEY=base64:UInV/8MxloQNjf2IdXK2Nf0eYREgx02BxlA5AOHUPYA=
APP_DEBUG='.$debugStatus.'
APP_LOG_LEVEL=debug
APP_URL_BASE='.$appUrl.'
APP_URL='.$appUrl.'
DOC_BASE='.$appUrl.'

PORTAL_URL=https://portal.cmspdf.com

BRAND=logo.png

DB_CONNECTION=system
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='.$dbName.'
DB_USERNAME='.$dbUser.'
DB_PASSWORD='.$dbPassword.'

LIMIT_UUID_LENGTH_32=true

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
SENTRY_LARAVEL_DSN=https://fc26289b081e45f19e868b29c227e0dd@o439251.ingest.sentry.io/5405720

EOF
        ';
        $commands = [
            'cd webapps/'.$slug,
            $envFile,
        ];
        try {
            \SSH::into('runtime')->run($commands, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            dd($e->getMessage());
            echo $e->getMessage();
        }

        $commandsSecond = [
            'cd webapps/'.$slug,
            'composer install',
            'php artisan migrate',
            'php artisan storage:link'
        ];
        try {
            \SSH::into('runtime')->run($commandsSecond, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }
        $portStage = 'True';
        return view('port-setup', ['team'=>$team, 'input'=>$input]);
        //return Redirect()->back()->with($portStage)->with($input);
    }

    public function newSitePort2(Request $request)
    {
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $request->site_url.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tts000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;




//        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);
//
//        $tenantcode = $tenantresponse->getStatusCode();
//        $tenantresult = $tenantresponse->getBody()->getContents();
//
//        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::create([
            'fqdn' => $request->site_url.':'.$request->site_port,
            'historical_fqdn' => $request->site_url.':'.$request->site_port,
            'website_id' => $request->site_port,
            'creator' => 'System',
            'creator_email' => 'info@tartancms.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename,
            'site_url' => $request->site_url,
            'site_port' =>$request->site_port
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();
        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

//        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
//        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';
//
//        $countryresponse = $countryclient->get($countryurl);
//        $countrycode = $countryresponse->getStatusCode();
//        $countryresult = $countryresponse->getBody()->getContents();
//
//
//        $languageresponse = $languageclient->get($languageurl);
//        $languagecode = $languageresponse->getStatusCode();
//        $languageresult = $languageresponse->getBody()->getContents();
//
//

//
        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();
//        return Redirect::to('https://' . $tenantdetails->fqdn);
    }


    public function adjustEnv(Request $request)
    {
        $input = $request->all();

        $runcloudUserClient = new \GuzzleHttp\Client();
        $runcloudAppClient = new \GuzzleHttp\Client();
        $runcloudGitClient = new \GuzzleHttp\Client();
        $runcloudDbClient = new \GuzzleHttp\Client();
        $runcloudDbUserClient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $runcloudServer = RuncloudServer::where('id', $request->server_id)->first();
        $apiKey = $runcloudServer->api_key;
        $apiSecret = $runcloudServer->api_secret;

        $serverId = $runcloudServer->server_id;
        $username = $runcloudServer->server_user;
        $password = $runcloudServer->server_password;

        $runcloudUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/users';
        $runcloudAppUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/custom';
        $runcloudDbUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases';

        $team = Team::find($request->team_id);
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $team->name)));
        $dbslug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $team->name)));


        $siteUrl =
            //SETUP WEBAPP IN RUNCLOUD
        $appUrl = 'http://'.$request->site_url;

        $runcloudAppPost = array(
            "name"=> $slug,
            "domainName"=> $appUrl,
            "user"=> 282158,
            "publicPath"=> '/public',
            "phpVersion"=> "php74rc",
            "stack"=> "hybrid",
            "stackMode"=> "production",
            "clickjackingProtection"=> true,
            "xssProtection"=> true,
            "mimeSniffingProtection"=> true,
            "processManager"=> "ondemand",
            "processManagerMaxChildren"=> 50,
            "processManagerMaxRequests"=> 500,
            "timezone"=> "UTC",
            "disableFunctions"=> "",
            "maxExecutionTime"=> 600,
            "maxInputTime"=> 600,
            "maxInputVars"=> 1000,
            "memoryLimit"=> 256,
            "postMaxSize"=> 256,
            "uploadMaxFilesize"=> 256,
            "sessionGcMaxlifetime"=> 1440,
            "allowUrlFopen"=> true
        );

        $runCloudAppResponse = $runcloudAppClient->post($runcloudAppUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudAppPost
        ]);

        $runcloudAppCode = $runCloudAppResponse->getStatusCode();
        $runcloudAppResult = $runCloudAppResponse->getBody()->getContents();
        $runcloudAppDetails = \GuzzleHttp\json_decode($runcloudAppResult);

        $runcloudAppId = $runcloudAppDetails->id;
        $runcloudUserId = $runcloudAppDetails->server_user_id;

        //SETUP WEBAPP DATABASE IN RUNCLOUD
        $dbName = $dbslug.$runcloudAppId;
        $dbUser = $dbslug.$runcloudAppId.'dba';
        $dbPassword = uniqid();
        $runcloudDbPost = array(
            "name"=> $dbName
        );
        $runCloudDbResponse = $runcloudDbClient->post($runcloudDbUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbPost
        ]);
        $runcloudDbCode = $runCloudDbResponse->getStatusCode();
        $runcloudDbResult = $runCloudDbResponse->getBody()->getContents();
        $runcloudDbDetails = \GuzzleHttp\json_decode($runcloudDbResult);
        $dbId = $runcloudDbDetails->id;


        //SETUP WEBAPP DATABASE USER IN RUNCLOUD
        $runcloudDbUserPost = array(
            "username"=> $dbUser,
            "password"=> $dbPassword
        );
        $runcloudDbUserUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databaseusers';
        $runCloudDbUserResponse = $runcloudDbUserClient->post($runcloudDbUserUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserPost
        ]);
        $runcloudDbUserCode = $runCloudDbUserResponse->getStatusCode();
        $runcloudDbUserResult = $runCloudDbUserResponse->getBody()->getContents();
        $runcloudDbUserDetails = \GuzzleHttp\json_decode($runcloudDbUserResult);
        $dbUserId = $runcloudDbUserDetails->id;


        //ATTACH DATABASE USER TO DATABASE IN RUNCLOUD
        $runcloudDbUserAttachPost = array(
            "id"=> $dbUserId
        );
        $runcloudDbUserAttachUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/databases/'.$dbId.'/grant';
        $runCloudDbUserAttachResponse = $runcloudDbUserClient->post($runcloudDbUserAttachUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudDbUserAttachPost
        ]);
        $runcloudDbUserAttachCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudDbUserAttachResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudDbUserAttachDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);

        //SETUP WEBAPP GIT REPO IN RUNCLOUD
        $runcloudGitUrl = 'https://manage.runcloud.io/api/v2/servers/'.$serverId.'/webapps/'.$runcloudAppId.'/git';
        $runcloudGitPost = array(
            "provider"=> "github",
            "repository"=> "jeslabbert/tartan-cms",
            "branch"=> "NoTenant"
        );

        $runCloudGitResponse = $runcloudGitClient->post($runcloudGitUrl, [
            'auth' => [
                $apiKey,
                $apiSecret
            ],
            'form_params' => $runcloudGitPost
        ]);
        $runcloudGitCode = $runCloudDbUserAttachResponse->getStatusCode();
        $runcloudGitResult = $runCloudDbUserAttachResponse->getBody()->getContents();
        $runCloudGitDetails = \GuzzleHttp\json_decode($runcloudDbUserAttachResult);



        $debugStatus = 'false';
        $envFile = 'cat > .env <<EOF
APP_NAME="'.$team->name.'"
APP_ENV=local
APP_KEY=base64:UInV/8MxloQNjf2IdXK2Nf0eYREgx02BxlA5AOHUPYA=
APP_DEBUG='.$debugStatus.'
APP_LOG_LEVEL=debug
APP_URL_BASE='.$appUrl.'
APP_URL='.$appUrl.'
DOC_BASE='.$appUrl.'

PORTAL_URL=https://portal.cmspdf.com

BRAND=logo.png

DB_CONNECTION=system
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE='.$dbName.'
DB_USERNAME='.$dbUser.'
DB_PASSWORD='.$dbPassword.'

LIMIT_UUID_LENGTH_32=true

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
SENTRY_LARAVEL_DSN=https://fc26289b081e45f19e868b29c227e0dd@o439251.ingest.sentry.io/5405720

EOF
        ';
        $commands = [
            'cd webapps/'.$slug,
            $envFile,
        ];
        try {
            \SSH::into('cmspdfcloud')->run($commands, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }

        $commandsSecond = [
            'cd webapps/'.$slug,
            'composer install',
            'php artisan migrate',
            'php artisan storage:link'
        ];
        try {
            \SSH::into('cmspdfcloud')->run($commandsSecond, function($line)
            {
//                echo $line.PHP_EOL;
            });
        } catch (\ErrorException $e) {
            echo $e->getMessage();
        }


        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $appUrl.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = $appUrl;
        $body['sitename'] = $team->name;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;

        $teamsite = TeamSite::create([
            'fqdn' => $appUrl,
            'historical_fqdn' => $appUrl,
            'website_id' => $runcloudAppId,
            'creator' => 'System',
            'creator_email' => 'info@cmspdf.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();

        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';

        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();

    }

    public function newsite(Request $request)
    {
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = \config('tenancy.url').'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tts000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;









        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::create([
            'fqdn' => $tenantdetails->fqdn,
            'historical_fqdn' => $tenantdetails->fqdn,
            'website_id' => $tenantdetails->website_id,
            'creator' => 'System',
            'creator_email' => 'info@taskmule.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();
        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

//        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
//        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = 'https://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'https://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'https://' . $teamsite->fqdn . '/api/v1/siteparams';
//
//        $countryresponse = $countryclient->get($countryurl);
//        $countrycode = $countryresponse->getStatusCode();
//        $countryresult = $countryresponse->getBody()->getContents();
//
//
//        $languageresponse = $languageclient->get($languageurl);
//        $languagecode = $languageresponse->getStatusCode();
//        $languageresult = $languageresponse->getBody()->getContents();
//
//

//
        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();
//        return Redirect::to('https://' . $tenantdetails->fqdn);
    }

    public function siteHttpsUpdate(Request $request)
    {
        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
            'https' => $request->https
        ]);
        return Redirect()->back();
    }
    public function newsiteNonTenantPort(Request $request)
    {
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $request->site_url.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tts000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;




//        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);
//
//        $tenantcode = $tenantresponse->getStatusCode();
//        $tenantresult = $tenantresponse->getBody()->getContents();
//
//        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::create([
            'fqdn' => $request->site_url.':'.$request->site_port,
            'historical_fqdn' => $request->site_url.':'.$request->site_port,
            'website_id' => $request->site_port,
            'creator' => 'System',
            'creator_email' => 'info@tartancms.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename,
            'site_url' => $request->site_url,
            'site_port' =>$request->site_port
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();
        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

//        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
//        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';
//
//        $countryresponse = $countryclient->get($countryurl);
//        $countrycode = $countryresponse->getStatusCode();
//        $countryresult = $countryresponse->getBody()->getContents();
//
//
//        $languageresponse = $languageclient->get($languageurl);
//        $languagecode = $languageresponse->getStatusCode();
//        $languageresult = $languageresponse->getBody()->getContents();
//
//

//
        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();
//        return Redirect::to('https://' . $tenantdetails->fqdn);
    }
    public function newsiteNonTenant(Request $request)
    {
        $input = $request->all();

        $tenantclient = new \GuzzleHttp\Client();
        $countryclient = new \GuzzleHttp\Client();
        $languageclient = new \GuzzleHttp\Client();
        $setupclient = new \GuzzleHttp\Client();
        $userclient = new \GuzzleHttp\Client();
        $siteclient = new \GuzzleHttp\Client();

        $tenanturl = $request->site_url.'/api/v1/sites/create';

        $body['_token'] = $request->_token;
        $body['subname'] = 'tts000' . $request->subname;
        $body['sitename'] = $request->sitename;
        $body['language_id'] = 1;
        $body['themename'] = $request->themename;
        $body['publicregistration'] = $request->publicregistration;
        $body['first_name'] = Auth::user()->name;
        $body['last_name'] = Auth::user()->last_name;
        $body['username'] = Auth::user()->username;
        $body['email'] = Auth::user()->email;
        $body['password'] = Auth::user()->password;

        $rnd = mt_rand(100000, 999999);


//        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);
//
//        $tenantcode = $tenantresponse->getStatusCode();
//        $tenantresult = $tenantresponse->getBody()->getContents();
//
//        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::create([
            'fqdn' => $request->site_url,
            'historical_fqdn' => $request->site_url,
            'website_id' => $rnd,
            'creator' => 'System',
            'creator_email' => 'info@tartancms.com',
            'team_id' => $request->team_id,
            'tenant_sitename' =>$request->sitename,
            'site_url' => $request->site_url,
            'site_port' =>$request->site_port
        ]);

        $comm1set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Consultant')->first();
        $comm2set = Setting::where('setting_type', 'Commission')->where('setting_name', 'Marketing')->first();
        $comm3set = Setting::where('setting_type', 'Commission')->where('setting_name', 'IT Support')->first();
        $globalset = Setting::where('setting_type', 'Commission')->where('setting_name', 'Global Commission')->first();

        $teamglobalcomm = GlobalCommission::create([
            'team_id' => $request->team_id,
            'comm1' => $comm1set->setting_value,
            'comm2' => $comm2set->setting_value,
            'comm3' => $comm3set->setting_value,
            'global_commission' => $globalset->setting_value
        ]);
        $team = Team::where('id', $request->team_id)->first();
        TeamCommission::create([
            'team_id'=>$request->team_id,
            'first_name'=>'Support',
            'first_user_id'=>$team->owner_id,
            'first_split'=>50,
            'second_name'=>'Sales',
            'second_split'=>50,
            'second_user_id'=>$team->owner_id,
        ]);

//        $countryurl = $teamsite->fqdn . '/api/v1/countrysetup';
//        $languageurl = $teamsite->fqdn . '/api/v1/languagesetup';
        $setupurl = 'http://' . $teamsite->fqdn . '/api/v1/setup';
        $userurl = 'http://' . $teamsite->fqdn . '/api/v1/newadmin';
        $siteurl = 'http://' . $teamsite->fqdn . '/api/v1/siteparams';
//
//        $countryresponse = $countryclient->get($countryurl);
//        $countrycode = $countryresponse->getStatusCode();
//        $countryresult = $countryresponse->getBody()->getContents();
//
//
//        $languageresponse = $languageclient->get($languageurl);
//        $languagecode = $languageresponse->getStatusCode();
//        $languageresult = $languageresponse->getBody()->getContents();
//
//

//
        $siteresponse = $siteclient->post($siteurl, ['form_params' => $body ]);
        $sitecode = $siteresponse->getStatusCode();
        $siteresult = $siteresponse->getBody()->getContents();

        $userresponse = $userclient->post($userurl, ['form_params' => $body ]);
        $usercode = $userresponse->getStatusCode();
        $userresult = $userresponse->getBody()->getContents();
        $userdetails = \GuzzleHttp\json_decode($userresult);

        $setupresponse = $setupclient->get($setupurl, ['form_params' => $body ]);
        $setupcode = $setupresponse->getStatusCode();
        $setupresult = $setupresponse->getBody()->getContents();

        return Redirect()->back();
//        return Redirect::to('https://' . $tenantdetails->fqdn);
    }

    public function updatesite(Request $request)
    {
        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = \config('tenancy.url').'/api/v1/sites/update';

        $body['_token'] = $request->_token;
        $body['domainname'] = $request->domainname;
        $body['site_id'] = $request->website_id;
        $body['sitename'] = $request->websitename;

        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->update([
            'fqdn' => $tenantdetails
        ]);

        return redirect;
    }

    public function updatesitename(Request $request)
    {


        $tenantclient = new \GuzzleHttp\Client();

        $tenanturl = $request->website . '/api/v1/name/update';

        $body['sitename'] = $request->websitename;


        $tenantresponse = $tenantclient->post($tenanturl, ['form_params' => $body ]);

        $tenantcode = $tenantresponse->getStatusCode();
        $tenantresult = $tenantresponse->getBody()->getContents();

        $tenantdetails = \GuzzleHttp\json_decode($tenantresult);

        $teamsite = TeamSite::where('website_id', $request->website_id)->first()->update([
            'tenant_sitename' => $request->websitename
        ]);

        return redirect($request->website .'/admin/whitelabelling');
    }

}
