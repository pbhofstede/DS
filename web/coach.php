<?php
if  (isset($_SESSION['dutchscouts']) && ($_SESSION['dutchscouts'] != NULL)) 
{
	$user	=	CoachDB::getCoach($_SESSION['dutchscouts']);
	
	if ($user != null)
	{
		$_SESSION['lastLogin']	=	$user->getLastLogin();
		CoachDB::updateCoachLastLogin(time(), $user->getId());
	}
}
?>
