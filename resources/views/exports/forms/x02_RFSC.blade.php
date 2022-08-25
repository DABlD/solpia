@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6" style="vertical-align: middle; {{ $bold }} {{ $center }}">
			SOLPIA MARINE AND SHIP MANAGEMENT
		</td>
	</tr>

	<tr>
		<td colspan="6" style="text-decoration: underline; vertical-align: middle; {{ $bold }} {{ $center }}">
			CREW UNIFORM ORDER SLIP
		</td>
	</tr>

	<tr>
		<td colspan="2">DATE SUBMITTED:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ now()->format('d-M-yy') }}
		</td>
		<td>REFERENCE NO:</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">SUBMITTED BY:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ auth()->user()->gender == "Female" ? "MS" : "MR." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td>P.P. NO.:</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">FLEET ASSIGNED:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ auth()->user()->fleet }}
		</td>
	</tr>

	<tr>
		<td colspan="2">PRINCIPAL:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ $data->principal->name }}
		</td>
	</tr>

	<tr>
		<td colspan="2">VESSEL:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ $data->vessel->name }}
		</td>
		<td>ETD: {{ isset($data->applicants[0]) ? (isset($data->applicants[0]->pro_app->eld) ? now()->parse($data->applicants[0]->pro_app->eld)->format('M j, Y') : '') : '' }}</td>
	</tr>

	<tr>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">No.</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">RANK</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">CREW NAME</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">WAISTLINE</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">SHOE</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">COVERALL</td>
	</tr>

	@if($data->applicants)
		@foreach($data->applicants as $key => $applicant)
			<tr>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $key+1 }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->rank }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">
					{{ $applicant->user->lname }}, {{ $applicant->user->fname }} {{ $applicant->user->suffix }} {{ $applicant->user->mname }}
				</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->waistline }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->shoe_size }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->clothes_size }}</td>
			</tr>
		@endforeach

		@for($i = sizeof($data->applicants); $i < 12; $i++)
			<tr>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $i+1 }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
			</tr>
		@endfor
	@endif

	<tr>
		<td colspan="2" style="{{ $bold }} font-style: italic;">
			SMOP-CUR-22
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $center }} text-decoration: underline;">
			{{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td colspan="3" style="text-decoration: underline; {{ $center }}">
			HONEY ROSE DE MARA
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $center }}">REQUESTED BY</td>
		<td colspan="3" style="{{ $center }}">RECEIVED BY</td>
	</tr>

	<tr>
		<td colspan="6" style="height: 60px;"></td>
	</tr>

	{{-- 2nd copy~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~`` --}}

	<tr>
		<td colspan="6"></td>
	</tr>

	<tr>
		<td colspan="6" style="vertical-align: middle; {{ $bold }} {{ $center }}">
			SOLPIA MARINE AND SHIP MANAGEMENT
		</td>
	</tr>

	<tr>
		<td colspan="6" style="text-decoration: underline; vertical-align: middle; {{ $bold }} {{ $center }}">
			CREW UNIFORM ORDER SLIP
		</td>
	</tr>

	<tr>
		<td colspan="2">DATE SUBMITTED:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ now()->format('d-M-yy') }}
		</td>
		<td>REFERENCE NO:</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">SUBMITTED BY:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ auth()->user()->gender == "Female" ? "MS" : "MR." }} {{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td>P.P. NO.:</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">FLEET ASSIGNED:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ auth()->user()->fleet }}
		</td>
	</tr>

	<tr>
		<td colspan="2">PRINCIPAL:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ $data->principal->name }}
		</td>
	</tr>

	<tr>
		<td colspan="2">VESSEL:</td>
		<td style="color: #0000FF; text-decoration: underline;">
			{{ $data->vessel->name }}
		</td>
		<td>ETD: {{ isset($data->applicants[0]) ? (isset($data->applicants[0]->pro_app->eld) ? now()->parse($data->applicants[0]->pro_app->eld)->format('M j, Y') : '') : '' }}</td>
	</tr>

	<tr>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">No.</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">RANK</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">CREW NAME</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">WAISTLINE</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">SHOE</td>
		<td style="text-decoration: underline; {{ $center }} {{ $bold }} border: 1px solid #000000">COVERALL</td>
	</tr>

	@if($data->applicants)
		@foreach($data->applicants as $key => $applicant)
			<tr>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $key+1 }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->rank }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">
					{{ $applicant->user->lname }}, {{ $applicant->user->fname }} {{ $applicant->user->suffix }} {{ $applicant->user->mname }}
				</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->waistline }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->shoe_size }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $applicant->clothes_size }}</td>
			</tr>
		@endforeach

		@for($i = sizeof($data->applicants); $i < 12; $i++)
			<tr>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000">{{ $i+1 }}</td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
				<td style="color: #0000FF; {{ $center }} border: 1px solid #000000"></td>
			</tr>
		@endfor
	@endif

	<tr>
		<td colspan="2" style="{{ $bold }} font-style: italic;">
			SMOP-CUR-22
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $center }} text-decoration: underline;">
			{{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td colspan="3" style="text-decoration: underline; {{ $center }}">
			HONEY ROSE DE MARA
		</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td style="{{ $center }}">REQUESTED BY</td>
		<td colspan="3" style="{{ $center }}">RECEIVED BY</td>
	</tr>

	<tr>
		<td></td>
	</tr>
</table>