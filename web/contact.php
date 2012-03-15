<?php
include ('header.php');
echo '<h1>Contact</h1>';
echo '<h2>Spelers</h2>';
echo '<p>Voor alles rondom spelers en de scouting kan het beste contact opgenomen worden met de juiste scout, of hoofdscout, deze vind je in het <a href="'.$config['url'].'/content/scouts/">scoutoverzicht</a>.</p>';
echo '<h2>Website</h2>';
echo '<p>Bij problemen van technische aard (website-errors etc) kan er contact worden opgenomen met de beheerders van deze website via het contactformulier.</p>';

echo '<form action="" method="POST">';
	echo '<p>';
		echo '<label>Alias</label>';
		echo $_SESSION['dutchscoutsName'];
	echo '</p>';
	echo '<p>';
		echo '<label>Emailadres</label>';
		echo '<input name="email" type="text" value="'.$_POST['email'].'"/> (optioneel)';
	echo '</p>';
	echo '<p>';
		echo '<label>Bericht</label>';
		echo '<textarea name="message" rows="10" cols="35">'.$_POST['message'].'</textarea>';
	echo '</p>';
	echo '<p>';
		echo '<label>&nbsp;</label>';
		echo '<input name="inputSend" type="submit" value="Verstuur" />';
	echo '</p>';
echo '</form>';

function sendMail($sender, $receiver, $message) {
	$headers	=	"From: sitebeheer@dutchscouts.nl <sitebeheer@dutchscouts.nl>\r\n";
	$headers	.=	"Reply-To: ".$sender."\r\n";
	$headers	.=	"MIME-Version: 1.0\r\n";
	$headers	.=	"Content-type: text/html; charset=iso-8859-1\r\n";
	$headers	.=	"Return-Path: Mail-Error <sitebeheer@dutchscouts.nl>\r\n";
	
	if(@mail($receiver, 'Contact forumulier DS', $message, $headers)) {
		return true;
	} else {
		return false;
	}
}

if($_POST['inputSend']){
	if ($_POST['email'] && !preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i', $_POST['email'])) {
		echo '<div class="error">Het opgegeven emailadres is niet geldig</div>';
	} elseif(!$_POST['message']) {
		echo '<div class="error">Vul aub een bericht in</div>';
	} elseif(strlen($_POST['message']) < 25) {
		echo '<div class="error">Het bericht moet tenminste 25 tekens bevatten</div>';
	} else {
		$message	=	"Het online contactformulier leverde het volgende bericht op:<br />";
		$message	.=	"<strong>Username:</strong> ".$_SESSION['dutchscoutsName']."<br />";
		$message	.=	"<strong>Team id:</strong> ".$_SESSION['dutchscouts']."<br />";
		$message	.=	"<strong>Emailadres:</strong> ".$_POST['email']."<br />";
		$message	.=	"----------------------------------<br />";
		$message	.=	$_POST['message'];
		
		$mailSucces		=	sendMail($_POST['email'], 'sitebeheer@dutchscouts.nl', $message);
		
		if($mailSucces == true) {
			echo '<div class="ok">Bericht verstuurd</div>';
			$_POST['message'] = '';
			$_POST['email'] = '';
		} else {
			echo '<div class="error">Verzenden mislukt, probeer het nogmaals</div>';
		}
	}
}
include ('footer.php');
?>
