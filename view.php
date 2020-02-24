<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<h3 style = "color:blue">List of Publications indexed in SCOPUS & above</h3>
		<?php
			require('connection.php');
			session_start();
			$count=0;
			$sap_id = $_SESSION['sapid'];
			$query = "SELECT * FROM journal WHERE sap_id = $sap_id AND remarks = \"Completed\"";
			$result = mysqli_query($db,$query);
			if(!$result)
			{
				die("Unable to connect");
			}
			if(mysqli_num_rows($result)>0)
			{
		?>
		<table style = "border:none">
			<tr>
				<th>S.NO.</th>
				<th>TITLE</th>
				<th>OTHER AUTHORS</th>
				<th>MONTH</th>
				<th>YEAR</th>
				<th></th>
			</tr>
			<?php
				while($row = mysqli_fetch_assoc($result))
				{
					$count++;
					echo "<tr>";
						echo "<td width = \"5%\" align = \"center\">".$count."</td>";
						echo "<td width = \"40%\">".$row['title']."</td>";
						echo "<td width = \"25%\">".$row['authors']."</td>";
						echo "<td width = \"10%\" align = \"center\">".$row['month']."</td>";
						echo "<td width = \"10%\" align = \"center\">".$row['year']."</td>";
						echo "<td width = \"10%\"><a href=\"details.php?title=".$row['title']."\" target = \"_blank\">view details</a></td>";
					echo "</tr>";
				}

			?>
		</table>
		<?php
			}
			else
			{
				echo "<h4>You don't have any publication in this category!</h4>";
			}
		?>
		<h3 style = "color:red">*Pending List of Publications</h3>
		<?php
			$query = "SELECT * FROM data WHERE sap_id = $sap_id AND remarks = \"Pending\"";
			$result = mysqli_query($db,$query);
			$count = 0;
			if(!$result)
			{
				die("Unable to connect");
			}
			if(mysqli_num_rows($result)>0)
			{
		?>
		<table style = "border:none">
			<tr>
				<th>S.NO.</th>
				<th>TITLE</th>
				<th>OTHER AUTHORS</th>
				<th>MONTH</th>
				<th>YEAR</th>
				<th></th>
			</tr>
			<?php
				while($row = mysqli_fetch_assoc($result))
				{
					$count++;
					echo "<tr>";
						echo "<td width = \"5%\" align = \"center\">".$count."</td>";
						echo "<td width = \"40%\">".$row['title']."</td>";
						echo "<td width = \"25%\">".$row['authors']."</td>";
						echo "<td width = \"10%\" align = \"center\">".$row['month']."</td>";
						echo "<td width = \"10%\" align = \"center\">".$row['year']."</td>";
						echo "<td width = \"10%\"><a href=\"details.php?title=".$row['title']."\" target = \"_blank\">view details</a></td>";
					echo "</tr>";
				}
			?>
		</table>
		<?php
			}
			else
			{
				echo "<h4 style = \"color:blue\">You don't have any publication in this category!</h4>";
			}
		?>
	</body>
</html>
