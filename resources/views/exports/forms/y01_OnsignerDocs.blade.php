<table>
	@php
		foreach ($data as $key => $applicant) {
		    $docs2 = $applicant->docs;

		    foreach ($docs2 as $doc) {
		    	if(str_starts_with($doc, '[')){
		        	$doc = json_decode($doc)[0];
		    	}

		        if($doc){
		        	$img = public_path('files\\' . $applicant->applicant_id . '\\' . $doc);

		            echo "<tr>
		            	<td>
		            		<img src='$img' width='700px' height='1000px' style='image-orientation: 0deg;'>
		            	</td>
		            </tr>";
		        }
		    }
		}
	@endphp
</table>