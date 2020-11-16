@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{__('Dashboard')}} V1</div>

                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="commission-tab" data-toggle="tab" href="#commission" role="tab" aria-controls="home" aria-selected="true">Commission</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="billing-tab" data-toggle="tab" href="#billing" role="tab" aria-controls="profile" aria-selected="false">Billing</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="commission" role="tabpanel" aria-labelledby="home-tab"><canvas id="commChart" width="600" height="400"></canvas></div>
                            <div class="tab-pane fade" id="billing" role="tabpanel" aria-labelledby="profile-tab"><canvas id="invoiceChart" width="600" height="400"></canvas></div>
                        </div>

                        <div class="commChartDiv">

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
                            suggestedMax: 10,
                            steps: 10,
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

        var billingChartData = {
            labels: {!! $billingPeriods !!},
            datasets: [{
                type: 'bar',
                label: 'Paid Invoices',
                yAxisID: "y-axis-0",
                backgroundColor: "rgba(217,83,79,0.75)",
                data: {!! $setInvoiceValues !!}
            },
                    {
                    type: 'bar',
                    label: 'Pending Invoices',
                    yAxisID: "y-axis-0",
                    backgroundColor: "rgba(92,184,92,0.75)",
                    data: {!! $unsetInvoiceValues !!}
                    },
                {
                    type: 'line',
                    label: 'Sites',
                    yAxisID: "y-axis-1",
                    borderColor:"rgba(0, 156, 234,1)",
                    backgroundColor: "rgba(0, 156, 234,1)",
                    data: {!! $teamPeriods !!}
                }]
        };


        var invctx = document.getElementById("invoiceChart");
        // allocate and initialize a chart
        var invch = new Chart(invctx, {
            type: 'bar',
            data: billingChartData,
            options: {
                title: {
                    display: true,
                    text: "Monthly Invoices"
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
                            suggestedMax: 10,
                            steps: 10,
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