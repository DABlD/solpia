@php
	$center = "text-align: center;";
	$bold = "font-weight: bold";
@endphp

<table>
	<tr>
		<td colspan="9" style="{{ $center }} {{ $bold }} height: 50px; font-size: 20px; font-family: 'Times New Roman'; vertical-align: middle;">
			<b>SOLPIA MARINE &#38; SHIP MANAGEMENT INC.</b>
		</td>
	</tr>

	<tr><td colspan='9'></td></tr>

	<tr>
		<td>DATE:</td>
		<td colspan="4" style="{{ $center }}">{{ now()->format('F, M d, Y') }}</td>
		<td></td>
		<td colspan="3">
			AKJ-BRW-2021-
			@if($data->data2['ref'] > 9999)
				0{{ $data->data2['ref'] }}
			@else
				00{{ $data->data2['ref'] }}
			@endif
		</td>
	</tr>

	<tr><td colspan='9'></td></tr>

	<tr>
		<td colspan="9" style="height: 75px;">
			Dear Sir/Madam:

			<br style="mso-data-placement:same-cell;" />
			<br style="mso-data-placement:same-cell;" />

			I {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }} with rank of {{ $data->rank }} wish to inform you that I shall {{ $data->data2['purpose'] }} the following documents which I have submitted to your company such as:
			<br style="mso-data-placement:same-cell;" />
		</td>
	</tr>

	<tr>
		<td colspan="9">Please state purpose: {{ $data->data2['purpose'] }} (list down documents)</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 30px;"></td>
	</tr>

	<tr>
		<td colspan="9" style="color: #0000FF; height: 180px; vertical-align: top;">
			@foreach($data->data2['docs'] as $key => $doc)
				@if($key > 0)
					<br style="mso-data-placement:same-cell;" />
				@endif
				{{ str_replace('&', '&#38;', $doc) }}
			@endforeach
			-NOTHING FOLLOWS-
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 80px;">
			I hereby release and forever discharge SOLPIA MARINE &#38; SHIP MGMT, INC,. its Principals, Officers and all other parties at interest therein, from any and all claims, liabilities and demands arising from the decision that I willfully made.
			
			<br style="mso-data-placement:same-cell;" />
			<br style="mso-data-placement:same-cell;" />

			Thank you for understanding.
		</td>
	</tr>

	<tr><td colspan='9'></td></tr>

	<tr>
		<td colspan="2">Respectfully,</td>
		<td colspan="3"></td>
		<td colspan="2">Assisted by:</td>
		<td colspan="2">{{ auth()->user()->fname }} {{ auth()->user()->lname }}</td>
	</tr>

	<tr>
		<td colspan="5" style="color: #0000FF; height: 30px; vertical-align: bottom; {{ $center }} text-decoration: underline;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr>
		<td colspan="5" style="{{ $center }}">
			(signature over printed name)
		</td>
	</tr>

	<tr><td colspan='9'></td></tr>

	<tr>
		<td colspan="4">Documents checked &#38; released</td>
		<td colspan="2"></td>
		<td colspan="3">Noted by:</td>
	</tr>

	<tr>
		<td colspan="9">By:</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>


	<tr><td colspan='9'></td></tr>

	<tr>
		<td colspan="4" style="{{ $center }}">
			{{ auth()->user()->fname }} {{ auth()->user()->lname }}
		</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $center }}">Mr. Adulf Kit Jumawan</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $center }} {{ $bold }}">Crewing Officer</td>
		<td colspan="2"></td>
		<td colspan="3" style="{{ $center }} {{ $bold }}">Crewing Manager</td>
	</tr>

	<tr>
		<td colspan="9"></td>
	</tr>
</table>