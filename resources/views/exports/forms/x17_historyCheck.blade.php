@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$bc = $bold . " " . $center;
	// dd($data);
@endphp

<table>
	<tr>
		<td colspan="9" style="height: 60px;"></td>
	</tr>

	<tr>
		<td style="{{ $bold }} height: 20px;">Name of Agency</td>
		<td>:</td>
		<td colspan="4"></td>
		<td style="{{ $bc }}">Date</td>
		<td>:</td>
		<td>{{ now()->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td style="{{ $bold }} height: 20px;">Tel / Fax No.</td>
		<td>:</td>
		<td colspan="4"></td>
		<td colspan="3"></td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">Dear Sir/Madam:</td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9" style="{{ $bc }} font-size: 14px;">Re:Seafarer Employment History Check</td>
	</tr>

	<tr><td colspan="9" style="height: 40px;"></td></tr>

	<tr>
		<td colspan="9">May we request your good self to please advice us of the following information with respect</td>
	</tr>

	<tr>
		<td colspan="9">to your ex-seafarer?</td>
	</tr>

	<tr><td colspan="9" style="height: 40px;"></td></tr>

	<tr>
		<td colspan="3">Name: {{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}</td>
		<td colspan="2">Rank: {{ $data->rank }}</td>
		<td colspan="4">Last Vessel: {{ $data->last_vessel }}</td>
	</tr>

	<tr><td colspan="9"></td></tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">a. Performance level of his duties</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">b. Character</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">c. Sobriety</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">d. Finish contract or Not</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">e. Reason for leaving the company</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">f. Any Accountabilities</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">g. Is he still Rehirable</td>
		<td></td>
		<td colspan="5"></td>
	</tr>
	
	<tr>
		<td colspan="3" style="height: 20px;">h. Is he subject for promotion</td>
		<td></td>
		<td colspan="5"></td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">Remarks / Comments</td>
	</tr>

	<tr>
		<td style="height: 50px;"></td>
		<td colspan="7" style="height: 50px;"></td>
		<td style="height: 50px;"></td>
	</tr>

	<tr><td colspan="9"></td></tr>

	<tr>
		<td colspan="9">Your kind and prompt attention on the above request is much appreciated</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="9" style="{{ $center }}">(THROUGH PHONE INQUIRY)</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 60px;"></td>
	</tr>

	<tr>
		<td>Information furnished by:</td>
		<td colspan="5"></td>
		<td>Requested by:</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="3" style="height: 40px; {{ $center }}"></td>
		<td colspan="2"></td>
		<td colspan="4" style="height: 40px; {{ $center }}">
			@if(auth()->user()->gender == "Male")
				MR. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@else
				MS. {{ auth()->user()->fname }} {{ auth()->user()->lname }}
			@endif
			 / {{ auth()->user()->role }}
		</td>
	</tr>


	<tr>
		<td colspan="3" style="{{ $bc }}">
			Name/Position
		</td>
		<td colspan="2"></td>
		<td colspan="4" style="{{ $bc }}">
			Name/Position
		</td>
	</tr>

	<tr>
		<td colspan="9" style="height: 40px;"></td>
	</tr>

	<tr>
		<td colspan="9">Note: The above information will be treated in the strictest confidentiality.</td>
	</tr>
</table>