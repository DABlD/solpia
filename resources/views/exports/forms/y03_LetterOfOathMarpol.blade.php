<table>
	<tr>
		<td colspan="19" style="height: 40px;">
			<img src="{{ public_path('images/letter_head.jpg') }}" width="700px" height="80px">
		</td>
	</tr>
	<tr><td colspan="19" style="text-align: center; height: 80px; vertical-align: middle; font-weight: bold;">LETTER OF OATH</td></tr>
	
	<tr>
		<td colspan="4">Name of Seafarer:</td>
		<td colspan="9" style="border-bottom: 1px solid #000;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="7"></td>
	</tr>

	<tr>
		<td colspan="4">Seaman's Book No.:</td>
		<td colspan="9" style="border-bottom: 1px solid #000;">
			@php
				$number = "";
				foreach($data->document_id as $id){
					if($id->type == "SEAMAN'S BOOK"){
						$number = $id->number;
					}
				}

				echo $number;
			@endphp
		</td>
		<td colspan="7"></td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td colspan="19">
		   I, as 
		   <span style="text-decoration: underline;">{{ $data->rank }}</span> 
		   of 
		   <span style="text-decoration: underline;">{{ $data->vessel }}</span>
		   , hereby declare that I shall comply with MARPOL 73/78 regulation during my sea service period under all circumstances.
		</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td></td>
		<td colspan="19">
			1. Annex I - Regulations for the Prevention of Pollution by Oil
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="19">
			2. Annex II - Regulations for the Control of Pollution by Noxious Liquid Substances in Bulk
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="19">
			3. Annex III - Regulations for the Preventions of Harmful Substances Carried by Sea in
		</td>
	</tr>

	<tr>
		<td colspan="1"></td>
		<td colspan="19">
			<span style="color: #FFF;">--</span>
			Packaged Form
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="19">
			4. Annex IV - Regulations for the Preventions of Pollution by Sewage from Ships
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="19">
			5. Annex V - Regulations for the Preventions of Pollution by Garbage from Ships
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="19">
			5. Annex VI - Regulations for the Preventions of Air Pollution from Ships
		</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td colspan="19">
			I pledge to engage in occupational activities during my sea service period under all circumstances
		</td>
	</tr>

	<tr><td></td></tr>

	<tr>
		<td colspan="19">
			I pledge that I understand I will be subject to the concerned MARPOL 73/78 regulation, if I violate the regulations above
		</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td colspan="19" style="text-align: center;">
			<span style="text-decoration: underline;">{{ now()->format('Y') }}</span> (Y) /
			<span style="text-decoration: underline;">{{ now()->format('M') }}</span> (M) /
			<span style="text-decoration: underline;">{{ now()->format('d') }}</span> (D) /
		</td>
	</tr>

	<tr><td style="height: 60px;"></td></tr>

	<tr>
		<td colspan="19" style="text-decoration: underline;">
			Name of person in Oath (Name / Signature): 
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
	</tr>

	<tr><td style="height: 60px;"></td></tr>

	<tr>
		<td colspan="19" style="text-decoration: underline;">
			To Toei Japan Ltd / Nitta Kisen Kaisha LTD
		</td>
	</tr>
</table>