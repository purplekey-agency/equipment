@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="row">
                    <a href="/dashboard/equipment/add" class="py-3 mx-auto">
                        <div class="btn btn-primary">
                            {{ __('Print report') }}
                        </div>
                    </a>
                </div>

                <div class="card-header">{{ __('Statistics') }}</div>
                <div class="card-body">
                

                    <div class="col-md-12 chart-container" id="general-chart">
                    
                    <canvas id="myChart" width="400" height="400"></canvas>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">


var MONTHS = ['January', 'February'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['January', 'February'],
			datasets: [{
				label: 'Dataset 1',
				backgroundColor: color("red").alpha(0.5).rgbString(),
				borderColor: "red",
				borderWidth: 1,
				data: [
                    10,
				]
			}, {
				label: 'Dataset 2',
				backgroundColor: color("blue").alpha(0.5).rgbString(),
				borderColor: "blue",
				borderWidth: 1,
				data: [
                    10,
				]
			}]

		};

		window.onload = function() {
			var ctx = document.getElementById('myChart').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					title: {
						display: true,
						text: 'Chart.js Bar Chart'
					}
				}
			});

		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			var zero = Math.random() < 0.2 ? true : false;
			barChartData.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return zero ? 0.0 : randomScalingFactor();
				});

			});
			window.myBar.update();
		});


</script>

@endsection