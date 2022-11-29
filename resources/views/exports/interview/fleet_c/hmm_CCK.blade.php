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
		INTERVIEW SHEET FOR CHIEF COOK
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

{{ $criteria('1. Knowledge of basic cooking, western and eastern cooking') }}
{{ $criteria('2. Operational phases of food services') }}
{{ $criteria('3. Food storing and handling') }}
{{ $criteria('4. Victualling, victualling inventory') }}
{{ $criteria('5. Knowledge on food hygiene, kitchen hygiene') }}
{{ $criteria('6. Pest control, garbage handling and disposal') }}
{{ $criteria('7. Vessel housekeeping and sanitation') }}
{{ $criteria('8. Food and beverage service procedures') }}
{{ $criteria('9. Reception and services for officers') }}
{{ $criteria('10. Fire and accident prevention') }}
{{ $criteria('11. Table settings') }}
{{ $criteria('12. Menu planning') }}
{{ $criteria('13. Good housekeeping') }}
{{ $criteria('14. Food purchasing & budgeting') }}
{{ $criteria('15. Operation of washing machine') }}
{{ $criteria('16. Preserving fresh food') }}
{{ $criteria('17. Arrangement & keep clean the provision store') }}
{{ $criteria('18. Management of bond store') }}
{{ $criteria('19. Management of ship store & laundry') }}
{{ $criteria('20. Reception of previsions') }}

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