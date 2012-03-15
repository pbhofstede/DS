<?php 
 // Include PHT file before starting session!
    
    include ('Class\PHT.php');
    session_start();
    /*
    You must supply your chpp crendentials and a callback url.
    User will be redirected to this url after login
    You can add your own parameters to this url if you need,
    they will be kept on user redirection
    */
    try
    {
    $CallBackURL = $_GET['CallbackURL']; 
    if (isset($_GET['Pass']))
    {
		$CallBackURL = $CallBackURL.'&Pass='.$_GET['Pass'];		
	}
	if (isset($_GET['ReturnURL']))
    {
		$CallBackURL = $CallBackURL.'&ReturnURL='.$_GET['ReturnURL'];		
	}
	//echo $CallBackURL;
    $HT = new CHPPConnection('GG6InhlME6WtIcHBPBpM87', 'jPfgjNAcVIZ5IGMuBDstDyf8K86jXvNpEgkPVyp9wak', $CallBackURL);
    $url = $HT->getAuthorizeUrl();
    }
    catch(HTError $e)
    {
    echo $e->getMessage();
    }
    /*
    Be sure to store $HT in session before redirect user
    to Hattrick chpp login page
    */
    $_SESSION['HT'] = $HT;
    /*
    Redirect user to Hattrick for login
    or put a link with this url on your site
    */
    header('Location: '.$url); 
?>
