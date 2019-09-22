<?php

include('connect-db.php');


$result = $conn->query("SELECT count(*) FROM ".$DB_table_R."");
$row = $result->fetch_assoc();
if($row['count(*)']!=0) {
		$result = $conn->query("SELECT MAX(id_R) FROM ".$DB_table_R."")
		or die($conn->connect_error());
		$nr = $result->fetch_assoc();
		$result = $conn->query("SELECT * FROM ".$DB_table_R." WHERE id_R = ".$nr['MAX(id_R)']."")
		or die($conn->connect_error());
		$nrdoc = $result->fetch_assoc();
		$nrnext = $nrdoc['RegNr'];
		//echo $nrdoc['RegNr'];
		list($rd, $Did)=explode('-', $nrdoc['RegNr']);
		$madenr = $Did +1;
		$fullnr = $rd . '-' . $madenr;
		echo $fullnr;
}
else
	{
		$fullnr = 'REG-1';
	}
$conn->query("INSERT INTO ".$DB_table_R." (RegNr)
VALUES ('$fullnr')")
or die($conn->connect_error());
$result = $conn->query("SELECT MAX(id_R) FROM ".$DB_table_R."")
		or die($conn->connect_error());
		$nr = $result->fetch_assoc();
		$id = $nr['MAX(id_R)'];
header('Location: edit.php?id='.$id.'');


?>
