<?php 
session_start();
if(!isset($_SESSION['session_username'])){
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Halo</title>
	<style type="text/css">
		.admin-page{
			text-align: center;
			margin-top: 200px;
		}
		.img2{
			width: 150px;
		}
		.button{
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<div class="admin-page">
		<h2>Welcome to your page, Admin!</h2>
		<img class="img2" src="team.png">
		<form class="button" action="logout.php">
    		<input type="submit" value="Logout" />
		</form>		
	</div>

</body>
</html>