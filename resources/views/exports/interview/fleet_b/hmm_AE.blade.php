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
		INTERVIEW SHEET FOR APPRENTICE ENGINEER
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

{{ $criteria('1. Carrying out a watch routine appropriate to the duties of a rating forming part of an engine room watch', 25) }}
{{ $criteria('2. Understanding of orders and be understood in matters relevant to watchkeeping duties', 25) }}
{{ $criteria('3. Emergency equipment operations and applications of emergency procedures', 25) }}
{{ $criteria('4. Knowledge for prevention of oil pollution') }}
{{ $criteria('5. Knowledge for E/R pipe line system (Bilge, General Service S.W)') }}
{{ $criteria('6. Disposal procedure of oily waste at sea & in port') }}
{{ $criteria('7. Knowledge of oil separator & meaning of ppm') }}
{{ $criteria('8.Procedure on the turn over of watch to duty reliever') }}
{{ $criteria('9. Cases that should be reported to duty engineer') }}
{{ $criteria('10. Monitoring various alarm in engine room & reporting to duty engineer', 25) }}
{{ $criteria('11. Welding skill') }}
{{ $criteria('12. Check point and preparation for the bunkering') }}
{{ $criteria('13. Knowledge of fire fighting equipment') }}
{{ $criteria('14. Knowledge of kind & function of valves') }}
{{ $criteria('15. Knowledge for prevention of fire ') }}
{{ $criteria('16. Familiarization with ISM') }}
{{ $criteria('17 Knowledge of the unit of pressure, temperature, weight, volume, length', 25) }}
{{ $criteria('18. Operation of life saving appliances & fire fighting equipment') }}
{{ $criteria('19. Start and stop of emergency generator') }}
{{ $criteria('20. Understanding POEA contract terms and conditions.') }}

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
		=CONCATENATE(SUM(F{{ $criterias + $sections + 11 }}:I{{ $criterias + $sections + 11 }}), " / 100")
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