 <?php
function calc_time_taken()

{
include 'connect-db.php';
$today = strtotime("now");
$time = new DateTime(date("Y-m-d H:i:s", $today));
//echo date("Y-m-d H:i:s", $today) . "<br>";
$T_val = $time->format('Y-m-d H:i:s');
$result = $conn->query("SELECT * FROM ".$DB_table_R." WHERE choose_time<end_date AND end_date<'$T_val'");
$x = 0;
while($row = $result->fetch_assoc()) {
$start = $row['choose_time'];
$end = $row['end_date'];
 
//Convert them to timestamps.
$date1Timestamp = strtotime($start);
$date2Timestamp = strtotime($end);
 
//Calculate the difference.
$difference = $date2Timestamp - $date1Timestamp;
$total = $total + $difference;
$x++;
}
$average = $total/$x;
return round($average);
}
?>
