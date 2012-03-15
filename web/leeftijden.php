<?php
include('header.php');

$currentSeason		=	ceil((time() - 1010271601) / 19353600);

function getFinalDay($season) {
	return (1029664800 + (($season - 1) * 19353600));
}

function getMaximumAge($timestamp) 
{
 	/* tijd negeren */
	$cur_time = (floor(time() / 86400)) * 86400;
	$daysToGo	=	(($timestamp - $cur_time) / 86400);
	$maxDays	=	2352 - $daysToGo;
	return floor($maxDays / 112).'j '.($maxDays % 112).'d';
}


if(isset($_POST['submit']) && ctype_digit($_POST['season'])) {
	$season		=	$_POST['season'];
} else {
	$season		=	$currentSeason;
}



if(!empty($_POST['season']) && !ctype_digit($_POST['season'])) {
    echo '<script type="text/javascript">';
		echo 'alert(\'Ingevulde waarde is geen getal\');';
	echo '</script>';
}

echo '<h1>U20-Leeftijden</h1>';
echo 'Bekijk de huidige maximale leeftijd voor de U20 World Cup&rsquo;s. De huidige worldcup is World Cup '.$currentSeason.'.';

echo '<h2>World Cup leeftijden overzicht</h2>';
echo '<table width="100%" style="text-align: center">';
	echo '<tr>';
		echo '<th colspan="11">World Cup leeftijden overzicht</th>';
	echo '</tr>';
echo '<tr class="niveau1">';
	echo '<td rowspan="2" width="10%">Seizoen</td>';
	echo '<td colspan="2" width="45%">Uiterste leeftijden</td>';
	echo '<td colspan="2" width="45%">Optimale leeftijden</td>';
echo '</tr>';
echo '<tr class="niveau2">';
	echo '<td>Maximale leeftijd</td>';
	echo '<td>Minimale leeftijd</td>';
	echo '<td>Kwalificatie</td>';
	echo '<td>Finale</td>';
echo '</tr>';
if($currentSeason == $season) {
	echo '<tr style="color:red" bgcolor="#FEFBC8">';
} else {
	echo '<tr>';
}
	echo '<td class="niveau2">'.$currentSeason.'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 17712000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) + 1728000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 9849600).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason)).'</td>';
echo '</tr>';

$currentSeason = $currentSeason + 1;
if($currentSeason == $season) {
	echo '<tr style="color:red" bgcolor="#FEFBC8">';
} else {
	echo '<tr">';
}
	echo '<td class="niveau2">'.$currentSeason.'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 17712000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) + 1728000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 9849600).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason)).'</td>';
echo '</tr>';

$currentSeason = $currentSeason + 1;
if($currentSeason == $season) {
	echo '<tr style="color:red" bgcolor="#FEFBC8">';
} else {
	echo '<tr>';
}
	echo '<td class="niveau2">'.$currentSeason.'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 17712000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) + 1728000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 9849600).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason)).'</td>';
echo '</tr>';

$currentSeason = $currentSeason + 1;
if($currentSeason == $season) {
	echo '<tr style="color:red" bgcolor="#FEFBC8">';
} else {
	echo '<tr>';
}
	echo '<td class="niveau2">'.$currentSeason.'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 17712000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) + 1728000).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason) - 9849600).'</td>';
	echo '<td>'.getMaximumAge(getFinalDay($currentSeason)).'</td>';
echo '</tr>';

if(isset($_POST['submit']) && ctype_digit($_POST['season'])) {
	if ($season != $currentSeason && $season != ($currentSeason -1) && $season != ($currentSeason -2)){
		echo '<tr style="color:red" bgcolor="#FEFBC8">';
			echo '<td style="border-bottom: 1px solid #EE6600">'.$season.'</td>';
			echo '<td>'.getMaximumAge(getFinalDay($season) - 17712000).'</td>';
			echo '<td>'.getMaximumAge(getFinalDay($season) + 1728000).'</td>';
			echo '<td>'.getMaximumAge(getFinalDay($season) - 9849600).'</td>';
			echo '<td>'.getMaximumAge(getFinalDay($season)).'</td>';
		echo '</tr>';
	} 
}
echo '<tr class="none">';
echo '<form action="" method="POST">';
	echo '<td><input name="season" type="text" size="3"/></td>';
	echo '<td colspan="4" align="left"><input name="submit" type="submit" id="submit" value="Bekijk"></td>';
echo '</form>';
echo '</tr>';
echo '</table>';

echo '<h2>Overzicht van leeftijden per seizoen</h2>';
//
echo '<table width="100%" style="text-align: center">';
	echo '<tr>';
		echo '<th colspan="11">Seizoen '.$season.'</th>';
	echo '</tr>';
	echo '<tr class="niveau1">
		<td colspan="5">Kwalificatie</td>
		<td rowspan="16">&nbsp;&nbsp;&nbsp;</td>
		<td colspan="5">WK (Finale)</td>
	</tr>
	<tr class="niveau2">
		<td>Ronde</td>
		<td>Wed</td>
		<td>Datum</td>
		<td>Leeftijd</td>
		<td>Promotie</td>
		<td>Ronde</td>
		<td>Wed</td>
		<td>Datum</td>
		<td>Leeftijd</td>
		<td>Promotie</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>1</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 17712000).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 17712000).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 17712000 - 38620800).'</td>
		<td class="niveau2">2</td>
		<td>1</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 5011200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 5011200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 5011200 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>2</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 17107200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 17107200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 17107200 - 38620800).'</td>
		<td class="niveau2">2</td>
		<td>2</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 4752000).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 4752000).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 4752000 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>3</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 16502400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 16502400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 16502400 - 38620800).'</td>
		<td class="niveau2">2</td>
		<td>3</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 4406400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 4406400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 4406400 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>4</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 15897600).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 15897600).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 15897600 - 38620800).'</td>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>5</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 15292800).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 15292800).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 15292800 - 38620800).'</td>
		<td class="niveau2">3</td>
		<td>1</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1987200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 1987200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1987200 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>6</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 14688000).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 14688000).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 14688000 - 38620800).'</td>
		<td class="niveau2">3</td>
		<td>2</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1728000).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 1728000).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1728000 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>7</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 14083200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 14083200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 14083200 - 38620800).'</td>
		<td class="niveau2">3</td>
		<td>3</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1382400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 1382400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1382400 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>8</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 13478400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 13478400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 13478400 - 38620800).'</td>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>9</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 12873600).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 12873600).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 12873600 - 38620800).'</td>
		<td class="niveau2">4</td>
		<td>1</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1123200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 1123200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 1123200 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>10</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 12268800).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 12268800).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 12268800 - 38620800).'</td>
		<td class="niveau2">4</td>
		<td>2</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 777600).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 777600).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 777600 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>11</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 11664000).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 11664000).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 11664000 - 38620800).'</td>
		<td class="niveau2">4</td>
		<td>3</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 518400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 518400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 518400 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>12</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 11059200).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 11059200).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 11059200 - 38620800).'</td>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>13</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 10454400).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 10454400).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 10454400 - 38620800).'</td>
		<td class="niveau2">&frac12; Finale</td>
		<td>&nbsp;</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 172800).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 172800).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 172800 - 38620800).'</td>
	</tr>
	<tr>
		<td class="niveau2">1</td>
		<td>14</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 9849600).'</td>
		<td>'.getMaximumAge(getFinalDay($season) - 9849600).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 9849600 - 38620800).'</td>
		<td class="niveau2">Finale</td>
		<td>&nbsp;</td>
		<td>'.date('d-m-Y', getFinalDay($season)).'</td>
		<td>'.getMaximumAge(getFinalDay($season)).'</td>
		<td>'.date('d-m-Y', getFinalDay($season) - 38620800).'</td>
	</tr>
</table>';
echo '<h2>Belang van U20-leeftijden</h2>';
echo 'Uitgebreide uitleg over de reden en werking van optimale leeftijden bij het U20, is te vinden op <a href="'.$config['url'].'/leeftijdenUitleg/">deze pagina</a>.';
include('footer.php');
?>