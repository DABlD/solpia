<table>
	@php
		foreach ($data as $key => $applicant) {
		    $docs2 = $applicant->docs;

		    if($applicant->reliever){
			    foreach ($docs2 as $doc) {
			        $doc = json_decode($doc);
			        if($doc){
			        	$img = public_path('files\\' . $applicant->applicant_id . '\\' . $doc[0]);
			            echo "<tr>
			            	<td>
			            		<img src='$img' width='650px' height='950px' style='image-orientation: none;'>>
			            	</td>
			            </tr>";
			        }
			    }
		    }
		}
	@endphp
</table>