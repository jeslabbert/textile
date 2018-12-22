@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{__('Dashboard')}}</div>

                    <div class="card-body">
                        {{__('Your application\'s dashboard.')}}
                        <div class="commChartDiv">
                            <canvas id="commChart" width="600" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>

@endsection
@section('addscripts')

    <script src="https://npmcdn.com/chart.js@latest/dist/Chart.bundle.min.js"></script>
    <script>

        // set default to straight lines - no curves
        // Chart.defaults.global.elements.line.tension = 0;
        // set default no fill beneath the line
        Chart.defaults.global.elements.line.fill = false;

        // stacked bar with 2 unstacked lines - nope
        var barChartData = {
            labels: {!! $billingPeriods !!},
            datasets: [{
                type: 'bar',
                label: 'Commission',
                yAxisID: "y-axis-0",
                backgroundColor: "rgba(217,83,79,0.75)",
                data: {!! $settledComm !!}
            },
                {{--{--}}
                {{--type: 'bar',--}}
                {{--label: 'Pending',--}}
                {{--yAxisID: "y-axis-0",--}}
                {{--backgroundColor: "rgba(92,184,92,0.75)",--}}
                {{--data: {!! $unsettledComm !!}--}}
            {{--},--}}
                {
                type: 'line',
                label: 'Sites',
                yAxisID: "y-axis-1",
                borderColor:"rgba(0, 156, 234,1)",
                backgroundColor: "rgba(0, 156, 234,1)",
                data: {!! $teamPeriods !!}
            }]
        };


        var ctx = document.getElementById("commChart");
        // allocate and initialize a chart
        var ch = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                title: {
                    display: true,
                    text: "Monthly Earnings"
                },
                tooltips: {
                    mode: 'label'
                },
                responsive: true,
                scales: {

                    xAxes: [{
                        stacked: true
                    }],
                    yAxes: [{
                        scaleBeginAtZero : true,
                        ticks: {
                            beginAtZero: true
                        },
                        stacked: true,
                        position: "left",
                        id: "y-axis-0",
                    }, {
                        scaleBeginAtZero : true,
                        ticks: {
                            beginAtZero: true
                        },
                        stacked: false,
                        position: "right",
                        id: "y-axis-1",
                    },

                    ]
                }
            }
        });
    </script>

    @endsection