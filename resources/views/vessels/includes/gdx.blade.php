{{-- INCLUDED ON vessels.index --}}

<script>
	function ECPTCREWLIST(){
        let vessels = [
        	[9540, 	"M/V NORD ATOLL"],
        	[4765, 	"M/V WECO ESTHER"],
        	[8, 	"M/V ATLANTIC BUENAVISTA"],
        	[9, 	"M/V ATLANTIC OASIS"],
        	[4662, 	"M/V NORD SINGAPORE"],
        	[7, 	"M/V ANCASH QUEEN"]
        ];

        let vesselString = "";

        vessels.forEach(vessel => {
            vesselString += `
                <div class="col-md-6 iInput" style="text-align: left;">
                    ${checkbox("vessels", vessel[1], `data-id="${vessel[0]}"`)}
                </div>
            `;
        });

        swal({
            title: "MAMILI KA",
            html: `
                <div class="row">
                    ${vesselString}
                </div>

            	<br>

                <div class="row">
                	<div class="col-md-6 iInput" style="text-align: left;">
	            		<input type="radio" name="type" value="lun" checked> Lined-Up
	            		<input type="radio" name="type" value="obc"> On Board
                	</div>
                </div>
            `,
            width: '400px'
    	}).then(result => {
            if(result.value){
                let vessels = [];

                $('[name="vessels"]:checked').each((a, cb) => {
                    vessels.push(cb.dataset.id);
                });

                if(vessels){
                    let data = {};
                        data.type = $('[name="type"]:checked').val();
                        data.vessels = vessels;
                        data.filename = `ECPT NI GLADYS ANNE`;
                        data.folder = "GDX\\";

                    window.location.href = `{{ route('applications.exportDocument') }}/1/ECPTCREWLIST?` + $.param(data);
                }
                else{
                    swal('No vessel selected');
                }
            }
        });
    }
</script>