@php
	$father = null;
	$mother = null;
	$spouse = null;
	$children = [];

	foreach($data->family_data as $fd){
		if($fd->type == "Father"){
			$father = $fd;
		}
		elseif($fd->type == "Mother"){
			$mother = $fd;
		}
		elseif(in_array($fd->type, ["Son", "Daughter"])){
			array_push($children, $fd);
		}
		elseif(in_array($fd->type, ["Spouse", "Partner"])){
			$spouse = $fd;
		}
	}

	$elem = null;
	$hs = null;
	$college = null;

	foreach($data->educational_background as $eb){
		if($eb->type == "Elementary"){
			$elem = $eb;
		}
		elseif($eb->type == "High School"){
			$hs = $eb;
		}
		elseif(in_array($eb->type, ["Vocational", "Undergrad", "College"])){
			$college = $eb;
		}
	}
@endphp

<table>
	<tr>
		<td>FIRST NAME</td>
		<td>{{ $data->user->fname }}</td>
	</tr>
	<tr>
		<td>MIDDLE NAME</td>
		<td>{{ $data->user->mname }}</td>
	</tr>
	<tr>
		<td>LAST NAME</td>
		<td>{{ $data->user->lname }}</td>
	</tr>
	<tr>
		<td>RANK:</td>
		<td>{{ $data->rank }}</td>
	</tr>
	<tr>
		<td>DATE OF BIRTH:</td>
		<td>{{ isset($data->user->birthday) ? $data->user->birthday->format('F j, Y') : "-" }}</td>
	</tr>
	<tr>
		<td>BIRTH PLACE:</td>
		<td>{{ $data->birth_place }}</td>
	</tr>
	<tr>
		<td>MARTIAL STATUS: </td>
		<td>{{ $data->civil_status }}</td>
	</tr>
	<tr>
		<td>RELIGION:</td>
		<td>{{ $data->religion }}</td>
	</tr>
	<tr>
		<td>NAME OF FATHER</td>
		<td>{{ isset($father) ? $father->fullName2 : "-" }}</td>
		<td>DOB:</td>
		<td>{{ isset($father->birthday) ? $father->birthday->format("F j, Y") : "-" }}</td>
	</tr>
	<tr>
		<td>NAME OF MOTHER:</td>
		<td>{{ isset($mother) ? $mother->fullName2 : "-" }}</td>
		<td>DOB:</td>
		<td>{{ isset($mother->birthday) ? $mother->birthday->format("F j, Y") : "-" }}</td>
	</tr>
	<tr>
		<td>NAME OF WIFE:</td>
		<td>{{ isset($spouse) ? $spouse->fullName2 : "-" }}</td>
	</tr>
	<tr>
		<td>NAME OF CHILDREN:</td>
		<td></td>
	</tr>
	@foreach($children as $child)
		<tr>
			<td></td>
			<td>{{ $child->nameFull2 }}</td>
		</tr>
	@endforeach
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>WAISTLINE SIZE (INCH): </td>
		<td style="text-align: left;">{{ $data->waistline }}</td>
	</tr>
	<tr>
		<td>SAFETY SHOE SIZE (CM):</td>
		<td style="text-align: left;">{{ $data->shoe_size }}</td>
	</tr>
	<tr>
		<td>COVERALL SIZE:</td>
		<td>{{ $data->clothes_size }}</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>HOME ADDRESS:</td>
		<td>{{ $data->user->address ?? $data->provincial_address }}</td>
	</tr>
	<tr>
		<td>EMAIL ADD:</td>
		<td>{{ $data->user->email }}</td>
	</tr>
	<tr>
		<td>FACEBOOK NAME: </td>
		<td></td>
	</tr>
	<tr>
		<td>TIN NO. :</td>
		<td>{{ $data->tin }}</td>
	</tr>
	<tr>
		<td>SSS NO.: </td>
		<td>{{ $data->sss }}</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>Educational Background: </td>
		<td></td>
	</tr>
	<tr>
		<td>GRADE SCHOOL</td>
		<td colspan="3">{{ isset($elem) ? $elem->school : "-" }}</td>
	</tr>
	<tr>
		<td>HIGH SCHOOL</td>
		<td colspan="3">{{ isset($hs) ? $hs->school : "-" }}</td>
	</tr>
	<tr>
		<td>COLLEGE</td>
		<td colspan="3">{{ isset($college) ? $college->school : "-" }}</td>
	</tr>
</table>