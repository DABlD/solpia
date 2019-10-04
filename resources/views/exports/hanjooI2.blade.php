<table>
	<tr></tr>

	<tr>
		<td rowspan="2" colspan="5"></td>
		<td></td>
		<td rowspan="2" colspan="9">
			FORM SP08-06(1/1) / 0 15.12.21
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
		<td colspan="3">
			{{ isset($applicant->rank) ? $applicant->rank->abbr : '-----' }}
		</td>
		<td colspan="2">Date of Interview</td>
		<td colspan="8">{{ $applicant->created_at->format('d-M-y') }}</td>
	</tr>

	<tr>
		<td colspan="2">Name</td>
		<td colspan="3">
			{{ $applicant->user->lname . ', ' . $applicant->user->fname . ' ' . $applicant->user->suffix . ' ' . $applicant->user->mname[0] }}
		</td>
		<td colspan="2">Seaman book No.</td>
		@php
			$docu = "SEAMAN'S BOOK";
			$docu = isset($applicant->document_id->$docu) ? $applicant->document_id->$docu : false;
		@endphp
		<td colspan="8">
			{{ $docu ? $docu->number : '-----' }}
		</td>
	</tr>

	<tr>
		<td colspan="2">Date of Birth</td>
		<td colspan="3">
			{{ $applicant->user->birthday->format('F j, Y') }}
		</td>
		<td colspan="2">License Class (Officer Only)</td>
		<td colspan="8">
			@if($applicant->rank->id >= 1 && $applicant->rank->id <= 8)
				@php
					$docu = "COC";
					$docu = isset($applicant->document_lc->$docu) ? $applicant->document_lc->$docu : false;
				@endphp
				{{ $docu ? $docu->no : '-----' }}
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="2">Address</td>
		<td colspan="5">
			{{ $applicant->provincial_address ?? $applicant->user->address}}
		</td>
		<td colspan="4">M.P.</td>
		<td colspan="4">
			{{ $applicant->user->contact }}
		</td>
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
		<td colspan="7">Total Score</td>
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
		<td colspan="3">
			{{ $applicant->religion }}
		</td>
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