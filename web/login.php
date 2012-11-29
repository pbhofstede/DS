<?php
include ('header.php');

$error = NULL;

if(isset($_POST['submit'])) {
 
	if (($_POST['name'] != '') and ($_POST['securitycode'] != '')) 
	{
		$coach = CoachDB::getCoachByDSUserName($_POST['name']);
		
		if ($coach != NULL)
	 	{
			if (crypt($_POST['securitycode'], $coach->getDSPassword()) == $coach->getDSPassword()) 
			{
			   if ($coach->getHTUserTokenSecret() != '')
				{
					$_SESSION['dutchscouts']		=	$coach->getId();
					$_SESSION['dutchscoutsName']	=	$_POST['name'];
					$_SESSION['dutchscoutsSC']		=	$_POST['securitycode'];
							
					redirect($config['url'].'/');
				}
				else
				{
					$error = '<span class="error">Geen toegang tot Hattrick teamdata. Maak een nieuwe account aan op de hoofdpagina.</span>';
				}
			}
			else
			{
				// Password incorrect!
				$error = '<span class="error">Foutief wachtwoord.</span>';
			}
		
		}
		else 
		{
			$error = '<span class="error">Geen toegang tot DutchScouts, voer uw juiste gebruikersnaam en wachtwoord in of maak een nieuwe account aan op de hoofdpagina.</span>';
		}
	}
	else 
	{
		$error			=	'<span class="error">Gebruikersgegevens incorrect, vul een gebruikersnaam en wachtwoord in.</span>';
	}
}

if(empty($_POST['submit']) || $error != NULL) {
	echo '<form action="" method="POST" name="inlogForm">';
	echo '<p>';
	echo '<label>Gebruikersnaam</label>';
	echo '<input type="text" name="name" onfocus="formInUse = true;"/> ';
	echo '</p>';
	echo '<p>';
	echo '<label>Wachtwoord</label>';
	echo '<input type="password" name="securitycode" onfocus="formInUse = true;" autocomplete="off"/>  Geef het wachtwoord om in DutchScouts in te kunnen loggen (geen Hattrick veiligheidscode).';
	echo '</p>';
	echo '<p>';
	echo '<label>&nbsp;</label>';
	echo '<input type="submit" name="submit" value="Inloggen" /><BR><BR>';
	echo $error;
	echo '</p>';
	echo '</form>';
}
include ('footer.php');
?>
