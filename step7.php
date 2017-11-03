<?php
/*
	Filename: step7.php
	Author: Pedro Bauer
	Description: In this file the conditions are defined. 
	It is literally the same as in step1.php with the exception of the checkbox which needs to be checked with a boolean value.
	
 */

require('includes/session.php');


// In this section i define that the page is number 7. So the pageDefine.php file gets the right case.
@$_SESSION['user']->page->id= "7";

require('includes/pageDefine.php');
require('includes/database.php');


if(empty($_SESSION['user']->$pageToken->slyCMSschool)){@$_SESSION['user']->$pageToken->slyCMSschool = '0';}

if(!isset($_SESSION['user']->$pageToken->projectSupport)){
	$_SESSION['user']->$pageToken->projectSupport = "180";
}

if(!isset($_SESSION['user']->$pageToken->projectTerms)){
	$_SESSION['user']->$pageToken->projectTerms = "50% Anzahlung, Restzahlung nach erfolgter Schulung innert 10 Tagen zahlbar";
}

if(!isset($_SESSION['user']->$pageToken->projectStart)){
	$_SESSION['user']->$pageToken->projectStart = "Sofort möglich";
}

if(!isset($_SESSION['user']->$pageToken->projectDelivery)){
	$_SESSION['user']->$pageToken->projectDelivery = "Ca. 4-8 Wochen nach Auftragserteilung";
}

if(!isset($_SESSION['user']->$pageToken->projectValidity)){
	$_SESSION['user']->$pageToken->projectValidity = "30 Tage ab Offertvergabe";
}


if(isset($_POST['back'])){
	$_SESSION['user']->page->id --;
	header('Location: stepBlockeditor.php');
}
if(isset($_POST['continue'])){
	$_SESSION['user']->$pageToken->projectPrice = $_POST['projectPrice'];
	$_SESSION['user']->$pageToken->projectSupport = $_POST['projectSupport'];
	if(empty($_POST['slyCMSschool'])){$_SESSION['user']->$pageToken->slyCMSschool = '0';}else{$_SESSION['user']->$pageToken->slyCMSschool = '1';}	
	$_SESSION['user']->$pageToken->projectTerms = $_POST['projectTerms'];
	$_SESSION['user']->$pageToken->projectStart = $_POST['projectStart'];
	$_SESSION['user']->$pageToken->projectDelivery = $_POST['projectDelivery'];
	$_SESSION['user']->$pageToken->projectValidity = $_POST['projectValidity'];
	$_SESSION['user']->page->id ++;
	$_SESSION['user']->page->name = "Finished";
	$_SESSION['user']->page->token = "pageFinished";
	
	$result = $db->query("SELECT * FROM offer WHERE offerName='".$_SESSION['user']->pageCover->projectName."'");
	
	// 
	if(mysqli_num_rows($result) == 0){
		$db->query("INSERT INTO offer (
				offerName, 
				offerToken, 
				offerInternal, 
				offerExternal, 
				offerDate,
				offerPackprice,
				offerSupport,
				offerSchulung,
				offerTerms,
				offerStart,
				delivery,
				offerValidity
				)
		 	VALUES (
				'".$_SESSION['user']->pageCover->projectName."', 
				'".$_SESSION['user']->pageCover->projectToken."', 
				'".$_SESSION['user']->pageCover->OfferInternal."', 
				'".$_SESSION['user']->pageCover->OfferExternal."', 
				'".$_SESSION['user']->pageCover->datepicker."',
				'".$_SESSION['user']->$pageToken->projectPrice."',
				'".$_SESSION['user']->$pageToken->projectSupport."',
				'".$_SESSION['user']->$pageToken->slyCMSschool."',
				'".$_SESSION['user']->$pageToken->projectTerms."',
				'".$_SESSION['user']->$pageToken->projectStart."',
				'".$_SESSION['user']->$pageToken->projectDelivery."',
				'".$_SESSION['user']->$pageToken->projectValidity."'
				
)");
	}else{
		$db->query("UPDATE offer SET  
				offerToken = '".$_SESSION['user']->pageCover->projectToken."', 
				offerInternal = '".$_SESSION['user']->pageCover->OfferInternal."', 
				offerExternal = '".$_SESSION['user']->pageCover->OfferExternal."', 
				offerDate = '".$_SESSION['user']->pageCover->datepicker."', 
				offerPackPrice = '".$_SESSION['user']->$pageToken->projectPrice."', 
				offerSupport = '".$_SESSION['user']->$pageToken->projectSupport."', 
				offerSchulung = '".$_SESSION['user']->$pageToken->slyCMSschool."', 
				offerTerms = '".$_SESSION['user']->$pageToken->projectTerms."', 
				offerStart = '".$_SESSION['user']->$pageToken->projectStart."', 
				delivery = '".$_SESSION['user']->$pageToken->projectDelivery."', 
				offerValidity = '".$_SESSION['user']->$pageToken->projectValidity."'
				WHERE offername = '".$_SESSION['user']->pageCover->projectName."'");
		echo "Update";
	}
	
	header('Location: step8.php');
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
	</head>
	<body>
		<div class="centered">
			<?require('includes/header.php');?>
			<form method="POST">
				<table>
					<tr>
						<td><label>Pauschalpreis</label></td>
						<td><input type="number" name="projectPrice" value="<?if(isset($_SESSION['user']->$pageToken->projectPrice)){echo $_SESSION['user']->$pageToken->projectPrice;}?>" min="1" max="999999999" step="1" maxlength="9" required /><label class="currency">CHF</label><div class="required">*</div>
						
					</tr>
					<tr>
						<td><label>Studenansatz f&uuml;r Support:</label></td>
						<td><input type="number" name="projectSupport" value="<?if(isset($_SESSION['user']->$pageToken->projectSupport)){echo $_SESSION['user']->$pageToken->projectSupport;}?>" min="1" max="999" step="1" maxlength="3" required /><label class="currency">CHF</label><div class="required">*</div></td>
					</tr>
					<tr>
						<td colspan="2">
							<label for="check1">
							      <input type="checkbox" name="slyCMSschool" value="1" id="check1" <?if($_SESSION['user']->$pageToken->slyCMSschool == "1"){echo "checked";}else{}?>>
							      slyCMS Schulung nur in Regensdorf oder Online/Telefon
							</label>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Zahlungskonditionen:</label>
							<div class="clear"></div>
							<input type="text" name="projectTerms" value="<?if(isset($_SESSION['user']->$pageToken->projectTerms)){echo $_SESSION['user']->$pageToken->projectTerms;}?>" required />
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Projektstart:</label>
							<div class="clear"></div>
							<input type="text" name="projectStart" value="<?if(isset($_SESSION['user']->$pageToken->projectStart)){echo $_SESSION['user']->$pageToken->projectStart;}?>" required />
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Lieferung:</label>
							<div class="clear"></div>
							<input type="text" name="projectDelivery" value="<?if(isset($_SESSION['user']->$pageToken->projectDelivery)){echo $_SESSION['user']->$pageToken->projectDelivery;}?>" required />
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<label>Angebotsgültigkeit:</label>
							<div class="clear"></div>
							<input type="text" name="projectValidity" value="<?if(isset($_SESSION['user']->$pageToken->projectValidity)){echo $_SESSION['user']->$pageToken->projectValidity;}?>" required/>
							<div class="required">*</div>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="back" value="Zur&uuml;ck" />
							<input type="submit" name="continue" value="Weiter" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>
<?}?>