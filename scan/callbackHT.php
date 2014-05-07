<?php
	// In callback url page:
  include('config.php');
  
	$HT = $_SESSION['HT'];
	
  try
  {
		$HT->retrieveAccessToken($_REQUEST['oauth_token'], $_REQUEST['oauth_verifier']);
		
		$userToken = $HT->getOauthToken();
		$userTokenSecret = $HT->getOauthTokenSecret();
	
		if ($HT->getClub()->getUserId() > 0) {	
			
			$coach = CoachDB::getCoach($HT->getClub()->getUserId());
			            	
			if ($coach == NULL) {
				CoachDB::insertCoach(new Coach($HT->getClub()->getUserId(), $HT->getClub()->getTeamId(), $HT->getClub()->getTeamname(),
          "user", "",
					"", "", $userToken, $userTokenSecret, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0));
			
				$coach = CoachDB::getCoach($HT->getClub()->getUserId());
			}
			else {
				$coach->setDSUserName("");
				$coach->setDSPassword("");
				$coach->setHTuserToken($userToken);
				$coach->setHTuserTokenSecret($userTokenSecret);
			}
						
			CoachDB::updateCoach($coach);

      $teams = $coach->getTeams($HT);
      
			if ($teams != null) {
				foreach($teams as $team) {
				  $teamid = $team->getTeamID(); 
							
          $coachteam = CoachDB::getCoachTeam($coach->getId(), $teamid); 
					
          $coachteam->setleagueID($team->getLeagueId());
          $coachteam->setassistants($HT->getClub($teamid)->getAssistantTrainerLevels());
				  $coachteam->setformcoach($HT->getClub($teamid)->getFormCoachLevels());
				  $coachteam->setdoctors($HT->getClub($teamid)->getMedicLevels());
          $coachteam->setTeamName($team->getTeamName());

          CoachDB::updateCoachTeam($coachteam);    
					
        } 
				
        $HT->ClearPrimaryTeam();
        $HT->clearSecondaryTeam();
			}
		}
  }
  catch(HTError $e)
  {
    echo "Error: ".$e->getMessage();
  }
	catch(Error $e)
  {
    echo "Error: ".$e->getMessage();
  }
?>
<html>
	<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
	<link href="<?php echo $config['url'].'/style.css'; ?>" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
	<div class="chpp"><img src="<?php echo $config['url'].'/images/chpp.gif'; ?>" /></div>
	<div class="cup"><img src="<?php echo $config['url'].'/images/cup.png'; ?>" /></div>
		<div class="banner"><img src="<?php echo $config['url'].'/images/banner.png'; ?>" /></div>
		<div class="container">
			<div class="content">
				<?php 
				  echo $language['reg_intro']; 
					if (isset($_REQUEST['mess'])) {
					  echo '<FONT COLOR="FF0000">'.$_REQUEST['mess'].'</FONT><br/><br/>';
					}
				?>
				<span id="scan">
					<form action="doRegister.php" method="POST">
						<p>
							<label><?php echo $language['name']; ?></label>
							<input type="text" name="name" maxlength="100" onKeyPress="checkKey(event)" />
						</p>
						<p>
							<label><?php echo $language['password']; ?></label>
							<input type="password" name="password" maxlength="100"/>
						</p>
						<p>
							<label><?php echo $language['retypepassword']; ?></label>
							<input type="password" name="password2" maxlength="100"/>
						</p>
						<p>
							<label>&nbsp;</label>
							
							<input type="hidden" name="oauth_token" value="<?php echo $_REQUEST['oauth_token']?>">
							<input type="hidden" name="oauth_verifier" value="<?php echo $_REQUEST['oauth_verifier']?>">
							<input type="submit" value="<?php echo $language['register']; ?>" />
						</p>
					</form>
				</span>
			</div>
		</div>
	</body>
</html>
