<?php
include ('header.php');
require_once('ckeditor/ckeditor.php');
$publicatieArray['nee'] 		=	'Nee';
$publicatieArray['ja'] 			=	'Ja';
$publicatieArray['scouts'] 		=	'Scouts';
$publicatieArray['admin'] 		=	'Admin';

$gebruiktArray['home']		=	"Home";
$gebruiktArray['login']		=	"Inloggen";
$gebruiktArray['logout']		=	"Uitloggen";
$gebruiktArray['scan']		=	"Scan";
$gebruiktArray['myTraining']		=	"Mijn Training";
$gebruiktArray['myPlayers']		=	"Mijn Spelers";
//$gebruiktArray['']		=	"";
/*$naamArray = array("Home", "Inloggen", "Uitloggen", "Scan", "Mijn Training", "Mijn Spelers", "Mijn speler", "Groep Nieuws", "Scout groepen", "Zoeken", "Scout Administratie", "Informatie Beheer", "Contact");
$afkortingArray = array("home", "login", "logout", "scan", "myTraining", "myPlayers", "myPlayer", "scoutOverview", "scouting", "search", "administration", "information", "contact"); 		   
	   */
if($user->getRank() != 'administrator') {
	echo 'Geen toegang';
} else {
	/*Informatie beheer*/
	echo '<h2>Informatie beheer</h2>';
	echo '<p>Op deze pagina is het mogelijk pagina&rsquo;s met informatie voor gebruikers, scouts of administratoren te beheren.</p>';
	//Pagina bewerken
	if(!empty($_GET['a'])) {
		echo '<h3>Informatie aanpassen</h3>';
		echo '<p>Je kunt de content opslaan met behulp van de opslaan functie in de text editor. De overige informatie kan daaronder veranderd worden.</p>';
		$informationContent		=	InformationDB::getInformationById($_GET['a']);
		// Content bewerken
		echo '<h4>Content aanpassen</h4>';
		if($informationContent != NULL) {
			if($_POST['editor']) {
				$informationContent->update(NULL, NULL, $_POST['editor'], NULL);
			}
			
			echo '<form method="POST">';
				$CKEditor = new CKEditor();
				$CKEditor->editor("editor", stripslashes($informationContent->getContent()));
			echo '</form>';
	
			//Instellingen aanpassen
			echo '<h4>Instellingen aanpassen</h4>';
			echo '<form action="" method="POST">';
			echo '<table>';
				echo '<tr>';
					echo '<td>Naam</td>';
					if(!$informationContent->getNaam()) {
						echo '<td><input name="naam" type="text"/></td>';
					} else {
						echo '<td><input name="naam" type="text" value="'.$informationContent->getNaam().'" /></td>';
					}
				echo '</tr>';
				echo '<tr>';
					echo '<td>Afkorting</td>';
					if(!$informationContent->getAfkorting()) {
						echo '<td><input name="afkorting" type="text"/></td>';
					} else {
						echo '<td><input name="afkorting" type="text" value="'.$informationContent->getAfkorting().'" /></td>';
					}
				echo '</tr>';
				echo '<tr>';
					echo '<td>Publicatie</td>';
					echo '<td align="right">';
					echo '<select name="publicatie">';
						foreach($publicatieArray AS $key => $value) {
							if(!$informationContent->getPublicatie() && $key == 'nee') {
								echo '<option value="'.$key.'" selected>'.$value.'</option>';
							} elseif($key == $informationContent->getPublicatie()) {
								echo '<option value="'.$key.'" selected>'.$value.'</option>';
							} else {
								echo '<option value="'.$key.'">'.$value.'</option>';
							}
						}
					echo '</select>';
					echo '</td>';
				echo '</tr>';
				echo '<tr>';
					echo '<td colspan="2" align="right"><input type="submit" name="update" value="Verander" /></td>';
				echo '</tr>';
			echo '</table>';
			echo '</form>';
			
			if($_POST['update']) {
				$naamGestript = str_replace(' ', '', $_POST['naam']);
				if(!ctype_alnum($naamGestript) || !ctype_alnum($_POST['afkorting'])) {
					echo '<div class="error">De naam en afkorting mogen enkel uit letters en cijfers bestaan. De afkorting mag ook geen spaties bevatten.</div>';
				} else {
					$informationContent->update($_POST['naam'], $_POST['afkorting'], NULL, $_POST['publicatie']);
					header("Location: ".$config['url']."/information/".$informationContent->getId()."/");
				}
			}
		echo '<span style="float: right"><a href="'.$config['url'].'/information/">Terug naar informatie beheer</a></span>';
		} else {
			header("Location: ".$config['url']."/information/");
		}
	} else {
	
	
	/*Huidige pagina's*/
	echo '<h3>Huidige pagina&rsquo;s</h3>';
	echo '<ul>';
		$informationList = InformationDB::getInformationList();
		if ($informationList != NULL) {
			foreach($informationList AS $information) {
				echo '<li>'.$information->getNaam().' <a href="'.$config['url'].'/information/'.$information->getId().'/"><img src="'.$config['url'].'/images/edit.png"/></a></li>';
				$gebruiktArray[$information->getAfkorting] = $information->getNaam();
			}
		} else {
			echo '<li> - </li>';
		}
	echo '</ul>';
	
	/*Pagina toevoegen*/
	echo '<h3>Pagina toevoegen</h3>';
	//Form
	echo '<form action="" method="POST">';
	echo '<table>';
		echo '<tr>';
			echo '<td>Naam</td>';
			if(empty($_POST['naam'])) {
				echo '<td><input name="naam" type="text"/></td>';
			} else {
				echo '<td><input name="naam" type="text" value="'.$_POST['naam'].'" /></td>';
			}
		echo '</tr>';
		echo '<tr>';
			echo '<td>Afkorting</td>';
			if(empty($_POST['afkorting'])) {
				echo '<td><input name="afkorting" type="text"/></td>';
			} else {
				echo '<td><input name="afkorting" type="text" value="'.$_POST['afkorting'].'" /></td>';
			}
		echo '</tr>';
		echo '<tr>';
			echo '<td>Publicatie</td>';
			echo '<td align="right">';
			echo '<select name="publicatie">';
				foreach($publicatieArray AS $key => $value) {
					if(empty($_POST['publicatie']) && $key == 'nee') {
						echo '<option value="'.$key.'" selected>'.$value.'</option>';
					} elseif($key == $_POST['publicatie']) {
						echo '<option value="'.$key.'" selected>'.$value.'</option>';
					} else {
						echo '<option value="'.$key.'">'.$value.'</option>';
					}
				}
			echo '</select>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan="2" align="right"><input type="submit" name="submit" value="Voeg Toe" /></td>';
		echo '</tr>';
	echo '</table>';
	echo '</form>';
	
	if($_POST['submit']) {
		InformationDB::insertInformation(new Information(NULL, $_POST['naam'], $_POST['afkorting'], NULL, $_POST['publicatie']));
		header("Location: ".$config['url']."/information/");
	}
	
	/*Pagina's die al bestaan*/
	echo '<h3>Namen/Afkortingen die al bestaan</h3>';
		echo '<table>';
			echo '<tr>';
				echo '<td><strong>Naam</strong></td>';
				echo '<td><strong>Afkorting</strong></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Home</td>';
				echo '<td>home</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Inloggen</td>';
				echo '<td>login</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Uitloggen</td>';
				echo '<td>logout</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Scan</td>';
				echo '<td>scan</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Mijn Training</td>';
				echo '<td>myTraining</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Mijn Spelers</td>';
				echo '<td>myPlayers</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Mijn speler</td>';
				echo '<td>myPlayer</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Groep Nieuws</td>';
				echo '<td>scoutOverview</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Scout groepen</td>';
				echo '<td>scouting</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Zoeken</td>';
				echo '<td>search</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Scout Administratie</td>';
				echo '<td>administration</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Informatie Beheer</td>';
				echo '<td>information</td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td>Contact</td>';
				echo '<td>contact</td>';
			echo '</tr>';
		echo '</table>';
	}
}
include ('footer.php');
?>