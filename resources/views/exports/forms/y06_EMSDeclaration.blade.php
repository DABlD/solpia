@php
	$bold = "font-weight: bold;";
	$center = "text-align: center;";
@endphp

<style>
	td{
		font-size: 14px;
	}

	footer {
	    position: fixed;
	    bottom: -20px;
	    left: 0;
	    right: 0;
	    height: 50px;

	    text-align: center;
	    line-height: 35px;
	    font-size: 12px;
	}

	.page-wrapper {
	    width: 90%;
	    text-align: center; /* centers text */
	    margin-left: 50px;
	}
</style>

<div class="page-wrapper">
	<table>
		<tr>
			<td colspan="8" style="text-align: center;">
				<img src="{{ public_path("images/ems_header.png") }}" alt="" width="100%">
			</td>
		</tr>

		<tr><td style="height: 15px;"></td></tr>

		<tr>
			<td colspan="8" style="text-align: center;">CREW SIGN-ON DECLARATION</td>
		</tr>

		<tr><td style="height: 40px;"></td></tr>

		<tr>
			<td style="width: 20px;"></td>
			<td colspan="7" style="text-align: justify;">
				This document will serve to confirm that the undersigned crew member had underwent Company familiarization training and been made aware of the Company's policies, procedures and objective with respect to Company's Enviromental Management System (EMS), in particular:
			</td>
		</tr>

		<tr><td style="height: 15px;"></td></tr>

		<tr>
			<td>1.</td>
			<td colspan="7" style="text-align: justify;">
				Company's zero-tolerance policy with respect to any violations of its EMS, MARPOL or other environmental regulation.
			</td>
		</tr>

		<tr>
			<td>2.</td>
			<td colspan="7" style="text-align: justify;">
				Been made aware of and been advised to follow the Company's open and anonymous reporting system with respect to reporting any and all violations, included witnessed violations, of Company's EMS, MARPOL or other environmental regulation.
			</td>
		</tr>

		<tr>
			<td>3.</td>
			<td colspan="7" style="text-align: justify;">
				That the Company had a non-retaliation and non-adverse action policy with respect to any and all such open/anonymous reports made.
			</td>
		</tr>

		<tr>
			<td>4.</td>
			<td colspan="7" style="text-align: justify;">
				That the open report contacts are as follows: <span style="font-size: 17px;">(<span style="color: red;">see EMS Appendix 2</span>)</span>.
			</td>
		</tr>

		<tr><td style="height: 15px;"></td></tr>
		<tr><td></td><td colspan="7">Furthermore, the undersigned, by executing this declaration does agree:</td></tr>
		<tr><td style="height: 15px;"></td></tr>

		<tr>
			<td><span style="font-size: 20px;">&bull;</span></td>
			<td colspan="7" style="text-align: justify;"> 
				That the falsification of any vessel documents or record-keeping shall not be tolerated by the Company;
			</td>
		</tr>

		<tr>
			<td><span style="font-size: 20px;">&bull;</span></td>
			<td colspan="7" style="text-align: justify;">
				That I will follow all Company's policies, procedures and objectives as stated in the Company's EMS including complying with MARPOL and any/all international, national and port state regulations during my employment on board;
			</td>
		</tr>

		<tr>
			<td><span style="font-size: 20px;">&bull;</span></td>
			<td colspan="7" style="text-align: justify;"> 
				If I witness or learn of or know of any such violations with respect to the above I will immediately report them via the Company's open & anonymous reporting system;
			</td>
		</tr>

		<tr>
			<td><span style="font-size: 20px;">&bull;</span> </td>
			<td colspan="7">
				That I will not participate in any illegal/unauthorized procedure/act whilst on board;
			</td>
		</tr>

		<tr>
			<td><span style="font-size: 20px;">&bull;</span> </td>
			<td colspan="7">
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
</div>

<footer style="color: grey;">
    Rev. 02 / 09.29.2023
</footer>