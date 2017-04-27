<?php
session_start();
if(isset ($_SESSION['user']) && isset($_SESSION['pass'])){
	header('location:dashboard.php');
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Untitled Document</title>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/login.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
	<div class="row">
        <div class="col-md-4 col-md-offset-4">
			<div class="account-wall">
            <div class="logo"> 
                <img src="asset/logo.png"/>
            </div>

                <form class="form-horizontal" method="POST" action="loginproses.php">
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-9 dropleft">
                      <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-9 dropleft">
                      <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 dropleft">
                      <button type="submit" class="btn btn-default">Sign in</button>
                    </div>
                  </div>
                </form>
			</div>
        </div>
    </div>
</div>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
