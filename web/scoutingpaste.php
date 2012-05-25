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
			$playerList	=	$scout->getPlayerList(false);
			
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
				
				
				foreach($playerList AS $player) {
					if ($player->getscoutid() == $scout->getId()) {
						$vIndexGK = $vIndexGK + $player->getIndexGK();
						$vIndexDEF = $vIndexDEF + $player->getIndexDEF();
						$vIndexCD = $vIndexCD + $player->getIndexCD();
						$vIndexWB = $vIndexWB + $player->getIndexWB();
						$vIndexIM = $vIndexIM + $player->getIndexIM();
						$vIndexWG = $vIndexWG + $player->getIndexWG();
						$vIndexSC = $vIndexSC + $player->getIndexSC();
						$vIndexDFW = $vIndexDFW + $player->getIndexDFW();
						$vIndexSP = $vIndexSP + $player->getIndexSP();
					}
				}
				
				$vMax = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				
				if ($vMax == $vIndexGK) {
					$vIndexStr = 'GK';
					
					$vMax2 = max($vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexDEF) {
					$vIndexStr = 'DEF';
					
					$vMax2 = max($vIndexGK, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexCD) {
					$vIndexStr = 'CD';
					
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexWB) {
					$vIndexStr = 'WB';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexIM) {
					$vIndexStr = 'IM';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexWG, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexWG) {
					$vIndexStr = 'WG';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexSC, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexSC) {
					$vIndexStr = 'SC';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexDFW, $vIndexSP);
				}
				else if ($vMax == $vIndexDFW) {
					$vIndexStr = 'DFW';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexSP);
				}
				else if ($vMax == $vIndexSP) {
					$vIndexStr = 'SP';
					$vMax2 = max($vIndexGK, $vIndexDEF, $vIndexCD, $vIndexWB, $vIndexIM, $vIndexWG, $vIndexSC, $vIndexDFW);
				}

				if ($vMax2 == $vIndexGK) {
					$vIndex2Str = 'GK';
				}
				else if ($vMax2 == $vIndexDEF) {
					$vIndex2Str = 'DEF';
				}
				else if ($vMax2 == $vIndexCD) {
					$vIndex2Str = 'CD';
				}
				else if ($vMax2 == $vIndexWB) {
					$vIndex2Str = 'WB';
				}
				else if ($vMax2 == $vIndexIM) {
					$vIndex2Str = 'IM';
				}
				else if ($vMax2 == $vIndexWG) {
					$vIndex2Str = 'WG';
				}
				else if ($vMax2 == $vIndexSC) {
					$vIndex2Str = 'SC';
				}
				else if ($vMax2 == $vIndexDFW) {
					$vIndex2Str = 'DFW';
				}
				else if ($vMax2 == $vIndexSP) {
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
					if ($player->getscoutid() == $scout->getId()) {
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
						if ($player->getBestIndexName() == $vIndexStr) {
							echo '[td]'.$player->getBestIndex().'[/td]';
						}
						else {
							$vGewildeIndex = $player->getIndexByName($vIndexStr);
							if ($vGewildeIndex >= ($player->getBestIndex() - 7)) {
								echo '[td]'.$vGewildeIndex.'[/td]';
							}
							else {
							  echo '[td]'.$player->getBestIndex().' ('.$player->getBestIndexName().')[/td]';
							}
						}
						
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
