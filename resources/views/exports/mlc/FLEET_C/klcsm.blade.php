@php
	$b = "font-weight: bold;";
	$c = "text-align: center;";
	$bc = $b . ' ' . $c;
	$und = 'text-decoration: underline;';
	$blue = 'color: #0000FF;';
	$red = 'color: #FF0000;';

	$fill = function($height = 15){
		echo "<tr><td colspan='12' style='height: $height;'></td></tr>";
	};

	$d1 = function($text, $bo = false) use($b){
		if($bo){
			echo "
				<tr>
					<td colspan='12' style='$b'>$text</td>
				</tr>
			";
		}
		else{
			echo "
				<tr>
					<td colspan='12'>$text</td>
				</tr>
			";
		}
	};

	$start = now()->parse($data->effective_date);
@endphp

<table>
	<tr>
		<td colspan="12" style="{{ $bc }}  font-size: 20px;">
			Contract of Employment for Seafarer
		</td>
	</tr>

	<tr>
		<td colspan="12" style="font-size: 8px;">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	{{-- SHIPOWNER START --}}

	<tr>
		<td rowspan="6" style="{{ $c }}">Shipowner</td>
		<td colspan="3">Name of the</td>
		<td colspan="6" rowspan="2" style="{{ $bc }}">KOREA LINE CORPORATION</td>
		<td rowspan="2">Phone number</td>
		<td style="{{ $bc }}" rowspan="2">82-2-3701-0114</td>
	</tr>

	<tr>
		<td colspan="3">company</td>
	</tr>

	<tr>
		<td colspan="3">Location of</td>
		<td colspan="8" rowspan="2" style="{{ $bc }}">
			@if($data->vessel->type == "LNG")
				30, Sinchonnyeok-ro, Seodaemun-gu, Seoul, Republic of Korea
			@else
				SM R&#38;D Center, 78, Magokjungang8-ro, Gangseo-gu, Seoul, Korea
			@endif
		</td>
	</tr>

	<tr>
		<td colspan="3">the company</td>
	</tr>

	<tr>
		<td colspan="3">Name of the</td>
		<td colspan="6" rowspan="2" style="{{ $bc }}">
			HAN SU HAN
			{{-- @if($data->vessel->type == "LNG")
				HAN SU HAN
			@else
				MIN TAE YUN
			@endif --}}
		</td>
		<td rowspan="2">Identification number</td>
		<td rowspan="2" style="{{ $bc }}">824-87-01648</td>
	</tr>

	<tr>
		<td colspan="3">employee</td>
	</tr>

	{{-- SHIPOWNER END --}}

	{{-- SEAFARER START --}}

	<tr>
		<td rowspan="6" style="{{ $c }}">Seafarer</td>
		<td colspan="3">Name of</td>
		<td colspan="6" rowspan="2" style="{{ $bc }} {{ $blue }}">{{ $data->user->namefull }}</td>
		<td>Date of birth</td>
		<td style="{{ $bc }} {{ $blue }}">{{ $data->user->birthday ? now()->parse($data->user->birthday)->format('d/M/Y') : "---" }}</td>
	</tr>

	<tr>
		<td colspan="3">seafarer</td>
		<td>Age</td>
		<td style="{{ $bc }} {{ $blue }}">{{ $data->user->birthday ? $data->user->birthday->age : "---" }}</td>
	</tr>

	<tr>
		<td colspan="3" rowspan="2">Sex</td>
		<td colspan="6" rowspan="2" style="{{ $bc }} {{ $blue }}">Male</td>
		<td rowspan="2">Birth place</td>
		<td rowspan="2" style="{{ $bc }} {{ $blue }}">{{ $data->birth_place }}</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="8">Address of seafarer</td>
		<td colspan="3" rowspan="2" style="{{ $bc }} {{ $blue }}">
			{{ $data->user->address ?? $data->provincial_address }}
		</td>
	</tr>

	<tr>
		<td colspan="8">(in home country)</td>
	</tr>

	{{-- SEAFARER END --}}

	{{ $fill() }}


	{{ $d1("1. Contract Period", true) }}
	<tr>
		<td colspan="3">1.1. from</td>
		<td style="{{ $bc }} {{ $blue }}">({{ $start->format('d/M/Y') }})</td>
		<td colspan="2" style="{{ $c }}">to</td>
		<td colspan="4" style="{{ $bc }} {{ $blue }}">({{ $start->add($data->employment_months, 'months')->format('d/M/Y') }})</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="3">1.2. the port of sailing</td>
		<td colspan="5" style="{{ $bc }} {{ $blue }}">({{ $data->port }})</td>
		<td colspan="2" style="{{ $c }}">to the port of destination</td>
		<td colspan="2">UNFIXED</td>
	</tr>

	{{ $fill() }}

	{{ $d1("2. Advance Notice of Rescission of the Seafarer's Employment Contract", true) }}
	<tr>
		<td colspan="10">If the shipowner or the seafarer wishes to make a rescission of the seafarer's employment contract, to the extent that</td>
		<td colspan="2" style="{{ $blue }}">the seafarer must make an advance notice</td>
	</tr>

	<tr>
		<td colspan="12">of rescission to the shipowner before 7 days and to the extent that the shipowner must make a written advance notice of rescission to the more than 30 days, prior to the rescission of the contract.</td>
	</tr>

	{{ $fill() }}

	{{ $d1("3. Vessel of Employment and Rank", true) }}
	<tr>
		<td colspan="9">3.1. Vessel of Employment</td>
		<td style="{{ $b }} {{ $blue }}">{{ $data->vessel->name }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>Official No.</td>
		<td colspan="3" style="{{ $blue }} {{ $b }}">{{ $data->vessel->imo }}</td>
		<td colspan="5">Flag.</td>
		<td style="{{ $blue }} {{ $b }}">{{ $data->vessel->flag }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>Gross Tonnage</td>
		<td colspan="3" style="{{ $blue }} {{ $b }}">{{ $data->vessel->gross_tonnage }}</td>
		<td colspan="5">Year built</td>
		<td style="{{ $blue }} {{ $b }}">{{ $data->vessel->year_build }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>3.2 Rank:</td>
		<td colspan="3" style="{{ $blue }} {{ $b }}">{{ $data->pro_app->rank->abbr }}</td>
		<td colspan="7"></td>
	</tr>

	{{ $fill() }}
	{{ $d1("4. Hours of Work and Overtime", true) }}
	{{ $d1("4.1. The hours of work on board shall be eight hours in a day and forty hours in a week.") }}
	{{ $d1("4.2. Overtime") }}
	{{ $d1("1) The hours of work may be extended for sixteen hours as a maximum in a week by the agreement of the persons concerned.") }}

	{{ $fill() }}
	<tr>
		<td colspan="4">2) Notwithstanding the provision of paragraph</td>
		<td style="{{ $red }} {{ $c }} {{ $und }}">4.1)</td>
		<td colspan="7">the shipowner may give an order of overtime work within sixteen hours in a week to the crew who is performing</td>
	</tr>

	<tr>
		<td colspan="12">the duty of navigational watch and within 4 hours in a week to other crew. </td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="12">
			3) When there is an unavoidable circumstance such as securing the safety of ship operation etc., the shipowner may give an order of overtime work to the crew even though it exceeds the hours of work prescribed in paragraphs 1) and 2)
		</td>
	</tr>

	{{ $fill() }}
	{{ $d1("4.3. Overtime Allowance:") }}
	{{ $fill() }}
	{{ $d1("The shipowner shall pay an fixed overtime allowance equivalent to the amount to seafarer for the work as provision of paragraph 4.2.") }}
	{{ $fill() }}
	{{ $d1("5. Hours of Rest and Holiday", true) }}
	{{ $fill() }}
	{{ $d1("5.1. The shipowner shall give the crew ten hours of rest or more in any 24 hour period and seventy seven hours of rest or more in any seven-day period.") }}
	{{ $fill() }}
	{{ $d1("5.2. Hours of rest may be divided into no more than two periods, one of which shall be at least six hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.") }}
	{{ $fill() }}
	{{ $d1("5.3. Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day.") }}
	{{ $fill() }}
	{{ $d1("6. Payment", true) }}
	{{ $d1("6.1. Consolidated pay and benefits") }}

	@php
		$wage = $data->wage;
		$basic = ceil($wage->basic);
		// if(!in_array($data->id, [1243, 1422, 1657, 1703, 1730, 1773, 2013, 2672, 2767])){
		// 	dd($data->id, $basic, $wage);
		// }
		$ot = ceil($basic / 173 * 103 * 1.25);
		$lp = ceil($basic * 9 / 30);

		// allowances
		$sa = ceil($wage->sup_allow ?? 0);
		$so = ceil($wage->sub_allow ?? 0);
		$oa = ceil($wage->owner_allow ?? 0);
		$oa2 = ceil($wage->other_allow ?? 0);
		$ra = ceil($wage->retire_allow ?? 0);

		$ccb = number_format(str_contains($data->vessel->type, "BUL") ? 80 : 0, 2);

		$total = number_format($basic + $ot + $lp + $sa + $so + $oa + $ra + $oa2 + $ccb, 2);
		$so = number_format($so, 2);
	@endphp

	<tr>
		<td colspan="12">1) Consolidated pay</td>
	</tr>

	<tr>
		<td colspan="4">&#9312; Monthly total wages:</td>
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">{{ $total }}</td>
		<td colspan="3" style="{{ $blue }}">Before deduction FKSU Membership Fee</td>
	</tr>

	<tr>
		<td colspan="4">&#9313; Basic Wage:</td>
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">{{ number_format($basic, 2) }}</td>
		<td colspan="3" style="{{ $blue }}"></td>
	</tr>

	<tr>
		<td colspan="12">2) Fixed Overtime Allowances, Other Allowances, deduction and calculation method</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $und }}">&#9312; O/T:</td>
		<td colspan="2"></td>
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">{{ number_format($ot, 2) }}</td>
		<td colspan="3">Calculation method: Basic / 173hrs x 1.25 x 103hrs</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $und }}">&#9313; Other allowances</td>
		<td colspan="2" style="{{ $red }} {{ $und }}">(Owner's Allowance):</td>
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">{{ number_format($sa + $so + $oa + $ra + $oa2, 2) }}</td>
		<td colspan="3">Calculation method: OWNER'S DISCRETION</td>
	</tr>

	<tr>
		<td colspan="2" style="{{ $und }}">&#9314; Leave pay:</td>
		<td colspan="2"></td>
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">{{ number_format($lp, 2) }}</td>
		<td colspan="3">Calculation method: Basic wage x 9days / 30days</td>
	</tr>

	<tr>
		<td colspan="4">&#9315; FKSU Membership Fee:</td>
		{{-- <td colspan="1"></td> --}}
		<td style="{{ $bc }}">US$</td>
		<td colspan="1"></td>
		<td colspan="3" style="{{ $bc }}">40.00</td>
		<td colspan="3">As IBF FKSU CA (BBCHP) Article 33</td>
	</tr>

	<tr>
		<td colspan="3">&#9316; GOVT. Tax deduction: </td>
		<td colspan="9" style="{{ $b }}">AS REGULATIONS</td>
	</tr>

	{{ $d1("3) Health and social security protection benefits - Shipowner provides medical care, sickness benefit, employment injury benefit, ") }}
	{{ $d1("invalidity benefit, family benefit and survivors’ benefit to the seafarer.") }}

	{{ $d1("6.2. Payment date:") }}
	<tr>
		<td colspan="2" style="{{ $blue }}">Every 15th next month.</td>
		<td colspan="10">If the payment date falls on a holiday, payment will be made on the day before the holiday.</td>
	</tr>
	{{ $d1("6.3. Payment methods: Payment will be paid to seafarer or credited to the bank account of seafarer.") }}

	{{ $fill() }}
	{{ $d1("7. Paid Leave", true) }}
	<tr>
		<td colspan="8">7.1. The shipowner shall provide paid leave to the seafarer who has completed (</td>
		<td style="{{ $blue }} {{ $c }}">9</td>
		<td colspan="3">) months of continuous service on board(services on the vessel in repair or laid up shall</td>
	</tr>

	<tr>
		<td colspan="2">be included) within (</td>
		<td>3</td>
		<td colspan="9">) months from the time of completion of the service. However, the commencement of paid leave may be</td>
	</tr>

	<tr>
		<td colspan="12">extended until the vessel's entry into port when the vessel is under way.</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="12" style="{{ $blue }}">
			7.2 The leave pay should be given to seafarers even though the seafarers could not complete the contract.
		</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="6">7.3. The number of days of paid leave pursuant to 7.1 and 7.2 shall be (</td>
		<td style="{{ $blue }}">9</td>
		<td colspan="5">) days per one month of continuous service on board.</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="12" style="{{ $blue }}">
			7.4. In place of the four hours of each week in overtime work, one day of paid leave shall be added to the number of days of paid leave pursuant to 7.3.
		</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="12" style="{{ $blue }}">
			7.5.  In the calculation of the number of days of paid leave, the service period on board of less than one month shall be calculated at a rate of days, 
		</td>
	</tr>
	<tr>
		<td colspan="12" style="{{ $blue }}">
			but a fraction of less than one day shall be one day. 
		</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="12" style="{{ $blue }}">
			7.6. The time and place of port granting paid leave shall be decided on the negotiation between the shipowner and the seafarer.
		</td>
	</tr>

	{{ $fill() }}
	{{ $d1("8. Repatriation", true) }}
	{{ $d1("8.1. Shipowner shall ensure that seafarers are entitled to repatriation in the following circumstances.") }}
	{{ $d1("1) If the seafarers’ employment agreement expires while they are aboard") }}
	{{ $d1("2) When the seafarers’ employment agreement in terminated by the shipowner or by the seafarer for justified reasons") }}
	{{ $d1("3) When the seafarers are no longer able to carry out their duties under their employment agreement or cannot be excepted to carry them out in the specific circumstance") }}

	{{ $fill() }}
	{{ $d1("9. Seafarer’s employment agreement shall continue to have effect while a seafarer is held captive on or off the ship as a result of acts of piracy or armed robbery against ships, regardless of whether the date fixed for its expiry has passed or either party has given notice to suspend or terminate it.") }}

	{{ $fill() }}
	{{ $d1("10. Shipowner shall cover the health and social security protection benefits to be provided to the seafarer by due process of law. And terms not regulated in this contract will follow the one that is more advantageous to both parties comparing the Laws of Flag State / CBA.") }}

	{{ $fill() }}
	{{ $d1("11. Before autographing to this contract, the seafarer confirmed that no fees or other charges for recruitment or placement or for providing employment to seafarers are borne directly or indirectly, in whole or in part, to the agent of seafarer recruitment and placement. (other than the cost of the seafarer obtaining the seafarer’s book and a passport or other similar personal travel documents.). If the seafarer found that, the fact should be noticed to the shipowner immediately.") }}
	
	{{ $fill() }}
	<tr>
		<td colspan="4">12. The place of conclude contract:</td>
		<td colspan="5" style="{{ $blue }} {{ $bc }}">MANILA, PHILIPPINES</td>
		<td colspan="3"></td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="4">13. The time of conclude contract (dd/mm/yy)</td>
		<td colspan="5" style="{{ $bc }} {{ $blue }}">{{ now()->format('l, F j, Y') }}</td>
	</tr>

	{{ $fill() }}
	{{ $d1("14. Seafarers signing a seafarers' employment agreement be given an opportunity to examine and seek advice on the agreement before signing, as well as such other facilities as are necessary to ensure that they have freely entered into an agreement with a sufficient understanding of their rights and responsibilities.") }}
	
	{{ $fill(25) }}
	<tr>
		<td colspan="6"></td>
		<td colspan="3">Shipowner:</td>
		<td colspan="2">
			@if($data->vessel->type == "LNG")
				KOREA LINE LNG CORP
			@else
				KOREA LINE CORPORATION
			@endif
		</td>
	</tr>

	{{ $fill(70) }}
	<tr>
		<td colspan="3"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="3" style="{{ $c }}">Agent</td>
		<td colspan="2" style="{{ $c }}">Shirley Erasquin</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="3"></td>
		<td colspan="2" style="{{ $c }}">CREWING MANAGER</td>
	</tr>
	<tr>
		<td colspan="3"></td>
		<td colspan="3" style="{{ $c }}"></td>
		<td colspan="3"></td>
		<td colspan="2" style="{{ $c }}">Solpia Marine &#38; Ship Management Inc.</td>
	</tr>

	{{ $fill(70) }}
	<tr>
		<td colspan="6"></td>
		<td colspan="3">Seafarer:</td>
		<td colspan="2" style="{{ $b }}">{{ $data->user->namefull }}</td>
		<td>(signature)</td>
	</tr>
</table>