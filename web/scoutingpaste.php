<?php

include('config.php');
include('coach.php');

if ($user != NULL) {
	$scouting	=	$user->getScout();
}
else
{
  $scouting = NULL;
}

function cmpDate($playerA, $playerB) {
 	if ($playerA->getDateOfBirth() > $playerB->getDateOfBirth())
 		return -1;
 	else if ($playerA->getDateOfBirth() < $playerB->getDateOfBirth())
 		return 1;
 	else
		return 0;
}

if($scouting != NULL) {
	foreach($scouting AS $scout) {
		if($scout->getId() == $_GET['a']) {
			if ((strpos($scout->getName(), 'FWC') === FALSE) &&
					(strpos($scout->getName(), 'QWC') === FALSE) &&
					(strpos($scout->getName(), 'U20') === FALSE)) {
				
				$u20 = FALSE;
			}
			else {
			  $u20 = TRUE;
			}
			
			$playerList	=	$scout->getPlayerList($u20);
			
			if($playerList != NULL) {				 
				usort($playerList, 'cmpDate');
				
				$vIndexGK = 0;
				$vIndexDEF = 0;
				$vIndexCD = 0;
				$vIndexWB = 0;
				$vIndexIM = 0;
				$vIndexWG = 0;
				$vIndexSC = 0;
				$vIndexDFW = 0;
				$vIndexSP = 0;
				
				
				$vMax = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				
				if ($_GET['index1'] == 'indexGK') {
					$vIndexStr = 'GK';
				}
				else if ($_GET['index1'] == 'indexDEF') {
					$vIndexStr = 'DEF';
				}
				else if ($_GET['index1'] == 'indexCD') {
					$vIndexStr = 'CD';
				}
				else if ($_GET['index1'] == 'indexWB') {
					$vIndexStr = 'WB';
				}
				else if ($_GET['index1'] == 'indexIM') {
					$vIndexStr = 'IM';
				}
				else if ($_GET['index1'] == 'indexWG') {
					$vIndexStr = 'WG';
				}
				else if ($_GET['index1'] == 'indexSC') {
					$vIndexStr = 'SC';
				}
				else if ($_GET['index1'] == 'indexDFW') {
					$vIndexStr = 'DFW';
				}
				else {
					$vIndexStr = 'SP';
				}

				if ($_GET['index2'] == 'indexGK') {
					$vIndex2Str = 'GK';
				}
				else if ($_GET['index2'] == 'indexDEF') {
					$vIndex2Str = 'DEF';
				}
				else if ($_GET['index2'] == 'indexCD') {
					$vIndex2Str = 'CD';
				}
				else if ($_GET['index2'] == 'indexWB') {
					$vIndex2Str = 'WB';
				}
				else if ($_GET['index2'] == 'indexIM') {
					$vIndex2Str = 'IM';
				}
				else if ($_GET['index2'] == 'indexWG') {
					$vIndex2Str = 'WG';
				}
				else if ($_GET['index2'] == 'indexSC') {
					$vIndex2Str = 'SC';
				}
				else if ($_GET['index2'] == 'indexDFW') {
					$vIndex2Str = 'DFW';
				}
				else {
					$vIndex2Str = 'SP';
				}
				 
				echo '[table][tr][th]naam[/th][th]age[/th]';
				if ($vIndexStr == 'GK') {
					echo '[th]kp[/th]';
				}
				if (($vIndexStr == 'GK') ||
				    ($vIndexStr == 'DEF') ||
						($vIndexStr == 'CD') ||
						($vIndexStr == 'WB') ||
						($vIndexStr == 'IM') ||
						($vIndexStr == 'WG') ||
						($vIndexStr == 'SP')) {
					echo '[th]def[/th]';
				}
				if (($vIndexStr == 'DEF') ||
						($vIndexStr == 'CD') ||
						($vIndexStr == 'WB') ||
						($vIndexStr == 'IM') ||
						($vIndexStr == 'WG') ||
						($vIndexStr == 'DFW') ||
						($vIndexStr == 'SP')) {
					echo '[th]pm[/th]';
				}
				if (($vIndexStr == 'GK') ||
				    ($vIndexStr == 'DEF') ||
						($vIndexStr == 'CD') ||
						($vIndexStr == 'WB') ||
						($vIndexStr == 'IM') ||
						($vIndexStr == 'WG') ||
						($vIndexStr == 'SC') ||
						($vIndexStr == 'DFW') ||
						($vIndexStr == 'SP')) {
					echo '[th]psn[/th]';
				}
				if (($vIndexStr == 'WG') ||
						($vIndexStr == 'SC') ||
						($vIndexStr == 'DFW')) {
					echo '[th]sco[/th]';
				}
				if (($vIndexStr == 'WB') ||
						($vIndexStr == 'WG') ||
						($vIndexStr == 'SC') ||
						($vIndexStr == 'DFW')) {
					echo '[th]wing[/th]';
				}	
				if (($vIndexStr == 'GK') ||
						($vIndexStr == 'SP')) {
					echo '[th]sh[/th]';
				}
				echo '[th]index '.$vIndexStr.'[/th][th]index '.$vIndex2Str.'[/th][th]spec[/th][/tr]<BR>';

				foreach($playerList AS $player) {
					if (($u20) ||
					   ($player->getscoutid() == $scout->getId())) {
						echo '[tr]';
						echo '[td]'.$player->getName().'[/td]';
						echo '[td]'.$player->getLeeftijdStr().'[/td]';
						if ($vIndexStr == 'GK') {
							echo '[td]'.$player->getKeeper().'[/td]';
						}
						if (($vIndexStr == 'GK') ||
				        ($vIndexStr == 'DEF') ||
								($vIndexStr == 'CD') ||
								($vIndexStr == 'WB') ||
								($vIndexStr == 'IM') ||
								($vIndexStr == 'WG') ||
								($vIndexStr == 'SP')) {
							echo '[td]'.$player->getDefender().'[/td]';
						}
						if (($vIndexStr == 'DEF') ||
								($vIndexStr == 'CD') ||
								($vIndexStr == 'WB') ||
								($vIndexStr == 'IM') ||
								($vIndexStr == 'WG') ||
								($vIndexStr == 'DFW') ||
								($vIndexStr == 'SP')) {
							echo '[td]'.$player->getPlaymaker().'[/td]';
						}
						if (($vIndexStr == 'GK') ||
								($vIndexStr == 'DEF') ||
								($vIndexStr == 'CD') ||
								($vIndexStr == 'WB') ||
								($vIndexStr == 'IM') ||
								($vIndexStr == 'WG') ||
								($vIndexStr == 'SC') ||
								($vIndexStr == 'DFW') ||
								($vIndexStr == 'SP')) {
							echo '[td]'.$player->getPassing().'[/td]';
						}
						if (($vIndexStr == 'WG') ||
								($vIndexStr == 'SC') ||
								($vIndexStr == 'DFW')) {
							echo '[td]'.$player->getScorer().'[/td]';
						}
						if (($vIndexStr == 'WB') ||
								($vIndexStr == 'WG') ||
								($vIndexStr == 'SC') ||
								($vIndexStr == 'DFW')) {
							echo '[td]'.$player->getWinger().'[/td]';
						}
						if (($vIndexStr == 'GK') ||
								($vIndexStr == 'SP')) {
							echo '[td]'.$player->getSetPieces().'[/td]';
						}
						
						//if ($player->getBestIndexName() == $vIndexStr) {
						//	echo '[td]'.$player->getBestIndex().'[/td]';
						//}
						//else {
						//	$vGewildeIndex = $player->getIndexByName($vIndexStr);
						//	if ($vGewildeIndex >= ($player->getBestIndex() - 7)) {
						//		echo '[td]'.$vGewildeIndex.'[/td]';
						//	}
						//	else {
						//	  echo '[td]'.$player->getBestIndex().' ('.$player->getBestIndexName().')[/td]';
						//	}
						//}
						
						echo '[td]'.$player->getIndexByName($vIndexStr).'[/td]';
						
						echo '[td]'.$player->getIndexByName($vIndex2Str).'[/td]';
						echo '[td]'.$specs[$player->getSpeciality()].'[/td]';
						echo '[/tr]<BR>';
					}
				}
			}
			echo '[/table]';
		}
	}
} 
else {
	header("Location: ".$config['url']."/");
}
?>
