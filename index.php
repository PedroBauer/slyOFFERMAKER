<?php
/*

	Filename: index.php
	Author: Pedro Bauer
	Description: This file is the entry to the whole project. In short term it means that you log yourself in over this file.
	If the session accepts your input you will continue and if not you will get a tooltip saying invalid login.

 */


require_once ('includes/session.php');
if (!isset($_SESSION['user'])) {	
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/body.css">
	</head>
	<body onload="document.getElementById('email').focus()">
		<div class="centered">
			<div id="loginContainer">
				<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
					<? if (isset($_GET['loginFailed'])) {?><p style="background:red;color:white;padding:3px;">Ung&uuml;ltiges Login!</p><?}?>
					<table>
						<tr>
							<td colspan="2"><img src="images/slyOFFERMAKER.png" class="logo"></td>
						</tr>
						<tr>
							<td><label><p>E-Mail:</p></label></td>
							<td><input type="text" id="email" name="email" />
						</tr>
						<tr>
							<td><label><p>Passwort:</p></label></td>
							<td><input type="password" name="password" /></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Login" /></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</body>
</html>
<? 
} else {
?>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<? header('Location: step1.php'); ?>
	</body>
</html>

<?php } ?>