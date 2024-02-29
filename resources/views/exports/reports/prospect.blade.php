@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
@endphp

<table>
	<tr>
		<td colspan="15" style="{{ $bc }} height: 30px; font-size: 14px;">
			RECRUITMENT WEEKLY PRODUCTIVITY REPORT FOR {{ $from }} - {{ $to }}
		</td>
	</tr>

	<tr>
		<td rowspan="2" style="{{ $bc }} height: 40px;">RANK</td>
		<td rowspan="2" style="{{ $bc }} height: 40px;">NAME</td>
		<td rowspan="2" style="{{ $bc }} height: 40px;">VESSEL EXPERIENCE</td>
		<td rowspan="2" style="{{ $bc }} height: 40px;">ACTUAL APPLICANTS REPORTED</td>
		<td colspan="3" style="{{ $bc }} height: 40px;">TOTAL APPLICANTS</td>
		<td colspan="7" style="{{ $bc }} height: 40px;">STATUS</td>
		<td rowspan="2" style="{{ $bc }} height: 40px;">REMARKS</td>
	</tr>

	<tr>
		<td style="{{ $bc }} height: 40px;">WALK IN</td>
		<td style="{{ $bc }} height: 40px;">ONLINE</td>
		<td style="{{ $bc }} height: 40px;">KALAW/SOURCES</td>
		<td style="{{ $bc }} height: 40px;">ON PROCESS/POOLING</td>
		<td style="{{ $bc }} height: 40px;">FOR INTERVIEW</td>
		<td style="{{ $bc }} height: 40px;">PASSED</td>
		<td style="{{ $bc }} height: 40px;">ENDOSED TO CREWING</td>
		<td style="{{ $bc }} height: 40px;">FAILED</td>
		<td style="{{ $bc }} height: 40px;">BACK OUT</td>
		<td style="{{ $bc }} height: 40px;">FOR FOLLOW-UP</td>
	</tr>

	<tr>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}"></td>

		<td style="{{ $bc }}"></td>
		<td style="{{ $bc }}">=COUNTIF(E5:E{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(F5:F{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(G5:G{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(H5:H{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(I5:I{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(J5:J{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(K5:K{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(L5:L{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(M5:M{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}">=COUNTIF(N5:N{{ sizeof($data) + 5 }})</td>
		<td style="{{ $bc }}"></td>
	</tr>

	@foreach($data as $applicant)
		@php
			$op = 0;
			$fi = 0;
			$passed = 0;
			$etc = 0;
			$failed = 0;
			$backout = 0;
			$ffu = 0;

			if(str_starts_with($applicant['remarks'], 'BACKED')){
				$backout++;
			}

			if(str_starts_with($applicant['remarks'], 'FOLLOW')){
				$ffu++;
			}

			foreach($applicant['candidates'] as $candidate){
				$op++;

				if($candidate['initial_interview']){
					$fi++;
				}

				if($candidate['technical_interview']){
					$passed++;
				}

				if($candidate['endorsed_to_crewing']){
					$etc++;
				}

				if($candidate['status'] == "REJECTED"){
					$failed++;
				}

				if($candidate['status'] == "REJECTED"){
					$failed++;
				}
			}

			$exps = json_decode($applicant['exp']);
		@endphp

		<tr>
			<td style="{{ $c }}">{{ $applicant['rank'] }}</td>
			<td>{{ $applicant['name'] }}</td>
			<td style="{{ $c }}">
				@if($exps)
					@for($i = 0; $i < sizeof($exps); $i++)
						{{ $exps[$i] }}
						@if($i+1 != sizeof($exps))
							,
						@endif
					@endfor
				@else
					-
				@endif
			</td>
			<td style="{{ $c }}">1</td>

			<td style="{{ $c }}">{{ $applicant['source'] == "Walk-in" ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $applicant['source'] == "Online" ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $applicant['source'] == "Kalaw" || $applicant['source'] == "Source" ? "✔" : "" }}</td>

			<td style="{{ $c }}">{{ $op ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $fi ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $passed ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $etc ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $failed ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $backout ? "✔" : "" }}</td>
			<td style="{{ $c }}">{{ $ffu ? "✔" : "" }}</td>
			<td>{{ $applicant['remarks'] }}</td>
		</tr>
	@endforeach

	@for($i = 0; $i < 5; $i++)
		<tr>
			<td style="{{ $c }}"></td>
			<td></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
			<td style="{{ $c }}"></td>
		</tr>
	@endfor

	<tr>
		<td colspan="15" style="height: 40px;"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">FLEET</td>
		<td style="{{ $bc }}">
			NUMBER OF APPLICANTS STILL ON PROCESS &#38; FOLLOW-UP
		</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">FLEET</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">A</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">A</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">B</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">B</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">C</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">C</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">D</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">D</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">E</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">E</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">TOEI</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">TOEI</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">FISHING</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">FISHING</td>
		<td style="{{ $bc }}"></td>
	</tr>

	<tr>
		<td style="{{ $bc }}">TOTAL</td>
		<td style="{{ $bc }}"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td style="{{ $bc }}">TOTAL</td>
		<td style="{{ $bc }}"></td>
	</tr>
</table>