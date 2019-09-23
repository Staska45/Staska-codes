 
<?php

// connect to the database

include('connect-db.php');
include 'functions.php';
// number of results to show per page

// check if the 'id' variable is set in URL, and check that it is valid

if (isset($_GET['id']) && is_numeric($_GET['id']))

{

// get id value

$id = $_GET['id'];



//postpone

delay_reg($id);



// redirect back to the view page

header("Location: index.php?id=".$id."");

}

else

// if id isn't set, or isn't valid, redirect back to view page

{

header("Location: index.php?id=".$id."");

}



?>
