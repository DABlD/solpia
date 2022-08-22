<table>
	<tr>
		<td colspan="3" style="color: #FFF;">-----</td>
		<td colspan="8" style="height: 40px;">
			<img src="{{ public_path('images/letter_head.jpg') }}" width="680px" height="80px">
		</td>
		<td colspan="3" style="color: #FFF;">-----</td>
	</tr>

	<tr>
		<td colspan="14" style="text-align: center; height: 100px; vertical-align: middle; font-weight: bold; font-size: 25px;">LETTER OF OATH</td>
	</tr>
	
	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="2">Name of Seafarer:</td>
		<td colspan="4" style="border-bottom: 1px solid #000;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="2">Seaman's Book No.:</td>
		<td colspan="4" style="border-bottom: 1px solid #000;">
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
		<td colspan="4"></td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
		   I, as 
		   <span style="text-decoration: underline;">{{ $data->rank }}</span> 
		   of 
		   <span style="text-decoration: underline;">{{ $data->vessel }}</span>
		   , hereby declare that I shall comply with the Company Drug and Alcohol Policy and Social Medica Guidance during my sea service period under all circumstances.
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6" style="color: #FF0000;">
			"Drug and Alcohol Policy"
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			"I pledge that I understand possessing, carrying and consuming cannabis are prohibited anywhere on board, whether or not a vessel is moving"
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			"I pledge that I shall be subject to the laws, any related regulations, and local rules of the Vessel's flag, and of the places where she trades that prohibit possessing, carrying and consuming cannabis."
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			In the event of a violation of these or any other company policies, Toei Japan Ltd/Nitta Kisen Kaisha Ltd reserve the right to take appropriate actions against the violator including but not limited to termination, legal actions to recover costs incurred by the vessel's interests, etc.
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 100px;"></td></tr>
	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td style="text-align: right;" colspan="6">Nitta Kisen Kaisha Ltd.</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 60px;"></td></tr>
	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6" style="color: #FF0000;">
			"Social Media Guidance"
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			"I pledge not to release / post photos or videos on my social media nor to give any information to third parties that are unnecessary during my sea service period and even after I disembark from the vessel, to put ME, THE CREW, THE VESSEL, or COMPANY in Harm's way and lose reputation."
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			I pledge to consider what information is being communicated when I post and how it could be received. Sensitive information posted on social media is a major vulnerability, because it enables greater and increased speed of critical information shared publicly.
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			In the event of a violation of these or any other company policies, Toei Japan Ltd/Nitta Kisen Kaisha Ltd reserve the right to take appropriate actions against the violator including but not limited to termination, legal actions to recover costs incurred bu the vessels' interests, etc.
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6" style="text-align: center;">
			20<span style="text-decoration: underline;">{{ now()->format('y') }}</span> (Y) /
			<span style="text-decoration: underline;">{{ now()->format('M') }}</span> (M) /
			<span style="text-decoration: underline;">{{ now()->format('d') }}</span> (D) /
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6" style="font-size: 15px;">
			Name of person in Oath ( Name / Signature : <span style="text-decoration: underline;">
				{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
			</span>)
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 50px;"></td></tr>

	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6">
			To Toei Japan Ltd / Nitta Kisen Kaisha Ltd.
		</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>

	<tr><td style="height: 100px;"></td></tr>
	<tr>
		<td colspan="4" style="color: #FFF; height: 40px;">-----</td>
		<td colspan="6" style="text-align: right;">Nitta Kisen Kaisha Ltd.</td>
		<td colspan="4" style="color: #FFF;">-----</td>
	</tr>
</table>