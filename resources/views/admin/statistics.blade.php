@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">{{ __('Statistics') }}</div>
                <div class="card-body">
                
					<div class="row">
						<div class="col-md-3 p-3 d-flex">
							<button class="btn btn-primary mx-auto w-100" id="basicstatistics-btn" onclick="showBasicStatistics({{$nonrenteq}}, {{$renteq}})">Show basic statistics</button>
						</div>
						<div class="col-md-3 p-3 d-flex">
							<button class="btn btn-primary mx-auto w-100" id="rentedtatistics-btn" onclick="showRentedStatistics({{$rentedEq}}, {{$nonRentedEq}})">Show rented statistics</button>
						</div>
						<div class="col-md-3 p-3 d-flex">
							<button class="btn btn-primary mx-auto w-100" id="mostrenteditems-btn" onclick="showMostRentedStatistics({{json_encode($mostRentedItems)}}, {{json_encode($mostRentedItemsNuber)}})">Show most rented items</button>
						</div>
						<div class="col-md-3 p-3 d-flex">
							<button class="btn btn-primary mx-auto w-100" id="mostreningusers-btn" onclick="showMostRentingUsers({{json_encode($mostRentingUser)}}, {{json_encode($mostRentingUserNumber)}})">Show most renting users</button>
						</div>
					</div>

                    <div class="col-md-12 chart-container" id="basicstatistics-container">
                    

                    </div>

                    <div class="col-md-12 chart-container" id="rentedstatistics-container">
                    

                    </div>

					<div class="col-md-12 chart-container" id="mostrenteditems-container">
                    

					</div>

					<div class="col-md-12 chart-container" id="mostrentingusers-container">
                    
						

					</div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">

function showBasicStatistics(stat1, stat2){

	$("#basicstatistics-container").append('<canvas class="animated fadeIn" id="basicstatistics" width="200" height="200"></canvas>');

	if($('#basicstatistics-btn').hasClass('btn-primary')){
		$('#basicstatistics-btn').removeClass('btn-primary');
		$('#basicstatistics-btn').addClass('btn-secondary');

		$('#basicstatistics-container').removeClass('chart-container').addClass('chart-container-active');

		var ctx = document.getElementById('basicstatistics').getContext("2d");

		var basicstatisticschart = new Chart(ctx, {

			type:'bar',
			data:{
				labels: ['Non-renting equipment', 'Renting equipment'],
				datasets: [{
					label:'Number of corresponding equipment',
					data: [stat1, stat2],
					backgroundColor:[
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						],
					borderColor:[
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}

		});
	}
	else{
		$('#basicstatistics-btn').addClass('btn-primary');
		$('#basicstatistics-btn').removeClass('btn-secondary');

		$('#basicstatistics-container').addClass('chart-container').removeClass('chart-container-active');

		$("canvas#basicstatistics").remove();
	}

		

}

function showRentedStatistics(stat1, stat2){

	$("#rentedstatistics-container").append('<canvas class="animated fadeIn" id="rentedstatistics" width="200" height="200"></canvas>');

	if($('#rentedtatistics-btn').hasClass('btn-primary')){
		$('#rentedtatistics-btn').removeClass('btn-primary');
		$('#rentedtatistics-btn').addClass('btn-secondary');

		$('#rentedstatistics-container').removeClass('chart-container').addClass('chart-container-active');

		var ctx = document.getElementById('rentedstatistics').getContext("2d");

		var basicstatisticschart = new Chart(ctx, {

			type:'bar',
			data:{
				labels: ['Rented equipment', 'Avalible rented equipment'],
				datasets: [{
					label:'Number of corresponding equipment',
					data: [stat1, stat2],
					backgroundColor:[
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						],
					borderColor:[
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}

		});
	}
	else{
		$('#rentedtatistics-btn').addClass('btn-primary');
		$('#rentedtatistics-btn').removeClass('btn-secondary');

		$('#rentedstatistics-container').addClass('chart-container').removeClass('chart-container-active');

		$("canvas#rentedstatistics").remove();
	}

}

function showMostRentedStatistics(arr1, arr2){

	$("#mostrenteditems-container").append('<canvas class="animated fadeIn" id="mostrenteditems" width="200" height="200"></canvas>');

	if($('#mostrenteditems-btn').hasClass('btn-primary')){
		$('#mostrenteditems-btn').removeClass('btn-primary');
		$('#mostrenteditems-btn').addClass('btn-secondary');

		$('#mostrenteditems-container').removeClass('chart-container').addClass('chart-container-active');

		var ctx = document.getElementById('mostrenteditems').getContext("2d");

		var basicstatisticschart = new Chart(ctx, {
			type:'bar',
			data:{
				labels: [arr1[0], arr1[1], arr1[2], arr1[3], arr1[4]],
				datasets: [{
					label:'',
					data: [arr2[0], arr2[1], arr2[2], arr2[3], arr2[4]],
					backgroundColor:[
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						],
					borderColor:[
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}

		});

	}
	else{
		$('#mostrenteditems-btn').addClass('btn-primary');
		$('#mostrenteditems-btn').removeClass('btn-secondary');

		$('#mostrenteditems-container').addClass('chart-container').removeClass('chart-container-active');

		$("canvas#mostrenteditems").remove();
	}

}

function showMostRentingUsers(arr1, arr2){
	$("#mostrentingusers-container").append('<canvas class="animated fadeIn" id="mostrentingusers" width="200" height="200"></canvas>');

	if($('#mostreningusers-btn').hasClass('btn-primary')){
		$('#mostreningusers-btn').removeClass('btn-primary');
		$('#mostreningusers-btn').addClass('btn-secondary');

		$('#mostrentingusers-container').removeClass('chart-container').addClass('chart-container-active');

		var ctx = document.getElementById('mostrentingusers').getContext("2d");

		var basicstatisticschart = new Chart(ctx, {
			type:'bar',
			data:{
				labels: [arr1[0], arr1[1], arr1[2], arr1[3], arr1[4]],
				datasets: [{
					label:'',
					data: [arr2[0], arr2[1], arr2[2], arr2[3], arr2[4]],
					backgroundColor:[
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						],
					borderColor:[
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}

		});

	}
	else{
		$('#mostreningusers-btn').addClass('btn-primary');
		$('#mostreningusers-btn').removeClass('btn-secondary');

		$('#mostrentingusers-container').addClass('chart-container').removeClass('chart-container-active');

		$("canvas#mostrentingusers").remove();
	}
}


</script>

@endsection