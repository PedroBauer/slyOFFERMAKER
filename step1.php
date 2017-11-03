<?php
/*
	Filename: step1.php
	Author: Pedro Bauer
	Description: The file step1 means exactly the first step of the offermaker. 
	While entering your greeted with a form that you have to fill out you can complete the Coverpage of the offer.

 */

require('includes/session.php');

@$_SESSION['user']->page->id= "1";

require('includes/pageDefine.php');


if(@$_SESSION['user']->pageCover->datepicker == false){
	@$_SESSION['user']->pageCover->datepicker = date("d.m.o");
}


if(isset($_POST['Weiter'])){
	$_SESSION['user']->pageCover->projectName = $_POST['projectName'];
	$_SESSION['user']->pageCover->projectToken = $_POST['projectToken'];
	$_SESSION['user']->pageCover->OfferInternal = $_POST['OfferInternal'];
	$_SESSION['user']->pageCover->OfferExternal = $_POST['OfferExternal'];
	$_SESSION['user']->pageCover->datepicker = $_POST['datepicker'];
	$_SESSION['user']->page->id ++;
	header('Location: stepBlockeditor.php');
}
if(isset($_POST['Logout'])){session_unset();}

if (!isset($_SESSION['user'])) {
	header('Location: index.php');
}else{	

?>
<!DOCTYPE>
<html>
	<head>
		 <title><?=$pageName?></title>
		 <meta charset="utf-8">
		 <link rel="stylesheet" type="text/css" href="css/body.css">
		 <link rel="stylesheet" type="text/css" href="thirdparty/JQuery/jquery-ui.min.css">
		 <script type="text/javascript" src="thirdparty/JQuery/jquery-1.11.2.min.js"></script>
		 <script type="text/javascript" src="thirdparty/JQuery/jquery-ui.min.js"></script>
		 <script type="text/javascript">
			$(function() {
				$( "#datepicker" ).datepicker();
				$( "#datepicker" ).datepicker( "option", "dateFormat", "dd.mm.yy" );
				$( "#datepicker" ).datepicker('setDate', "<?=$_SESSION['user']->pageCover->datepicker;?>");	
			});
		</script>
	</head>
	<body>
		<div class="centered">
			<?require('includes/header.php');?>
			<form action="" method="POST">
				<table>
					<tr>
						<td><label>Projektname:</label></td>
						<td><input type="text" id="projectName" name="projectName" value="<?if(isset($_SESSION['user']->pageCover->projectName)){echo $_SESSION['user']->pageCover->projectName;}?>" required/><div class="required">*</div></td>
					</tr>
					<tr>
						<td><label>Datum der Offerte:</label></td>
						<td><input type="text" id="datepicker" name="datepicker"/><div class="required">*</div></td>
					</tr>
					<tr>
						<td><label>Projektkürzel:</label></td>
						<td><input type="text" id="projectToken" name="projectToken" value="<?if(isset($_SESSION['user']->pageCover->projectToken)){echo $_SESSION['user']->pageCover->projectToken;}?>" maxlength="3" required /><div class="required">*</div></td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Ansprechperson(en)@slySOLUTIONS:</label>
							<div class="clear"></div>
							<textarea name="OfferInternal" spellcheck="false" required><?if(isset($_SESSION['user']->pageCover->OfferInternal)){echo $_SESSION['user']->pageCover->OfferInternal;}?></textarea>
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Ansprechperson(en) Kunde:</label>
							<div class="clear"></div>
							<textarea name="OfferExternal" spellcheck="false" required><?if(isset($_SESSION['user']->pageCover->OfferExternal)){echo $_SESSION['user']->pageCover->OfferExternal;}?></textarea>
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="Weiter" value="Weiter" /></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
<?}?>