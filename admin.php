<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>REGISTRATION</title>
<link rel="stylesheet" href="list.css">
</head>

<body bgcolor="#f2f2f2">



<?php

include 'connect-db.php';
// Create connection


$per_page = 20;

/*$result = $conn->query("SELECT * FROM ".$DB_table_R."
RIGHT JOIN ".$DB_table_U." ON ".$DB_table_R.".usr_id = ".$DB_table_U.".id_U ORDER BY ".$DB_table_R.".start_date DESC");*/
$result = $conn->query("SELECT * FROM ".$DB_table_R."
RIGHT JOIN ".$DB_table_U." ON usr_id = ".$DB_table_U.".id_U ORDER BY choose_time DESC");
$total_results = $result->num_rows;

$total_pages = ceil($total_results / $per_page);



// check if the 'page' variable is set in the URL

if (isset($_GET['page']) && is_numeric($_GET['page']))

{

$show_page = $_GET['page'];



// make sure the $show_page value is valid

if ($show_page > 0 && $show_page <= $total_pages)

{

$start = ($show_page -1) * $per_page;

$end = $start + $per_page;

}

else

{

// error - show first set of results

$start = 0;

$end = $per_page;

}

}

else

{

// if page isn't set, show first set of results

$start = 0;

$end = $per_page;

}



// display pagination


echo '<table id="header1">';
echo '<tr><th><span style="float:center;">Registration</span><th></th><th></th></th></tr>';
echo "<tr><td><a href='page.php'>Display Board</a> | <b>User Page:</b> ";
for ($i = 1; $i <= $total_pages; $i++)

{

echo "<a href='index.php?page=$i'>$i</a> ";

}

echo "</td></tr>";


// display data in table
?>
<table id="sarasas">
<?php
//echo "<table border='1' cellpadding='10' id='sarasas'>";

echo "<tr> <th>Name</th> <th>Surname</th> <th>Email</th> <th>RegNr</th> <th>Apointment Time</th>";
echo "<th></th> ";
echo "<th></th> ";
echo "<th></th>";
echo "</tr>";


// loop through results of database query, displaying them in the table

for ($i = $start; $i < $end; $i++)

{

// make sure that PHP doesn't try to show results that don't exist


if ($i == $total_results) { break; }

$j=$i+1;
// echo out the contents of each row into a table
while($row = $result->fetch_assoc()) {
if($row['choose_time']){
echo "<tr>";

echo '<td>' . $row['Name'] . '</td>';

echo '<td>' . $row['Surname']. '</td>';

echo '<td>' . $row['Email']. '</td>';

echo '<td>' . $row['RegNr']. '</td>';

echo '<td>' . $row['choose_time']. '</td>';

if($row['choose_time']>=$row['end_date']){
echo '<td><a href="end_task.php?id=' . $row['id_R']. '"><img border="0" alt="edit" src="images/Tick.png" width="20" height="20"></a></td>';}
if($row['choose_time']<$row['end_date']){
echo '<td><img border="0" alt="edit" src="images/tick_full.png" width="20" height="20"></a></td>';}

echo '<td><a href="edit_admin.php?id=' . $row['id_R']. '"><img border="0" alt="edit" src="images/edit-document.jpg" width="20" height="20"></a></td>';

echo '<td><a href="delete.php?id=' . $row['id_R'] . '"><img border="0" alt="delete" src="images/delete-button.jpg" width="20" height="20"></a></td>';



echo "</tr>";
}
}
}
// close table>

echo "</table>";

?>


</body>

</html>
