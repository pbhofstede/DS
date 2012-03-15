<?php
function output($string, $type = 'string') {
	if($type == 'string') {
		return nl2br(stripslashes(htmlspecialchars($string)));
	} elseif($type == 'textarea') {
		return stripslashes($string);
	}
}

function redirect($url, $wait = 0) {
	if($wait == 0) {
		header('Location: '.$url);
		include ('footer.php');
		exit();
	} else {
		echo '<meta http-equiv="refresh" content="'.$wait.';'.$url.'" />';
	}
}
  $output = '';
	$output		.=		'<option value="0">Rampzalig</option>';
	$output		.=		'<option value="1">Rampzalig</option>';
	$output		.=		'<option value="2">Waardeloos</option>';
	$output		.=		'<option value="3">Slecht</option>';
	$output		.=		'<option value="4">Zwak</option>';
	$output		.=		'<option value="5">Matig</option>';
	$output		.=		'<option value="6">Redelijk</option>';
	$output		.=		'<option value="7">Goed</option>';
	$output		.=		'<option value="8">Uitstekend</option>';
	$output		.=		'<option value="9">Formidabel</option>';
	$output		.=		'<option value="10">Uitmuntend</option>';
	$output		.=		'<option value="11">Briljant</option>';
	$output		.=		'<option value="12">Wonderbaarlijk</option>';
	$output		.=		'<option value="13">Wereldklasse</option>';
	$output		.=		'<option value="14">Bovennatuurlijk</option>';
	$output		.=		'<option value="15">Reusachtig</option>';
	$output		.=		'<option value="16">Buitenaards</option>';
	$output		.=		'<option value="17">Mytisch</option>';
	$output		.=		'<option value="18">Magisch</option>';
	$output		.=		'<option value="19">Utopisch</option>';
	$output		.=		'<option value="20">Goddelijk</option>';

function getSkillLevel($level, $language = 'NL') {
	if($level == NULL) {
		return NULL;
	} elseif($level == 0) {
		if($language == 'NL') {
			return 'Niet bestaand';
		}
	} elseif($level == 1) {
		if($language == 'NL') {
			return 'Rampzalig';
		}
	} elseif($level == 2) {
		if($language == 'NL') {
			return 'Waardeloos';
		}
	}  elseif($level == 3) {
		if($language == 'NL') {
			return 'Slecht';
		}
	} elseif($level == 4) {
		if($language == 'NL') {
			return 'Zwak';
		}
	} elseif($level == 5) {
		if($language == 'NL') {
			return 'Matig';
		}
	} elseif($level == 6) {
		if($language == 'NL') {
			return 'Redelijk';
		}
	} elseif($level == 7) {
		if($language == 'NL') {
			return 'Goed';
		}
	} elseif($level == 8) {
		if($language == 'NL') {
			return 'Uitstekend';
		}
	} elseif($level == 9) {
		if($language == 'NL') {
			return 'Formidabel';
		}
	} elseif($level == 10) {
		if($language == 'NL') {
			return 'Uitmuntend';
		}
	} elseif($level == 11) {
		if($language == 'NL') {
			return 'Briljant';
		}
	} elseif($level == 12) {
		if($language == 'NL') {
			return 'Wonderbaarlijk';
		}
	} elseif($level == 13) {
		if($language == 'NL') {
			return 'Wereldklasse';
		}
	} elseif($level == 14) {
		if($language == 'NL') {
			return 'Bovennatuurlijk';
		}
	} elseif($level == 15) {
		if($language == 'NL') {
			return 'Reusachtig';
		}
	} elseif($level == 16) {
		if($language == 'NL') {
			return 'Buitenaards';
		}
	} elseif($level == 17) {
		if($language == 'NL') {
			return 'Mytisch';
		}
	} elseif($level == 18) {
		if($language == 'NL') {
			return 'Magisch';
		}
	} elseif($level == 19) {
		if($language == 'NL') {
			return 'Utopisch';
		}
	} elseif($level == 20) {
		if($language == 'NL') {
			return 'Goddelijk';
		}
	}
}

function getPosition($id, $language = 'NL') {
	if($id == NULL) {
		return NULL;
	} elseif($id == 1) {
		if($language == 'NL') {
			return 'Keeper';
		} elseif($language == 'US') {
			return 'Keeper';
		}
	} elseif($id == 2) {
		if($language == 'NL') {
			return 'Rechter verdediger';
		} elseif($language == 'US') {
			return 'Right back';
		}
	} elseif($id == 3) {
		if($language == 'NL') {
			return 'Centrale verdediger';
		} elseif($language == 'US') {
			return 'Central Defender';
		}
	} elseif($id == 4) {
		if($language == 'NL') {
			return 'Centrale verdediger';
		} elseif($language == 'US') {
			return 'Central Defender';
		}
	} elseif($id == 5) {
		if($language == 'NL') {
			return 'Linker verdediger';
		} elseif($language == 'US') {
			return 'Left Back';
		}
	} elseif($id == 6) {
		if($language == 'NL') {
			return 'Rechter vleugelspeler';
		} elseif($language == 'US') {
			return 'Right winger';
		}
	} elseif($id == 7) {
		if($language == 'NL') {
			return 'Middenvelder';
		} elseif($language == 'US') {
			return 'Inner Midfield';
		}
	} elseif($id == 8) {
		if($language == 'NL') {
			return 'Middenvelder';
		} elseif($language == 'US') {
			return 'Inner Midfield';
		}
	} elseif($id == 9) {
		if($language == 'NL') {
			return 'Linker vleugelspeler';
		} elseif($language == 'US') {
			return 'Left winger';
		}
	} elseif($id == 10) {
		if($language == 'NL') {
			return 'Aanvaller';
		} elseif($language == 'US') {
			return 'Forward';
		}
	} elseif($id == 11) {
		if($language == 'NL') {
			return 'Aanvaller';
		} elseif($language == 'US') {
			return 'Forward';
		}
	} elseif($id == 12) {
		if($language == 'NL') {
			return 'Keeper (reserve)';
		} elseif($language == 'US') {
			return 'Keeper (substitution)';
		}
	} elseif($id == 13) {
		if($language == 'NL') {
			return 'Verdediger (reserve)';
		} elseif($language == 'US') {
			return 'Defender (substitution)';
		}
	} elseif($id == 14) {
		if($language == 'NL') {
			return 'Middenvelder (reserve)';
		} elseif($language == 'US') {
			return 'Inner Midfield (substitution)';
		}
	} elseif($id == 15) {
		if($language == 'NL') {
			return 'Vleugelspeler (reserve)';
		} elseif($language == 'US') {
			return 'Winger (substitution)';
		}
	} elseif($id == 16) {
		if($language == 'NL') {
			return 'Aanvaller (reserve)';
		} elseif($language == 'US') {
			return 'Forward (substitution)';
		}
	} elseif($id == 17) {
		if($language == 'NL') {
			return 'Spelhervatter';
		} elseif($language == 'US') {
			return 'Set Pieces';
		}
	} elseif($id == 18) {
		if($language == 'NL') {
			return 'Aanvoerder';
		} elseif($language == 'US') {
			return 'Captain';
		}
	}
}
?>
