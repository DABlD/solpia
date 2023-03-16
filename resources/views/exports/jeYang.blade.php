@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b$c";

	$checkDate = function($date){
		return $date ? now()->parse($date)->format('Y.m.d') : '---';
	};
@endphp

<table>
	<tr>
		<td colspan="15"></td>
	</tr>

	<tr>
		<td colspan="15" style="{{ $bc }} font-size: 16px;">
			{{ $data->rank ? $data->rank->name : "-" }} {{ $data->user->namefull }}
		</td>
	</tr>

	<tr>
		<td style="{{ $bc }}">NO</td>
		<td style="{{ $bc }}">사진</td>
		<td style="{{ $bc }}">
			성명
			<br style='mso-data-placement:same-cell;' />
			Name of crew
			<br style='mso-data-placement:same-cell;' />
			생년월일 D.O.B
		</td>
		<td style="{{ $bc }}">
			직책
			<br style='mso-data-placement:same-cell;' />
			DUTY
			<br style='mso-data-placement:same-cell;' />
			(신체조건)
		</td>
		<td style="{{ $bc }}">
			Passport/Seamanbook No.
			<br style='mso-data-placement:same-cell;' />
			면허 License No.
		</td>
		<td style="{{ $bc }}">
			국적
			<br style='mso-data-placement:same-cell;' />
			월급여
			<br style='mso-data-placement:same-cell;' />
			대리점
		</td>
		<td style="{{ $bc }}">경력사항</td>
		<td style="{{ $bc }}">
			SHIP TYPE/FLAG
		</td>
		<td style="{{ $bc }}">
			FISHING GROUND
		</td>
		<td style="{{ $bc }}">
			"REMARK
			<br style='mso-data-placement:same-cell;' />
			(BT, COP….)"
		</td>
		<td style="{{ $bc }}">COVID 19 VACCINE</td>
		<td style="{{ $bc }}">YELLOW</td>
		<td style="{{ $bc }}">POLIO</td>
		<td style="{{ $bc }}">MMR</td>
		<td style="{{ $bc }}">MEDICAL</td>
	</tr>

	@php
		$pp = isset($data->document_id->PASSPORT) ? $data->document_id->PASSPORT : null;
		$sb = isset($data->document_id->{"SEAMAN'S BOOK"}) ? $data->document_id->{"SEAMAN'S BOOK"} : null;
	@endphp

	@if($data->sea_service && sizeof($data->sea_service) >= 2)
		@foreach($data->sea_service as $key => $ss)
			@if($key == 0)
				<tr>
					<td></td>
					<td rowspan="4"></td>
					<td>{{ $data->user->namefull }}</td>
					<td>{{ $data->rank ? $data->rank->abbr : "-" }}</td>
					<td>
						{{ $pp ? $pp->number : "" }} ({{ $checkDate($pp ? $pp->expiry_date : null) }})
						{{ $sb ? $sb->number : "" }} ({{ $checkDate($sb ? $sb->expiry_date : null) }})
					</td>
					<td style="{{ $c }}">KR</td>
					<td>{{ $ss->vessel_name }}({{ $checkDate($ss->sign_on) }}-{{ $checkDate($ss->sign_off) }})</td>
					<td></td>
					<td></td>
					<td style="{{ $c }}">
						@if(isset($data->document_lc->{"BASIC TRAINING - BT"}))
							@if($data->document_lc->{"BASIC TRAINING - BT"}->expiry_date >= now()->toDateString())
								VALID
							@else
								EXPIRED
							@endif
						@else
							N/A
						@endif
					</td>
					<td style="{{ $c }}">
						@foreach($data->document_med_cert as $key => $docu)
							@if(str_contains($docu->type, 'COVID'))
								{{ $docu->clinic }}
								@break
							@endif
						@endforeach
					</td>
					<td style="{{ $c }}">
						@if(isset($data->document_med_cert->{"YELLOW FEVER"}))
							@if($data->document_med_cert->{"YELLOW FEVER"}->issue_date)
								VALID
							@endif
						@else
							N/A
						@endif
					</td>
					<td style="{{ $c }}">
						@if(isset($data->document_med_cert->{"POLIO VACCINE (IPV)"}))
							@if($data->document_med_cert->{"POLIO VACCINE (IPV)"}->issue_date)
								VALID
							@endif
						@else
							N/A
						@endif
					</td>
					<td style="{{ $c }}">
						@foreach($data->document_med_cert as $key => $docu)
							@if(str_contains($docu->type, 'MMR') || str_contains($docu->type, 'MEASLES'))
								@if($docu->issue_date)
									VALID
								@endif
							@endif
						@endforeach
					</td>
					<td style="{{ $c }}">
						@if(isset($data->document_med_cert->{"MEDICAL CERTIFICATE"}))
							@if($data->document_med_cert->{"MEDICAL CERTIFICATE"}->expiry_date >= now()->toDateString())
								VALID
							@else
								EXPIRED
							@endif
						@else
							N/A
						@endif
					</td>
				</tr>
			@elseif($key == 1)
				@php
					$salary = $data->wage->total;
					$add = 70;

					if(in_array($data->rank ? $data->rank->abbr : "-", ["FMAN", "DHAND", "OLR"])){
						$add = 50;
					}
				@endphp
				<tr>
					<td></td>
					<td>{{ $data->user->birthday ? $data->user->birthday->format('Y.m.d') : "-" }}</td>
					<td>{{ $data->height }}/{{ $data->weight }}</td>
					<td></td>
					<td style="{{ $c }}">US${{ number_format($salary + $add) }}</td>
					<td>{{ $ss->vessel_name }}({{ $checkDate($ss->sign_on) }}-{{ $checkDate($ss->sign_off) }})</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@elseif($key == 2)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="{{ $c }}">US${{ number_format($salary) }}+{{ $add }}</td>
					<td>{{ $ss->vessel_name }}({{ $checkDate($ss->sign_on) }}-{{ $checkDate($ss->sign_off) }})</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@elseif($key == 3)
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $ss->vessel_name }}({{ $checkDate($ss->sign_on) }}-{{ $checkDate($ss->sign_off) }})</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@else
				@if($ss->vessel_name == null)
					@break
				@endif
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>{{ $ss->vessel_name }}({{ $checkDate($ss->sign_on) }}-{{ $checkDate($ss->sign_off) }})</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			@endif
		@endforeach
	@else

	@endif
</table>