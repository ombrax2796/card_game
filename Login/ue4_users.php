<?php

include("dbconnect.php");


/////// First Function To Get User Data For Login 



if($_GET["stuff"]=="login"){

$mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	
/////// Need to Grab Username And Password



$username = $_GET["user"];
$password = $_GET["password"];

// create a prepared statement
$stmt = mysqli_prepare($mysqli, "SELECT username, password, regkey, banned FROM users WHERE username='$username'");

// bind parameters
mysqli_stmt_bind_param($stmt, 's', $username);

// execute query
mysqli_stmt_execute($stmt);

// bind result variables
mysqli_stmt_bind_result($stmt, $username, $hashed_password, $regkey, $banned);

// fetch value
mysqli_stmt_fetch($stmt);

if(password_verify($password, $hashed_password)){
    echo json_encode(array('result' => 'success', 'regkey' => $regkey, 'banned' => $banned));
}else{
    // incorrect password
}

mysqli_stmt_close($stmt);







$mysqli->close();

}


//////////////////////
/////// Second Function Getting The User Information
//////////////////////

if($_GET["stuff"]=="userinfo"){

$mysqli = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

//////// Gets the RegKey which is Unique To The User

$rk = $_GET["rk"];




$query = "SELECT username, status, email, banned, kills, wins FROM users WHERE regkey='$rk'";

if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($username, $email, $kills, $partie_win, $partie_lose );
    while ($stmt->fetch()) {
     echo "{";
        echo '"username": "' . $username . '",';
        echo '"email": "' . $email . '",';
        echo '"Partie gagnées": "' . $partie_win . '",';
        echo '"Partie perdues": "' . $partie_lose . '"';
        echo "}";
    }

    
    $stmt->close();
}


$mysqli->close();
}

//////////////////////
/////// Third Function Change State Of User Online/Offline
//////////////////////

if($_GET["stuff"]=="u_status"){
    
$conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if ($conn->query($sql) === TRUE) {
    echo "successfully";
} else {
    echo "error" . $conn->error;
}

$conn->close();
}

?>