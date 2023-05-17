<table>
	<tr>
		<td colspan="11">Walang Lagay! SOLPIA!!!</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td>Vessel:</td>
		<td colspan="4">{{ $data->vessel }}</td>
		<td colspan="2"></td>
		{{-- <td>AGE:</td> --}}
		<td></td>
		<td>
			{{-- {{ $data->user->birthday ? $data->user->birthday->diff(now())->format('%y') : '---' }} --}}
		</td>
		<td>BMI:</td>
		<td>{{ $data->bmi }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td>Rank:</td>
		<td>{{ $data->rank ?? "" }}</td>
		<td>Name:</td>
		<td colspan="3">{{ $data->user->lname . ', ' . $data->user->fname . (($data->user->suffix != "") ? (' ' . $data->user->suffix) : '') . ' ' . $data->user->mname }}</td>
		<td colspan="2">Height(cm):</td>
		<td>{{ $data->height }}</td>
		<td>Weight:</td>
		<td>{{ $data->weight }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td>Ex-crew:</td>
		<td colspan="4">{{ $data->exCrew }}</td>
		<td colspan="2">New Applicant:</td>
		<td colspan="4">{{ $data->newHire }}</td>
	</tr>

	<tr>
		<td colspan="2"></td>
		<td colspan="2">(Vessel Name)</td>
		<td colspan="3"></td>
		<td colspan="4">(Previous Company)</td>
	</tr>

	<tr>
		<td colspan="11"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="3">Signature</td>
		<td colspan="4">Remarks</td>
	</tr>

	<tr>
		<td colspan="4">Documentation Assistant</td>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="4">Crewing Manager / Asst. Crewing Manager</td>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="4">Operation's Assistant</td>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		{{-- <td colspan="4">C.E.O / J.S. Sim (if new crew)</td> --}}
		<td colspan="4"></td>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="3"></td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td rowspan="3" colspan="11">Remarks:</td>
	</tr>

	<tr></tr>
	<tr></tr>

	{{-- <tr>
		<td colspan="11">
			Last Medical:
			@foreach($data->document_med as $data)
				{{ ' ' . $data->type . '(' . $data->year . '),' }}
			@endforeach
		</td>
	</tr>

	<tr>
		<td colspan="11">Last Vessel Evaluation / History Check:</td>
	</tr> --}}

	<tr>
		<td colspan="2">For Promotional Cases</td>
		<td colspan="2"></td>
		<td colspan="5">Pls. Remark his previous Rank and Sea career including</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="4">recommendation letter from the vessel if any.</td>
		<td colspan="3"></td>
	</tr>

	<tr>
		<td colspan="4">DOC NO: SMOP-WL-09</td>
		<td colspan="4">EFFECTIVE DATE: 01 SEPT 17</td>
		<td colspan="3" style="text-align: right;">REVISION NO: 1.0/11/29/22</td>
	</tr>
</table>