 <?php
function calc_time_taken()

{
$average = 0;
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
if($average>0){
return round($average);
}
else{return 300;}
}
function delay_reg($id)
{
include 'connect-db.php';
$today = strtotime("now");
//echo date("Y-m-d H:i:s", $today) . "<br>";
$result = $conn->query("SELECT * FROM ".$DB_table_R."
RIGHT JOIN ".$DB_table_U." ON usr_id = ".$DB_table_U.".id_U ORDER BY choose_time DESC LIMIT 30");
$prew_ID = 0;
while($row = $result->fetch_assoc()) {
if($row['choose_time']>=$row['end_date'])
{
if($row['id_R']  == $id){
if($prew_ID!=0)
{
$curent_time = $row['choose_time'];
$conn->query("UPDATE ".$DB_table_R." SET choose_time='$perw_time' WHERE id_R='$id' ")
or die($conn->connect_error());
$conn->query("UPDATE ".$DB_table_R." SET choose_time='$curent_time' WHERE id_R='$prew_ID' ")
or die($conn->connect_error());
}
}
$perw_time = $row['choose_time'];
$prew_ID = $row['id_R'];
}
}
}
?>
