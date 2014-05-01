<?php
ob_start();
session_start();

include('functions.php');

require('../scan/class/PHT.php');

include("ckeditor/ckeditor.php") ;

require('../scan/class/db/db.class.php');

require('../scan/class/coach.class.php');
require('../scan/class/db/coach.db.class.php');

require('class/information.class.php');
require('class/db/information.db.class.php');

require ('class/nationalplayers.class.php');
require ('class/db/nationalplayers.db.class.php');

require('../scan/class/player.class.php');
require('../scan/class/db/player.db.class.php');

require('class/playerComment.class.php');
require('class/db/playerComment.db.class.php');

require('class/playerLog.class.php');
require('class/db/playerLog.db.class.php');

require('class/playerTraining.class.php');
require('class/db/playerTraining.db.class.php');

require('class/scout.class.php');
require('class/db/scout.db.class.php');

require('class/training.class.php');
require('class/db/training.db.class.php');

require('class/scoutRequirements.class.php');
require('class/db/scoutRequirements.db.class.php');

require('../scan/calcTraining.php');

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

$specs   = array(NULL, "T", "Q", "P", "U", "H", "R");

$const_player_sql = 
		"SELECT player.id, player.coach, player.teamid, coachteams.teamname, player.name, player.dateOfBirth, player.tsi, player.salary, player.injury, player.aggressiveness, player.agreeability, player.honesty, player.leadership, ".
			"  player.speciality, player.form, player.stamina, player.experience, ".
			"  player.keeper, player.defender, player.playmaker, player.winger, player.passing, player.scorer, player.setPieces, ".
			"  player.caps, player.capsU20, player.added, player.lastupdate, player.scoutid, ".
			"  player.indexGK, player.indexCD, player.indexDEF, player.indexWB, player.indexIM, player.indexWG, player.indexSC, player.indexDFW, player.indexSP, ".
			"  player.keeperSubSkill, player.defenderSubSkill, player.playmakerSubSkill, player.wingerSubSkill, player.passingSubSkill, player.scorerSubSkill, player.setPiecesSubSkill, ".
			"  player.lasttraining, player.u20, coachteams.leagueid, coachteams.bot, coachteams.doctors, coachteams.trainingtype, coachteams.conditieperc, coachteams.trainingintensity, coachteams.trainerskill, coachteams.assistants, coachteams.formcoach, player.sundayTraining ".
			"FROM player left join coach on (player.coach = coach.id) left join coachteams on (player.coach = coachteams.coachid and coachteams.teamid = coalesce(player.teamid, coach.teamid))";


if ($_SERVER["SERVER_NAME"] == 'localhost') {
	$config['url']			=	'http://localhost:801/dutchscouts/web';
	$config['scan_url']		=	'http://localhost:801/dutchscouts/scan';
  $config['urlweb']		=	'http://localhost:801/dutchscouts/web';
}
else {
	$config['url']			=	'http://www.dutchscouts.nl/web';
	$config['scan_url']		=	'http://www.dutchscouts.nl/scan';
  $config['urlweb']		=	'http://www.dutchscouts.nl/web';
} 

if(!empty($_GET['language'])) {
	if($_GET['language'] == 'NL') {
		$_SESSION['language']	=	'NL';
	} elseif($_GET['language'] == 'US') {
		$_SESSION['language']	=	'US';
	}
}

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


$language[20] = '';
$language[$HT_TR_SP + 20] = 'SP';
$language[$HT_TR_DEF + 20] = 'DEF';
$language[$HT_TR_SCO + 20] = 'SCO';
$language[$HT_TR_CRO + 20] = 'VL';
$language[$HT_TR_SHO + 20] = 'SHO';
$language[$HT_TR_PAS + 20] = 'PAS';
$language[$HT_TR_PM + 20] = 'PM';
$language[$HT_TR_GK + 20] = 'K';
$language[$HT_TR_OPM + 20] = 'OPM';
$language[$HT_TR_CTR + 20] = 'CTR';
$language[$HT_TR_VLA + 20] = 'VLA';

if(empty($_SESSION['language']) || $_SESSION['language'] == 'NL') {
	$language['intro']		=	'Vul hieronder je gegevens in om je spelers te uploaden voor het U20 en NT. Bedenkt dat alle spelers opgeslagen worden en dat feit dat een speler na scannen getoont wordt het niet betekend dat deze een kans maakt in het U20 of NT. Mocht dit het geval zijn dan zal een scout je hiervan op de hoogte brengen.<br /><br />Update je spelers aub ook elke week of tenminste na elke pop.<br /><br /><br />';
	$language['toFullVersion']	=	'Naar uitgebreide pagina';
	
	$language['name']		=	'Naam';
	$language['scan']		=	'Scannen';
	
	$language['ID']			=	'ID';
	$language['player']		=	'Speler';
	$language['lastPosition']	=	'Laatste Positie';
	$language['age']		=	'Leeftijd';
	
	$language['year']		=	'jaar';
	$language['days']		=	'dagen';
	$specs_long = array("&nbsp;", "Technisch", "Snel", "Krachtig", "Onvoorspelbaar", "Koppen", "Snel herstel");

} elseif($_SESSION['language'] == 'US') {
	$language['intro']		=	'Please fill in your DutchScouts username and password to login and upload the current state of your Dutch players for the U20 and NT. Please keep in mind that all players will be saved and that the shown players are just an overview of the scanned players in your team. If there is a candidate among them, you will be contacted by a scout.<br /><br />Please scan your players every week or at least when they pop.<br /><br /><br />';
	$language['toFullVersion']	=	'To full version';
	
	$language['name']		=	'Login name';
	$language['scan']		=	'Scan';
	
	$language['ID']			=	'ID';
	$language['player']		=	'Player';
	$language['lastPosition']	=	'Last Position';
	$language['age']		=	'Age';
	
	$language['year']		=	'year';
	$language['days']		=	'days';
	
	$specs_long = array("&nbsp;", "Technical", "Quick", "Powerful", "Unpredictable", "Head specialist", "Regainer");
}
?>
