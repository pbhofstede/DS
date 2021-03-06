<?php
class Coach {
	private $id;		//Hattrick based id of player
	private $teamid;	//Id of the team
	private $teamname;	//Teamname of coach
	private $rank;
	private $lastlogin;
	private $DSUserName;	//DS-username
	private $DSPassword;	//DS-password
	private $HTuserToken;	//oAuth usertoken
	private $HTuserTokenSecret;	//oAuth usertoken secret
	private $LastTraining;
	private $lastHTlogin;
	
	/**
	* Constructs the coach
	* @param int $id
	* @param int $teamid
	* @param String $teamname
	*/
	
	public function __construct($id, $teamid, $teamname, $rank, $lastlogin, $DSUserName, $DSPassword, $HTuserToken, $HTuserTokenSecret, 
		$LastTraining, $lastHTlogin) {
		$this->id		=	$id;
		$this->teamid		=	$teamid;
		$this->teamname		=	$teamname;
		$this->rank			=	$rank;
		$this->lastlogin	=	$lastlogin;
		$this->DSUserName = $DSUserName;
		$this->DSPassword = $DSPassword;
		$this->HTuserToken = $HTuserToken;
		$this->HTuserTokenSecret = $HTuserTokenSecret;
		$this->LastTraining = $LastTraining;
		$this->lastHTlogin = $lastHTlogin;
	}

    public function getTeams($HT){
        $primTeam = $HT->getPrimaryTeam();
        $secTeam = $HT->getSecondaryTeam();

        $list[] = $primTeam;
        if ($secTeam != NULL){
            $list[] = $secTeam;    
        }
        return $list;
    }
	
	public function getScout() {
		return CoachDB::getScout($this->id);
	}
	
	public function getPlayers() {
		return PlayerDB::getPlayerListByCoach($this->id);
	}
	
	public function getLastScan() {
		return PlayerDB::getLastScanByCoach($this->id);
	}
	
	public function getTraining() {
		return TrainingDB::getTrainingListByCoach($this->id);
	}

	public function getTrainingByIdAndCoach($number) {
		return TrainingDB::getTrainingByIdAndCoach($number, $this->id);
	}
	
	/**
	* Returns the coach id
	* @return int $id
	*/
	public function getId() {
		return $this->id;
	}
	
	/**
	* Return the teamid of the team
	* @return int $teamid
	*/
	public function getTeamid() {
		return $this->teamid;
	}
	
	/**
	* Returns the teamname of the coach
	* @return String $teamname
	*/
	public function getTeamname() {
		return $this->teamname;
	}
	public function setTeamname($teamname) {
		$this->teamname = $teamname;
	}
	
	
	public function setDSUserName($DSUserName) {
		$this->DSUserName=$DSUserName;
	}	
	public function getDSUserName() {
		return $this->DSUserName;
	}
	
	public function setDSPassword($DSPassword) {
		$this->DSPassword=$DSPassword;
	}	
	public function getDSPassword() {
		return $this->DSPassword;
	}
	
	public function setHTuserToken($HTuserToken) {
		$this->HTuserToken=$HTuserToken;
	}	
	public function getHTuserToken() {
		return $this->HTuserToken;
	}
	
	public function setHTuserTokenSecret($HTuserTokenSecret) {
		$this->HTuserTokenSecret=$HTuserTokenSecret;
	}	
	public function getHTuserTokenSecret() {
		return $this->HTuserTokenSecret;
	}
	
	public function setLastTraining($LastTraining) {
		$this->LastTraining=$LastTraining;
	}	
	public function getLastTraining() {
		return $this->LastTraining;
	}
			
	public function getLastlogin() {
		return $this->lastlogin;
	}
	public function getRank() {
		return $this->rank;
	}
	
	public function setlastHTlogin($lastHTlogin) {
		$this->lastHTlogin=$lastHTlogin;
	}	
	public function getlastHTlogin() {
		return $this->lastHTlogin;
	}
}

class CoachTeam {
    private $coachid;
    private $teamid;
    private $teamname;
    private $LastTraining;
    private $conditieperc;
    private $trainingtype;
    private $trainingintensity;
    private $trainerskill;
    private $assistants;
    private $doctors;
    private $formcoach;
    private $bot;
    private $leagueID;
    private $isNew;

    public function __construct($coachid, $teamid, $teamname, 
		$LastTraining, $conditieperc, $trainingtype, $trainingintensity, $trainerskill, $assistants, $doctors, $formcoach, $bot, $leagueID) {
		$this->coachid		=	$coachid;
		$this->teamid		=	$teamid;
		$this->teamname		=	$teamname;
		$this->LastTraining = $LastTraining;
		$this->conditieperc = $conditieperc;
		$this->trainingtype = $trainingtype;
		$this->trainingintensity = $trainingintensity;
		$this->trainerskill = $trainerskill;
		$this->assistants = $assistants;
		$this->doctors = $doctors;
        $this->formcoach = $formcoach;
		$this->bot = $bot;
		$this->leagueID = $leagueID;
    }

    public function setCoachId($coachid) {
		$this->coachid=$coachid;
	}	
	public function getCoachID() {
		return $this->coachid;
	}
    public function setTeamId($teamid) {
		$this->teamid=$teamid;
	}	
	public function getTeamID() {
		return $this->teamid;
	}
    public function setTeamName($teamname) {
		$this->teamname=$teamname;
	}	
	public function getTeamName() {
		return $this->teamname;
	}
    public function setLastTraining($lasttraining) {
		$this->LastTraining=$lasttraining;
	}	
	public function getLastTraining() {
		return $this->LastTraining;
	}
    public function setConditiePerc($conditieperc) {
		$this->conditieperc=$conditieperc;
	}	
	public function getConditiePerc() {
		return $this->conditieperc;
	}
    public function settrainingtype($trainingtype) {
		$this->trainingtype=$trainingtype;
	}	
	public function gettrainingtype() {
		return $this->trainingtype;
	}	
    public function settrainingintensity($trainingintensity) {
		$this->trainingintensity=$trainingintensity;
	}	
	public function gettrainingintensity() {
		return $this->trainingintensity;
	}
    public function settrainerskill($trainerskill) {
		$this->trainerskill=$trainerskill;
	}	
	public function gettrainerskill() {
		return $this->trainerskill;
	}
    public function setassistants($assistants) {
		$this->assistants=$assistants;
	}	
	public function getassistants() {
		return $this->assistants;
	}
    public function setdoctors($doctors) {
		$this->doctors=$doctors;
	}	
	public function getdoctors() {
		return $this->doctors;
	}
    public function setIsNew($isNew) {
		$this->isNew=$isNew;
	}	
	public function getIsNew() {
		return $this->isNew;
	}
    public function setFormCoach($formcoach) {
		$this->formcoach=$formcoach;
	}	
	public function getFormCoach() {
		return $this->formcoach;
	}
    public function setbot($bot) {
		$this->bot=$bot;
	}	
	public function getbot() {
		return $this->bot;
	}
	
	public function setleagueID($leagueID) {
		$this->leagueID=$leagueID;
	}	
	public function getleagueID() {
		return $this->leagueID;
	}
}
?>
