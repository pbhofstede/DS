<?php
include ('header.php');

if ($user != NULL) {
	$scouting	=	$user->getScout();
}
else {
  $scouting = NULL;
}

if (($user != NULL) &&
    (($scouting != NULL) or
		 ($user->getRank() == 'administrator') or 
		 ($user->getRank() == 'bc'))) {
	
	if (isset($_POST['submit'])) {
		$vSubKeeper = $_POST['keeper'];
		$vSubDefender = $_POST['defender'];
		$vSubPlaymaker = $_POST['playmaker'];
		$vSubWinger = $_POST['winger'];
		$vSubPassing = $_POST['passing'];
		$vSubScorer = $_POST['scorer'];
		$vSubSetpieces = $_POST['setpieces'];

		$player	=	PlayerDB::getPlayer($_GET['player']);
		$player->setKeeperSubSkill($vSubKeeper);
		$vSubDefender = $_POST['defender'];
		$player->setDefenderSubSkill($vSubDefender);
		$vSubPlaymaker = $_POST['playmaker'];
		$player->setPlaymakerSubSkill($vSubPlaymaker);
		$vSubWinger = $_POST['winger'];
		$player->setWingerSubSkill($vSubWinger);
		$vSubPassing = $_POST['passing'];
		$player->setPassingSubSkill($vSubPassing);
		$vSubScorer = $_POST['scorer'];
		$player->setScorerSubSkill($vSubScorer);
		$vSubSetpieces = $_POST['setpieces'];
		$player->setSetPiecesSubSkill($vSubSetpieces);
		
		$player->calcIndicesAndUpdateToDB();
		
		header("Location: ".$config['url']."/player/".$player->getId()."/");
	}
	else if (isset($_POST['cancel'])) {
		header("Location: ".$config['url']."/player/".$_GET['player']."/");
	}
	else {
		$player	=	PlayerDB::getPlayer($_GET['player']);
		if ($player != NULL) {	 
			echo '<h1>'.$player->getName().'</h1>';
			echo '<form action="" method="POST" name="updateSubSkill">';
			
			echo '<TABLE width="400px">';
			echo '<td>Keepen:</TD><TD>'.getSkillLevel($player->getKeeper()).' ('.$player->getKeeperStr().')</TD><TD width="20%"><input type="text" name="keeper" value="'.$player->getKeeperSubSkill().'"/></TD></TR>';
			echo '<td>Verdedigen:</TD><TD>'.getSkillLevel($player->getDefender()).' ('.$player->getDefenderStr().')</TD><TD><input type="text" name="defender" value="'.$player->getDefenderSubSkill().'"/></TD></TR>';
			echo '<td>Positiespel:</TD><TD>'.getSkillLevel($player->getPlaymaker()).' ('.$player->getPlaymakerStr().')</TD><TD><input type="text" name="playmaker" value="'.$player->getPlaymakerSubSkill().'"/></TD></TR>';
			echo '<td>Vleugelspel:</TD><TD>'.getSkillLevel($player->getWinger()).' ('.$player->getWingerStr().')</TD><TD><input type="text" name="winger" value="'.$player->getWingerSubSkill().'"/></TD></TR>';
			echo '<td>Passen:</TD><TD>'.getSkillLevel($player->getPassing()).' ('.$player->getPassingStr().')</TD><TD><input type="text" name="passing" value="'.$player->getPassingSubSkill().'"/></TD></TR>';
			echo '<td>Scoren:</TD><TD>'.getSkillLevel($player->getScorer()).' ('.$player->getScorerStr().')</TD><TD><input type="text" name="scorer" value="'.$player->getScorerSubSkill().'"/></TD></TR>';
			echo '<td>Spelhervatting:</TD><TD>'.getSkillLevel($player->getSetPieces()).' ('.$player->getSetPiecesStr().')</TD><TD><input type="text" name="setpieces" value="'.$player->getSetPiecesSubSkill().'"/></TD></TR>';
			


			echo '</TABLE>';
			echo '<input type="submit" name="cancel" value="Annuleren" /><input type="submit" name="submit" value="Opslaan" />';
		}
	}
}