  <?php
     include 'Config.php';
     $conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE ".$dbname."";
if ($conn->query($sql) === TRUE) {
    echo "Database ".$dbname." created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->close();
//create table 
include 'connect-db.php';
$sql = "CREATE TABLE ".$DB_table_R." (
id_R INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
usr_id INT(6) NULL,
RegNr TEXT NOT NULL,
choose_time DATETIME DEFAULT CURRENT_TIMESTAMP,
start_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
end_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table ".$DB_table_R." created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
//create table 
$sql = "CREATE TABLE ".$DB_table_U." (
id_U INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name TEXT NOT NULL,
Surname TEXT NOT NULL,
Email TEXT DEFAULT NULL,
array_con VARCHAR(255) DEFAULT NULL,
reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table ".$DB_table_U." created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
$conn->close();
?> 
