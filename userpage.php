 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<?php
if (isset($_GET['id']) && is_numeric($_GET['id']))

{

// get id value

$id = $_GET['id'];
}
$page = $_SERVER['PHP_SELF']."?id=".$id;
$sec = "5";
?>
<html lang="lt"> 
<head> 
<meta charset="UTF-8">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8">
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<script>
function startTime() {
    var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;
	var yyyy = today.getFullYear();
	if(dd<10){
		dd='0'+dd;
	} 
	if(mm<10){
		mm='0'+mm;
	} 
	var today2 = yyyy+'-'+mm+'-'+dd;
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
	document.getElementById("DATE").innerHTML = today2;
    document.getElementById('txt').innerHTML =
    h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
</script>
<title>Registration successful</title> 
<style>
 </style>
 <link rel="stylesheet" href="list.css">
</head> 
<body onload="startTime()">
<div class="container">
<table id="header" >
<tr>
<th></th>
<th><div class="top"><div id="DATE" style="font-size:30px;"></div></div>
<div class="bot"><div id="txt" style="font-size:35px;"></div></div></th>
<th><div  style="font-size:30px;">Registration successful</div></th>
<th></th>
</tr>
</table>
</div>
<table id="sarasas" >
<hr></hr>
<tr> <th>User</th> <th>RegNr</th> <th>Apointment Time</th> </tr>
<?php

include 'connect-db.php';
if (isset($_GET['id']) && is_numeric($_GET['id']))

{

// get id value

$id = $_GET['id'];
$today = strtotime("now");
//echo date("Y-m-d H:i:s", $today) . "<br>";
$result = $conn->query("SELECT * FROM ".$DB_table_R."
RIGHT JOIN ".$DB_table_U." ON ".$DB_table_R.".usr_id = ".$DB_table_U.".id_U ORDER BY ".$DB_table_R.".start_date ASC LIMIT 30");
$j = 0;
while($row = $result->fetch_assoc()) {
if($row['choose_time']>=$row['end_date'])
{
if($row['id_R']  == $id){
echo "<tr>";

echo '<td>' . $row['Name'] .' '. $row['Surname']. '</td>';

echo '<td>' . $row['RegNr']. '</td>';

$time = new DateTime(date("Y-m-d H:i:s", $today));

if($j>0){
$num = 10*$j;
$interval = 'PT'.$num.'M';
$time->add(new DateInterval($interval));
}

echo '<td>' . $time->format('Y-m-d H:i'). '</td>';

echo "</tr>";
}
$j++;
}
}
}
?>
</table>
</body> 
</html> 

