<?php
session_start();
function auth($username, $password, $domain = 'EDU001', $endpoint = 'ldap://education.vic.gov.au', $dc = 'OU=Users,OU=Schools,DC=education,DC=vic,DC=gov,DC=au') {
	$ldap = @ldap_connect($endpoint);
	if(!$ldap) return false;
	ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
	ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

	$bind = @ldap_bind($ldap, "$domain\\$username", $password);
	if($bind) {return true;} else {return false;}

}
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">	
	<link rel="stylesheet" href="css/style.css" rel="stylesheet" >
	<title>Technician Lookup</title>
	<style>
		form {max-width: 300px;margin:auto}
		input {margin-bottom:10px}
	</style>
</head>
<body>
    <div class="container" id="page-wrap" style="margin-top: 54px;">
		<div id="heading">
			<h1 class="text-center">Specialist Technician Lookup</h1>
		</div>
		<?php 
			session_regenerate_id();
			if(isset($_SESSION['user']))
			{
				header("Location: search");
				session_write_close();
			}
		?>
		<?php if(empty($_POST['username']) || empty($_POST['password'])) { ?>
		<form method="POST">
			<input type="text" name="username" placeholder="username" class="form-control" required>
			<input type="password" name="password" placeholder="password" class="form-control" required>
			<input type="submit" class="btn btn-default btn-block" value="Login">
		</form>
		<?php } else {
			$bind = auth($_POST['username'], $_POST['password']);

			if(!$bind) {
				echo '<div class="alert alert-danger text-center">Login failed</div>';
			}
#			else echo '<div class="alert alert-success text-center">Login success</div><h1 class="text-center"><a href="mailto:' . $info['mail'] . '">' . $info['displayname'] . '</a></h1>';
			else {
				$_SESSION['user'] = $_POST['username'];
				$_SESSION['password'] = $_POST['password'];
				// redirect to required page
				header( "Location: search" );
				session_write_close();
			}
		}
		?>
	</div>
</body>
</html>