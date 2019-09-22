<?php

/*

EDIT.PHP

Allows user to edit specific entry in database

*/

function renderForm($id, $regnr, $Name, $Surname, $choose_time, $Email, $usr_id, $update,  $error)

{

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<title>Registration Edit</title>
<link rel="stylesheet" href="list.css">
</head>
  <link rel="stylesheet" href="jquery-ui.css">
  <script src="jquery.min.js"></script>
  <script src="jquery-ui.js"></script>

  <script>
  $( function() {
    $( "#datepicker" ).datepicker(
	{
		'format': 'yyyy-m-d',
        'autoclose': true
	}
	);
  } );
  </script>
    <script>
  $( function() {
    $( "#datepicker2" ).datepicker(
	{
		'format': 'yyyy-m-d',
        'autoclose': true
	}
	);
  } );
  </script>
<body bgcolor="#f2f2f2">

<?php

// if there are any errors, display them

if ($error != '')

{

echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';

}

?>



<form action="" method="post">

<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<table id="irasas">

<div>

<tr>
<td>
<strong>Reg. Nr. *</strong>
</td>
<td>

<?php
echo ''.$regnr.'<br/>';
?>
</td>
</tr>

<tr>
<td>
<strong>Name *</strong>
</td>
<td>
<input type="text" id="fill" name="Name" value="<?php echo $Name; ?>" /><br/>
</tr>

<tr>
<td>
<strong>Surname *</strong>
</td>
<td>
<input type="text" id="fill" name="Surname" value="<?php echo $Surname; ?>" /><br/>
</tr>

<tr>
<td>
<strong>Choose Time *</strong>
</td>
<td>
<input type="text" id="fill" name="choose_time" value="<?php echo $choose_time; ?>" /><br/>
</tr>

<tr>
<td>
<strong>Email*</strong>
</td>
<td>
<input type="text" id="fill" name="Email" value="<?php echo $Email; ?>" /><br/>
</td>
</tr>
<tr>
<td>
* Mandatory fields
</td>
<td>
</td>
</tr>
<tr>
<td>
<input type="submit"  id="btn" name="submit" value="Save">
</td>
<td>
</td>
</tr>

</table>
</div>

</form>

</body>

</html>

<?php

}







// connect to the database


// check if the form has been submitted. If it has, process the form and save it to the database

include('connect-db.php');

	if (isset($_POST['submit']))

{

// confirm that the 'id' value is a valid integer before getting the form data

if (is_numeric($_POST['id']))

{

// get form data, making sure it is valid

$id = mysqli_real_escape_string($conn, $_POST['id']);

$Name = mysqli_real_escape_string($conn, $_POST['Name']);

$Surname = mysqli_real_escape_string($conn, $_POST['Surname']);

$choose_time = mysqli_real_escape_string($conn, $_POST['choose_time']);

$Email = mysqli_real_escape_string($conn, $_POST['Email']);


// check that fields are filled in

if ($Name == '' || $Surname == '' || $choose_time == '' || $Email == '')

{

// generate error message

$error = 'ERROR: Fields are mandatory'. $update;


//error, display form

renderForm($id, $regnr, $Name, $Surname, $choose_time, $Email, $usr_id, $update, $error);

}

else

{
if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)

{

// query db

$id = mysqli_real_escape_string($conn, $_GET['id']);
$result = $conn->query("SELECT * FROM ".$DB_table_R." WHERE id_R=$id")
or die($conn->connect_error());
$row_R = $result->fetch_assoc();
$usr_id = $row_R['usr_id'];
if($usr_id){
    $result = $conn->query("SELECT * FROM ".$DB_table_U." WHERE id_U=$usr_id")
    or die($conn->connect_error());
    $row_U = $result->fetch_assoc();
    $update = "true";
}
}
if($update == "true"){
$sql = "UPDATE ".$DB_table_R.", ".$DB_table_U." SET ".$DB_table_U.".Name='$Name', ".$DB_table_U.".Surname='$Surname', ".$DB_table_R.".choose_time='$choose_time', ".$DB_table_U.".Email='$Email' WHERE ".$DB_table_R.".id_R='$id' AND ".$DB_table_U.".id_U='$usr_id'";
if ($conn->query($sql) === TRUE) {
    echo "Table ".$DB_table_U." created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
}
else{
$result=$conn->query("SELECT * FROM ".$DB_table_U." WHERE Name='$Name' AND Surname='$Surname'")
or die($conn->connect_error());
$row_U = $result->fetch_assoc();
$usr_id = $row_U['id_U'];
echo $usr_id;
if($usr_id>0){
echo $usr_id;
$conn->query("UPDATE ".$DB_table_U." SET Name='$Name', Surname='$Surname', Email='$Email' WHERE id_U='$id' ")
or die($conn->connect_error());
$conn->query("UPDATE ".$DB_table_R." SET choose_time='$choose_time', usr_id='$usr_id' WHERE id_R='$id' ")
or die($conn->connect_error());
}
else{
$conn->query("INSERT INTO ".$DB_table_U." (Name, Surname, Email)
VALUES ('$Name', '$Surname', '$Email')");
$result = $conn->query("SELECT MAX(id_U) FROM ".$DB_table_U."")
            or die($conn->connect_error());
            $nr = $result->fetch_assoc();
            $usr_id = $nr['MAX(id_U)'];
$conn->query("UPDATE ".$DB_table_R." SET choose_time='$choose_time', usr_id='$usr_id' WHERE id_R='$id' ")
or die($conn->connect_error());
}
}
//header("Location: index.php");
header("Location: userpage.php?id=".$id."");

}

}

else

{

// if the 'id' isn't valid, display an error

echo 'Error!';

}

}

else

// if the form hasn't been submitted, get the data from the db and display the form

{



// get the 'id' value from the URL (if it exists), making sure that it is valid (checing that it is numeric/larger than 0)

if (isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0)

{

// query db

$id = mysqli_real_escape_string($conn, $_GET['id']);	
$result = $conn->query("SELECT * FROM ".$DB_table_R." WHERE id_R=$id")
or die($conn->connect_error());
$row_R = $result->fetch_assoc();
$usr_id = $row_R['usr_id'];
if($usr_id){
$result = $conn->query("SELECT * FROM ".$DB_table_U." WHERE id_U=$usr_id")
or die($conn->connect_error());
$row_U = $result->fetch_assoc();
$update = "true";
}

// check that the 'id' matches up with a row in the databse

if($row_R || $row_U)

{
// get data from db

$regnr = $row_R['RegNr'];

$Name = $row_U['Name'];

$Surname= $row_U['Surname'];

$choose_time= $row_R['choose_time'];

$Email = $row_U['Email'];

// show form
renderForm($id, $regnr, $Name, $Surname, $choose_time, $Email, $usr_id, $update, '');

}

else

// if no match, display result

{

echo "No results!";

}

}

else

// if the 'id' in the URL isn't valid, or if there is no 'id' value, display an error

{

echo 'Error!';

}

}
?>
