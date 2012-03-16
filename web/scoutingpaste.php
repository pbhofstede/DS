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
				}
				else if ($vMax == $vIndexDEF) {
					$vIndexStr = 'DEF';
				}
				else if ($vMax == $vIndexCD) {
					$vIndexStr = 'CD';
				}
				else if ($vMax == $vIndexWB) {
					$vIndexStr = 'WB';
				}
				else if ($vMax == $vIndexIM) {
					$vIndexStr = 'IM';
				}
				else if ($vMax == $vIndexWG) {
					$vIndexStr = 'WG';
				}
				else if ($vMax == $vIndexSC) {
					$vIndexStr = 'SC';
				}
				else if ($vMax == $vIndexDFW) {
					$vIndexStr = 'DFW';
				}
				else if ($vMax == $vIndexSP) {
					$vIndexStr = 'SP';
				}		
				 
				echo '[table][tr][th]naam[/th][th]age[/th][th]kp[/th][th]def[/th][th]pm[/th][th]psn[/th][th]sco[/th][th]wing[/th][th]sh[/th][th]index '.$vIndexStr.'[/th][th]spec[/th][/tr]<BR>';

				foreach($playerList AS $player) {
					if ($player->getscoutid() == $scout->getId()) {
						echo '[tr]';
						echo '[td]'.$player->getName().'[/td]';
						echo '[td]'.$player->getLeeftijdStr().'[/td]';
						echo '[td]'.$player->getKeeper().'[/td]';
						echo '[td]'.$player->getDefender().'[/td]';
						echo '[td]'.$player->getPlaymaker().'[/td]';
						echo '[td]'.$player->getPassing().'[/td]';
						echo '[td]'.$player->getScorer().'[/td]';
						echo '[td]'.$player->getWinger().'[/td]';
						echo '[td]'.$player->getSetPieces().'[/td]';
						
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
