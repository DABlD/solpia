@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$bc = $bold . ' ' . $center;

	$box = "border: 1px solid black;";
@endphp

<table>
	<tr>
		<td colspan="15" style="height: 45px;"></td>
	</tr>

	<tr>
		<td colspan="15" style="{{ $bc }} height: 20px; font-size: 15px;">
			REQUEST TO PROCESS
		</td>
	</tr>

	<tr><td colspan="15" style="height: 10px;"></td></tr>

	<tr>
		<td></td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(0, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">USA VISA REFUND</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(2, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">FLAG</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(3, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="5" style="{{ $bold }}">
			VESSEL / PRINCIPAL ENROLLMENT / AMENDMENT
		</td>
	</tr>

	<tr><td colspan="15" style="height: 3px;"></td></tr>

	<tr>
		<td></td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(1, $data->docus) ? 'a' : '' }}
		</td>

		@if($data->visa)
			<td colspan="1" style="{{ $bold }}">OTHER VISA</td>
			<td colspan="2" style="{{ $bold }}">{{ $data->visa }}</td>
		@else
			<td colspan="3" style="{{ $bold }}">OTHER VISA {{ $data->visa ?? "___________" }}</td>
		@endif

		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(4, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">IHT CERT</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(5, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="5" style="{{ $bold }}">
			CONTRACT
		</td>
	</tr>

	<tr>
		<td colspan="13"></td>
		<td style="{{ $bold }} text-align: right;">No.:</td>
		<td style="{{ $center }}">_____________</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $bold }}">
			DEPARTMENT: {{ $data->department }}
		</td>
		<td style="{{ $bold }} text-align: right;">Date:</td>
		<td style="{{ $center }}">{{ now()->toFormattedDateString() }}</td>
	</tr>

	<tr>
		<td colspan="15" style="height: 7px;"></td>
	</tr>

	<tr>
		<td colspan="15" style="height: 3px;"></td>
	</tr>

	@if(in_array(2, $data->docus))
		<tr>
			<td colspan="3" style="{{ $bc }}">SEAFARER NAME</td>
			<td colspan="3" style="{{ $bc }}">RANK</td>
			<td colspan="2" style="{{ $bc }}">FLAG</td>
			<td colspan="4" style="{{ $bc }}">{{ $crews[0]->user->fleet != "FLEET B" ? "VESSEL" : $crews[0]->vessel }}</td>
			<td colspan="2" style="{{ $bc }}">JOINING PORT</td>
			<td style="{{ $bc }}">DEPARTURE</td>
		</tr>
	@else
		<tr>
			<td colspan="4" style="{{ $bc }}">SEAFARER NAME</td>
			<td colspan="4" style="{{ $bc }}">RANK / POSITION</td>
			<td colspan="4" style="{{ $bc }}">{{ $crews[0]->user->fleet != "FLEET B" ? "VESSEL" : $crews[0]->vessel }}</td>
			<td colspan="2" style="{{ $bc }}">PORT / COUNTRY</td>
			<td style="{{ $bc }}">DEPARTURE</td>
		</tr>
	@endif

	@foreach($crews as $crew)
		@php
			$name = $crew->user->lname . ', ' . $crew->user->fname . ' ' . ($crew->user->suffix == "" ? '' : $crew->user->suffix . ' ') . $crew->user->mname;
			$name = $crew->user->lname == '' ? '' : $name;
		@endphp

		@if(in_array(2, $data->docus))
			<tr>
				<td colspan="3" style="{{ $center }} height: 13px;">{{ $name }}</td>
				<td colspan="3" style="{{ $center }} height: 13px;">{{ $crew->rank }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">{{ $crew->rank ? $data->flag : "" }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crews[0]->user->fleet == "FLEET B" ? "" : $crew->vessel }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">
					@if(isset($crew->port))
						{{ $crew->port }}
					@else
						@if($crew->rank)
							{{ $data->port }}
						@endif
					@endif
				</td>
				<td style="{{ $center }} height: 13px;">
					@if($crew->rank != "")
						@if($data->departure == "Onboard")
							{{ $data->departure }}
						@else
							{{ now()->parse($data->departure)->toFormattedDateString() }}
						@endif
					@endif
				</td>
			</tr>
		@else
			<tr>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $name }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crew->rank }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crews[0]->user->fleet == "FLEET B" ? "" : $crew->vessel }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">
					@if(isset($crew->port))
						{{ $crew->port }}
					@else
						@if($crew->rank)
							{{ $data->port }}
						@endif
					@endif
				</td>
				<td style="{{ $center }} height: 13px;">
					@if($crew->rank != "")
						@if($data->departure == "Onboard")
							{{ $data->departure }}
						@else
							{{ now()->parse($data->departure)->toFormattedDateString() }}
						@endif
					@endif
				</td>
			</tr>
		@endif
	@endforeach

	<tr>
		<td colspan="15" style="height: 3px;"></td>
	</tr>

	{{-- 2ND PART --}}

	<tr>
		<td colspan="3" style="{{ $bold }} height: 45px;">Requested by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Approved by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Noted by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Received by:</td>
	</tr>

	<tr>
		<td colspan="15">SMOP-RTP-09</td>
	</tr>

	{{-- 1ST END --}}
	<tr><td colspan="15" style="height: 20px;"></td></tr>
	{{-- 1ST START --}}

	<tr>
		<td colspan="15" style="height: 45px;"></td>
	</tr>

	<tr>
		<td colspan="15" style="{{ $bc }} height: 20px; font-size: 15px;">
			REQUEST TO PROCESS
		</td>
	</tr>

	<tr><td colspan="15" style="height: 10px;"></td></tr>

	<tr>
		<td></td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(0, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">USA VISA REFUND</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(2, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">FLAG</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(3, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="5" style="{{ $bold }}">
			VESSEL / PRINCIPAL ENROLLMENT / AMENDMENT
		</td>
	</tr>

	<tr><td colspan="15" style="height: 3px;"></td></tr>

	<tr>
		<td></td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(1, $data->docus) ? 'a' : '' }}
		</td>

		@if($data->visa)
			<td colspan="1" style="{{ $bold }}">OTHER VISA</td>
			<td colspan="2" style="{{ $bold }}">{{ $data->visa }}</td>
		@else
			<td colspan="3" style="{{ $bold }}">OTHER VISA {{ $data->visa ?? "___________" }}</td>
		@endif
		
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(4, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="3" style="{{ $bold }}">IHT CERT</td>
		<td style="{{ $box }} {{ $bc }}">
			{{ in_array(5, $data->docus) ? 'a' : '' }}
		</td>
		<td colspan="5" style="{{ $bold }}">
			CONTRACT
		</td>
	</tr>

	<tr>
		<td colspan="13"></td>
		<td style="{{ $bold }} text-align: right;">No.:</td>
		<td style="{{ $center }}">_____________</td>
	</tr>

	<tr>
		<td colspan="13" style="{{ $bold }}">
			DEPARTMENT: {{ $data->department }}
		</td>
		<td style="{{ $bold }} text-align: right;">Date:</td>
		<td style="{{ $center }}">{{ now()->toFormattedDateString() }}</td>
	</tr>

	<tr>
		<td colspan="15" style="height: 7px;"></td>
	</tr>

	<tr>
		<td colspan="15" style="height: 3px;"></td>
	</tr>

	@if(in_array(2, $data->docus))
		<tr>
			<td colspan="3" style="{{ $bc }}">SEAFARER NAME</td>
			<td colspan="3" style="{{ $bc }}">RANK</td>
			<td colspan="2" style="{{ $bc }}">FLAG</td>
			<td colspan="4" style="{{ $bc }}">{{ $crews[0]->user->fleet != "FLEET B" ? "VESSEL" : $crews[0]->vessel }}</td>
			<td colspan="2" style="{{ $bc }}">JOINING PORT</td>
			<td style="{{ $bc }}">DEPARTURE</td>
		</tr>
	@else
		<tr>
			<td colspan="4" style="{{ $bc }}">SEAFARER NAME</td>
			<td colspan="4" style="{{ $bc }}">RANK / POSITION</td>
			<td colspan="4" style="{{ $bc }}">{{ $crews[0]->user->fleet != "FLEET B" ? "VESSEL" : $crews[0]->vessel }}</td>
			<td colspan="2" style="{{ $bc }}">PORT / COUNTRY</td>
			<td style="{{ $bc }}">DEPARTURE</td>
		</tr>
	@endif

	@foreach($crews as $crew)
		@php
			$name = $crew->user->lname . ', ' . $crew->user->fname . ' ' . ($crew->user->suffix == "" ? '' : $crew->user->suffix . ' ') . $crew->user->mname;
			$name = $crew->user->lname == '' ? '' : $name;
		@endphp

		@if(in_array(2, $data->docus))
			<tr>
				<td colspan="3" style="{{ $center }} height: 13px;">{{ $name }}</td>
				<td colspan="3" style="{{ $center }} height: 13px;">{{ $crew->rank }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">{{ $crew->rank ? $data->flag : "" }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crews[0]->user->fleet == "FLEET B" ? "" : $crew->vessel }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">
					@if(isset($crew->port))
						{{ $crew->port }}
					@else
						@if($crew->rank)
							{{ $data->port }}
						@endif
					@endif
				</td>
				<td style="{{ $center }} height: 13px;">
					@if($crew->rank != "")
						@if($data->departure == "Onboard")
							{{ $data->departure }}
						@else
							{{ now()->parse($data->departure)->toFormattedDateString() }}
						@endif
					@endif
				</td>
			</tr>
		@else
			<tr>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $name }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crew->rank }}</td>
				<td colspan="4" style="{{ $center }} height: 13px;">{{ $crews[0]->user->fleet == "FLEET B" ? "" : $crew->vessel }}</td>
				<td colspan="2" style="{{ $center }} height: 13px;">
					@if(isset($crew->port))
						{{ $crew->port }}
					@else
						@if($crew->rank)
							{{ $data->port }}
						@endif
					@endif
				</td>
				<td style="{{ $center }} height: 13px;">
					@if($crew->rank != "")
						@if($data->departure == "Onboard")
							{{ $data->departure }}
						@else
							{{ now()->parse($data->departure)->toFormattedDateString() }}
						@endif
					@endif
				</td>
			</tr>
		@endif
	@endforeach

	<tr>
		<td colspan="15" style="height: 3px;"></td>
	</tr>

	<tr>
		<td colspan="3" style="{{ $bold }} height: 45px;">Requested by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Approved by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Noted by:</td>
		<td colspan="4" style="{{ $bold }} height: 45px;">Received by:</td>
	</tr>

	<tr>
		<td colspan="15">SMOP-RTP-09</td>
	</tr>
</table>