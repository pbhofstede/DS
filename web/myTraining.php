<?php
include ('header.php');
//Array
$trainingArray['1']		=	'Keepen';
$trainingArray['2']		=	'Verdedigen';
$trainingArray['3']		=	'Controlerendspel';
$trainingArray['4']		=	'Vleugelspel';
$trainingArray['5']		=	'Vleugelaanval';
$trainingArray['6']		=	'Positiespel';
$trainingArray['7']		=	'Scoren';
$trainingArray['8']		=	'Schieten';			
$trainingArray['9']		=	'Kortepass';
$trainingArray['10']	=	'Openingenmaken';
$trainingArray['11']	=	'Spelhervatting';

echo '<h1>Mijn training</h1>';
if ($user != NULL) {
  if (!empty($_GET['a'])) {
		// Training Aanpassen
		$training	=	$user->getTrainingByIdAndCoach($_GET['a']);
		if($training != NULL) {
			echo '<h2>Training aanpassen</h2>';
			echo 'Hieronder is het mogelijk de ingevoerde training aan te passen.';
			echo '<table width="100%">';
			echo '<form action="" method="POST">';
				echo '<tr>';
					echo '<th colspan="8">Training</th>';
				echo '</tr>';
				echo '<tr class="niveau1">';
					echo '<td>Van</td>';
					echo '<td>Tot</td>';
					echo '<td>Training</td>';
					echo '<td>TI%</td>';
					echo '<td>Conditie %</td>';
					echo '<td>Assistenten</td>';
					echo '<td>Fysios</td>';
					echo '<td>&nbsp;</td>';
				echo '</tr>';
				echo '<tr class="none">';
					if(empty($_POST['from'])) {
						echo '<td><input name="from" type="text" value="'.date('d-m-Y', $training->getVan()).'" size="9" /></td>';
					} else {
						echo '<td><input name="from" type="text" value="'.$_POST['from'].'" size="9" /></td>';
					}
					if(empty($_POST['till'])) {
						echo '<td><input name="till" type="text" value="'.date('d-m-Y', $training->getTot()).'" size="9" /></td>';
					} else {
						echo '<td><input name="till" type="text" value="'.$_POST['till'].'" size="9" /></td>';
					}
					echo '<td>';
						echo '<select name="training">';
							foreach($trainingArray AS $key => $value) {
								if($key == $training->getTraining()) {
									echo '<option value="'.$key.'" selected>'.$value.'</option>';
								} else {
									echo '<option value="'.$key.'">'.$value.'</option>';
								}
							}
						echo '</select>';
					echo '</td>';
					if(empty($_POST['ti'])) {
						echo '<td><input name="ti" type="text" value="'.$training->getTi().'" size="1" />%</td>';
					} else {
						echo '<td><input name="ti" type="text" value="'.$_POST['ti'].'" size="1" />%</td>';
					}
					if(empty($_POST['conditie'])) {
						echo '<td><input name="conditie" type="text" value="'.$training->getConditie().'" size="1" />%</td>';
					} else {
						echo '<td><input name="conditie" type="text" value="'.$_POST['conditie'].'" size="1" />%</td>';
					}
					if(empty($_POST['assistenten'])) {
						echo '<td><input name="assistenten" type="text" value="'.$training->getAssistenten().'" size="1" /></td>';
					} else {
						echo '<td><input name="assistenten" type="text" value="'.$_POST['assistenten'].'" size="1" /></td>';
					}
					if(empty($_POST['fysios'])) {
						echo '<td><input name="fysios" type="text" value="'.$training->getFysios().'" size="1" /></td>';
					} else {
						echo '<td><input name="fysios" type="text" value="'.$_POST['fysios'].'" size="1" /></td>';
					}
					echo '<td><input type="submit" name="verander" value="Verander" /></td>';
				echo '</tr>';
			echo '</form>';
			echo '</table>';
		
			if($_POST['verander']) {
				$datumFrom		=	explode('-', $_POST['from']);
				$datumFrom		=	mktime(12, 0, 0, $datumFrom[1], $datumFrom[0], $datumFrom[2]);
				$datumTill		=	explode('-', $_POST['till']);
				$datumTill		=	mktime(12, 0, 0, $datumTill[1], $datumTill[0], $datumTill[2]);
			
				if(!ctype_digit($_POST['ti']) || $_POST['ti'] < 1 || $_POST['ti'] > 100) {
					echo '<div class="error">De trainingsintensiteit moet tussen 0% en 100% liggen.</div>';
				} elseif(!ctype_digit($_POST['conditie']) || $_POST['conditie'] < 5 || $_POST['conditie'] > 100) {
					echo '<div class="error">Het aandeel conditietraining moet tussen 5% en 100% liggen.</div>';
				} elseif(!ctype_digit($_POST['fysios']) || $_POST['fysios'] < 0 || $_POST['fysios'] > 11) {
					echo '<div class="error">Het aandeel fysiotherapeuten is minimaal 0 en ligt aannemelijk niet boven de 11.</div>';
				} elseif ($datumFrom >= $datumTill) {
					echo '<div class="error">Zorg dat de datum "Van" eerder is dan de datum "Tot".</div>';
				} else {
					TrainingDB::updateTraining(new Training($training->getId(), $user->getId(), $datumFrom, $datumTill, $_POST['training'], $_POST['ti'], $_POST['conditie'], $_POST['assistenten'], $_POST['fysios']));
					header("Location: ".$config['url']."/myTraining/".$training->getId()."/");
				}
			}
		} else {
			echo '<div class="error">Geen training aanwezig</div>';
		}
		echo '<span style="float: right"><a href="'.$config['url'].'/myTraining/">Terug naar mijn training</a></span>';
	} else {
		echo 'Hieronder is het mogelijk in te voeren wat je traint of hebt getraind. Hierdoor kan een scout een beter beeld krijgen over de potentie van een speler.<br />';
		echo 'Invullen is niet verplicht maar word wel gewenst.<br /> Per speler kan de informatie worden uitgebreid, dit is gewenst voor spelers waarvan bekend is dat deze U20- of NT-potentie hebben.';
		echo '<h2>Training geschiedenis</h2>';
		echo '<table width="100%">';
			echo '<tr>';
				echo '<th colspan="8">Training</th>';
			echo '</tr>';
			echo '<tr class="niveau1">';
				echo '<td>Van</td>';
				echo '<td>Tot</td>';
				echo '<td>Training</td>';
				echo '<td>TI%</td>';
				echo '<td>Conditie %</td>';
				echo '<td>Assistenten</td>';
				echo '<td>Fysios</td>';
				echo '<td>&nbsp;</td>';
			echo '</tr>';
			$training	=	$user->getTraining();
			if($training != NULL) {
				foreach($training AS $order) {
					echo '<tr>';
						echo '<td>'.date('d-m-Y', $order->getVan()).'</td>';
						echo '<td>'.date('d-m-Y', $order->getTot()).'</td>';
						echo '<td>'.$trainingArray[$order->getTraining()].'</td>';
						echo '<td>'.$order->getTi().'</td>';
						echo '<td>'.$order->getConditie().'</td>';
						echo '<td>'.$order->getAssistenten().'</td>';
						echo '<td>'.$order->getFysios().'</td>';
						echo '<td><a href="'.$config['url'].'/myTraining/'.$order->getId().'/"><img src="'.$config['url'].'/images/edit.png"/></a></td>';
					echo '</tr>';
				}
			}
			
			echo '<form action="" method="POST">';
				echo '<tr class="none">';
				if(empty($_POST['from'])) {
					echo '<td><input name="from" type="text" value="'.date('d-m-Y',time()).'" size="9" /></td>';
				} else {
					echo '<td><input name="from" type="text" value="'.$_POST['from'].'" size="9" /></td>';
				}
				if(empty($_POST['till'])) {
					echo '<td><input name="till" type="text" value="'.date('d-m-Y',time()).'" size="9" /></td>';
				} else {
					echo '<td><input name="till" type="text" value="'.$_POST['till'].'" size="9" /></td>';
				}
				echo '<td>';
					echo '<select name="training">';
						foreach($trainingArray AS $key => $value) {
							if($key == $_POST['training']) {
								echo '<option value="'.$key.'" selected>'.$value.'</option>';
							} else {
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
						}
					echo '</select>';
				echo '</td>';
				if(empty($_POST['ti'])) {
					echo '<td><input name="ti" type="text" value="100" size="1" />%</td>';
				} else {
					echo '<td><input name="ti" type="text" value="'.$_POST['ti'].'" size="1" />%</td>';
				}
				if(empty($_POST['conditie'])) {
					echo '<td><input name="conditie" type="text" value="5" size="1" />%</td>';
				} else {
					echo '<td><input name="conditie" type="text" value="'.$_POST['conditie'].'" size="1" />%</td>';
				}
				if(empty($_POST['assistenten'])) {
					echo '<td><input name="assistenten" type="text" value="0" size="1" /></td>';
				} else {
					echo '<td><input name="assistenten" type="text" value="'.$_POST['assistenten'].'" size="1" /></td>';
				}
				if(empty($_POST['fysios'])) {
					echo '<td><input name="fysios" type="text" value="0" size="1" /></td>';
				} else {
					echo '<td><input name="fysios" type="text" value="'.$_POST['fysios'].'" size="1" /></td>';
				}
				echo '<td><input type="submit" name="submit" value="OK" /></td>';
			echo '</tr>';
		echo '</table>';
	echo 'Indien de gekozen training keepen is mag voor het aantal assistenten het aantal keeperstrainers worden ingevuld.';	
		if(isset($_POST['submit'])) {
			$datumFrom		=	explode('-', $_POST['from']);
			$datumFrom		=	mktime(12, 0, 0, $datumFrom[1], $datumFrom[0], $datumFrom[2]);
			$datumTill		=	explode('-', $_POST['till']);
			$datumTill		=	mktime(12, 0, 0, $datumTill[1], $datumTill[0], $datumTill[2]);
		
			if(!ctype_digit($_POST['ti']) || $_POST['ti'] < 1 || $_POST['ti'] > 100) {
				echo '<div class="error">De trainingsintensiteit moet tussen 0% en 100% liggen.</div>';
			} elseif(!ctype_digit($_POST['conditie']) || $_POST['conditie'] < 5 || $_POST['conditie'] > 100) {
				echo '<div class="error">Het aandeel conditietraining moet tussen 5% en 100% liggen.</div>';
			} elseif(!ctype_digit($_POST['assistenten']) || $_POST['assistenten'] < 0 || $_POST['assistenten'] > 11) {
				echo '<div class="error">Het aandeel assistenten is minimaal 0 en ligt aannemelijk niet boven de 11.</div>';
			} elseif(!ctype_digit($_POST['fysios']) || $_POST['fysios'] < 0 || $_POST['fysios'] > 11) {
				echo '<div class="error">Het aandeel fysiotherapeuten is minimaal 0 en ligt aannemelijk niet boven de 11.</div>';
			} elseif ($datumFrom >= $datumTill) {
				echo '<div class="error">Zorg dat de datum "Van" eerder is dan de datum "Tot".</div>';
			} else {
				$training = TrainingDB::insertTraining(new Training(NULL, $user->getId(), $datumFrom, $datumTill, $_POST['training'], $_POST['ti'], $_POST['conditie'], $_POST['assistenten'], $_POST['fysios']));
				if($training != NULL ) {
					$players	=	$user->getPlayers();
					if($players != NULL) {
							foreach($players AS $player) {
								PlayerTrainingDB::insertPlayerTrainingList(new PlayerTraining($player->getId(), $training, NULL, NULL));
							}
					}
				}
				header("Location: ".$config['url']."/myTraining/");
			}
		}
	}
}
else {
	redirect($config['url'].'/', 0);
}
include ('footer.php');
?>