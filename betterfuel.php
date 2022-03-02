
	<div id='fuelMain'>
		<div class='row p-2 bg-light text-center'>
		 <div class='col-6 p-2'><span class='s-text exo'>Current price</span><br><span class='text-danger'><b>$ 1,350</b></span></div>
		 <div class='col-6 p-2'><span class='s-text exo'>Price change</span><br><span id='fuelTimer'></span></div>
		 <div class='col-6 p-2'><span class='s-text exo'>Capacity</span><br><span id='remCapacity'>8,961,013</span> / <span class='s-text'>9,000,000 Lbs</span></div>
		 <div class='col-6 p-2'><span class='s-text exo'>Holding</span><br><span id='holding' class='font-weight-bold'>38,987</span> Lbs</div>

		 <!--<div class='col-sm-12 p-2'><div id='slider'></div></div>-->
		 <div class='col-sm-6 p-2 font-weight-bold'><span class='m-text exo'>Total price</span><br><b class='text-danger'>$<span id='sumCost'>1,350</span></b></div>
		 <div class='col-sm-6 p-2 font-weight-bold'><span class='m-text exo'>Amount to purchase</span><br><input type='tel' class='form-control form-control-sm text-center' id='amountInput' value='1000' placeholder='Amount to purchase'></div>
		 <div class='col-sm-12 p-2'>
			
		
			<div class="btn-group d-flex" role="group">
				<button class="btn btn-xs btn-primary w-100" onClick="popup('bonus.php?high=tanks','Bonus');">Increase capacity</button>
				<button class='btn btn-danger btn-xs btn-block w-100 ' onClick="Ajax('fuel.php?mode=do&amount='+$('#amountInput').val(),'runme',this);"><span class='glyphicons glyphicons-usd'></span> Purchase</button>
			</div>
			
		 </div>
		 <div class='col-12 p-2'><div id='fuelChart' style='width:100%;height:200px;'></div></div>
		</div>
	</div>

	<script>
		popMenu({
		buttons: {Fuel: ['fuel.php?m=nonav','fuelMain',true,'gas-station'],Co2: ['co2.php','fuelMain',false,'leaf']}
	});
		
	$("#amountInput").inputFilter(function(value) {
		return /^\d*$/.test(value);
	});

	$('#fuelTimer').countdown({
		until: 1226,
		compact: true,
		onExpiry: function() {
			if($('#fuelMain').is(':visible')){
				popup('fuel.php','Fuel Market');
			}
		}
	});
	$('#amountInput').on('keyup',function() {
		var val = $(this).val();
		if(val>8961013) {
			val = 8961013;
			$(this).val(val);
		}
		var cost = val*.75;
		$('#sumAmount').html(number_format(val));
		$('#sumCost').html(number_format(cost));
	});

	fuel_startFuelChart([1230,900,790,360,1040,1370,1830,2470,2130,1350],['09:00:00','09:30:00','10:00:00','10:30:00','11:00:00','11:30:00','12:00:00','12:30:00','13:00:00','13:30:00']);


	function fuel_startFuelChart(priceArray,timeArray) {
		Highcharts.chart('fuelChart', {
			title: {
				text: 'Fuel price per 1,000 Lbs'
			},
			yAxis: {
				title: {
					text: 'Jet A1 cost'
				}
			},
			tooltip: {
				valueDecimals: 2,
				valuePrefix: '$'
			},
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			legend: {
				enabled: false
			},
			xAxis: {
				categories: timeArray
			},
			plotOptions: {
				area: {
					fillColor: {
						linearGradient: {
							x1: 0,
							y1: 0,
							x2: 0,
							y2: 1
						},
						stops: [
							[0, Highcharts.getOptions().colors[0]],
							[1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
						]
					},
					marker: {
						radius: 2
					},
					lineWidth: 1,
					states: {
						hover: {
							lineWidth: 1
						}
					},
					threshold: null
				}
			},
			series: [{
				type: 'area',
				name: 'Cost',
				data: priceArray
			}]
		});
	}
	</script>
