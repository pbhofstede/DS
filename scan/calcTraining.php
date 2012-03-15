<?php
  
	$TR_KEEPEN = 0.31;
  $TR_VERDEDIGEN = 0.1705;
  $TR_POSITIESPEL = 0.2010;
  $TR_VLEUGELSPEL = 0.29;
  $TR_PASSEN = 0.2180;
  $TR_SCOREN = 0.1935;
  $TR_SPELHERVATTEN = 1.1625;
	
	function CalculateTrainingWeeks($aCurLeeftijdDagen, 
		$aKeepen, $aVerdedigen, $aPositiespel, $aVleugelSpel, $aPassen, $aScoren, $aSpelhervatten,
		$aCurKeepen, $aCurVerdedigen, $aCurPostiespel, $aCurVleugelSpel, $aCurPassen, $aCurScoren, $aCurSpelhervatten) {
		
		//oh boy.. als je de globale constantes in deze functie wilt gebruiken moet je deze éénmalig met global aanroepen..
		global $TR_KEEPEN, $TR_VERDEDIGEN, $TR_POSITIESPEL, $TR_VLEUGELSPEL, $TR_PASSEN, $TR_SCOREN, $TR_SPELHERVATTEN;
		$aMaxCurLeeftijdDagen = 32 * 112;
		$aMaxRekenLeeftijdDagen = 30 * 112;
		$aLeeftijdDagen = 17 * 112;
		
		if ($aCurLeeftijdDagen < $aLeeftijdDagen) {
			//mag nooit voorkomen zet voor straf dan de leeftijd op 32 jaar 
		  $aCurLeeftijdDagen = $aMaxCurLeeftijdDagen;
		}
		
		if ($aKeepen > 0) {
			if ($aCurKeepen > $aKeepen) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aKeepen, 15, $aCurKeepen, 7, $TR_KEEPEN);
			}
			else if ($aKeepen > $aCurKeepen) {
				if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurKeepen, 15, $aKeepen, 7, $TR_KEEPEN);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurKeepen, 15, $aKeepen, 7, $TR_KEEPEN);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aVerdedigen > 0) {
			if ($aCurVerdedigen > $aVerdedigen) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aVerdedigen, 15, $aCurVerdedigen, 7, $TR_VERDEDIGEN);
			}
			else if ($aVerdedigen > $aCurVerdedigen) { 
			  if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurVerdedigen, 15, $aVerdedigen, 7, $TR_VERDEDIGEN);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurVerdedigen, 15, $aVerdedigen, 7, $TR_VERDEDIGEN);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aPositiespel > 0) {
			if ($aCurPostiespel > $aPositiespel) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aPositiespel, 15, $aCurPostiespel, 7, $TR_POSITIESPEL);
			}
			else if ($aPositiespel > $aCurPostiespel) {
				if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurPostiespel, 15, $aPositiespel, 7, $TR_POSITIESPEL);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurPostiespel, 15, $aPositiespel, 7, $TR_POSITIESPEL);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aVleugelSpel > 0) {
			if ($aCurVleugelSpel > $aVleugelSpel) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aVleugelSpel, 15, $aCurVleugelSpel, 7, $TR_VLEUGELSPEL);
			}
			else if ($aVleugelSpel > $aCurVleugelSpel) {
			  if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurVleugelSpel, 15, $aVleugelSpel, 7, $TR_VLEUGELSPEL);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurVleugelSpel, 15, $aVleugelSpel, 7, $TR_VLEUGELSPEL);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aPassen > 0) {
			if ($aCurPassen > $aPassen) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aPassen, 15, $aCurPassen, 7, $TR_PASSEN);
			}
			else if ($aPassen > $aCurPassen) {
			  if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurPassen, 15, $aPassen, 7, $TR_PASSEN);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurPassen, 15, $aPassen, 7, $TR_PASSEN);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aScoren > 0) {
			if ($aCurScoren > $aScoren) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aScoren, 15, $aCurScoren, 7, $TR_SCOREN);
			}
			else if ($aScoren > $aCurScoren) {
			  if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurScoren, 15, $aScoren, 7, $TR_SCOREN);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurScoren, 15, $aScoren, 7, $TR_SCOREN);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		if ($aSpelhervatten > 0) {
			if ($aCurSpelhervatten > $aSpelhervatten) {
				$aLeeftijdDagen = CalculateTraining($aLeeftijdDagen, $aSpelhervatten, 15, $aCurSpelhervatten, 7, $TR_SPELHERVATTEN);
			}
			else if ($aSpelhervatten > $aCurSpelhervatten) {
				if ($aCurLeeftijdDagen < $aMaxCurLeeftijdDagen) {
					$aCurLeeftijdDagen = CalculateTraining($aCurLeeftijdDagen, $aCurSpelhervatten, 15, $aSpelhervatten, 7, $TR_SPELHERVATTEN);
				}
				else {
					$vExtraDagen = CalculateTraining($aMaxRekenLeeftijdDagen, $aCurSpelhervatten, 15, $aSpelhervatten, 7, $TR_SPELHERVATTEN);
					$aCurLeeftijdDagen = $aCurLeeftijdDagen + ($vExtraDagen - $aMaxRekenLeeftijdDagen);
				}
			}
		}
		
		$jaren = floor($aLeeftijdDagen / 112);
		$dagen = $aLeeftijdDagen - ($jaren * 112);	

		return ($aLeeftijdDagen - $aCurLeeftijdDagen) / 7;
	}

  function CalculateTraining($aStartDagen, $aStartNiveau,
		$aConditiePerc, $aDoelNiveau, $aCoachLevel, $aTrainingSoort)
	{
    $polinom = array(0, 0.04912625, 0.225855, 0.39528625, 0.55742, 0.71225625, 0.859795, 1.00003625, 1.13298, 1.25862625, 
			1.376975, 1.48802625, 1.59178, 1.68823625, 1.777395, 1.85925625, 1.93382, 2.00108625, 2.061055, 2.11372625, 2.1591);
			
		$agekoef = array(1, 0.982, 0.963, 0.946, 0.928, 0.911, 0.894, 0.877, 0.861, 0.845, 0.830, 0.814, 0.799, 0.784, 0.770, 
			0.756, 0.742, 0.728);
			
		$skillkoef = array(0.3520, 0.3761, 0.4038, 0.4360, 0.4740, 0.5194, 0.5747, 0.6435, 0.7316, 0.8482, 1.0105, 1.2519,
			1.3625, 1.5000, 1.6761, 1.9112, 2.2443, 2.7608, 3.6967, 6.0892);
			
		$assistkoef = array(0.970000, 0.98222, 0.98631, 0.98914, 0.99138, 0.99326, 0.99490, 0.99635, 0.99767, 0.99888, 1.000000);
		
		$coachkoef = array(0, 0, 0, 0, 0.774, 0.867, 0.9430, 1, 1.045);

		$agetable = array(0.000, 16.000, 31.704, 47.117, 62.246, 77.094, 91.668, 105.972, 120.012, 133.791, 147.316, 160.591, 
			173.620, 186.408, 198.960, 211.279, 223.370, 235.238);
			
		$coachK = $coachkoef[$aCoachLevel];
		$assistK = $assistkoef[10];
		$intensK = 100/100;
		$staminaK =(100-$aConditiePerc)/100;

		$trainK = $aTrainingSoort;	
		
		$totalK = $coachK*$assistK*$intensK*$staminaK*$trainK;
		$years = floor($aStartDagen / 112);
		$days = $aStartDagen - ($years * 112);
		$level = $aStartNiveau;
		
		if ($years <= 33) {
			$sublevel = 0; 
			$aDoelSubNiveau = 0;
			$years0 = $agetable[$years-17];
			$years1 = $agetable[$years-16];
			$age0 = ($days/112)*($years1-$years0)+$years0;
			$skill0lost = Pow(6.0896*$totalK,1/0.72);
			$ageee = $years*1+$days/112;
			$shtraf = 0;
			$age1 = $years*1+$days/112;
			$age1old = 0;
			$ageold = 0;
			$resyears = 0;
			$resdays = 0;
			
			for ($lev = $level; $lev <= $aDoelNiveau; $lev++) {
				if ($lev < 9) {
					$xxx1 = (Pow($lev+$aDoelSubNiveau,1.72)-1)*(1/6.0896/1.72);
				}
				else {
					$xxx1 = 2.45426+(1/4.7371/1.96)*Pow($lev+$aDoelSubNiveau-5,1.96);
				}

				if ($level < 9) {
					$yyy1 = (Pow($level+$sublevel,1.72)-1)*(1/6.0896/1.72);
				}
				else {
					$yyy1 = 2.45426+Pow($level+$sublevel-5,1.96)*(1/4.7371/1.96);
				}

				if ($xxx1 > $yyy1) {
					if ($totalK <> 0) {
						$xxx = ($xxx1-$yyy1)/$totalK+$age0;
					}
					else {
						$xxx = 0;
					}

					for ($i = 17; $i < 34; $i++) {
						if ($xxx<=$agetable[$i-17]) {
							break;
						}
					}
					
					$agge = $i-1;
					$stolH = $agetable[$agge-17];
					$stolI = $agetable[$agge-16];
					$ageeeold = $ageee;
					
					$vTemp = $stolI-$stolH; 
					if ($vTemp <> 0) {
						$ageee = $agge+($xxx-$stolH)/$vTemp;
					}
					else {
						$ageee = 0;
					}

					if ($lev > ($level+$sublevel+1)) {
						$shtrafx = 1/16-$ageee+$ageeeold;
						
						if ($shtrafx > 0) {
							$shtraf = $shtraf+$shtrafx;
						}
					}
					else {
						$shtrafx = (1/16-$ageee+$years*1+$days/112)*($lev-($level+$sublevel));
					
						if ($shtrafx > 0) {
							$shtraf = $shtraf + $shtrafx;
						}
					}
				
					if ($lev > 15) {
						$drop = (0.00112/3)*(Pow(($lev-15),3)-Pow(($lev-16),3));
					}
					else {
						$drop = 0;
					}
				
					if ($lev <= 15) {
						$age1 = $ageee;
					}
					
					if ($lev > 15) {
						$age1 = $age1+($ageee-$ageeeold)/(1-$drop*($ageee-$ageeeold)*16);
					}

					$resyears = floor($age1+$shtraf+0.0089);
					$resdays = floor(($age1+$shtraf-$resyears+0.0089)*112);
				
					if ($resyears > 31) {
						$resyears = 39;	
						break;
					}
				}
			}
		}
		else {
		  $resyears = 39;
			$resdays = 0;
		}
		$aEinddagen = (ceil($resyears) * 112) + Ceil($resdays);
		
		return $aEinddagen;
	}
?>
