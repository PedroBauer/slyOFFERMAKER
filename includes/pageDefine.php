<?php
/*
	Filename: pageDefine.php
	Author: Pedro Bauer
	Description: This include is used for the session management. By using this include it is easier to manage each page for the session.
	Also by keeping this file one can keep their code clean and without redundance.

 */
switch ($_SESSION['user']->page->id) {
	case 1:
		$pageName = $_SESSION['user']->page->name = "Deckblatt";
		$pageToken = $_SESSION['user']->page->token = "pageCover";
		break;
	case 2:
		$pageName = $_SESSION['user']->page->name = "Generelles";
		$pageToken = $_SESSION['user']->page->token = "pageGeneral";
		break;
	case 3:
		$pageName = $_SESSION['user']->page->name = "Design";
		$pageToken = $_SESSION['user']->page->token = "pageDesign";
		break;
	case 4:
		$pageName = $_SESSION['user']->page->name= "Programmierung";
		$pageToken = $_SESSION['user']->page->token= "pageProgramming";
		break;
	case 5:
		$pageName = $_SESSION['user']->page->name = "Hosting";
		$pageToken = $_SESSION['user']->page->token = "pageHosting";
		break;
	case 6:
		$pageName = $_SESSION['user']->page->name = "Ausschluss";
		$pageToken = $_SESSION['user']->page->token = "pageExclusion";
		break;
	case 7:
		$pageName = $_SESSION['user']->page->name = "Konditionen";
		$pageToken = $_SESSION['user']->page->token = "pageConditions";
		break;
	case 8:
		$pageName = $_SESSION['user']->page->name = "Finished";
		$pageToken = $_SESSION['user']->page->token = "pageFinished";
		break;
}
?>