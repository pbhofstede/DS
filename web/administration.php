<?php
include ('header.php');
if ($user == Null) {
	redirect($config['url'].'/', 0);
}
else if ($user->getRank() != 'administrator') {
	echo 'Geen toegang';
} 
else {
	echo '<h2>Scout Administratie</h2>';
	
	if(isset($_GET['a']) && ($_GET['a'] == 'new')) {
		if($_POST['submit']) {
			ScoutDB::insertScout(new Scout(NULL, $_POST['scouting']));
			echo '<table width="100%" style="border: 1px solid black">';
				echo '<tr>';
					echo '<td style="padding: 3px; background-color: black; color: white">Status</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td>Groep "'.output($_POST['scouting']).'" toegevoegd</td>';
				echo '</tr>';
			echo '</table>';
			echo '<br /><br />';
		}
		
		echo '<form action="" method="POST">';
			echo '<table width="100%" style="border: 1px solid black">';
				echo '<tr>';
					echo '<td colspan="2" style="padding: 3px; background-color: black; color: white">Nieuwe scouting groep</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><input type="text" name="scouting" /></td>';
					echo '<td><input type="submit" name="submit" value="Toevoegen" /></td>';
				echo '</tr>';
			echo '</table>';
		echo '</form>';
	} elseif(isset($_GET['a']) && ($_GET['a'] == 'delete')) {
		ScoutDB::deleteScout($_GET['b']);
		redirect($config['url'].'/administration/');
	} elseif(isset($_GET['a']) && ($_GET['a'] != NULL)) 
	{
		$scouting		=	ScoutDB::getScout($_GET['a']);
		if($scouting != NULL) {
			if(isset($_POST['submitAddRequirement'])) {
				ScoutRequirementsDB::insertScoutRequirements(new ScoutRequirements(NULL, $scouting->getId(), (time() - ((($_POST['ageStartYear'] * 112) + $_POST['ageStartDay']) * 86400)), (time() - ((($_POST['ageEndYear'] * 112) + $_POST['ageEndDay']) * 86400)), 
					$_POST['ageCurrentStart'], $_POST['ageCurrentStartDays'], $_POST['ageCurrentEnd'], $_POST['ageCurrentEndDays'], 
					$_POST['indexGK'], $_POST['indexCD'], $_POST['indexDEF'], $_POST['indexWB'], $_POST['indexIM'], $_POST['indexWG'], $_POST['indexSC'], $_POST['indexDFW'], $_POST['indexSP'], isset($_POST['u20'])));
			} elseif(isset($_POST['submitAddScout'])) {
				if(CoachDB::getCoach($_POST['scoutAdd'])) {
					CoachDB::insertScout($_POST['scoutAdd'], $scouting->getId());
				}
			} elseif(isset($_POST['submitMutScout'])) {
				$scouting->setName($_POST['naam']);
				$scouting->setIndices($_POST['indices']);
				ScoutDB::updateScout($scouting);
			} elseif(isset($_POST['submitDeleteScout'])) {
				CoachDB::deleteScout($_POST['scoutDelete'], $scouting->getId());
			} elseif(isset($_GET['b']) && ($_GET['b'] == 'deleteRequirement')) {
				ScoutRequirementsDB::deleteScoutRequirements($_GET['c']);
			}
			
			$coachList	=	CoachDB::getCoachList();
			$groupScouts	=	$scouting->getScouts();
			
			$currentRequirements	=	ScoutRequirementsDB::getScoutRequirementsByScout($scouting->getId());
			
			echo '<table width="100%" style="border: 1px solid black">';
			echo '<tr>';
			echo '<td colspan="2" style="padding: 3px; background-color: black; color: white">'.output($scouting->getName()).'</td>';
			echo '</tr>';
			
			echo '<form action="" method="POST">';
			echo '<tr><td>Naam</td><td><input type="text" name="naam" value="'.$scouting->getName().'"/></tr>';
			echo '<tr><td>Indices (GK,DEF,CD,WB,IM,WG,SC,DFW,SP)</td><td><input type="text" name="indices" value="'.$scouting->getIndices().'"/></tr>';
			echo '<tr><td></td><td><input type="submit" name="submitMutScout" value="Aanpassen"/></td></tr>';
			echo '</form>';
			
			echo '<tr>';
			echo '<td colspan="2"><strong>Leden</strong></td>';
			echo '</tr>';
				if($groupScouts != NULL) {
					foreach($groupScouts AS $scout) {
						if($scout != NULL) {
							echo '<tr>';
								echo '<td style="border-top: 1px solid black">'.output($scout->getTeamname()).'</td>';
								echo '<td style="border-top: 1px solid black">'.output($scout->getId()).'</td>';
							echo '</tr>';
						}
					}
				} else {
					echo '<tr>';
						echo '<td colspan="2" style="border-top: 1px solid black">Geen leden</td>';
					echo '</tr>';
				}
				echo '<tr><td colspan="2">&nbsp;</td></tr>';
				echo '<tr>';
					echo '<td colspan="2"><strong>Leden mutaties</strong></td>';
				echo '</tr>';
				echo '<form action="" method="POST">';
					echo '<tr>';
						echo '<td style="border-top: 1px solid black"><input type="text" name="scoutAdd" /></td>';
						echo '<td style="border-top: 1px solid black"><input type="submit" name="submitAddScout" value="Toevoegen" /></td>';
					echo '</tr>';
				echo '</form>';
				echo '<form action="" method="POST">';
					echo '<tr>';
						echo '<td style="border-top: 1px solid black">';
							echo '<select name="scoutAdd">';
								if($coachList != NULL) {
									foreach($coachList AS $coach) {
										if(!in_array($coach, $groupScouts)) {
											echo '<option value="'.output($coach->getId()).'">'.output($coach->getTeamname()).'</option>';
										}
									}
								} else {
									echo '<option>Geen coach</option>';
								}
							echo '</select>';
						echo '</td>';
						echo '<td style="border-top: 1px solid black"><input type="submit" name="submitAddScout" value="Toevoegen" /></td>';
					echo '</tr>';
				echo '</form>';
				echo '<form action="" method="POST">';
					echo '<tr>';
						echo '<td style="border-top: 1px solid black">';
							echo '<select name="scoutDelete">';
								if($groupScouts != NULL) {
									foreach($groupScouts AS $groupScout) {
										if($groupScout != NULL) {
											echo '<option value="'.output($groupScout->getId()).'">'.output($groupScout->getTeamname()).'</option>';
										}
									}
								} else {
									echo '<option>Geen scouts</option>';
								}
							echo '</select>';
						echo '</td>';
						echo '<td style="border-top: 1px solid black"><input type="submit" name="submitDeleteScout" value="Verwijder" /></td>';
					echo '</tr>';
				echo '</form>';
			echo '</table>';
			
			echo '<br /><br />';
			
			echo '<table width="100%" style="border: 1px solid black">';
				echo '<tr>';
					echo '<td colspan="18" style="padding: 3px; background-color: black; color: white">Eisen</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="18" style="italic"><b><i>Wanneer er geen einddatum huidige leeftijd wordt opgegeven, zal het systeem de eisen automatisch uitrekenen (goed coach, 15% conditie) en aanvullen!</i></b></td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td><strong>Leeftijdsgroep</strong></td>';
					echo '<td><strong>Huidige leeftijd</strong></td>';
					echo '<td><strong>U20</strong></td>';
					echo '<td><strong>GK</strong></td>';
					echo '<td><strong>CD</strong></td>';
					echo '<td><strong>DEF</strong></td>';
					echo '<td><strong>WB</strong></td>';
					echo '<td><strong>IM</strong></td>';
					echo '<td><strong>WG</strong></td>';
					echo '<td><strong>SC</strong></td>';
					echo '<td><strong>DFW</strong></td>';
					echo '<td><strong>SP</strong></td>';
					echo '<td></td>';
				echo '</tr>';
				
				$ageStartYear	=	17;
				$ageStartDay = 0;
						
				$ageEndYear	=	18;
				$ageEndDay = 0;
						
				if($currentRequirements != NULL) {
					foreach($currentRequirements AS $requirement) {
						$ageStartYear		=	floor((((time() - $requirement->getAgeStart()) / 86400)) / 112);
						$ageStartDay		=	ceil((((time() - $requirement->getAgeStart()) / 86400)) % 112);
						
						$ageEndYear		=	floor((((time() - $requirement->getAgeEnd()) / 86400)) / 112);
						$ageEndDay		=	ceil((((time() - $requirement->getAgeEnd()) / 86400)) % 112);
						
						echo '<tr>';
							echo '<td>'.floor((((time() - $requirement->getAgeStart()) / 86400)) / 112).'y '.ceil((((time() - $requirement->getAgeStart()) / 86400)) % 112).'d tot '.floor((((time() - $requirement->getAgeEnd()) / 86400)) / 112).'y '.ceil((((time() - $requirement->getAgeEnd()) / 86400)) % 112).'d</td>';
							echo '<td>'.output($requirement->getAgeCurrentStart()).'y en '.output($requirement->getAgeCurrentStartDays()).'d tot '.output($requirement->getAgeCurrentEnd()).'y en '.output($requirement->getAgeCurrentEndDays()).'d</td>';
							
							if ($requirement->getU20()) {
								echo '<td>Ja</td>';
							}
							else {
								echo '<td>Nee</td>';
							}
							echo '<td>'.output($requirement->getIndexGK()).'</td>';
							echo '<td>'.output($requirement->getIndexCD()).'</td>';
							echo '<td>'.output($requirement->getIndexDEF()).'</td>';
							echo '<td>'.output($requirement->getIndexWB()).'</td>';
							echo '<td>'.output($requirement->getIndexIM()).'</td>';
							echo '<td>'.output($requirement->getIndexWG()).'</td>';
							echo '<td>'.output($requirement->getIndexSC()).'</td>';
							echo '<td>'.output($requirement->getIndexDFW()).'</td>';
							echo '<td>'.output($requirement->getIndexSP()).'</td>';
							echo '<td><a href="'.$config['url'].'/administration/'.output($scouting->getId()).'/deleteRequirement/'.output($requirement->getId()).'/">X</a></td>';
						echo '</tr>';
					}
				}
				echo '<form action="" method="POST">';
					echo '<tr>';
						echo '<td><input type="text" name="ageStartYear" value="'.output($ageStartYear).'" style="width: 20px;" />y <input type="text" name="ageStartDay" value="'.output($ageStartDay).'" style="width: 20px;" />d tot <input type="text" name="ageEndYear" value="'.output($ageEndYear).'" style="width: 20px;" />y <input type="text" name="ageEndDay" value="'.output($ageEndDay).'" style="width: 20px;" />d</td>';
						echo '<td><input type="text" name="ageCurrentStart" style="width: 20px;" />y <input type="text" name="ageCurrentStartDays" style="width: 20px;" />d tot <input type="text" name="ageCurrentEnd" style="width: 20px;" />y <input type="text" name="ageCurrentEndDays" style="width: 20px;" />d</td>';

						echo '<td><input type="checkbox" name="u20"/></td>';
						echo '<td><input type="text" name="indexGK" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexCD" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexDEF" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexWB" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexIM" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexWG" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexSC" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexDFW" style="width: 20px;" /></td>';
						echo '<td><input type="text" name="indexSP" style="width: 20px;" /></td>';
						
						echo '<td><input type="submit" name="submitAddRequirement" value="Submit"></td>';
					echo '</tr>';
				echo '</form>';
			echo '</table>';
			
		}
	} else 
	{
		$scoutingGroups		=	ScoutDB::getScoutList();
		echo '<table width="100%" style="border: 1px solid black">';
			echo '<tr>';
				echo '<td colspan="2" style="padding: 3px; background-color: black; color: white">';
					echo '<span style="float: left">Scoutgroepen</span>';
					echo '<span style="float: right;"><a href="'.$config['url'].'/administration/new/"><font color="white">Nieuwe groep</font></a></span>';
				echo '</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td><strong>Groepsnaam</strong></td>';
				echo '<td><strong>Opties</strong></td>';
			echo '</tr>';
			if($scoutingGroups != NULL) 
			{
				foreach($scoutingGroups AS $scout) 
				{			
					echo '<tr>';
						echo '<td style="border-top: 1px solid black"><a href="'.$config['url'].'/administration/'.output($scout->getId()).'/">'.output($scout->getName()).'</a></td>';
						echo '<td style="border-top: 1px solid black"><a href="javascript:if(confirm(\'Hierbij verwijdert u de volledige scoutgroep met leden en eisen. Weet u dit zeker?\')){document.location=\''.$config['url'].'/administration/delete/'.output($scout->getId()).'/\';}">Verwijder</a></td>';
					echo '</tr>';
				}
			} 
			else 
			{
				echo '<tr>';
					echo '<td colspan="2">Geen scout groepen</td>';
				echo '</tr>';
			}
		echo '</table>';
	}
}
?>