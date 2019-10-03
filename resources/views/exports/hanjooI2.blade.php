@php
	$checkDate2 = function($date, $type){
		if($date == "UNLIMITED"){
			return $date;
		}
		elseif($date == "" || $date == null){
			if($type == "E"){
				return 'UNLIMITED';
			}
			else{
				return '-----';
			}
		}
		else{
			return $date->format('F j, Y');
		}
	};

	// CHECK IF WATCHKEEPING AND HAS RANK AND IS DECK OR ENGINE RATING
	if(isset($applicant->rank_id)){
		$rank = $applicant->rank_id;
	}
	else{
		if(isset($applicant->rank)){
			$rank = $applicant->rank->id;
		}
		else{
			$rank = 0;
		}
	}

	$getDocument = function($docu, $type, $issuer = null, $name = null, $regulation = null) use ($applicant, $checkDate2, $rank) {
		$name   = !$name ? $docu : $name;

		if(in_array($type, ['id', 'lc', 'med_cert'])){

			if($type == "lc" && ($docu == "COC" || $docu == "COE") && $name == "NATIONAL LICENSE - RATINGS"){
				if($rank > 0 && $regulation){
					$tempDocu = $docu;
					$docu = false;
					$temp = "";

					if($rank >= 9 && $rank <= 23){
						foreach($applicant->document_lc as $document){
							$regulation = json_decode($document->regulation);
							
							if($rank >= 9 && $rank <= 14){
								$tempName = "COC";
								$temp = $tempDocu == $tempName ? 'II/4' : 'II/5';
							}
							elseif($rank >= 15 && $rank <= 23){
								$tempName = "COE";
								$temp = $tempDocu == $tempName ? 'III/4' : 'III/5';
							}

						    if($document->type == $tempName && in_array($temp, $regulation)){
						        $docu = $document;
						        break; 
						    }
						}

						$name .= " ($temp)";
					}
					else{
						$docu = false;
					}
				}
				else{
					return;
				}
			}
			elseif ($docu == 'ECDIS SPECIFIC') {
				$array = [
					'ECDIS FURUNO 2107',
					'ECDIS FURUNO 3200',
					'ECDIS FURUNO 3300',
					'ECDIS JRC 701B',
					'ECDIS JRC 7201',
					'ECDIS JRC 901B',
					'ECDIS JRC 9201',
					'ECDIS MARTEK',
					'ECDIS MECYS',
					'ECDIS TRANSAS',
				];

				$string = "";
				foreach($array as $ecdis){
					$docu = isset($applicant->{"document_$type"}->$ecdis) ? $applicant->{"document_$type"}->$ecdis : false;

					$number = $docu ? $docu->no : '-----';
					$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
					$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

					if($docu){
						$string .= "
							<tr>
								<td colspan='2'>
									<span></span><span></span>$ecdis
								</td>

								<td colspan='1'>$number</td>
								<td colspan='2'>$issue</td>
								<td colspan='3'>$expiry</td>
								<td colspan='1'></td>
							</tr>
						";
					}

				}

				if($string != ""){
					echo $string;
					return;
				}
			}
			elseif ($docu == 'SSBT WITH BRM') {
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu){
					$name = 'SSBT';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!$docu){
						$name = 'BRM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'BTM';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
			}
			else{
				$temp = $docu;
				$docu = isset($applicant->{"document_$type"}->$docu) ? $applicant->{"document_$type"}->$docu : false;

				if(!$docu && $temp == "RADAR"){
					$name = 'RADAR TRAINING COURSE';
					$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;

					if(!$docu){
						$name = 'RADAR SIMULATOR COURSE';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}

					if(!$docu){
						$name = 'RADAR OPERATOR PLOTTING AID';
						$docu = isset($applicant->document_lc->{$name}) ? $applicant->document_lc->{$name} : false;
					}
				}
			}

		}
		elseif($type == 'flag'){

			$temp = $docu;
			$docu = false;

			if($rank >= 24 && $rank <= 26){
				if($temp == 'LICENSE'){
					$temp = "SHIP'S COOK ENDORSEMENT";
				}
			}

			foreach($applicant->document_flag as $document){
			    if($document->country == "Panama" && $document->type == $temp){
			        $docu = $document;
			    }
			}
		}

		$noNum  = $type == 'lc' ? 'no' : 'number';

		$number = $docu ? $docu->$noNum : '-----';
		$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
		$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

		// $issuer = $issuer != null ? $issuer : $docu ? $docu->issuer : 'NOT APPLICABLE';
		if($issuer != ""){
			$issuer = $issuer;
		}
		else{
			$issuer = $type == "med_cert" ? 'clinic' : 'issuer';
			$issuer = $docu ? $docu->$issuer : 'NOT APPLICABLE';

			if($issuer == "NOT APPLICABLE" && $type == "med_cert"){
				$issuer = "REVERTING";
			}
		}

		if($name == "69"){
			$noNum  = $type == 'lc' ? 'no' : 'number';

			$number = $docu ? $docu->$noNum : '-----';
			$issue  = $docu ? $checkDate2($docu->issue_date, 'I') : '-----';
			$expiry = $docu ? $checkDate2($docu->expiry_date, 'E') : '-----';

			if($temp == "ADVANCE FIRE FIGHTING - AFF"){
				echo "
					<tr>
						<td colspan='2' rowspan='3'>
							Advanced Safety Course<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
							- Fire Fighting<span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
							- Survival Craft And Rescue Boat<span></span><span></span>
							- First Aid
						</td>

						<td colspan='1'>$number</td>
						<td colspan='2'>$issue</td>
						<td colspan='3'>$expiry</td>
						<td colspan='1'></td>
					</tr>
				";
			}
			else{
				echo "
					<tr>
						<td colspan='1'>$number</td>
						<td colspan='2'>$issue</td>
						<td colspan='3'>$expiry</td>
						<td colspan='1'></td>
					</tr>
				";
			}
		}
		else{
			echo "
				<tr>
					<td colspan='2'>
						<span></span><span></span>$name
					</td>

					<td colspan='1'>$number</td>
					<td colspan='2'>$issue</td>
					<td colspan='3'>$expiry</td>
					<td colspan='1'></td>
				</tr>
			";
		}
	};
@endphp

<table>
	<tr>
		<td>asdasdasd</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="5"></td>
		<td></td>
		<td rowspan="2" colspan="9">
			FORM SP SOMETHING
		</td>
	</tr>

	<tr></tr>
	<tr></tr>

	<tr>
		<td colspan="15">
			Interview Check List for Foreigner
		</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="2">Rank</td>
		<td colspan="3"></td>
		<td colspan="2">Date of Interview</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2">Name</td>
		<td colspan="3"></td>
		<td colspan="2">Seaman book No.</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth</td>
		<td colspan="3"></td>
		<td colspan="2">License Class (Officer Only)</td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5"></td>
		<td colspan="4">M.P.</td>
		<td colspan="4"></td>
	</tr>
	
	{{-- 1st ROW --}}
	<tr>
		<td colspan="13">Evaluation Item</td>
		<td colspan="2">Score</td>
	</tr>

	<tr>
		<td rowspan="5">Document(40)</td>
		<td colspan="3">Evaluation Item</td>
		<td colspan="9">Score Standard</td>
		<td>1st</td>
		<td>2nd</td>
	</tr>

	<tr>
		<td colspan="3">Onboard Career</td>
		<td colspan="9">Refer the Onboard Career Table (Max score is 35)</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Own will disembarkation</td>
		<td colspan="9">-3 point per one time (If no Score is 0)</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">(For Officer) ISM CODE applied ship career</td>
		<td colspan="9">Addtional 2 point per year (Max Score is 5)</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="12">(For ratings) qualification for welding, electricity, machine (Max Score is 5)</td>
		<td></td>
		<td></td>
	</tr>





	{{-- 2ND ROW --}}
	<tr>
		<td rowspan="11">Interview(60)</td>
		<td colspan="5">Evaluation Item</td>
		<td colspan="7">Score</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="4" colspan="2">Skill (20)</td>
		<td colspan="3">Knowledge</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Judgement</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Foreign language expression</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Language Skill</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td rowspan="4" colspan="2">Attitude (20)</td>
		<td colspan="3">Own will disembarkation (-1 point/per)</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Change company (2 per: 5 / 4 per: 4)</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Boarding career gap (less than 6 month :5)</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Long term boarding plan</td>
		<td>5</td>
		<td colspan="2">4</td>
		<td>3</td>
		<td colspan="2">2</td>
		<td>1</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2">Health (10)</td>
		<td colspan="3">Qualification to perform task (Appearance or medical test result)</td>
		<td colspan="2">10</td>
		<td colspan="3">7</td>
		<td colspan="2">3</td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="2">Background (10)</td>
		<td colspan="3">Family relationship, marriage, personal history</td>
		<td colspan="2">10</td>
		<td colspan="3">7</td>
		<td colspan="2">3</td>
		<td></td>
		<td></td>
	</tr>

	{{-- END --}}
	<tr>
		<td>Remark</td>
		<td colspan="5"></td>
		<td colspan="7"></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td colspan="3">Recommendation (if have)</td>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="3">Last Evaluation Check</td>
		<td colspan="12"></td>
	</tr>

	<tr>
		<td colspan="3">Academic ability</td>
		<td colspan="2"></td>
		<td colspan="7">Religion</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="3">Alcohol</td>
		{{-- <td colspan="2">Y / &#9411;</td> --}}
		<td colspan="2"></td>
		<td colspan="7">Smoking</td>
		<td colspan="3"></td>
		{{-- <td colspan="3">Y / &#9411;</td> --}}
	</tr>

	<tr>
		<td colspan="3">Comments</td>
		<td colspan="12"></td>
	</tr>
</table>