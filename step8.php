<?php
/*
Filename: step8.php
Author: Pedro Bauer
Description: This is the final page that shows the preview of the PDF. Which one can download later on.
*/


require('includes/session.php');

@$_SESSION['user']->page->id= "8";

require('includes/pageDefine.php');

$pdfFilename = "Offer-".$_SESSION['user']->pageCover->projectName."_".$_SESSION['user']->pageCover->datepicker;

if(isset($_POST['back'])){
	$_SESSION['user']->page->id --;
	header('Location: step7.php');
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
	</head>
	<body>
		<div class="centered" id="lastPage">
			<?require('includes/header.php');?>
			<form method="POST">
				<iframe src="offer.pdf.php" width="100%" height="90%" frameborder="0" border="0"></iframe>
				<input type="submit" name="back" value="Zur&uuml;ck" />
				<a href="offer.pdfDownload.php" target="_blank">PDF Herunterladen</a>
			</form>
		</div>
	</body>
</html>
<?}?>
