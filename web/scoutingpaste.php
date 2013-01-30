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

function cmpIndexGK($playerA, $playerB)
{
 	if ($playerA->getIndexGK() > $playerB->getIndexGK())
 		return -1;
 	else if ($playerA->getIndexGK() < $playerB->getIndexGK())
 		return 1;
 	else
		return 0;
}

function cmpIndexDEF($playerA, $playerB)
{
 	if ($playerA->getIndexDEF() > $playerB->getIndexDEF())
 		return -1;
 	else if ($playerA->getIndexDEF() < $playerB->getIndexDEF())
 		return 1;
 	else
		return 0;
}

function cmpIndexCD($playerA, $playerB)
{
 	if ($playerA->getIndexCD() > $playerB->getIndexCD())
 		return -1;
 	else if ($playerA->getIndexCD() < $playerB->getIndexCD())
 		return 1;
 	else
		return 0;
}

function cmpIndexWB($playerA, $playerB)
{
 	if ($playerA->getIndexWB() > $playerB->getIndexWB())
 		return -1;
 	else if ($playerA->getIndexWB() < $playerB->getIndexWB())
 		return 1;
 	else
		return 0;
}

function cmpIndexIM($playerA, $playerB)
{
 	if ($playerA->getIndexIM() > $playerB->getIndexIM())
 		return -1;
 	else if ($playerA->getIndexIM() < $playerB->getIndexIM())
 		return 1;
 	else
		return 0;
}

function cmpIndexWG($playerA, $playerB)
{
 	if ($playerA->getIndexWG() > $playerB->getIndexWG())
 		return -1;
 	else if ($playerA->getIndexWG() < $playerB->getIndexWG())
 		return 1;
 	else
		return 0;
}

function cmpIndexSC($playerA, $playerB)
{
 	if ($playerA->getIndexSC() > $playerB->getIndexSC())
 		return -1;
 	else if ($playerA->getIndexSC() < $playerB->getIndexSC())
 		return 1;
 	else
		return 0;
}

function cmpIndexDFW($playerA, $playerB)
{
 	if ($playerA->getIndexDFW() > $playerB->getIndexDFW())
 		return -1;
 	else if ($playerA->getIndexDFW() < $playerB->getIndexDFW())
 		return 1;
 	else
		return 0;
}

function cmpIndexSP($playerA, $playerB)
{
 	if ($playerA->getIndexSP() > $playerB->getIndexSP())
 		return -1;
 	else if ($playerA->getIndexSP() < $playerB->getIndexSP())
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
					$sortName = 'cmpIndexGK';
				}
				else if ($_GET['index1'] == 'indexDEF') {
					$vIndexStr = 'DEF';
					$sortName = 'cmpIndexDEF';
				}
				else if ($_GET['index1'] == 'indexCD') {
					$vIndexStr = 'CD';
					$sortName = 'cmpIndexCD';
				}
				else if ($_GET['index1'] == 'indexWB') {
					$vIndexStr = 'WB';
					$sortName = 'cmpIndexWB';
				}
				else if ($_GET['index1'] == 'indexIM') {
					$vIndexStr = 'IM';
					$sortName = 'cmpIndexIM';
				}
				else if ($_GET['index1'] == 'indexWG') {
					$vIndexStr = 'WG';
					$sortName = 'cmpIndexWG';
				}
				else if ($_GET['index1'] == 'indexSC') {
					$vIndexStr = 'SC';
					$sortName = 'cmpIndexSC';
				}
				else if ($_GET['index1'] == 'indexDFW') {
					$vIndexStr = 'DFW';
					$sortName = 'cmpIndexDFW';
				}
				else {
					$vIndexStr = 'SP';
					$sortName = 'cmpIndexSP';
				}

				if ($_GET['index2'] == '') {
					$vIndex2Str = '';
				}
				else if ($_GET['index2'] == 'indexGK') {
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
				
				if ($u20) {
					usort($playerList, $sortName);
				}
				else {
					usort($playerList, 'cmpDate');
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
				echo '[th]index '.$vIndexStr.'[/th]';
				if ((! $u20) &&
				   ($vIndex2Str <> '')) {
					echo '[th]index '.$vIndex2Str.'[/th]';
				}
				echo '[th]spec[/th][/tr]<BR>';

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
						if ((! $u20) &&
						    ($vIndex2Str <> '')) {
							echo '[td]'.$player->getIndexByName($vIndex2Str).'[/td]';
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
