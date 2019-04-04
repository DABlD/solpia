<div id="docu"></div>

@push('before-scripts')
    <script>
        function addDocu(type){
            $(`.${type}Count`)[0].innerText = parseInt($(`.${type}Count`)[0].innerText) + 1;

            let count = $('.docu').length + 1;

            let docu_class = 'form-control aeigh';
            let docu_class2 = 'form-control';

            if($(`.${type}`).length == 0){
            	let temp = type == 'lc'? 'License/Certificates/Contracts' : type;
                appenddocu(`<div class="${type}"><u><h3><strong>${temp}</strong></h3></u>`);
            }
            else{
                appenddocu('<div>');
            }

            let string;

            let dType = "docu-dtype";
            let number = 'docu-number';
        	let issue_date = 'docu-issue_date';
        	let expiry_date = 'docu-expiry_date';

        	let country = "docu-country";
        	let booklet_no = "docu-bookletNo";
        	let license_no = "docu-licenseNo";
        	let goc = "docu-goc";
        	let sso = "docu-sso";
        	let sdsd = "docu-sdsd";

        	let issuer = "docu-issuer";

        	//<input type="hidden" name="docu-type${count}" value="${type}">
            if(type == "ID"){
            	string = `
	            	    <div class="row docu">

	            	        <div class="form-group col-md-3">
	            	            <label for="${dType}${count}">Type</label>
	            	            <select class="${docu_class} ${dType}" name="${dType}${count}">
									<option></option>
									<option value="PASSPORT">PASSPORT</option>
									<option value="US-VISA">US-VISA</option>
									<option value="SEAMANS BOOK">SEAMANS BOOK</option>
									<option value="MCV W/ PPRT">MCV W/ PPRT</option>
	            	            </select>
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${dType}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${number}${count}">Number</label>
	            	            <input type="text" class="${docu_class} ${number}" name="${number}${count}" placeholder="Enter Number">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${number}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${issue_date}${count}">Issue Date</label>
	            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${issue_date}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${expiry_date}${count}">Expiry Date</label>
	            	            <input type="text" class="${docu_class} ${expiry_date}" name="${expiry_date}${count}" placeholder="Select Expiry Date">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${expiry_date}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	    </div>
	            	    <hr>
	            	</div>`;
            }
            else if(type == "Flag"){
            	string = `
	            	    <div class="row docu">
							
	            	        <div class="form-group col-md-2">
	            	            <label for="${country}${count}">Country</label>
	            	            <input type="text" class="${docu_class} ${country}" name="${country}${count}" placeholder="Enter Country">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${country}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-2">
	            	            <label for="${booklet_no}${count}">Booklet No.</label>
	            	            <input type="text" class="${docu_class} ${booklet_no}" name="${booklet_no}${count}" placeholder="Enter Booklet No.">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${booklet_no}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-2">
	            	            <label for="${license_no}${count}">License No.</label>
	            	            <input type="text" class="${docu_class} ${license_no}" name="${license_no}${count}" placeholder="Enter License No.">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${license_no}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-2">
	            	            <label for="${goc}${count}">GOC</label>
	            	            <input type="text" class="${docu_class} ${goc}" name="${goc}${count}" placeholder="Enter GOC">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${goc}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-2">
	            	            <label for="${sso}${count}">SSO</label>
	            	            <input type="text" class="${docu_class} ${sso}" name="${sso}${count}" placeholder="Enter SSO">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${sso}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-2">
	            	            <label for="${sdsd}${count}">SDSD</label>
	            	            <input type="text" class="${docu_class} ${sdsd}" name="${sdsd}${count}" placeholder="Enter SDSD">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${sdsd}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	    </div>
	            	    <hr>
	            	</div>`;
            }
            else{
            	string = `
	            	    <div class="row docu">

	            	        <div class="form-group col-md-3">
	            	            <label for="${issuer}${count}">Issuer</label>
	            	            <input type="text" class="${docu_class2} ${issuer}" name="${issuer}${count}" placeholder="Enter Issuer">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${issuer}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${number}${count}">Number</label>
	            	            <input type="text" class="${docu_class2} ${number}" name="${number}${count}" placeholder="Enter Number">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${number}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${issue_date}${count}">Issue Date</label>
	            	            <input type="text" class="${docu_class} ${issue_date}" name="${issue_date}${count}" placeholder="Select Issue Date">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${issue_date}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	        <div class="form-group col-md-3">
	            	            <label for="${expiry_date}${count}">Expiry Date</label>
	            	            <input type="text" class="${docu_class} ${expiry_date}" name="${expiry_date}${count}" placeholder="Select Expiry Date">
	            	            <span class="invalid-feedback hidden" role="alert">
	            	                <strong id="${expiry_date}${count}Error"></strong>
	            	            </span>
	            	        </div>
	            	    </div>
	            	    <hr>
	            	</div>`;
            }

            // appenddocu(string, ctr? ` .${type}` : '');
            appenddocu(string, ` .${type}`);
            if(type != 'Flag'){
	            $(`[name="${issue_date}${count}"], [name="${expiry_date}${count}"]`).flatpickr({
	                altInput: true,
	                altFormat: 'F j, Y',
	                dateFormat: 'Y-m-d',
	                // maxDate: moment().format('YYYY-MM-DD')
	            });
            }

            if(type == "ID"){
            	$(`[name="${dType}${count}"]`).select2({
            		placeholder: 'Select Type',
            		tags: true
            	});
            }
        }

        function appenddocu(string, addClass = ""){
            $('#docu' + addClass).append(string);
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        
    </script>
@endpush