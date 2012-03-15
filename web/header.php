<?php
include('config.php');
include('coach.php');
?>
<html>
	<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
	<link href="<?php echo $config['url'].'/style.css'; ?>" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript">
		var formInUse = false;

		function setFocus()
		{
		 if(!formInUse) {
			document.inlogForm.name.focus();
		 }
		}
		
		function maakU20(){
			if (confirm("Weet je zeker dat je deze speler aan de U20-scouting toe wilt voegen?")) { 
				window.location = "makeU20/";
			}
		}

		function maakNT(){
			if (confirm("Weet je zeker dat je deze speler aan de NT-scouting toe wilt voegen?")) { 
				window.location = "makeNT/";
			}
		}
	</script>
	</head>
	<body onload="setFocus()">
		<div class="chpp"><img src="<?php echo $config['url'].'/images/chpp.gif'; ?>" /></div>
		<div class="banner"><img src="<?php echo $config['url'].'/images/banner.png'; ?>" /></div>
		
		<div class="container">
			<div class="menu">
				<?php 
          echo '<span style="float: left">';
					echo '<a href="'.$config['url'].'/">Home</a> | ';
					echo '<a href="'.$config['scan_url'].'/">Scan</a> | ';
					echo '<a href="'.$config['url'].'/leeftijden/">U20-leeftijden</a>';
					
					$informationList = InformationDB::getInformationListByPublication('ja');
					if ($informationList != NULL) {
						foreach($informationList AS $information) {
							echo ' | <a href="'.$config['url'].'/content/'.$information->getAfkorting().'/">'.$information->getNaam().'</a>';
						}
					}
					echo '</span>';
					if (isset($_SESSION['dutchscouts']) && ($_SESSION['dutchscouts'] != NULL)) {
						echo '<span style="float: right"><a href="'.$config['url'].'/logout/">Uitloggen</a></span>';
					} else {
						echo '<span style="float: right"><a href="'.$config['url'].'/login/">Inloggen</a></span>';
					}
				?>
			</div>
			
			<?php
				if (isset($_SESSION['dutchscouts']) && 
			     ($_SESSION['dutchscouts'] != NULL) &&
					 ($user != NULL)) {
				  echo '<div class="submenu">';
					echo '<span class="menuItem"><a href="'.$config['url'].'/myTraining/">Mijn training</a></span>';
					echo '<span class="menuItem"><a href="'.$config['url'].'/myPlayers/">Mijn spelers</a></span>';
					
					$scout = $user->getScout();
					
					if (($scout != NULL) or
					    ($user->getRank() == 'administrator') or 
							($user->getRank() == 'bc')) {
						
						echo '<span class="menuItem"><a href="'.$config['url'].'/scoutOverview/">Scouting</a></span>';
						$informationList = InformationDB::getInformationListByPublication('scouts');
						if ($informationList != NULL) {
							foreach($informationList AS $information) {
								echo '<span class="menuItem"><a href="'.$config['url'].'/content/'.$information->getAfkorting().'/">'.$information->getNaam().'</a></span>';
							}
						}
						
						echo '<span class="menuItem"><a href="'.$config['url'].'/search/"><img src="'.$config['url'].'/images/zoom.png"/></a></span>';
					}
					
					if($user && (($user->getRank() == 'administrator') or (($user->getRank() == 'bc'))))  
					{
						echo '<span class="menuItem"><a href="'.$config['url'].'/U20/">U20 te koop</a></span>';
						echo '<span class="menuItem"><a href="'.$config['url'].'/NT/">NT te koop</a></span>'; 
					}
					
					if($user && $user->getRank() == 'administrator') {
						echo '<span class="menuItem"><a href="'.$config['url'].'/administration/">Scout Admin.</a></span>';
						echo '<span class="menuItem"><a href="'.$config['url'].'/information/">Informatie beheer</a></span>';
						$informationList = InformationDB::getInformationListByPublication('admin');
						if ($informationList != NULL) {
							foreach($informationList AS $information) {
								echo '<span class="menuItem"><a href="'.$config['url'].'/content/'.$information->getAfkorting().'/">'.$information->getNaam().'</a></span>';
							}
						}
					}
					echo '<span class="menuItemLast"><a href="'.$config['url'].'/contact/"><img src="'.$config['url'].'/images/email.png"/></a></span>';
					echo '</div>';
					if (InformationDB::getSiteStats('training_running') == -1) {
						echo "Training running: ".InformationDB::getSiteStatsTrainingRunning();
					}
				}
				else {
					$user = Null;
				}
			?>
			
			<div class="content">
