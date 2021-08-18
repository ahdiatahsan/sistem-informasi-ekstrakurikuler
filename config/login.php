<?php
header('Content-Type:application/json');
include "koneksi.php";
//get data username dan password
$username = isset($_GET['username']) ? $_GET['username']:"";
$pass = isset($_GET['password']) ? $_GET['password']:"";
$password = md5($pass);
//pengecekan username dan password kosong atau tidak
if($username=="" and $password==""){
	$json_array = array(
		'error' => true,
		'message' => "Mohon Isi Username & Password",
	);
}else{
	//cquery pencarian username dan password
	$query='SELECT * FROM user WHERE username="'.$username.'" AND password="'.$password.'"';
	$result = mysqli_query($koneksi, $query) or die('error: ' .mysql_error());
	$row = mysqli_fetch_assoc($result);
    //pengecekan username dan password ada atau tidak
	if(mysqli_num_rows($result) > 0) {
				$json_array = array(
					'error' => false,
					'id' => $row['id'],
					'message' => "Sukses Login"
				);
	}else{
		$json_array = array(
			'error' => true,
			'message' => "Username Atau Password Salah",
		);
	}
}
echo json_encode($json_array);
?>
