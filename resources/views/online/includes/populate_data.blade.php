<script>
	function populate_data(){
		let config = {
	        altInput: true,
	        altFormat: 'F j, Y',
	        dateFormat: 'Y-m-d',
	        maxDate: moment().format('YYYY-MM-DD')
	    };

		let config2 = {
	        altInput: true,
	        altFormat: 'F j, Y',
	        dateFormat: 'Y-m-d',
	    };

		$('#createForm').append(`<input type="hidden" name="applicant_id" value='{{ $applicant->id }}'>`);

		$('[name="lname"]').val('{{ $applicant->user->lname }}');
		$('[name="fname"]').val('{{ $applicant->user->fname }}');
		$('[name="mname"]').val('{{ $applicant->user->mname }}');
		$('[name="suffix"]').val('{{ $applicant->user->suffix }}');

		$('[name="birthday"]').flatpickr(config).setDate('{{ $applicant->user->birthday }}', true);
		$('[name="birth_place"]').val('{{ $applicant->birth_place }}');

		$('[name="religion"]').val('{{ $applicant->religion }}').trigger('change');

		$('[name="address"]').val('{{ $applicant->user->address }}');
		$('[name="contact"]').val('{{ $applicant->user->contact }}');
		$('[name="provincial_address"]').val('{{ $applicant->provincial_address }}');
		$('[name="provincial_contact"]').val('{{ $applicant->provincial_contact }}');
		$('[name="email"]').val('{{ $applicant->user->email }}');

		$('[name="gender"][value="{{ $applicant->user->gender }}"]').click();

		$('[name="waistline"]').val('{{ $applicant->waistline }}');
		$('[name="shoe_size"]').val('{{ $applicant->shoe_size }}');
		$('[name="clothes_size"]').val('{{ $applicant->clothes_size }}');
		$('[name="height"]').val('{{ $applicant->height }}');
		$('[name="weight"]').val('{{ $applicant->weight }}');
		$('[name="bmi"]').val('{{ $applicant->bmi }}');
		$('[name="blood_type"]').val('{{ $applicant->blood_type }}');
		$('[name="civil_status"]').val('{{ $applicant->civil_status }}');
		$('[name="eye_color"]').val('{{ $applicant->eye_color }}');
		
		$('[name="tin"]').val('{{ $applicant->tin }}');
		$('[name="sss"]').val('{{ $applicant->sss }}');

		// EDUC BACKGROUND
		let index = 0;
		@foreach($applicant->educational_background as $data)
			addEB();
			inputs = $('#EB .form-control');
			i = (index * 6);

			if("{{ $data->year }}" == ""){
				start = "";
				end = "";
			}
			else{
				start = "{{ $data->year }}".split('-')[0];
				end = "{{ $data->year }}".split('-')[1];
			}

			inputs[i].value = "{{ $data->type }}";
	        inputs[i+1].value = "{{ $data->course }}";
	        inputs[i+2].value = start;
	        inputs[i+3].value = end;

	        $(inputs[i+4]).val("{{ $data->school }}").trigger('change');

	        inputs[i+5].value = "{{ $data->address }}";

	        $($(inputs[i+5]).parent().parent()).prepend(`
	        	<input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
	        `);
	        index++;
		@endforeach

		// FAMILY DATA
		index = 0;
		@foreach($applicant->family_data as $data)
			addFD("{{ $data->type }}");
		@endforeach

		@foreach($applicant->family_data as $data)
			inputs = $('#FD input');
			i = (index * 12);

	        inputs[i+1].value = "{{ $data->lname }}";
	        inputs[i+2].value = "{{ $data->fname }}";
	        inputs[i+3].value = "{{ $data->mname }}";
	        inputs[i+4].value = "{{ $data->suffix }}";
	        // inputs[i+2].value = start;
	        $(inputs[i+5]).flatpickr(config).setDate("{{ $data->birthday }}", true);
	        inputs[i+7].value = "{{ $data->age }}";
	        inputs[i+8].value = "{{ $data->occupation }}";
	        inputs[i+9].value = "{{ $data->email }}";
	        inputs[i+10].value = "{{ $data->address }}";

	        $($(inputs[i+10]).parent().parent()).prepend(`
	        	<input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
	        `);
	        index++;
		@endforeach

	    // DOCUMENT ID
		index = 0;
		@foreach($applicant->document_id as $data)
			addDocu('ID');
		@endforeach
		@foreach($applicant->document_id as $data)
			inputs = $('#docu .ID input, #docu .ID select');
			i = (index * 8);

		    $(inputs[i]).val("{!! str_replace("'S", "", $data->type) !!}").trigger('change');
		    $(inputs[i+1]).val("{!! $data->issuer !!}").trigger('change');

		    inputs[i+2].value 	= "{{ $data->number }}";

			$(inputs[i+3]).flatpickr(config).setDate("{{ $data->issue_date }}", true);
			$(inputs[i+5]).flatpickr(config2).setDate("{{ $data->expiry_date }}", true);

			$($(inputs[i+5]).parent().parent()).prepend(`
		        <input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
			`);
			index++;
		@endforeach

		// DOCUMENT MED CERT
		index = 0;
		@foreach($applicant->document_med_cert as $data)
			addDocu('MedCert');
		@endforeach
		@foreach($applicant->document_med_cert as $data)
			inputs = $('#docu .MedCert input, #docu .MedCert select');
			i = (index * 9);

			$(inputs[i]).val("{!! $data->type !!}").trigger('change');
			$(inputs[i+1]).val("{!! $data->clinic !!}").trigger('change');

			inputs[i+2].value = "{{ $data->issuer }}";
			inputs[i+3].value = "{{ $data->number }}";

		    $(inputs[i+4]).flatpickr(config).setDate("{{ $data->issue_date }}", true);
			$(inputs[i+6]).flatpickr(config2).setDate("{{ $data->expiry_date }}", true);

			$($(inputs[i+6]).parent().parent()).prepend(`
		        <input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
			`);
			index++;
		@endforeach

		// DOCUMENT MED
		index = 0;
		@foreach($applicant->document_med as $data)
			addDocu('Med');
		@endforeach
		@foreach($applicant->document_med as $data)
			inputs = $('#docu .Med input, #docu .Med select');
			i = (index * 5);

			$(inputs[i]).val("{!! $data->type !!}").trigger('change');
			$(inputs[i+1]).val("{{ $data->with_mv }}").trigger('change');

	        inputs[i+2].value 	= '{{ $data->year }}';
	        inputs[i+3].value 	= '{{ $data->case_remarks }}';

			$($(inputs[i+3]).parent().parent()).prepend(`
		        <input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
			`);
			index++;
		@endforeach

		document.getElementById("preview").src = "{!! asset($applicant->user->avatar) !!}";
		$('[type="file"]').removeClass('aeigh');
		
		getVessels();
		//getAddDetails
		
		$.ajax({
			url: '{{ route("applications.getAddDetails", ['applicant' => $applicant->id]) }}',
			success: result => {
				result = JSON.parse(result);

				let flags = result.document_flag;
				let lcs   = result.document_lc;
				let sss   = result.sea_service;

				let size = lcs.length;
				index = 0;

				for(let ctr = 0; ctr < lcs.length; ctr++){
					addDocu('lc');

					let inputs = $('#docu .lc input, #docu .lc select');

					i = (index * 10);

					checkIfExisting($(inputs[i]), lcs[ctr].type);
					checkIfExisting($(inputs[i+1]), lcs[ctr].issuer);

					regulations = JSON.parse(lcs[ctr].regulation);
					
					$(inputs[i+2]).val(regulations);
					$(inputs[i+2]).trigger('change');

					inputs[i+4].value = lcs[ctr].no;

					$(inputs[i+5]).flatpickr(config).setDate(lcs[ctr].issue_date, true);
					$(inputs[i+7]).flatpickr(config2).setDate(lcs[ctr].expiry_date, true);

					$($(inputs[i+7]).parent().parent()).prepend(`
						<input type="hidden" name="id-${lcs[ctr].id}" value="${lcs[ctr].id}" data-type="id">
					`);
					index++;
				}

				let keys = Object.keys(flags);
				length = keys.length;

				if(lcs.length > 0){
					$('#rank').val(lcs[0].rank).trigger('change');
				}
				else if(flags.length == undefined){
					$('#rank').val(flags[keys[0]][0].rank).trigger('change');
				}

				let flagDocu = [];
				for(let ctr = 0; ctr < length; ctr++){
					addDocu('Flag');

					let country = $($('.docu-country')[ctr]);
					$(country).val(keys[ctr]).trigger('change');
				}
				setTimeout(() => {
					for(let ctr = 0; ctr < keys.length; ctr++){
						index = 0;
						flags[keys[ctr]].forEach((data, ctr2) => {
							let country = $(`[name="docu-country${(ctr + 1)}"]`);

							inputs = $(`.flag${$(country).data('fdcount')}-documents input`);
							i = (index * 7);

							checkIfExisting($(inputs[i]), flags[keys[ctr]][ctr2].type);
							inputs[i+1].value = flags[keys[ctr]][ctr2].number;


							$(inputs[i+2]).flatpickr(config).setDate(flags[keys[ctr]][ctr2].issue_date, true);
							$(inputs[i+4]).flatpickr(config2).setDate(flags[keys[ctr]][ctr2].expiry_date, true);


							$loc = $($($(inputs[i+4]).parent().parent()).children()[(ctr2 * 4) + ctr2]);

							$loc.before(`
								<input type="hidden" name="id-${flags[keys[ctr]][ctr2].id}" value="${flags[keys[ctr]][ctr2].id}" data-type="id">
							`);
							index++;
						});
					}
				}, 1000);
				
				length = sss.length;
				swal({
					title: 'Loading Sea Services...',
					allowOutsideClick: false,
					allowEscapeKey: false,
				});
				swal.showLoading();
				
				for(let ctr = 0; ctr < length; ctr++){
					addSS2();
				}

				// length ? $('[name="imo1"]').select2('open') : '';
			
				index = 0;
				for(let ctr = 0; ctr < length; ctr++){
					inputs = $('#sea-services input, #sea-services select');
					i = (index * 20);
					
					$(inputs[i]).val(sss[ctr].imo).trigger('change');
					// checkIfExisting($(inputs[i+1]), sss[ctr].vessel_name);
					$(inputs[i+1]).val(sss[ctr].vessel_name);
					$(inputs[i+2]).val(sss[ctr].rank).trigger('change');

					// Set the value, creating a new option if necessary
					if(sss[ctr].vessel_type != "" && sss[ctr].vessel_type != null){
						if ($(inputs[i+3]).find("option[value='" + sss[ctr].vessel_type + "']").length) {
							$(inputs[i+3]).val(sss[ctr].vessel_type).trigger('change');
						} else { 
						    var newOption = new Option(sss[ctr].vessel_type, sss[ctr].vessel_type, true, true);
						    $(inputs[i+3]).append(newOption).trigger('change');
						} 
					}
					
					// inputs[i+3].value       = sss[ctr].vessel_type;
					inputs[i+4].value       = sss[ctr].smc;
					inputs[i+5].value       = sss[ctr].gross_tonnage;
					inputs[i+6].value       = sss[ctr].engine_type;
					inputs[i+7].value       = sss[ctr].bhp_kw;
					inputs[i+8].value       = sss[ctr].flag;
					// inputs[i+8].value       = sss[ctr].trade;

					// Set the value, creating a new option if necessary
					if(sss[ctr].trade != "" && sss[ctr].trade != null){
						if ($(inputs[i+9]).find("option[value='" + sss[ctr].trade + "']").length) {
							$(inputs[i+9]).val(sss[ctr].trade).trigger('change');
						} else { 
						    var newOption = new Option(sss[ctr].trade, sss[ctr].trade, true, true);
						    $(inputs[i+9]).append(newOption).trigger('change');
						} 
					}

					inputs[i+10].value       = sss[ctr].previous_salary;
					inputs[i+11].value      = sss[ctr].manning_agent;
					inputs[i+12].value      = sss[ctr].principal;
					// inputs[i+12].value      = sss[ctr].crew_nationality;

					// Set the value, creating a new option if necessary
					if(sss[ctr].crew_nationality != "" && sss[ctr].crew_nationality != null){
						if ($(inputs[i+13]).find("option[value='" + sss[ctr].crew_nationality + "']").length) {
							$(inputs[i+13]).val(sss[ctr].crew_nationality).trigger('change');
						} else { 
						    var newOption = new Option(sss[ctr].crew_nationality, sss[ctr].crew_nationality, true, true);
						    $(inputs[i+13]).append(newOption).trigger('change');
						}
					}

					$(inputs[i+14]).flatpickr(config).setDate(sss[ctr].sign_on, true);
					$(inputs[i+16]).flatpickr(config).setDate(sss[ctr].sign_off, true);

					inputs[i+18].value      = sss[ctr].remarks;

					// $(inputs[i]).select2('close');

					$($(inputs[i+18]).parent().parent()).prepend(`
						<input type="hidden" name="id-${sss[ctr].id}" value="${sss[ctr].id}" data-type="id">
					`);
					index++;
				}

				swal.close();
			}
		})
	}



	// $('html, body').animate({
 //        scrollTop: $(".Flag").offset().top - 200
 //    }, 2000);
</script>
