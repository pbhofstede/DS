<?php
ob_start();

if (($_SERVER["SERVER_NAME"] <> 'www.dutchscouts.nl') &&
    ($_SERVER["SERVER_NAME"] <> 'localhost')) {
  header('Location: http://www.dutchscouts.nl/scan');
}

require('class/PHT.php');
session_start();

include('functions.php');

require('class/db/db.class.php');

require('class/coach.class.php');
require('class/db/coach.db.class.php');

require('class/player.class.php');
require('class/db/player.db.class.php');

require('class/playerLog.class.php');
require('class/db/playerLog.db.class.php');

if ($_SERVER["SERVER_NAME"] == 'localhost') {
	$config['url']			=	'http://localhost/dutchscouts/scan';
	$config['scan_url']		=	'http://localhost/dutchscouts/scan';
  $config['urlweb']		=	'http://localhost/dutchscouts/web';
}
else {
	$config['url']			=	'http://www.dutchscouts.nl/scan';
	$config['scan_url']		=	'http://www.dutchscouts.nl/scan';
  $config['urlweb']		=	'http://www.dutchscouts.nl/web';
} 

$HT_TR_SP = 2;
$HT_TR_DEF = 3;
$HT_TR_SCO = 4;
$HT_TR_CRO = 5;
$HT_TR_SHO = 6;
$HT_TR_PAS = 7;
$HT_TR_PM = 8;
$HT_TR_GK = 9;
$HT_TR_OPM = 10;
$HT_TR_CTR = 11;
$HT_TR_VLA = 12;

$const_player_sql = 
		"SELECT player.id, player.coach, player.name, player.dateOfBirth, player.tsi, player.salary, player.injury, player.aggressiveness, player.agreeability, player.honesty, player.leadership, ".
			"  player.speciality, player.form, player.stamina, player.experience, ".
			"  player.keeper, player.defender, player.playmaker, player.winger, player.passing, player.scorer, player.setPieces, ".
			"  player.caps, player.capsU20, player.added, player.lastupdate, player.scoutid, ".
			"  player.indexGK, player.indexCD, player.indexDEF, player.indexWB, player.indexIM, player.indexWG, player.indexSC, player.indexDFW, player.indexSP, ".
			"  player.keeperSubSkill, player.defenderSubSkill, player.playmakerSubSkill, player.wingerSubSkill, player.passingSubSkill, player.scorerSubSkill, player.setPiecesSubSkill, ".
			"  player.lasttraining, player.u20, coach.trainingtype, coach.conditieperc, coach.trainingintensity, coach.trainerskill, coach.assistants, player.sundayTraining ".
			"FROM player left join coach on (coach.id = player.coach) ";

if(!empty($_GET['language'])) {
	if($_GET['language'] == 'NL') {
		$_SESSION['language']	=	'NL';
	} elseif($_GET['language'] == 'US') {
		$_SESSION['language']	=	'US';
	}
}

if(empty($_SESSION['language']) || $_SESSION['language'] == 'NL') {
	$language['intro']		=	'Vul hieronder je gegevens in om je spelers te uploaden voor het U20 en NT. Bedenk dat alle spelers opgeslagen worden en dat feit dat een speler na scannen getoond wordt niet meteen betekent dat deze een kans maakt in het U20 of NT. Mocht dit het geval zijn dan zal een scout je hiervan op de hoogte brengen.<br/><br/>Als je nog geen account bij DutchScouts hebt, is het noodzakelijk om je eenmalig te registreren om DutchScouts toegang te geven tot jouw teamdata. Klik hiervoor op de link "Nieuwe gebruiker of wachtwoord vergeten".<br /><br /><strong>Update:</br> Het is sinds kort niet meer noodzakelijk om na elke training je spelers te updaten. Dit wordt automatisch gedaan door DutchScouts zolang je de CHPP-machtiging niet intrekt.</strong><br /><br /><br />';
	$language['reg_intro']  =  'Bedankt voor het toegang verlenen van DutchScouts om uw spelersinformatie uit te lezen.<br/><br/>Voer hieronder uw zelf gekozen inlognaam en wachtwoord in om voortaan mee in te loggen op de DutchScouts-website om de scouts eventueel met extra informatie te voorzien.<br /><br />';
	$language['toFullVersion']	=	'Naar uitgebreide pagina';
	
	$language['incorrectAccount']	=	'Logingegevens voor DutchScouts incorrect';
	$language['noHTPermission']	=	'<FONT COLOR=FF0000>DutchScouts heeft geen toegang meer tot uw spelersgegevens.</FONT><BR>Ga naar <u><a href=http://www.dutchscouts.nl/scan/loginHT.php>http://www.dutchscouts.nl</a></u> om DutchScouts opnieuw toegang te geven tot uw spelers.<br>';
	
	$language['name']		=	'Inlognaam';
	$language['password']	=   'Wachtwoord';
	$language['retypepassword']=   'Herhaal wachtwoord';
	$language['DSname']		=   'Inlognaam (DutchScouts)';
	$language['DSpassword']	=   'Wachtwoord (DutchScouts)';
	$language['differentPasswords'] = '*  Voer twee maal hetzelfde wachtwoord in.';
	$language['coachNameExists'] = '*  Uw gekozen gebruikersnaam bestaat reeds, kies een andere gebruikersnaam.';
	$language['register']	=   'Registreren';
	$language['scan']		=	'Scannen';
	$language['login']		=	'Login';
	$language['new']		=   'Nieuwe gebruiker of wachtwoord vergeten';
	
	$language['ID']			=	'ID';
	$language['player']		=	'Speler';
	$language['lastPosition']	=	'Laatste Positie';
	$language['age']		=	'Leeftijd';
	$language['interessant']		=	'Interessant?';
	
	$language['year']		=	'jaar';
	$language['days']		=	'dagen';
	$language[0] = '';
	$language[$HT_TR_SP] = 'Spelhervatten';
	$language[$HT_TR_DEF] = 'Verdedigen';
	$language[$HT_TR_SCO] = 'Scoren';
	$language[$HT_TR_CRO] = 'Vleugelspel';
	$language[$HT_TR_SHO] = 'Schieten';
	$language[$HT_TR_PAS] = 'Korte pass';
	$language[$HT_TR_PM] = 'Positiespel';
	$language[$HT_TR_GK] = 'Keepen';
	$language[$HT_TR_OPM] = 'Openingen maken';
	$language[$HT_TR_CTR] = 'Controlerend spel';
	$language[$HT_TR_VLA] = 'Vleugelaanval';
	
	$language['conditie'] = 'Conditie';
	$language['training'] = 'Soort training';
	$language['trainingintensiteit'] = 'Trainingintensiteit';
	$language['assistenten'] = 'Aantal assistenten';

} elseif($_SESSION['language'] == 'US') {
	$language['intro']		=	"Please fill in your DutchScouts username and password to login and upload the current state of your Dutch players for the U20 and NT. Please keep in mind that all players will be saved and that the shown players are just an overview of the scanned players in your team. If there is a candidate among them, you will be contacted by a scout.<br/><br/>If you don't have an account on DutchScouts, you need to register once and give DutchScouts access to your teamdata. Do so by clicking on the link 'New user or password forgotten'.</br></br><strong>Update:</br>You don't have to update your players after training. DutchScouts updates your players automatically as long as you don't revoke the DutchScouts CHPP-license.</strong><br/><br/><br/>";
	$language['reg_intro']  =  'Thank you for giving DutchScouts access to read your playerstats.<br/><br/>If you want to give the scouts additional information, please fill in your name and password to logon to the DutchScouts-website.<br/><br/>';
	$language['toFullVersion']	=	'To full version';
	
	$language['incorrectAccount']	=	'Incorrect DutchScouts username or password';
	$language['noHTPermission']	=	"<FONT COLOR=FF0000>DutchScouts hasn't got permission te read yours players anymore.</FONT><BR>Please go to <u><a href=http://www.dutchscouts.nl/scan/loginHT.php>http://www.dutchscouts.nl</a></u> to give DutchScouts access to your players.<br>";
	
	$language['name']		=	'Login name';
	$language['password']	=   'Password';
	$language['retypepassword']=   'Retype password';
	$language['DSname']		=   'Login name (DutchScouts)';
	$language['DSpassword']	=   'Password (DutchScouts)';
	$language['differentPasswords'] = '*  Please type the same password twice.';
	$language['coachNameExists'] = '*  The username entered is an existing username. Please choose a different username.';
	$language['register']	=   'Register';
	$language['scan']		=	'Scan';
	$language['login']		=	'Login';
	$language['new']		=   'New user or password forgotten';
	
	$language['ID']			=	'ID';
	$language['player']		=	'Player';
	$language['lastPosition']	=	'Last Position';
	$language['age']		=	'Age';
	$language['interessant']		=	'Interesting?';
	
	$language['year']		=	'year';
	$language['days']		=	'days';
	$language[0] = '';
	$language[$HT_TR_SP] = 'Set Pieces';
	$language[$HT_TR_DEF] = 'Defending';
	$language[$HT_TR_SCO] = 'Scoring';
	$language[$HT_TR_CRO] = 'Cross Pass (Winger)';
	$language[$HT_TR_SHO] = 'Shooting';
	$language[$HT_TR_PAS] = 'Short Passes';
	$language[$HT_TR_PM] = 'Playmaking';
	$language[$HT_TR_GK] = 'Goaltending';
	$language[$HT_TR_OPM] = 'Through Passes';
	$language[$HT_TR_CTR] = 'Defensive Positions';
	$language[$HT_TR_VLA] = 'Wing Attacks';
	
	$language['conditie'] = 'Condition';
	$language['training'] = 'Trainingtype';
	$language['trainingintensiteit'] = 'Training intensity';
	$language['assistenten'] = 'Number of assistants';
}
?>
