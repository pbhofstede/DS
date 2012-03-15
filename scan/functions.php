<?php
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
