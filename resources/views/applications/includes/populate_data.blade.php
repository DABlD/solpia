<script>
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
	$('[name="religion"]').val('{{ $applicant->religion }}');
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
        inputs[i+4].value = "{{ $data->school }}";
        inputs[i+5].value = "{{ $data->address }}";

        $($(inputs[i+5]).parent().parent()).prepend(`
        	<input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
        `);
        index++;
	@endforeach

	// FAMILY DATA
	index = 0;
	@foreach($applicant->family_data as $data)
		@if($loop->index > 1)
			addFD("{{ $data->type }}");
		@endif
	@endforeach

	@foreach($applicant->family_data as $data)
		inputs = $('#FD input');
		i = (index * 9);

        inputs[i+1].value = "{{ $data->name }}";
        // inputs[i+2].value = start;
        $(inputs[i+2]).flatpickr(config).setDate("{{ $data->birthday }}", true);
        inputs[i+4].value = "{{ $data->age }}";
        inputs[i+5].value = "{{ $data->occupation }}";
        inputs[i+6].value = "{{ $data->email }}";
        inputs[i+7].value = "{{ $data->address }}";

        $($(inputs[i+7]).parent().parent()).prepend(`
        	<input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
        `);
        index++;
	@endforeach

	// SEA SERVICE
	@foreach($applicant->sea_service as $data)
		addSS();
	@endforeach
	$('[name="vessel_name1"]').select2('open');
    
    setTimeout(() => {
	index = 0;
		@foreach($applicant->sea_service as $data)
        	inputs = $('#sea-services input, #sea-services select');
	        i = (index * 18);

	        $(inputs[i]).val("{{ $data->vessel_name }}").trigger('change');
	        $(inputs[i+1]).val("{{ $data->rank }}").trigger('change');

			inputs[i+2].value       = "{{ $data->vessel_type }}";
			inputs[i+3].value       = "{{ $data->gross_tonnage }}";
			inputs[i+4].value       = "{!! $data->engine_type !!}";
			inputs[i+5].value       = "{{ $data->bhp_kw }}";
			inputs[i+6].value       = "{{ $data->flag }}";
			inputs[i+7].value       = "{{ $data->trade }}";
			inputs[i+8].value       = "{{ $data->previous_salary }}";
			inputs[i+9].value       = "{{ $data->manning_agent }}";
			inputs[i+10].value      = "{{ $data->principal }}";
			inputs[i+11].value      = "{{ $data->crew_nationality }}";

			$(inputs[i+12]).flatpickr(config).setDate("{{ $data->sign_on }}", true);
			$(inputs[i+14]).flatpickr(config).setDate("{{ $data->sign_off }}", true);

			inputs[i+16].value      = "{{ $data->remarks }}";

	    	$(inputs[i]).select2('close');

			$($(inputs[i+16]).parent().parent()).prepend(`
		        <input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
			`);
			index++;
		@endforeach
	}, 2000);

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
		i = (index * 8);

		$(inputs[i]).val("{!! $data->type !!}").trigger('change');
		$(inputs[i+1]).val("{!! $data->clinic !!}").trigger('change');

		inputs[i+2].value = "{{ $data->number }}";

	    $(inputs[i+3]).flatpickr(config).setDate("{{ $data->issue_date }}", true);
		$(inputs[i+5]).flatpickr(config2).setDate("{{ $data->expiry_date }}", true);

		$($(inputs[i+5]).parent().parent()).prepend(`
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

	// RANK
	@if(sizeof($applicant->document_lc) > 0)
		$('#rank').val('{{ $applicant->document_lc[0]->rank }}').trigger('change');
	@endif

	// DOCUMENT LC
	index = 0;
	@foreach($applicant->document_lc as $data)
		addDocu('lc');
	@endforeach
	@foreach($applicant->document_lc as $data)
		inputs = $('#docu .lc input, #docu .lc select');
		i = (index * 10);

		checkIfExisting($(inputs[i]), "{!! $data->type !!}");
		checkIfExisting($(inputs[i+1]), "{!! $data->issuer !!}");

        regulations = JSON.parse('{!! $data->regulation !!}');
        regulations.forEach(option => {
        	checkIfExisting($(inputs[i+2]), option);
        });

        inputs[i+4].value = '{{ $data->no }}';

	    $(inputs[i+5]).flatpickr(config).setDate("{{ $data->issue_date }}", true);
		$(inputs[i+7]).flatpickr(config2).setDate("{{ $data->expiry_date }}", true);

		$($(inputs[i+7]).parent().parent()).prepend(`
	        <input type="hidden" name="id-{{ $data->id }}" value="{{ $data->id }}" data-type="id">
		`);
		index++;
	@endforeach

	var flags = [];
	@foreach($applicant->document_flag as $key => $datas)
		addDocu('Flag');
		country = $($('.docu-country')[{{ $loop->index }}]);
		$(country).val("{{ $key }}").trigger('change');
		// countries.push("{{ $key }}");
		flags["{{ $key }}"] = [];
		flags["{{ $key }}"].push(JSON.parse('{!! json_encode($datas) !!}'));
	@endforeach

	// console.log(flags);
	for(datas in flags){
		console.log(datas);
		console.log(flags[datas]);
		for(data in datas){
			// console.log(data);
		}
	}
	// index = 0;
	// 	inputs = $(`.flag${$(country).data('fdcount')}-documents input`);
	// 	i = (index * 7);

	// 	checkIfExisting($(inputs[i]), "{!! $data->type !!}");
		
 //    	inputs[i+1].value = '{{ $data->number }}';

	//     $(inputs[i+2]).flatpickr(config).setDate("{{ $data->issue_date }}", true);
	// 	$(inputs[i+4]).flatpickr(config2).setDate("{{ $data->expiry_date }}", true);

	// 	index++;

	document.getElementById("preview").src = "{!! asset($applicant->user->avatar) !!}";
	// console.log("{ $data->avatar !!}");

	$('html, body').animate({
        scrollTop: $(".Flag").offset().top - 200
    }, 2000);
</script>
