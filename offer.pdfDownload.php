<?php
require('includes/session.php');
require('thirdparty/FPDF/WriteTag.php');
require('thirdparty/FPDI/fpdi.php');

class myPDF extends PDF_WriteTag
{
	//Page header
	function Header()
	{
		//Logo
		$this->Image('images/slyLOGO.png', 130, 13, 60);
		//Arial bold 15
		$this->SetFont('Arial','B',15);
		//Move to the right
		$this->Cell(80);
		//Line break
		$this->Ln(20);
	}

	//Page footer
	function Footer()
	{
		//Position at 1.5 cm from bottom
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',9);
		
		$this->SetFillColor(143,143,143);
		
		$this->SetXY(5, 285);
		
		$this->Cell(200,10,'slySOLUTIONS GmbH - Althardstrasse 147, 8105 Regensdorf +41 44 840 10 10 - www.slysolutions.ch - info@slysolutions.ch',1,0,'C');
		
		$this->SetFillColor(143,143,143);
		//Page number
	}
}





$pdf=new myPDF();
$pdf->SetMargins(30,15,25);
$pdf->SetFont('arial','',13);
$pdf->AddPage();

// Stylesheet
$pdf->SetStyle("b","","B",0,"");
$pdf->SetStyle("i","","I",0,"");
$pdf->SetStyle("u","","U",0,"");




/*******************************/
/*		  PAGE DECKBLATT	   */
/*******************************/


$pdf->SetXY(30, 100);

$txt="<b>".$_SESSION['user']->pageCover->projectName ." (". $_SESSION['user']->pageCover->projectToken.")</b>";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$pdf->SetFontSize(11);

$txt="<b>Projekt neue Webpräsenz</b>";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


$pdf->SetFontSize(10);

$pdf->SetXY(30, 125);

$txt="Ansprechpartnerin ". $_SESSION['user']->pageCover->projectToken."</b>";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="<i>".$_SESSION['user']->pageCover->OfferExternal."</i>";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$pdf->SetXY(30, 140);

$txt="Ansprechpartner slySOLUTIONS GmbH:";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="<i>".$_SESSION['user']->pageCover->OfferInternal."</i>";

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$pdf->SetXY(30, 160);

$txt="Regensdorf, ".$_SESSION['user']->pageCover->datepicker;

$pdf->WriteTag(0,0,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


/***********************************/
/*		  PAGE Generelles    	   */
/***********************************/

if(!empty($_SESSION['user']->pageGeneral->blocks)){
	
	$pdf->AddPage();
	
	$txt="<u>Generelles</u>";
	
	$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
	
	$pdf->Ln(10);
	
	foreach($_SESSION['user']->pageGeneral->blocks as $blocks){
		$txt=$blocks->text;
		$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
		$pdf->Ln(15);
	}
}else{}


/*		Projektbeschrieb		*/


$pdf->AddPage();

$txt="<u>Projektbeschrieb</u>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(10);


$txt="Das Projekt wird gegliedert in <b>Design, Programmierung / Tools</b> und <b>Hosting.</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(15);


/*		Design		*/


$txt="<b>Design:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(10);


/*		@EditableText		*/

foreach($_SESSION['user']->pageDesign->blocks as $blocks){
	$txt=$blocks->text;
	$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
	$pdf->Ln(15);
}




$txt="Natürlich sollen nicht nur die richtigen Informationen an den richtigen Stellen auffindbar sein,
sie sollen zudem in einem ansprechenden und adäquaten Erscheinungsbild verfügbar sein.
Hierfür ist unsere Designabteilung verantwortlich und erstellt für Sie ein elegantes und zeitgemässes Design.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


$txt="Neben dem „Monitor-Design“, werden wir ein zusätzliches Konzept für eine Webseite mit Responsive Design erstellen.
Die Seite wird dadurch erkennen, auf was für einem Gerät (Monitor, Tablet oder Smartphone) der User die Seite anschaut.
Um optimal dargestellt zu werden ordnen sich die Elemente um und werden in der Grösse an das Ausgabegerät angepasst.
Denn wir sollten unbedingt berücksichtigen, dass gern, Statistik gut 25% sämtlicher Seitenzugriffe über mobile Geräte erfolgen, Tendenz klar steigend.
Diese 25% dürfen wir keinesfalls vernachlässigen.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


$txt="Warum ein Responsive Design anstelle einer Mobilen Webseite?";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


$txt="Erstens braucht es dadurch nur eine einzige Seite, was die Administration stark erleichtert.
Zudem machen m.-Webseiten heute keinen Sinn mehr, Responsive Design sei Dank.
Es ist nicht vorteilhaft, wenn ein Besucher der Seite zuerst einen Klick opfern muss, um von der Standardseite zur m.-Seite zu wechseln (Thematik „in drei Klicks zum Ziel“).
Zudem erkennt eine Responsive Design Webseite nicht nur Handys, sondern auch Tablets und Laptops mit geringer Auflösung.
Somit benötigen wir heute nur noch eine einzige Webseite für sämtliche Geräte.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(15);


/*******************************************/
/*		  Programmierung / Tools    	   */
/*******************************************/


/*		Programmierung / Tools		*/

$pdf->AddPage();

$txt="<b>Programmierung / Tools:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);


/*		@EditableText		*/

foreach($_SESSION['user']->pageProgramming->blocks as $blocks){
	$txt=$blocks->text;
	$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
	$pdf->Ln(15);
}


$txt="Wir werden im Anschluss an die Programmierung eine Schulung abhalten (ca. 2 Stunden),
wie mit dem slyCMS umgegangen werden kann und wie die Webseite somit selbständig erweiterbar und aktualisierbar ist.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="Die neue Seite wird für sämtliche Browser optimiert (aktuelle Versionen plus eine Vorgängerversion).";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);





/***************************/
/*		  Hosting    	   */
/***************************/


/*		Hosting		*/

$pdf->AddPage();

$txt="<b>Hosting:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="Es gibt drei verschiedene Varianten bzgl. Hosting:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="<u>slySERVICE Package Base</u> CHF 129.- Pro Jahr";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$txt="Sämtliche Lizenzgebühren, reine Weiterleitung für das Webhosting, das Mailhosting bleibt bestehen.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="<u>slySERVICE Package Standard</u> CHF 189.- Pro Jahr";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$txt="Sämtliche Lizenzgebühren, Webhosting komplett, ohne Mailhosting.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

$txt="<u>slySERVICE Package Deluxe</u> CHF 249.- Pro Jahr";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$txt="Sämtliche Lizenzgebühren, Webhosting komplett plus Mailhosting inkl. 5 E-Mail Adressen.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$txt="Pro weitere Mailbox CHF 2.- pro Monat.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(5);

foreach($_SESSION['user']->pageHosting->blocks as $blocks){
	$txt=$blocks->text;
	$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
	$pdf->Ln(15);
}



/*******************************/
/*		  Ausschluss    	   */
/*******************************/

$txt="<b>AUSSCHLUSS:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(2);


foreach($_SESSION['user']->pageExclusion->blocks as $blocks){
	$txt=$blocks->text;
	$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);
	$pdf->Ln(15);
}


/*******************************/
/*		  Konditions    	   */
/*******************************/

$pdf->AddPage();

$txt="<u>Konditionen</u>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(2);



$pdf->SetXY(30, 43);

$txt="Umsetzung neue Webseite:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(100, 43);

$txt="CHF ".$_SESSION['user']->pageConditions->projectPrice.".00 pauschal";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(30, 53);

$txt="Schulung slyCMS:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


if($_SESSION['user']->pageConditions->slyCMSschool == 1){$text="(Durchführungsort in Regensdorf bei slySOLUTIONS)";}

$pdf->SetXY(100, 53);

$txt="Im Projektpreis inbegriffen".$text;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(30, 63);

$txt="Live schalten der Webseite:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(100, 63);

$txt="Im Projektpreis inbegriffen";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 73);

$txt="Studensatz danach (z.B. für";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 78);

$txt="Support und Erweiterungen):";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(100, 78);

$txt="CHF ".$_SESSION['user']->pageConditions->projectSupport.".00 pro Stunde";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);



$pdf->SetXY(30, 88);

$txt="Gewünschtes Hosting:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 93);

$txt="slySERVICE Package Base";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 99);

$txt="slySERVICE Package Standard";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 105);

$txt="slySERVICE Package Deluxe";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 93);
$pdf->Cell(5,5,'',1,0,'C');
$pdf->SetXY(118, 93);
$pdf->Cell(5,5,'CHF 129.- p.a.',0,0,'C');
$pdf->SetXY(100, 99);
$pdf->Cell(5,5,'',1,0,'C');
$pdf->SetXY(118, 99);
$pdf->Cell(5,5,'CHF 189.- p.a.',0,0,'C');
$pdf->SetXY(100, 105);
$pdf->Cell(5,5,'',1,0,'C');
$pdf->SetXY(118, 105);
$pdf->Cell(5,5,'CHF 249.- p.a.',0,0,'C');


$pdf->SetXY(30, 113);

$txt="Kaufkonditionen:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 113);

$txt="Sämtliche Preise verstehe sich exkl. 8% MwSt.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 120);

$txt="Zahlungskonditionen:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 120);

$txt=$_SESSION['user']->pageConditions->projectTerms;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 133);

$txt="Projektstart:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 133);

$txt=$_SESSION['user']->pageConditions->projectStart;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);



$pdf->SetXY(30, 138);

$txt="Lieferung:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 138);

$txt=$_SESSION['user']->pageConditions->projectDelivery;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 143);

$txt="Angebotsgültigkeit:";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 143);

$txt=$_SESSION['user']->pageConditions->projectValidity;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(30, 153);

$txt="Durch Ihre Unterschrift wird dieses Angebot in eine für beide Parteien verbindliche Auftragsbestätigung umgewandelt.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(30, 168);
$pdf->Cell(5,5,'',1,0,'C');

$pdf->SetXY(38, 168);

$txt="Ich habe die Allgemeinen Geschäftsbedingungen der slySOLUTIONS GmbH erhalten und gelesen und erkläre micht damit einverstanden.";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 183);

$txt="<b>Ihre slySOLUTIONS GmbH:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(100, 183);

$txt="<b>Auftraggeber:</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(30, 200);

$txt="<b>Samuel Betschart</b>";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->SetXY(30, 205);

$txt="Geschäftsführer";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);




$pdf->SetXY(100, 200);

$pdf->Line(100, 204, 135, 204);

$pdf->Ln(1);

$pdf->SetXY(100, 205);

$txt="Ort, Datum";

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);


$pdf->SetXY(100, 200);

$pdf->Line(150, 204, 190, 204);

$pdf->Ln(1);

$pdf->SetXY(150, 205);

$txt=$_SESSION['user']->pageCover->OfferExternal;

$pdf->WriteTag(0,5,iconv('UTF-8', 'windows-1252', $txt),0,"L",0,0);

$pdf->Ln(1);

$pdf->AddPage();

/*$pdf->setSourceFile("agb.pdf");
$pdf->AddPage();
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 6, 8, 200);
$pdf->AddPage();
$tplIdx = $pdf->importPage(2);
$pdf->useTemplate($tplIdx, 6, 8, 200);*/


// Signature

$pdf->Output("offer.pdf",'D');
?>