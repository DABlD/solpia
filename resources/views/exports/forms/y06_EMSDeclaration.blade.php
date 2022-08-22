@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
@endphp

<style>
	td{
		font-size: 14px;
	}
</style>

<table>
	<tr>
		<td colspan="8">Nitta Kisen Kaisha Ltd.</td>
	</tr>

	<tr><td style="height: 15px;"></td></tr>

	<tr>
		<td colspan="8" style="text-align: center;">ENVIRONMENTAL MANAGEMENT SYSTEM</td>
	</tr>
	<tr>
		<td colspan="8" style="text-align: center;">CREW SIGN-ON DECLARATION</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td></td>
		<td colspan="7">This document will serve to confirm that the undersigned crew member had underwent Company</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">familiarization training and been made aware of the Company's policies, procedures and objective with</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">respect to Company's Enviromental Management System (EMS), in particular:</td>
	</tr>

	<tr><td style="height: 15px;"></td></tr>

	<tr>
		<td></td>
		<td colspan="7">1. 
			<span style="color: white;">-</span>
			Company's zero-tolerance policy with respect to any violations of its EMS, MARPOL or other
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			environmental regulation.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">2. 
			<span style="color: white;">-</span>
			Been made aware of and been advised to follow the Company's open and anonymous reporting
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			system with respect to reporting any and all violations, included witnessed violations, of Company's
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			EMS, MARPOL or other environmental regulation.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">3. 
			<span style="color: white;">-</span>
			That the Company had a non-retaliation and non-adverse action policy with respect to any and all
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			such open/anonymous reports made.
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">4. 
			<span style="color: white;">-</span>
			That the open report contacts are as follows: <span style="font-size: 17px;">(see EMS/ECP reporting Diagram)</span>.
		</td>
	</tr>

	<tr><td style="height: 15px;"></td></tr>
	<tr><td></td><td colspan="8">Furthermore, the undersigned, by executing this declaration does agree:</td></tr>
	<tr><td style="height: 15px;"></td></tr>

	<tr>
		<td></td>
		<td colspan="7"><span style="font-size: 20px;">&bull;</span> 
			<span style="color: white;">--</span>
			That the falsification of any vessel documents or record-keeping shall not be tolerated by the
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			Company;
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7"><span style="font-size: 20px;">&bull;</span> 
			<span style="color: white;">--</span>
			That I will follow all Company's policies, procedures and objectives as stated in the Company's EMS/ECP
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			including complying with MARPOL and any/all international, national and port state regulations
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			during my employment on board;
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7"><span style="font-size: 20px;">&bull;</span> 
			<span style="color: white;">--</span>
			If I witness or learn of or know of any such violations with respect to the above I will immediately
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7">
			<span style="color: white;">----</span>
			report them via the Company's open & anonymous reporting system;
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7"><span style="font-size: 20px;">&bull;</span> 
			<span style="color: white;">--</span>
			That I will not participate in any illegal/unauthorized procedure/act whilst on board;
		</td>
	</tr>

	<tr>
		<td></td>
		<td colspan="7"><span style="font-size: 20px;">&bull;</span> 
			<span style="color: white;">--</span>
			That I will full cooperate with any investigation into an alleged violation or noncompliance.
		</td>
	</tr>

	<tr><td style="height: 40px;"></td></tr>

	<tr>
		<td></td>
		<td colspan="2" style="border-bottom: 1px solid;">{{ now()->format('F j, Y') }}</td>
		<td></td>
		<td colspan="2" style="border-bottom: 1px solid;"></td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td></td>
		<td colspan="2">Date</td>
		<td></td>
		<td colspan="2">Signature</td>
		<td colspan="2"></td>
	</tr>

	<tr><td style="height: 30px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2" style="border-bottom: 1px solid;">
			{{ $data->user->lname }}, {{ $data->user->fname }} {{ $data->user->suffix }}
		</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2">Name (Print)</td>
		<td colspan="2"></td>
	</tr>

	<tr><td style="height: 10px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2" style="border-bottom: 1px solid;">{{ $data->rank ?? "---" }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2">Rank</td>
		<td colspan="2"></td>
	</tr>

	<tr><td style="height: 10px;"></td></tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2" style="border-bottom: 1px solid;">{{ $data->vessel ?? "---" }}</td>
		<td colspan="2"></td>
	</tr>

	<tr>
		<td colspan="4"></td>
		<td colspan="2">Vessel</td>
		<td colspan="2"></td>
	</tr>
</table>