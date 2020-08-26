<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600' rel='stylesheet' type='text/css'>

    <style>
        body, html {
            background-color: #025980;
            background-repeat: repeat;
            background-size: 300px 200px;
            height: 100%;
            margin: 0;
        }

        .full-height {
            min-height: 100%;
        }

        .flex-column {
            display: flex;
            flex-direction: column;
        }

        .flex-fill {
            flex: 1;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }


        .text-center {
            text-align: center;
        }

        .links {
            padding: 1em;
            text-align: right;
        }

        .links a {
            text-decoration: none;
        }

        .links button {
            background-color: #3097D1;
            border: 0;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-family: 'Open Sans';
            font-size: 14px;
            font-weight: 600;
            padding: 15px;
            text-transform: uppercase;
            width: 100px;
        }
    </style>
</head>
<body>
    <div class="full-height flex-column">


        <div class="flex-fill flex-center">
            <div>
            <h1 class="text-center">
                Port Setup Step 2
            </h1>
<h2>Save the text on this page, it will not be shown again!</h2>
            <p>Please log in to your RunCloud account and access the web app you have just created, then follow these steps:</p>
        <ol>
            <li>
                Select Settings
            </li>
            <li>
                Change Web Application Stack to Native NGINX and then save
            </li>
            <li>
                Select NGINX Config
            </li>
            <li>Click on Create New Config</li>
            <li>Choose leave predefined as 'I want to create my own config' and choose location.http as the type</li>
            <li>In the config name section, type in {{$input['slug']}}</li>
            <li>
                Once this is done, under Config Content add the following<br/>

            <code>
                server {<br/>
                listen          {{$input['site_port']}} ;<br/>
                listen          [::]:{{$input['site_port']}} ;<br/>
                include /etc/nginx-rc/conf.d/{{$input['slug']}}.d/main.conf;<br/>

                # Redirect request to https<br/>
                if ($scheme = http) {<br/>
                # DO NOT REDIRECT TO HTTPS"<br/>
                }<br/>
                }<br/>
            </code>
            </li>
            <li>After this, go back to the server settings, click on Security</li>
            <li>Under Security, add a firewall rule.</li>
            <li>Leave the type as Globally Open Port and change Port to {{$input['site_port']}}</li>
            <li>Save this rule, then click on deploy.</li>
            <li>Once complete, click on 'Finalize Site' below to finalize installation.</li>

        </ol>
            <form class="form-horizontal" method="POST" action="/runcloud/setup/port2">
                {{ csrf_field() }}
                <input id="team_id" type="hidden" class="form-control" name="team_id" value="{{$team->id}}" required autofocus>
                <input id="subname" type="hidden" class="form-control" name="subname" value="{{$team->id}}" required autofocus>
                <input id="sitename" type="hidden" class="form-control" name="sitename" value="{{$team->name}}" required autofocus>
                <input id="siteurl" type="hidden" class="form-control" name="site_url" value="{{$input['site_url']}}">
                <input id="siteport" type="hidden"  class="form-control" name="site_port" value="{{$input['site_port']}}">
                <div class="text-center">
                    <button class="btn btn-success" data-toggle="tooltip" title="Finalize Site}">Finalize Site</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</body>
</html>
