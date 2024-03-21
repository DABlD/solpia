@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = "$b $c";
	$blue = "color: #0000FF;";
@endphp

<table>
	<tr>
		<td colspan="8" style="{{ $bc }} color: #FF0000; text-decoration: underline; height: 60px;">CREW NOTICE OF DOCUMENT DEFICIENCY</td>
		<td></td>
		<td colspan="8" style="{{ $bc }} color: #FF0000; text-decoration: underline; height: 60px;">CREW NOTICE OF DOCUMENT DEFICIENCY</td>
	</tr>

	<tr>
		<td>DATE:</td>
		<td colspan="3">{{ now()->format('l, F j, Y') }}</td>
		<td colspan="4"></td>
		<td></td>
		<td>DATE:</td>
		<td colspan="3">{{ now()->format('l, F j, Y') }}</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="4">To: {{ $data->user->namefull }}</td>
		<td></td>
		<td colspan="3">From: {{ auth()->user()->fullname }}</td>
		<td></td>
		<td colspan="4">To: {{ $data->user->namefull }}</td>
		<td></td>
		<td colspan="3">From: {{ auth()->user()->fullname }}</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8" style="height: 55px;">
			THIS IS A NOTICE OF YOUR DOCUMENT DEFICIENCY FOR RENEWAL OR APPLICATION. PLEASE KEEP US UPDATED OF ITS PROGRESS.
		</td>
		<td></td>
		<td colspan="8" style="height: 55px;">
			THIS IS A NOTICE OF YOUR DOCUMENT DEFICIENCY FOR RENEWAL OR APPLICATION. PLEASE KEEP US UPDATED OF ITS PROGRESS.
		</td>
	</tr>

	<tr>
		<td colspan="8" style="{{ $b }} text-decoration: underline;">LIST OF DEFICIENT DOCUMENTS:</td>
		<td></td>
		<td colspan="8" style="{{ $b }} text-decoration: underline;">LIST OF DEFICIENT DOCUMENTS:</td>
	</tr>

	@for($i = 0; $i <= 12; $i++)
		<tr>
			<td colspan="8" style="{{ $blue }}">{{ isset($data->def[$i]) ? $data->def[$i] : "" }}</td>
			<td></td>
			<td colspan="8" style="{{ $blue }}">{{ isset($data->def[$i]) ? $data->def[$i] : "" }}</td>
		</tr>
	@endfor

	<tr>
		<td colspan="8">Thank you for your kind understanding.</td>
		<td></td>
		<td colspan="8">Thank you for your kind understanding.</td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8">Acknowledged and received by:</td>
		<td></td>
		<td colspan="8">Acknowledged and received by:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $blue }} {{ $c }} height: 20px;">
			{{ $data->rank }} {{ $data->user->namefull }}
		</td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $blue }} {{ $c }} height: 20px;">
			{{ $data->rank }} {{ $data->user->namefull }}
		</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">(signature over printed name)</td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $c }}">(signature over printed name)</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="8"></td>
		<td></td>
		<td colspan="8"></td>
	</tr>

	<tr>
		<td colspan="8">Documents checked by:</td>
		<td></td>
		<td colspan="8">Documents checked by:</td>
	</tr>

	<tr>
		<td colspan="8">By:</td>
		<td></td>
		<td colspan="8">By:</td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $c }}">{{ auth()->user()->fullname }}</td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $c }}">{{ auth()->user()->fullname }}</td>
		<td colspan="4"></td>
	</tr>

	<tr>
		<td colspan="4" style="{{ $bc }}">{{ auth()->user()->role }}</td>
		<td colspan="4"></td>
		<td></td>
		<td colspan="4" style="{{ $bc }}">{{ auth()->user()->role }}</td>
		<td colspan="4"></td>
	</tr>
</table>