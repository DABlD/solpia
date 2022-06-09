@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$criterias = 0;
	$sections = 0;

	$criteria = function($text, $height = 13) use($center, $bold, &$criterias){
		$height = "height: $height" . 'px';
		$text = str_replace("&", "&#38;", $text);
		$criterias++;

		echo "
			<tr>
				<td colspan='5' style='$height'>
					$text
				</td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
				<td style='$center $bold $height'></td>
			</tr>
		";
	};

	$section = function($text) use($center, $bold, &$sections){
		// $text = str_replace("&", "&#38;", $text);
		$sections++;

		echo "
			<tr>
				<td colspan='9' style='$bold'> ‎‏‏‎ ‎‏‏‎$text</td>
			</tr>
		";
	};

	$remarks = function($text) use($center){
		$text = str_replace("&", "&#38;", $text);

		echo "
			<tr>
				<td colspan='3' style='font-size: 10px;'>$text</td>
				<td colspan='6' style='$center font-size: 10px;'></td>
			</tr>
		";
	};
@endphp

<tr>
	<td></td>
	<td colspan="6" style="{{ $bold }} {{ $center }} font-size: 30px; height: 30px;">
		INTERVIEW SHEET FOR ELECT
	</td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td style="height: 14px;">SERIAL NO.</td>
	<td colspan="2" style="{{ $center }}"></td>
	<td></td>
	<td colspan="5" rowspan="4">
		LEGEND E - EXCELLENT (5) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		G - GOOD (4) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		F - FAIR (3) ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎ ‎‏‏‎
		P - POOR (2)
	</td>
</tr>

<tr>
	<td>NAME:</td>
	<td colspan="2" style="{{ $center }}">
		{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
	</td>
</tr>

<tr>
	<td>RANK:</td>
	<td colspan="2" style="{{ $center }}">
		{{ $data->rank ? $data->rank->abbr : '---' }}
	</td>
</tr>

<tr>
	<td>DATE:</td>
	<td colspan="2" style="{{ $center }}">
		{{ now()->format('d-F-Y') }}
	</td>
</tr>

<tr>
	<td colspan="3"></td>
	<td></td>
	<td colspan="5"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td colspan="5" rowspan="2" style="{{ $center }} {{ $bold }}">QUESTIONNAIRE</td>
	<td colspan="4" style="{{ $center }}">GRADE</td>
</tr>

<tr>
	<td style="{{ $center }}">E</td>
	<td style="{{ $center }}">G</td>
	<td style="{{ $center }}">F</td>
	<td style="{{ $center }}">P</td>
</tr>

{{ $section('MARINE ENGINEERING') }}

{{ $criteria('1. Knowledge on the general points to check for watch engineer during navigation and port watch', 25) }}
{{ $criteria('2. Testing of electronic control equipment') }}
{{ $criteria('3. Carry out planned maintenance system and spare parts monitoring') }}
{{ $criteria('4. Operation of pumps  : pumping systems and other associated  control systems') }}
{{ $criteria('5. Using appropriate tools for fabrication and repair') }}
{{ $criteria('6. Boiler ACC (Automatic Combustion Control system)') }}
{{ $criteria('7. Operation, testing and maintenance of pneumatic control system') }}
{{ $criteria('8. Theoretical knowledge of provision refrigerator') }}
{{ $criteria('9. Reading manual/ instruction of machinery') }}
{{ $criteria('10. Operation and maintenance of cargo handling equipment and deck Machinery') }}
{{ $criteria('11. Converting unit of weight, volume, pressure, temperature') }}
{{ $criteria('12. Maintenance of electrical and Electronic control equipment') }}
{{ $criteria('13. Monitoring alarms') }}
{{ $criteria('14. Meaning of critical RPM') }}
{{ $criteria('15. Practical knowledge on safe working practice') }}
{{ $criteria('16. Operation of alternators, generators and control systems	') }}
{{ $criteria('17. Knowledge on the general check items about refrigeration & air conditioner running preparation and trail running', 25) }}
{{ $criteria('18. Reading electric circuit and diagram') }}

{{ $section('CONTROLLING AND CARE FOR PERSON ON BOARD') }}

{{ $criteria('19. Knowledge to carry out the safety work procedure for engine room black out', 25) }}
{{ $criteria('20. Application of medical first aid ; operation of  life saving and fire fighting equipments') }}
{{ $criteria('21. Theoritical knowledge of Provision crane / derrick crane') }}
{{ $criteria('22. General condition of electrical equipment including conduits & wiring') }}

<tr>
	<td colspan="5" style="{{ $bold }} text-align: right; font-size: 10px;">SUBTOTAL</td>
	<td style="{{ $center }}">=COUNTA(F16:F{{ $criterias + $sections + 10 }}) * 5</td>
	<td style="{{ $center }}">=COUNTA(G16:G{{ $criterias + $sections + 10 }}) * 4</td>
	<td style="{{ $center }}">=COUNTA(H16:H{{ $criterias + $sections + 10 }}) * 3</td>
	<td style="{{ $center }}">=COUNTA(I16:I{{ $criterias + $sections + 10 }}) * 2</td>
</tr>

<tr>
	<td colspan="4" style="height: 25px;"></td>
	<td style="{{ $bold }} height: 25px; font-size: 10px;">TOTAL</td>
	<td colspan="3" style="{{ $bold }} {{ $center }} height: 25px; text-decoration: underline;">
		=CONCATENATE(SUM(F{{ $criterias + $sections + 11 }}:I{{ $criterias + $sections + 11 }}), " / 110")
	</td>
</tr>

<tr>
	<td colspan="3" style="{{ $bold }} {{ $center }} font-size: 11px;">PERSONAL LEVEL</td>
	<td colspan="6" style="{{ $bold }} {{ $center }} font-size: 11px;">REMARKS</td>
</tr>

{{ $remarks('Family Background') }}
{{ $remarks('Ambition / Goals') }}
{{ $remarks('Hobbies and interests') }}
{{ $remarks('Personal belief / values') }}
{{ $remarks('Disposition on Alcohol') }}
{{ $remarks('Good Experience onboard') }}
{{ $remarks('Bad Experience onboard') }}
{{ $remarks('Illness / Injury') }}
{{ $remarks('Motive of application') }}

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td></td>
	<td>Remarks</td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="2"></td>
	<td colspan="5" style="{{ $center }}"></td>
	<td colspan="2"></td>
</tr>

<tr>
	<td colspan="9"></td>
</tr>

<tr>
	<td colspan="4"></td>
	<td colspan="5">EVALUATOR:</td>
</tr>

<tr>
	<td colspan="4"></td>
	<td colspan="4" style="{{ $center }} {{ $bold }}"></td>
	<td></td>
</tr>