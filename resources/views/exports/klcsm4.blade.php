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
			return $date->format('d-M-Y');
		}
	};

	$ss = function($ss) use($checkDate2){

		if($ss->vessel_name != null && $ss->vessel_type != null){
			$on = $checkDate2($ss->sign_on, 'a');
			$off = $checkDate2($ss->sign_off, 'a');

			$diff = "-";
			if($ss->sign_off != "" && $ss->sign_on != ""){
				$diff = $ss->sign_on->diffInDays($ss->sign_off);
			}

			$eng = str_replace('&', '&#38;', $ss->engine_type);
			$bhp = str_replace('&', '&#38;', $ss->bhp_kw);
			$flag = str_replace('&', '&#38;', $ss->flag);
			$principal = str_replace('&', '&#38;', $ss->principal);
			$manning = str_replace('&', '&#38;', $ss->manning_agent );

			echo "
				<tr>
					<td rowspan='2'>$flag</td>
					<td>$principal</td>
					<td>$ss->vessel_type</td>
					<td>$ss->trade</td>
					<td>$eng</td>
					<td>$on</td>
					<td rowspan='2'>$diff</td>
					<td rowspan='2'>$ss->remarks</td>
					<td rowspan='2'>
						AGENCY: $manning
						" . PHP_EOL . "
						COMBINED CREW: $ss->crew_nationality
					</td>
				</tr>

				<tr>
					<td>$ss->vessel_name</td>
					<td>$ss->rank</td>
					<td>$ss->gross_tonnage</td>
					<td>$bhp</td>
					<td>$off</td>
				</tr>
			";
		}
	};

	function isBlank2(){
		echo "
			<tr>
				<td rowspan='2'></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td rowspan='2'></td>
				<td rowspan='2'></td>
				<td rowspan='2'></td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		";
	}
@endphp

<table>
	<tr>
		<td>Name</td>
		<td colspan="2">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}
		</td>
		<td colspan="4"></td>
		<td>Rank</td>
		<td>{{ $data->rank ? $data->rank->abbr : "" }}</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>

	<tr>
		<td colspan="3">CAREER</td>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td rowspan="2">Flag</td>
		<td>Company Name</td>
		<td>Vessel Type</td>
		<td>Trading Area</td>
		<td>Engine Type</td>
		<td>From Date</td>
		<td rowspan="2">Period</td>
		<td rowspan="2">Leave Reason</td>
		<td rowspan="2">Remarks</td>
	</tr>

	<tr>
		<td>Vessel Name</td>
		<td>Rank</td>
		<td>G/T</td>
		<td>KW</td>
		<td>To Date</td>
	</tr>

	@php
		$size = 12;

		if($data->id == 5164){
			$size = 26;
		}

		for($i = 0; $i < $size; $i++){
			if(isset($data->sea_service[$i])){
				$ss($data->sea_service[$i]);
			}
			else{
				isBlank2();
			}
		}
	@endphp
</table>