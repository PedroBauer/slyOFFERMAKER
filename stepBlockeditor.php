<?php
/*

	Filename: stepBlockeditor.php
	Author: Pedro Bauer
	Description: The Blockeditor is the one file that covers 5 steps in one file.
	This file manages with the help of the blockeditor.js the drag & drop function and the session management.
	This file in itself also brings the function to get the predefined blocks and updates, adds or removes the blocks from the database if the user so wishes.
	

 */


require_once("includes/database.php");
require('includes/session.php');
require('includes/pageDefine.php');


if(isset($_POST['back'])){
	if($_SESSION['user']->page->id =="2"){
		header('Location: step1.php');
	}else{
		$_SESSION['user']->page->id --;
		header('Location: stepBlockeditor.php');
	}
}

if(isset($_POST['continue'])){
	if($_SESSION['user']->page->id =="6"){
		header('Location: step7.php');
	}else{
		$_SESSION['user']->page->id ++;
		header('Location: stepBlockeditor.php');
	}
}



if(isset($_POST['Logout'])){session_unset();}

if (!isset($_SESSION['user'])) {
	header('Location: index.php');
	}else{
	
		if (isset($_POST['action'])) {
		
			
			if ($_POST['action'] == 'updateBlock') {
				$db->query("UPDATE blocks SET blockText = '".str_replace("'", "\\'", $_POST['text'])."' WHERE blockId = ".$_POST['id']);
				if (mysqli_affected_rows($db)) die("1");
				else die("0");
			}
		
			
			else if ($_POST['action'] == 'insertBlock') {
				$db->query("INSERT INTO blocks (blockName, blockText) VALUES ('".str_replace("'", "\\'", $_POST['name'])."', '".str_replace("'", "\\'", $_POST['text'])."')");
				if (mysqli_affected_rows($db)) {
					$id = $db->query("SELECT LAST_INSERT_ID()")->fetch_array()[0];
					echo $id;
					die();
				}
				else die("0");
			}
		
			
			else if ($_POST['action'] == 'deleteBlock') {
				$db->query("DELETE FROM blocks WHERE blockID = ".$_POST['id']);
				if (mysqli_affected_rows($db)) die("1");
				else die("0");
			}
		
			else if ($_POST['action'] == 'updateSession') {
				$test = (object) $_POST['blocks'];
				$object = json_decode(json_encode($test), FALSE);
				$_SESSION['user']->$pageToken->blocks =  $object;
				die();
			}
		}	
	
?>

<!DOCTYPE html>
<html>
 	<head>
 		<title><?=$pageName?></title>
 		<meta http-equiv="content-type" content="text/html; charset=utf-8" />   
 		<link rel="stylesheet" type="text/css" rel="stylesheet" href="css/blockeditor.css">
 		<script type="text/javascript" src="thirdparty/JQuery/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="thirdparty/JQuery/jquery-ui.min.js"></script>
 		<script type="text/javascript" src="js/blockeditor.js"></script>
 	</head>
	<body>
	<?require('includes/header.php');?>
	
	<div id="blockOrganizer">
  
   <ul id="blocksForYourChoice" class="blockList">
    <li class="instruction">
    	<i>"Ziehe die Blöcke von der rechten Seite zur linken Seite"</i>
    	<br/>
    	Sie können den text formatieren wenn sie die tags:<br/>
    	<i>&lt;b&gt;&lt;/b&gt; für Fett<br/>
    	&lt;i&gt;&lt;/i&gt; für Kursiv<br/>
    	&lt;u&gt;&lt;/u&gt; für Underline<br/></i>
    </li>
    <li id="freeTextBlockTemplate" class="freeTextBlock">
     <div class="text"><textarea spellcheck="false"></textarea></div>
     <div class="title">Freitext</div>
     <div class="blockCreator">Block in Datenbank speichern als: <input type="text" placeholder="Neuer Blockname" /> <button>Block in DB speichern</button></div>
     <div class="blockUpdater"> <button>Block in DB speichern</button></div>
     <div class="blockRemover">x</div>
     <div class="blockDeleter">x</div>
    </li>
    <?

    $res = $db->query("SELECT * FROM blocks ORDER BY blockName");
    while($obj = $res->fetch_object()) {

		if (@$_SESSION['user']->$pageToken->blocks) {
			$blockAlreadyAddedToOffer = false;
			foreach(@$_SESSION['user']->$pageToken->blocks as $block) {

				if ($block->id == $obj->blockId) {
					$blockAlreadyAddedToOffer = true;
				}
		 	}
		 	if ($blockAlreadyAddedToOffer) continue;
		}?>
	
    <li id="block-<?=$obj->blockId?>" class="block">
     <div class="text"><textarea id="block-<?=$obj->blockId?>-text" spellcheck="false"><?=$obj->blockText?></textarea></div>
     <div class="title"><?=$obj->blockName?></div>
     <div class="blockUpdater"><?=$obj->blockName?> <button id="block-<?=$obj->blockId?>-updateButton" onclick="slyOfferMaker.updateBlock(<?=$obj->blockId?>)">Block in DB speichern</button></div>
     <div class="blockRemover" onclick="slyOfferMaker.removeBlock(<?=$obj->blockId?>)">x</div>
     <div class="blockDeleter" onclick="slyOfferMaker.deleteBlock(<?=$obj->blockId?>)">x</div>
    </li>
    <? } ?>
   </ul>
   
   <ul id="blocksInOffer" class="blockList">
   <? if (@$_SESSION['user']->$pageToken->blocks) {
   		foreach($_SESSION['user']->$pageToken->blocks as $block) { ?>
   	<li id="block-<?=$block->id?>" class="<?=($block->pseudo ? "freeTextBlock" : "block")?>">
     <div class="text"><textarea id="block-<?=$block->id?>-text" spellcheck="false"><?=$block->text?></textarea></div>
     <div class="title"><?=$block->name?></div>
     <? if (@$block->pseudo) {?><div class="blockCreator">Block in Datenbank speichern als: <input id="block-<?=$block->id?>-name" type="text" placeholder="Neuer Blockname" /> <button id="block-<?=$block->id?>-insertButton" onclick="slyOfferMaker.insertBlock(<?=$block->id?>)">Block in DB speichern</button></div><?}?>
     <div class="blockUpdater"><?=($block->name ? $block->name : "")?> <button id="block-<?=$block->id?>-updateButton" onclick="slyOfferMaker.updateBlock(<?=$block->id?>)">Block in DB speichern</button></div>
     <div class="blockRemover" onclick="slyOfferMaker.removeBlock(<?=$block->id?>)">x</div>
     <div class="blockDeleter" onclick="slyOfferMaker.deleteBlock(<?=$block->id?>)">x</div>
    </li>
   <?   }
      } ?>
      
   </ul>
   <div class="clear"></div>
  </div>
		<form method="POST">
			<input type="submit" name="back" value="Zur&uuml;ck" onclick="slyOfferMaker.updateSession();" />
			<input type="submit" name="continue" value="Weiter" onclick="slyOfferMaker.updateSession();" />
		</form>
	</body>
</html>

<?
}
?>