<table>
	@php
		foreach ($data as $key => $applicant) {
		    $docs2 = $applicant->docs;

		    foreach ($docs2 as $doc) {
		        $doc = json_decode($doc);
		        if($doc){
		        	$img = public_path('files\\' . $applicant->applicant_id . '\\' . $doc[0]);
		            echo "<tr>
		            	<td>
		            		<img src='$img' width='700px' height='1000px'>
		            	</td>
		            </tr>";
		        }
		    }
		}
	@endphp
</table>