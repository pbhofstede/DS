<?php
include ('config.php');
require ('calcTraining.php');

//set_time_limit(0);

$count = 0;

$va = $_GET['id'];

for ($i = 0; $i<=9; $i++) {
	$v = $i.$va;
	$allPlayers = PlayerDB::getAllPlayers($v);

	if ($allPlayers != Null) {
		foreach($allPlayers AS $player) {
			if ($player != Null) {
				//if (! ($player->getu20()) &&
				//	 ($player->getHasU20Age() <> '')) {
				//	$player->setu20(TRUE);
				//if ($player->getu20()) { 	
					$player->calcIndices();
					PlayerDB::updatePlayer($player);
					
					$count++;
				//}
			}
		}
  }
}
echo $count.' spelers geupdate';

?>