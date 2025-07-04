@php
	$rank = $data->pro_app->rank ?? $data->sea_service->sortBy('sign_off')->last()->rank2;
@endphp

<table>
	<tr>
		<td colspan="17">
			{{ $data->pro_app->rank->abbr }} {{ $data->user->fullname }} Matrix
		</td>
	</tr>

	<tr><td colspan="17"></td></tr>

	<tr>
		<td>No.</td>
		<td>VSL</td>
		<td>Embarkation / Disembarkation</td>
		<td>Period</td>
		<td>Operator</td>
		<td>Rank</td>
		<td>Type</td>
		<td>Day</td>
		<td></td>
		<td>O</td>
		<td>L</td>
		<td>C</td>
		<td colspan="5"></td>
	</tr>

	@php
		$i = 1;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td></td>

		<td>{{ $rank->abbr }}</td>
		<td>{{ $data->user->lname }}</td>
		<td>Filipino</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>

		<td></td>

		<td>-</td>
		<td>-</td>
		<td>-</td>
		<td>
			{{-- LATEST COC REGULATION --}}
			@php
				$filtered = $data->document_lc->filter(function ($value, $key) {
					return str_contains($value->type, "COC");
				});

				$coc = $filtered->sortBy('issue_date')->last()->regulation;
				$coc = json_decode($coc);

				echo $coc[0];
			@endphp
		</td>	
		<td></td>	
		<td></td>	
		<td></td>
	</tr>

	@php
		$i = 2;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td></td>

		<td>Filipino</td>
		<td></td>
		<td>-</td>
		<td>-</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>

		<td></td>

		<td>(Flag)License</td>
		<td>{{ $data->document_flag->count() > 0 ? "Yes" : "" }}</td>
		<td></td>
		<td></td>	
		<td></td>	
		<td></td>	
		<td></td>
	</tr>

	@php
		$i = 3;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td></td>

		<td>(Flag)Dangerous Goods</td>
		<td>-</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>

		<td></td>

		<td></td>
		<td></td>
		<td></td>
		<td></td>	
		<td></td>	
		<td></td>	
		<td></td>
	</tr>

	@php
		$i = 4;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td></td>

		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>

		<td></td>

		<td></td>
		<td></td>
		<td></td>
		<td></td>	
		<td></td>	
		<td></td>	
		<td></td>
	</tr>

	@php
		$i = 5;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td rowspan="2"></td>

		<td rowspan="2">Years with operator</td>
		<td rowspan="2">Years in rank</td>
		<td rowspan="2">Years on this types of tanker</td>
		<td rowspan="2">Years on all types of tanker</td>
		<td rowspan="2"></td>
		<td rowspan="2">Years on OIL</td>
		<td rowspan="2">Years on GAS</td>
		<td rowspan="2">Years on CHE</td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>
	</tr>

	@php
		$i = 6;
		$sr = 4 + (($i-1) * 2); // start row
		$ss = $data->sea_service[$i-1] ?? null;
	@endphp
	<tr>
		<td rowspan="2">{{ $i }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_name : "" }}</td>
		<td>{{ $ss ? (isset($ss->sign_on) ? $ss->sign_on->format("m/d/Y") : "") : "" }}</td>
		<td rowspan="2">=DATEDIF(C{{ $sr }},C{{ $sr+1 }},"Y")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"YM")&#38;"-"&#38;DATEDIF(C{{ $sr }},C{{ $sr+1 }},"MD")+1</td>
		<td rowspan="2"></td>
		<td rowspan="2">{{ $ss ? $ss->rank2->abbr : "" }}</td>
		<td rowspan="2">{{ $ss ? $ss->vessel_type : "" }}</td>
		<td rowspan="2">=IF(OR(C{{ $sr }}="",C{{ $sr+1 }}=""),0,DATEDIF(C{{ $sr }},C{{ $sr+1 }},"d")+1)</td>
		
		<td rowspan="2"></td>

		<td rowspan="2">Years with operator</td>
		<td rowspan="2">Years in rank</td>
		<td rowspan="2">Years on this types of tanker</td>
		<td rowspan="2">Years on all types of tanker</td>
		<td rowspan="2"></td>
		<td rowspan="2">Years on OIL</td>
		<td rowspan="2">Years on GAS</td>
		<td rowspan="2">Years on CHE</td>
	</tr>

	<tr>
		<td>{{ $ss ? (isset($ss->sign_off) ? $ss->sign_off->format("m/d/Y") : "") : "" }}</td>
	</tr>
</table>