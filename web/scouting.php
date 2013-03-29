<?php
include ('header.php');
echo '<h1>Scoutgroepen</h1>';

if (!empty($_GET['b'])) {
	$sort = $_GET['b'];
}
else {
	$sort = 'cmpBestIndex';
}

if ($user != NULL) {
	$scouting	=	$user->getScout();
}
else
{
  $scouting = NULL;
}

$allPlayers = TRUE;

if ($scouting != NULL) {
	foreach($scouting AS $scout) {
		if($scout->getId() == $_GET['a']) {
			if ((strpos($scout->getName(), 'FWC') === FALSE) &&
					(strpos($scout->getName(), 'QWC') === FALSE) &&
					(strpos($scout->getName(), 'U20') === FALSE)) {
				$u20 = FALSE;
				echo '<P align="right">Ook spelers uit andere scoutlichtingen laten zien die voldoen aan deze index  ';
				if (!empty($_GET['c'])) {
					$allPlayers = TRUE;
					echo '<input align="right" type="checkbox" CHECKED onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/'.$sort.'/'.(! $allPlayers).'\'"><BR>';
				}
				else {
					$allPlayers = FALSE;
					echo '<input align="right" type="checkbox" onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/'.$sort.'/'.(! $allPlayers).'/\'"><BR>';
				}
			}
			else {
				$u20 = TRUE;
			}
			echo '<form action="'.$config['url'].'/scoutingpaste.php" method="get" target="_blank">';
			echo '<input type="hidden" name="a" value="'.$_GET['a'].'"/>';
			echo 'Index 1: ';
			echo '<select name="index1">';
			echo '<option value="indexGK">GK</option>';
			echo '<option value="indexCD">CD</option>';
			echo '<option value="indexDEF">DEF</option>';
			echo '<option value="indexWB">WB</option>';
			echo '<option value="indexIM">IM</option>';
			echo '<option value="indexWG">WG</option>';
			echo '<option value="indexSC">SC</option>';
			echo '<option value="indexDFW">DFW</option>';
			echo '<option value="indexSP">SP</option>';
			echo '</select>';
			if ($u20) {
				echo '<input type = hidden name="index2">';
			}
			else {
				echo '  Index 2:';
				echo '<select name="index2">';
				echo '<option value=""></option>';
				echo '<option value="indexGK">GK</option>';
				echo '<option value="indexCD">CD</option>';
				echo '<option value="indexDEF">DEF</option>';
				echo '<option value="indexWB">WB</option>';
				echo '<option value="indexIM">IM</option>';
				echo '<option value="indexWG">WG</option>';
				echo '<option value="indexSC">SC</option>';
				echo '<option value="indexDFW">DFW</option>';
				echo '<option value="indexSP">SP</option>';
				echo '</select>';
			}
			echo '<input type="submit" value="Copy naar forum" />';
			echo '</form>';
			
			echo "</P>";
		}
	}
}	

function cmpDate($playerA, $playerB)
{
 	if ($playerA->getDateOfBirth() > $playerB->getDateOfBirth())
 		return -1;
 	else if ($playerA->getDateOfBirth() < $playerB->getDateOfBirth())
 		return 1;
 	else
		return 0;
}

function cmpBestIndex($playerA, $playerB)
{
 	if ($playerA->getBestIndexScout() > $playerB->getBestIndexScout())
 		return -1;
 	else if ($playerA->getBestIndexScout() < $playerB->getBestIndexScout())
 		return 1;
 	else
		return 0;
}

function cmpBestIndexKwal($playerA, $playerB)
{
	$a = Round($playerA->getLeeftijdWeken() + $playerA->getBestIndexScout() - 200, 2);
	$b = Round($playerB->getLeeftijdWeken() + $playerB->getBestIndexScout() - 200, 2);
	
 	if ($a > $b)
 		return -1;
 	else if ($a < $b)
 		return 1;
 	else
		return 0;
}


function cmpBirthday($playerA, $playerB)
{
 	if ($playerA->getDateOfBirth() > $playerB->getDateOfBirth())
 		return -1;
 	else if ($playerA->getDateOfBirth() < $playerB->getDateOfBirth())
 		return 1;
 	else
		return 0;
}

function cmpName($playerA, $playerB)
{
 	if ($playerA->getName() < $playerB->getName())
 		return -1;
 	else if ($playerA->getName() > $playerB->getName())
 		return 1;
 	else
		return 0;
}

function cmpSpec($playerA, $playerB)
{
 	if ($playerA->getSpeciality() < $playerB->getSpeciality())
 		return 1;
 	else if ($playerA->getSpeciality() > $playerB->getSpeciality())
 		return -1;
 	else
		return 0;
}

function cmpKe($playerA, $playerB)
{
 	if ($playerA->getKeeper() < $playerB->getKeeper())
 		return 1;
 	else if ($playerA->getKeeper() > $playerB->getKeeper())
 		return -1;
 	else if ($playerA->getKeeperStr(true) < $playerB->getKeeperStr(true))
		return 1;
	else if ($playerA->getKeeperStr(true) > $playerB->getKeeperStr(true))
		return -1;
	else
		return 0;
}

function cmpVe($playerA, $playerB)
{
 	if ($playerA->getDefender() < $playerB->getDefender())
 		return 1;
 	else if ($playerA->getDefender() > $playerB->getDefender())
 		return -1;
 	else if ($playerA->getDefenderStr(true) < $playerB->getDefenderStr(true))
		return 1;
	else if ($playerA->getDefenderStr(true) > $playerB->getDefenderStr(true))
		return -1;
	else
		return 0;
}

function cmpPo($playerA, $playerB)
{
 	if ($playerA->getPlaymaker() < $playerB->getPlaymaker())
 		return 1;
 	else if ($playerA->getPlaymaker() > $playerB->getPlaymaker())
 		return -1;
 	else if ($playerA->getPlaymakerStr(true) < $playerB->getPlaymakerStr(true))
		return 1;
	else if ($playerA->getPlaymakerStr(true) > $playerB->getPlaymakerStr(true))
		return -1;
	else
		return 0;
}

function cmpVl($playerA, $playerB)
{
 	if ($playerA->getWinger() < $playerB->getWinger())
 		return 1;
 	else if ($playerA->getWinger() > $playerB->getWinger())
 		return -1;
 	else if ($playerA->getWingerStr(true) < $playerB->getWingerStr(true))
		return 1;
	else if ($playerA->getWingerStr(true) > $playerB->getWingerStr(true))
		return -1;
	else
		return 0;
}

function cmpPa($playerA, $playerB)
{
 	if ($playerA->getPassing() < $playerB->getPassing())
 		return 1;
 	else if ($playerA->getPassing() > $playerB->getPassing())
 		return -1;
 	else if ($playerA->getPassingStr(true) < $playerB->getPassingStr(true))
		return 1;
	else if ($playerA->getPassingStr(true) > $playerB->getPassingStr(true))
		return -1;
	else
		return 0;
}

function cmpSc($playerA, $playerB)
{
 	if ($playerA->getScorer() < $playerB->getScorer())
 		return 1;
 	else if ($playerA->getScorer() > $playerB->getScorer())
 		return -1;
 	else if ($playerA->getScorerStr(true) < $playerB->getScorerStr(true))
		return 1;
	else if ($playerA->getScorerStr(true) > $playerB->getScorerStr(true))
		return -1;
	else
		return 0;
}

function cmpSP($playerA, $playerB)
{
 	if ($playerA->getSetPieces() < $playerB->getSetPieces())
 		return 1;
 	else if ($playerA->getSetPieces() > $playerB->getSetPieces())
 		return -1;
 	else if ($playerA->getSetPiecesStr(true) < $playerB->getSetPiecesStr(true))
		return 1;
	else if ($playerA->getSetPiecesStr(true) > $playerB->getSetPiecesStr(true))
		return -1;
	else
		return 0;
}

function cmpUpdate($playerA, $playerB)
{
 	if ($playerA->getLastUpdate() < $playerB->getLastUpdate())
 		return -1;
 	else if ($playerA->getLastUpdate() > $playerB->getLastUpdate())
 		return 1;
 	else
		return 0;
}

function cmpTraining($playerA, $playerB)
{
 	if ($playerA->getlasttraining() < $playerB->getlasttraining())
 		return -1;
 	else if ($playerA->getlasttraining() > $playerB->getlasttraining())
 		return 1;
 	else
		return 0;
}

if($scouting != NULL) {
	foreach($scouting AS $scout) {
		if($scout->getId() == $_GET['a']) {
			$playerList		=	$scout->getPlayerList($allPlayers);
			echo '<h2>Scoutgroep: '.$scout->getName().'</h2>';
			echo '<table width="100%" class="list">';
			echo '<tr>';
			echo '<th colspan="21">Spelers</th>';
			echo '</tr>';
			echo '<tr class="niveau1">';
			echo '<td>ID</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpName/'.$allPlayers.'/\'">Speler</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpSpec/'.$allPlayers.'/\'">Spec</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpKe/'.$allPlayers.'/\'">Ke</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpVe/'.$allPlayers.'/\'">Ve</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpPo/'.$allPlayers.'/\'">Po</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpVl/'.$allPlayers.'/\'">Vl</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpPa/'.$allPlayers.'/\'">Pa</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpSc/'.$allPlayers.'/\'">Sc</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpSP/'.$allPlayers.'/\'">Sp</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpBirthday/'.$allPlayers.'/\'">Leeftijd</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpUpdate/'.$allPlayers.'/\'">Update</td>';
			echo '<td>Co%</td>';
			echo '<td>TI</td>';
			echo '<td>Trnr</td>';
			echo '<td>Ass</td>';
			echo '<td>TRN</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpTraining/'.$allPlayers.'/\'">% TRN</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpBestIndex/'.$allPlayers.'/\'">Index</td>';
			echo '<td onClick="top.location=\''.$config['url'].'/scouting/'.$_GET['a'].'/cmpBestIndexKwal/'.$allPlayers.'/\'">Kwal.</td>';
			echo '<td>U20</td>';
			echo '</tr>';

			if($playerList != NULL) {				 
				usort($playerList, $sort);
				 
				foreach($playerList AS $player) {
					if ($player->getU20()) {
						$afwijkingDagen = $player->getU20AfwijkingDagen();
					}
					else {
					  $afwijkingDagen = 999;
					}
				  
					if ($player->getU20()) {
						if ($afwijkingDagen > 0) {
							echo '<tr bgColor="FFEEEE" onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						}
						else {
							echo '<tr bgColor="FFFFFF" onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						}
					}
					else {
					  if ($player->getscoutid() == $scout->getId()) {
						 echo '<tr bgColor="DAFAFA" onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						}
						else if ($player->getscoutid() > 0) {
						 echo '<tr bgColor="FFCCCC" onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						}
						else {
						 echo '<tr bgColor="EEEEEE" onClick="top.location=\''.$config['url'].'/player/'.$player->getId().'/\'">';
						}
					}
					echo '<td>'.$player->getID().'</td>';
					echo '<td>'.$player->getName().'</td>';
					echo '<td>'.$specs[$player->getSpeciality()].'</td>';
					echo '<td>'.$player->getKeeperStr().'</td>';
					echo '<td>'.$player->getDefenderStr().'</td>';
					echo '<td>'.$player->getPlaymakerStr().'</td>';
					echo '<td>'.$player->getWingerStr().'</td>';
					echo '<td>'.$player->getPassingStr().'</td>';
					echo '<td>'.$player->getScorerStr().'</td>';
					echo '<td>'.$player->getSetPiecesStr().'</td>';
					echo '<td>'.$player->getLeeftijdStr().'</td>';
					echo '<td>'.date("d-m-y", $player->getLastUpdate()).'</td>';
					echo '<td>'.$player->getconditieperc().'</td>';
					echo '<td>'.$player->gettrainingintensity().'</td>';
					echo '<td align="center">'.$player->gettrainerskill().'</td>';
					echo '<td>'.$player->getassistants().'</td>';
  				echo '<td>'.$language[$player->gettrainingtype()+20].'</td>';
					echo '<td>'.$player->getlasttraining().'%</td>';
					$index = $player->getBestIndexScout();
					echo '<td>'.$player->getBestIndexScoutName().': '.$index.'</td>';
					echo '<td>'.Round($player->getLeeftijdWeken() + $index - 200, 2).'</td>';
					if ($player->getU20()) {
						echo '<td>'.$afwijkingDagen.'</td>';
					}
					else {
						echo '<td></td>';
					}
					echo '</tr>';
				}
			} 
			else {
				echo '<tr><td colspan="18">Geen spelers in deze groep aanwezig.<td></tr>';
			}
			echo '</table>';
		}
	}
	echo '<span style="float: right"><a href="'.$config['url'].'/scoutOverview/">Terug naar scouting</a></span>';
} 
else {
	header("Location: ".$config['url']."/");
}
include ('footer.php');
?>