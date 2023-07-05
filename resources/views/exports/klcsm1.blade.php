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

	// CHECK IF WATCHKEEPING AND HAS RANK AND IS DECK OR ENGINE RATING
	if(isset($data->rank_id)){
		$rank = $data->rank_id;
	}
	else{
		if(isset($data->rank)){
			$rank = $data->rank->id;
		}
		else{
			$rank = 0;
		}
	}

	$rank_category = $data->rank ? $data->rank->category : null;
	$total = 0;

	$eb = function($label, $type) use ($data){
		foreach($data->educational_background as $eb){
			if($eb->type == $type){
				$temp = explode('-', $eb->year);
				$matriculation = $temp[0] ?? '-';
				$graduation = $temp[1] ?? '-';
				$course = $eb->course ?? '-';

				echo "
					<td>$label</td>
					<td colspan='2'>$eb->school</td>
					<td>$matriculation</td>
					<td>$graduation</td>
					<td>$course</td>
					<td></td>
					<td></td>
				";

				return false;
			}
		}

		// IF NO MATCH
		echo "
			<td>$label</td>
			<td colspan='2'></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		";
	};

	$ss = function($ss, $vr) use($checkDate2){
		$on = $checkDate2($ss->sign_on, 'in');
		$off = $checkDate2($ss->sign_off, 'in');
		$eng = str_replace('&', '&#38;', $ss->engine_type);
		$dura = $ss->sign_on->diffInDays($ss->sign_off);

		echo "
			<td>$ss->flag</td>
			<td colspan='2'>$ss->vessel_name</td>
			<td>$ss->gross_tonnage</td>
			<td>$ss->bhp_kw</td>
			<td>$ss->vessel_type</td>
			<td>$vr</td>
			<td>$eng</td>
			<td>$on</td>
			<td>$off</td>
			<td>$dura</td>
			<td>$ss->remarks</td>
			<td>$ss->crew_nationality</td>
			<td>$ss->manning_agent</td>
			<td>$ss->principal</td>
		";
	};

	$fd = function($type, $ctr = 1) use($checkDate2, $data){
		$i = 0;
		foreach ($data->family_data as $fd) {
			if($fd->type == $type){
				$i = $i + 1;
				if($i == $ctr){
					$name = $fd->fname . ' ' . $fd->mname . ' ' . $fd->lname;
					$dob = $checkDate2($fd->birthday, 'in');
					$address = str_replace('&', '&#38;', $fd->address);

					echo "
						<td>$type</td>
						<td colspan='2'>$name</td>
						<td>$dob</td>
						<td>$fd->occupation</td>
						<td colspan='3'>$address</td>
					";

					return false;
				}
			}
		}

		// IF NO MATCH
		echo "
			<td>$type</td>
			<td colspan='2'></td>
			<td></td>
			<td></td>
			<td colspan='3'></td>
		";
	};
@endphp

<table>
	<tr>
		<td colspan="6">PERSONAL HISTORY RECORD</td>
		<td colspan="2" rowspan="6" style="color: #ff0000;">PICTURE</td>
	</tr>

	<tr>
		<td colspan="4">PERSONAL INFORMATION</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td rowspan="3">Name</td>
		<td>Korean</td>
		<td colspan="4">-----</td>
	</tr>

	<tr>
		<td>Chinese</td>
		<td colspan="4">-----</td>
	</tr>

	<tr>
		<td>English</td>
		<td colspan="4">
			{{ $data->user->fname . ' ' . $data->user->mname . ' ' . $data->user->lname }}
		</td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td rowspan="4">Details</td>
		
		<td>Rank</td>
		<td colspan="2">{{ $data->rank->name ?? '-' }}</td>

		<td>Blood Type</td>
		<td>{{ $data->blood_type ?? '-' }}</td>

		<td>Marital Status</td>
		<td>{{ $data->civil_status ?? '-' }}</td>
	</tr>

	<tr>
		<td>ID no.</td>
		<td colspan="2">-</td>

		<td>Clothes Size</td>
		<td>{{ $data->clothes_size ?? '-' }}</td>

		<td>Religion</td>
		<td>{{ $data->religion }}</td>	
	</tr>

	<tr>
		<td>Birth Date</td>
		<td colspan="2">{{ $data->user->birthday->format('F j, Y') }}</td>

		<td>Shoe Size</td>
		<td>{{ $data->shoe_size ?? '-' }}</td>

		<td>Hobby</td>
		<td>-</td>	
	</tr>

	<tr>
		<td>Nationality</td>
		<td colspan="2">FILIPINO</td>

		<td>E-mail</td>
		<td colspan="3">{{ $data->user->email }}</td>	
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td>Phone</td>
		
		<td>Home</td>
		<td colspan="2"></td>

		<td>Mobile</td>
		<td>{{ $data->user->contact }}</td>

		<td>Emergency</td>
		<td>{{ $data->provincial_contact }}</td>
	</tr>

	<tr>
		<td>Address</td>
		<td colspan="7">{{ $data->user->address }}</td>
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="4"> FAMILY DETAILS</td>
	</tr>

	<tr>
		<td>Relation</td>
		<td colspan="2">Name</td>
		<td>Birth Date</td>
		<td>Occupation</td>
		<td colspan="3">Address &#38; Remarks</td>
	</tr>

	<tr>
		{{ $fd('Father') }}
	</tr>

	<tr>
		{{ $fd('Mother') }}
	</tr>

	<tr>
		{{ $fd('Spouse') }}
	</tr>

	<tr>
		{{ $fd('Son', 1) }}
	</tr>

	<tr>
		{{ $fd('Son', 2) }}
	</tr>

	<tr>
		{{ $fd('Daughter', 1) }}
	</tr>

	<tr>
		{{ $fd('Daughter', 2) }}
	</tr>

	<tr>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="4">EDUCATIONAL BACKGROUND</td>
	</tr>

	<tr>
		<td rowspan="2">School Type</td>
		<td colspan="2" rowspan="2">School Name</td>
		<td colspan="2">Date</td>
		<td rowspan="2">Course</td>
		<td rowspan="2">Completion</td>
		<td rowspan="2">Remarks</td>
	</tr>

	<tr>
		<td>Matriculation</td>
		<td>Graduation</td>
	</tr>

	<tr>
		{{ $eb('Primary', 'Elementary') }}
	</tr>

	<tr>
		{{ $eb('High School', 'High School') }}
	</tr>

	<tr>
		{{ $eb('University', 'College') }}
	</tr>

	<tr>
		{{ $eb('Vocational', 'Vocational') }}
	</tr>

	<tr>
		<td>Post-Graduate</td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>