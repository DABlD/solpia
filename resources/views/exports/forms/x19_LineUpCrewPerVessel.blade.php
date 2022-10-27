@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$bc = $bold . ' ' . $center;
@endphp

<tr>
	<td style="{{ $bc }}">No.</td>
	<td style="{{ $bc }}">RANK</td>
	<td style="{{ $bc }}">VESSEL</td>
	<td style="{{ $bc }}">NAME</td>
	<td style="{{ $bc }}">MOBILE NO.</td>
</tr>

@foreach($data as $key => $applicant)
	<tr>
		<td style="{{ $center }}">{{ $key+1 }}</td>
		<td style="{{ $center }}">{{ $applicant->rank->abbr }}</td>
		<td style="{{ $center }}">{{ $applicant->vessel->name }}</td>
		<td style="{{ $center }}">{{ $applicant->applicant->user->lname }}, {{ $applicant->applicant->user->fname }} {{ $applicant->applicant->user->suffix }} {{ $applicant->applicant->user->mname }}</td>
		<td style="{{ $center }}">{{ $applicant->applicant->user->contact }}</td>
	</tr>
@endforeach