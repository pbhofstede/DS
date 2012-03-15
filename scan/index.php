<?php
include('config.php');
?>
<html>
	<head>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type" />
	<link href="<?php echo $config['url'].'/style.css'; ?>" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript">
		var link = null;
		updateLink('<?php echo $config['url']; ?>');
		
		var formInUse = false;

		function setFocus()
		{
		 if(!formInUse) {
			document.inlogForm.DSUserName.focus();
		 }
		}
		
		function updateLink(newLink) {
			link	=	newLink;
		}
		
		function checkKey(e) {
			if(e.keyCode == 13) {
				goScan();
			}
		}
		
		function goScan() {
			var name		=	document.getElementById("name").value;
			var password	=	document.getElementById("password").value;
			xmlhttp = window.XMLHttpRequest?new XMLHttpRequest(): new ActiveXObject("Microsoft.XMLHTTP");
			xmlhttp.onreadystatechange = goScanTriggered;
			xmlhttp.open("GET", link + '/scan.php' + '?name=' + name + '&password=' + password + '&IEfix=' + new Date().getTime());
			xmlhttp.send(null);
		}
		
		function goScanTriggered() {
			if(xmlhttp.readyState == 1) {
				document.getElementById('scan').innerHTML = '<center><div style="padding:20px"><img src="' + link + '/images/loading.gif" /></div></center>';
			} else if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById('scan').innerHTML = xmlhttp.responseText;
			}
		}
	</script>
	<script type="text/javascript"></script>
	</head>
	<body onload="setFocus()">
	<div class="chpp"><img src="<?php echo $config['url'].'/images/chpp.gif'; ?>" /></div>
	<div class="cup"><img src="<?php echo $config['url'].'/images/cup.png'; ?>" /></div>
		<div class="banner"><img src="<?php echo $config['url'].'/images/banner.png'; ?>" /></div>
		<div class="container">
			<div class="language">
			  
					<?php 
						if(empty($_SESSION['language']) || $_SESSION['language'] == 'NL') {
							echo '<a href="'.$config['url'].'/NL/">';
							echo '<img src="'.$config['url'].'/images/nl.png"/>';

							echo '</a><a href="'.$config['url'].'/US/">';
							echo '<img src="'.$config['url'].'/images/eng.png"/>';
							echo " <b>Click here for an English version...</b></a>";
						}
						else {
							echo '<a href="'.$config['url'].'/US/">';
							echo '<img src="'.$config['url'].'/images/eng.png"/>';

							echo '</a><a href="'.$config['url'].'/NL/">';
							echo '<img src="'.$config['url'].'/images/nl.png"/>';
							echo " <b>Klik hier voor de Nederlandse versie...</b></a>";
						}
					?>
			</div>
			<div class="content">
				<?php echo $language['intro']; ?>
				<span id="scan">
					<form action="" method="POST" name="inlogForm">
						<p>
							<label><?php echo $language['name']; ?></label>
							<input type="text" id="name" name="DSUserName" maxlength="100" onKeyPress="checkKey(event)" onfocus="formInUse = true;"/>
						</p>
						<p>
							<label><?php echo $language['password']; ?></label>
							<input type="password" id="password" maxlength="100" onKeyPress="checkKey(event)" onfocus="formInUse = true;"/>
						</p>
						<p>
							<label>&nbsp;</label>
							<input type="button" value="<?php echo $language['scan']; ?>" onClick="goScan()"/>
						</p>
						<div class="contect"><a href="<?php echo $config['url']; ?>/loginHT.php"><u><?php echo $language['new'];?></u></a></div>
					</form>
				</span>
				<div align="right"><a href="<?php echo $config['urlweb']?>"><?php echo $language['toFullVersion']; ?></a></div>
			</div>
		</div>
	</body>
</html>
