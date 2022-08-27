@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
	$bc = $bold . ' ' . $center;
	$und = 'text-decoration: underline;';
	$blue = 'color: #0000FF;';
	$red = 'color: #FF0000;';

	$fill = function($height = 15){
		echo "<tr><td colspan='6' style='height: $height;'></td></tr>";
	}
@endphp

<table>
	<tr>
		<td colspan="6" style="font-size: 14px; {{ $bc }}">Contract of Employment for Seafarer</td>
	</tr>

	{{ $fill() }}
	<tr>
		<td colspan="6">The following parties to the contract agree to fully comply with the terms stated hereinafter:</td>
	</tr>

	<tr>
		<td rowspan="6">Shipowner</td>
		<td rowspan="2">
			Name of the 
			<br style='mso-data-placement:same-cell;' />
			company
		</td>
		<td rowspan="2" colspan="2" style="{{ $bc }}">KOREA LINE CORPORATION</td>
		<td rowspan="2">Phone number</td>
		<td rowspan="2" style="{{ $bc }}">(02)3701-0114</td>
	</tr>
	<tr></tr>

	<tr>
		<td rowspan="2">
			Location of the 
			<br style='mso-data-placement:same-cell;' />
			company
		</td>
		<td rowspan="2" colspan="4" style="{{ $bc }}">SM R&amp;D CENTER, 78, MAGOKJUNGANG8-RO, GANGSEO-GU, SEOUL, KOREA</td>
	</tr>
	<tr></tr>

	<tr>
		<td rowspan="2">
			Name of the 
			<br style='mso-data-placement:same-cell;' />
			employee
		</td>
		<td rowspan="2" colspan="2" style="{{ $bc }}">KIM, MAN TAE</td>
		<td rowspan="2">Identification number</td>
		<td rowspan="2">101-81-24624</td>
	</tr>
	<tr></tr>

	<tr>
		<td rowspan="6">Seafarer</td>
		<td rowspan="2">
			Name of 
			<br style='mso-data-placement:same-cell;' />
			seafarer
		</td>
		<td rowspan="2" colspan="2" style="{{ $bc }} {{ $blue }}">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }} {{ $data->user->mname }}
		</td>
		<td>Date of birth</td>
		<td style="{{ $bc }} {{ $blue }}">
			{{ $data->user->birthday ? $data->user->birthday->format('d/M/Y') : '---' }}
		</td>
	</tr>

	<tr>
		<td>Age</td>
		<td style="{{ $bc }} {{ $blue }}">
			{{ $data->user->birthday ? $data->user->birthday->age : '---' }}
		</td>
	</tr>

	<tr>
		<td rowspan="2">Sex</td>
		<td rowspan="2" colspan="2" style="{{ $bc }} {{ $blue }}">{{ $data->user->gender }}</td>
		<td rowspan="2">Birth place</td>
		<td rowspan="2" style="{{ $bc }} {{ $blue }}">{{ $data->birth_place }}</td>
	</tr>
	<tr></tr>

	<tr>
		<td rowspan="2" colspan="2">
			Address of seafarer
			<br style='mso-data-placement:same-cell;' />
			(in home country)
		</td>
		<td rowspan="2" colspan="3" style="{{ $bc }} {{ $blue }}">
			{{ $data->user->address }}
		</td>
	</tr>
	<tr></tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">1. Contract Period</td>
	</tr>

	{{ $fill(5) }}

	<tr>
		<td>1.1. from</td>
		<td style="{{ $bc }} {{ $blue }}">{{ now()->parse($data->effective_date)->format('(d/M/Y)') }}</td>
		<td style="{{ $center }}">to</td>
		<td style="{{ $bc }} {{ $blue }}">{{ now()->parse($data->effective_date)->add($data->employment_months, 'months')->format('(d/M/Y)') }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="2">1.2 the port of sailing</td>
		<td style="{{ $bc }} {{ $blue }}">{{ $data->port }}</td>
		<td>to the port of destination</td>
		<td>UNFIXED</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="6" style="{{ $bold }}">2. Advance Notice of Rescission of the Seafarer's Employment Contract</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="4">
			If the shipowner or the seafarer wishes to make a rescission of the seafarer's employment contract, to the extent that 			
		</td>
		<td colspan="2" style="{{ $blue }}">
			the seafarer must make an advance notice 
		</td>
	</tr>

	<tr>
		<td colspan="6">
			of rescission to the shipowner before 7 days and to the extent that the shipowner must make a written advance notice of rescission to 
		</td>
	</tr>

	<tr>
		<td colspan="6">
			the more than 30 days, prior to the rescission of the contract.
		</td>
	</tr>

	{{ $fill(20) }}

	<tr>
		<td colspan="6" style="{{ $bold }}">3. Vessel of Employment and Rank</td>
	</tr>

	<tr>
		<td colspan="3">3.1 Vessel of Employment:</td>
		<td colspan="3" style="{{ $bold }} {{ $blue }}">{{ $data->vessel->name }}({{ $data->vessel->type }})</td>
	</tr>

	<tr>
		<td>Official No.</td>
		<td style="{{ $bold }} {{ $blue }}">{{ $data->onum }}</td>
		<td>Flag</td>
		<td style="{{ $bold }} {{ $blue }}">{{ $data->vessel->flag }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td>Gross Tonnage</td>
		<td style="{{ $bold }} {{ $blue }}">{{ $data->vessel->gross_tonnage }}</td>
		<td>Year built</td>
		<td style="{{ $bold }} {{ $blue }}">{{ $data->vessel->year_build }}</td>
		<td colspan="2"></td>
	</tr>

	{{ $fill(5) }}

	<tr>
		<td>3.2 Rank:</td>
		<td style="{{ $bold }} {{ $blue }}">{{ $data->position }}</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="6" style="{{ $bold }}">4. Hours of Work and Overtime</td>
	</tr>

	<tr>
		<td colspan="6">4.1. The hours of work on board shall be eight hours in a day and forty hours in a week.</td>
	</tr>

	<tr>
		<td colspan="6">4.2. Overtime</td>
	</tr>

	<tr>
		<td colspan="6">1) The hours of work may be extended for sixteen hours as a maximum in a week by the agreement of the persons concerned.</td>
	</tr>

	<tr>
		<td colspan="6">2) Not withstanding the provision of paragraph 4.1), the shipowner may give an order of overtime work within sixteen hours in a week to the crew who is performing the duty of navigational watch and within 4 hours in a week to other crew.</td>
	</tr>

	<tr>
		<td colspan="6">3) When there is an unavoidable circumstance such as securing the safety of ship operation etc., the shipowner may give an order of overtime work to the crew even though it exceeds the hours of work prescribed in paragraphs 1) and 2)</td>
	</tr>

	<tr>
		<td colspan="6">4.3. Overtime allowance:</td>
	</tr>

	<tr>
		<td rowspan="2" colspan="6">The shipowner shall pay an fixed overtime allowance equivalent to the amount to seafarer for the work as provision of paragraph 4.2.</td>
	</tr>

	<tr></tr>

	<tr>
		<td colspan="6" style="{{ $bold }}">5. Hours of Rest and Holiday</td>
	</tr>

	<tr>
		<td colspan="6">5.1. The shipowner shall give the crew ten hours of rest or more in any 24 hour period and seventy seven hours of rest or more in any seven-day period.</td>
	</tr>

	<tr>
		<td colspan="6">5.2. Hours of rest may be divided into no more than two periods, one of which shall be at least six hours in length, and the interval between consecutive periods of rest shall not exceed 14 hours.</td>
	</tr>

	<tr>
		<td colspan="6">5.3. Holiday of seafarers is Saturday and Sunday and Korean legal holiday, worker’s day.</td>
	</tr>

	{{ $fill() }}

	<tr>
		<td colspan="6" style="{{ $bold }}">6. Payment</td>
	</tr>

	{{ $fill(5) }}

	<tr>
		<td colspan="6">6.1. Consolidated pay and benefits</td>
	</tr>

	<tr>
		<td colspan="6">1) Consolidated pay</td>
	</tr>

	<tr>
		<td colspan="2">&#9312; Monthly total wages:</td>
	</tr>
</table>