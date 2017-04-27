<?php
session_start();
require_once('connection.php');

$username = $_POST['username'];
$password = $_POST['password'];

if(isset ($username) or isset($password)){
	if($username == "" or $password == "")
	{ 
?>
	<script type="text/javascript">
	alert("LOGIN SALAH, USERNAME ATAU PASSWORD TIDAK BOLEH KOSONG");
	window.location = 'index.php';
	</script>
<?php
	}
}
$username = stripslashes($username);
$password = stripslashes($password);
$sql = "SELECT * FROM administrator WHERE username='".$username."' and password='".$password."'";
$result=mysqli_query($conn, $sql);
$count=mysqli_num_rows($result);
if($count==1){
		$_SESSION['user']=$username;
		$_SESSION['pass']=$password;
?>
    <script language="javascript">alert('Selamat, Login anda sukses!!');
	document.location='dashboard.php'</script>
<?php
	}else{
?>
 <script type="text/javascript">
	alert("LOGIN SALAH, USERNAME ATAU PASSWORD TIDAK DITEMUKAN");
	document.location='index.php'
	</script> 
<?php
	}
?>