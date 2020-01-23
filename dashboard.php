<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
		<script src="charts.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet", type="text/css", href="./css/dashboard.css">
		<script>
			function load_page(page){
			$('#frame').load(page);
			}
			function load_chart(page)
			{
				$('#frame').html("<canvas id='myChart'></canvas>");
				$.ajax({
					url:page,
					complete: function (response) {
						var result = JSON.parse(response.responseText);
						var color=[];
						for (var i in result.data) {
            color.push(dynamicColors());
         		}
						var ctx = document.getElementById("myChart").getContext('2d');
						var myChart = new Chart(ctx, {

							type: 'pie',
							data: {
								labels: result.labels,
								datasets: [{
									backgroundColor: color,
									data: result.data
								}]
							},
							options:{
								hover: {
									onHover: function(e,a) {
									 /* $("#canvas1").css("cursor", e[0] ? "pointer" : "default");

										 without jquery it can be like this:*/
											var el = document.getElementById("myChart");
											el.style.cursor = a[0] ? "pointer" : "default";

									}
								},
								plugins:{
									datalabels:{
										labels: {
																value: {
																		color: 'red',
																		font:{size: '20'}
																}
														}
									}
								},
								onClick: function(evt){
									var activePoint = myChart.getElementsAtEvent(evt);
									var selectedIndex = activePoint[0]._index;
									var label = this.data.labels[selectedIndex];
									var value = this.data.datasets[0].data[selectedIndex];
									window.open("report.php?index="+label,"_blank");
								}
							}
						});
					},
					error: function () {
					 $('#myChart').html('Bummer: there was an error!');
				 },
				});
			}
			function dynamicColors() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
}
		</script>
	</head>
	<body onload="load_page('view.php')">
		<?php
			session_start();
			$desig = $_SESSION['desig'];
		?>
		<div class="header">
			<img src="./img/UPES_Logo.png" alt="www.upes.ac.in" width="20%" height="24%">
		</div>
		<div class="row menu">
			<div class="col-1">
				<ul>
					<li style="float:left;color:white"><?php echo $_SESSION['sapid'] ?></li>
					<a style = "float:right; color:white;  margin-bottom: 7px; padding: 8px" href="login.php" class="button">Logout</a>
				</ul>
			</div>
		</div>
		<div class="row menu">
			<div class="col-2">
			<ul>
					<li><a href="#" onclick="load_page('view.php')">View</a></li>
					<li><a href="#" onclick="load_page('edit.php')">Edit</a></li>
					<li><a href="#" onclick="load_chart('chart.php')">Report</a></li>
					<?php
					if($desig=="Manager")
					{
					?>
					<li><a href="#" onclick="load_page('report_chart.php?tab=tr')">Team Report</a></li>
					<?php
					}
					if($desig=="Administrator")
					{
					?>
					<li><a href="#" onclick="load_page('status.php?tab=ad')">Status Review</a></li>
					<li><a href="#" onclick="load_page('status.php?tab=ad')">Overall Report</a></li>
					<?php
					}
					?>
			</ul>
			</div>
			<div class="col-3" id="frame">

			</div>
		</div>
	</body>
</html>
