<?php 
/*
	Filename: header.php
	Author: Pedro Bauer
	Description: This file is used on all ppages but index.php. It used for navigation purposis and to keep the user sure on which place he is located.
	This file is also very important for the blockeditor since 5 pages are managed by one file and that could easily lead to confusion.

 */


?>

<div id="topArea">
	<div id="locationContainer">
		<h1>slyOfferMaker: <?=$pageName?></h1>
	</div>
	<div id="subContainer">
		<div id="breadcrumbContainer">
			<?for($i=1;$i<9;$i++){
				if($_SESSION['user']->page->id == $i){
					//$_SESSION['user']->page->id = $i;
					echo '<div class="current-breadcrumb" id="crumb-'.$i.'">'.$i.'</div>';
					
				}else{
					//$_SESSION['user']->page->id = $i;
					if($i == 1 || $i>6){
						echo '<div class="breadcrumb" id="crumb-'.$i.'"><a href="step'.$i.'.php">'.$i.'</a></div>';
					}else{
						echo '<div class="breadcrumb" id="crumb-'.$i.'"><a href="stepBlockeditor.php">'.$i.'</a></div>';
					}
				}
			}?>
		</div>
		<div id="userContainer">
			
			<form method="POST">
				<label>Eingeloggt als: <?=$_SESSION['user']->name;?></label>
				<input type="submit" name="Logout" value="Logout" />
			</form>
		</div>
	</div>
</div>
<div class="clear"></div>