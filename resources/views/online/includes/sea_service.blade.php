<div id="sea-services"></div>

@push('before-scripts')
    <script src="{{ asset('js/moment-range.js') }}"></script>

    <script>
        window['moment-range'].extendMoment(moment);
        var imo = {};
        var imoString = "";
		
		// INIT GET VESSELS
        @if(!isset($edit))
		  getVessels(true);
        @endif
        function addSS(){
            addSS2();
        }

        function addSS2(){
            let count = parseInt($('.ssCount')[0].innerText) + 1;

            let string = `
                <div class="row ss">
                    
                    <span class="fa fa-times fa-2x" onclick="deleteRow(this, 'ss')"></span>

                    <div class="form-group col-md-3">
                        <label for="imo${count}">IMO Number</label>
                        <select class="form-control" name="imo${count}">
                            <option value=""></option>
                            ${imoString}
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="imo${count}Error"></strong>
                        </span>
                    </div>

                    <div class="col-md-9" style="width: 100%;"></div>
                    
                    <div class="form-group col-md-3">
                        <label for="vessel_name${count}">Vessel Name</label>
                        <input type="text" class="form-control" name="vessel_name${count}" placeholder="Enter Vessel Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="vessel_name${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="rank${count}">Rank</label>
                        <select class="form-control" name="rank${count}">
                            <option value=""></option>
                            ${rankString2}
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="rank${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="vessel_type${count}">Vessel Type</label>

                        <select class="form-control" name="vessel_type${count}">
                            <option value=""></option>
                            <option value="BULK CARRIER">BULK CARRIER</option>
                            <option value="BULK CARRIER (LOG)">BULK CARRIER (LOG)</option>
                            <option value="CONTAINER">CONTAINER</option>
                            <option value="CAR CARRIER">CAR CARRIER</option>
                            <option value="GENERAL CARGO">GENERAL CARGO</option>
                            <option value="OIL/CHEM">OIL/CHEM</option>
                            <option value="PROD. TANKER">PROD. TANKER</option>
                            <option value="LNG">LNG</option>
                            <option value="VLCC">VLCC</option>
                            <option value="WOODCHIP">WOODCHIP</option>
                            <option value="PURSE SEINER">PURSE SEINER</option>
                            <option value="LONGLINER">LONGLINER</option>
                            <option value="TRAWLER">TRAWLER</option>
                            <option value="SQUID JIGGER">SQUID JIGGER</option>
                            <option value="LONGLINER (TUNA)">LONGLINER (TUNA)</option>
                        </select>

                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="vessel_type${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="smc${count}">Year Built</label>
                        <input type="text" class="form-control" name="smc${count}" placeholder="Enter Year">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="smc${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="gross_tonnage${count}">GRT</label>
                        <input type="text" class="form-control" name="gross_tonnage${count}" placeholder="Enter GRT">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="gross_tonnage${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="engine_type${count}">Engine Type</label>
                        <input type="text" class="form-control" name="engine_type${count}" placeholder="Enter Engine Type">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="engine_type${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="bhp_kw${count}">BHP/KW</label>
                        <input type="text" class="form-control" name="bhp_kw${count}" placeholder="Enter BHP/KW">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="bhp_kw${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="flag${count}">Flag</label>
                        <input type="text" class="form-control" name="flag${count}" placeholder="Enter Flag">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="flag${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="trade${count}">Trade</label>

                        <select class="form-control" name="trade${count}">
                            <option value=""></option>
                            <option value="WORLDWIDE">WORLDWIDE</option>
                            <option value="FAR EAST">FAR EAST</option>
                            <option value="MIDDLE EAST">MIDDLE EAST</option>
                            <option value="DOMESTIC">DOMESTIC</option>
                        </select>

                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="trade${count}Error"></strong>
                        </span>
                    </div>

                    <div class="col-md-12" style="width: 100%;"></div>

                    <div class="form-group col-md-3">
                        <label for="previous_salary${count}">Previous Salary</label>
                        <input type="text" class="form-control" name="previous_salary${count}" placeholder="Enter Previous Salary">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="previous_salary${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="manning_agent${count}">Manning Agent</label>
                        <input type="text" class="form-control" name="manning_agent${count}" placeholder="Enter Manning Agent">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="manning_agent${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="principal${count}">Principal</label>
                        <input type="text" class="form-control" name="principal${count}" placeholder="Enter Principal">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="principal${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="crew_nationality${count}">Crew Nationality</label>

                        <select class="form-control" name="crew_nationality${count}">
                            <option value=""></option>
                            <option value="FULL CREW">FULL CREW</option>
                            <option value="MIXED CREW">MIXED CREW</option>
                        </select>

                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="crew_nationality${count}Error"></strong>
                        </span>
                    </div>

                    <div class="col-md-12" style="width: 100%;"></div>
                    
                    <div class="form-group col-md-3">
                        <label for="sign_on${count}">Sign On</label>
                        <input type="text" class="form-control sign-on" name="sign_on${count}" placeholder="Sign On Date">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="sign_on${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sign_off${count}">Sign Off</label>
                        <input type="text" class="form-control sign-off" name="sign_off${count}" placeholder="Sign Off Date">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="sign_off${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="remarks${count}">Remarks</label>
                        <input type="text" class="form-control" name="remarks${count}" placeholder="Remarks" id="autoComplete">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="remarks${count}Error"></strong>
                        </span>
                    </div>
                </div>
                <hr>
            `;
            
            $('#sea-services').append(string);
            $(`[name="trade${count}"]`).select2({
                placeholder: 'Select Trade',
                tags: true
            });
            $(`[name="crew_nationality${count}"]`).select2({
                placeholder: 'Select Crew Nationality',
                tags: true
            });

            $(`[name="imo${count}"]`).select2({
                placeholder: 'Select or Input IMO',
                tags: true
            });

            $(`[name="vessel_type${count}"]`).select2({
                placeholder: 'Select or input Type',
                tags: true
            });

            // $(`[name="vessel_name${count}"]`).select2({
            //     placeholder: 'Select or Input Vessel',
            //     tags: true
            // });

            $(`[name="rank${count}"]`).select2({
                placeholder: 'Select Rank',
            });

            $(`[name="sign_off${count}"], [name="sign_on${count}"]`).flatpickr({
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: moment().format('YYYY-MM-DD')
            });
            $('.ssCount')[0].innerText = count;

            // CHECK IF NO CONFLICT IN DATES
            // $(`[name="sign_off${count}"], [name="sign_on${count}"]`).change(e => {
            //     checkOverlap(e.target, $(e.target).hasClass('sign-on') ? 'sign-on' : 'sign-off');
            // });

            let count2 = $('.ss').length;

            // AUTO FILL SEA SERVICE
            // $(`[name="vessel_name${count}"]`).change(e => {

                // let vessel = $(`[name="vessel_name${count}"]`);
            //     let vessel = $(e.target);
            //     let selectedVessel = vessel.val();
            //     let parent = vessel.parent().parent();

                
            //     if(savedVessels[selectedVessel] != undefined){
            //         parent.find('[name^="imo"]').val(savedVessels[selectedVessel].imo);
            //         parent.find('[name^="vessel_type"]').val(savedVessels[selectedVessel].type);
            //         parent.find(`[name^="gross_tonnage"]`).val(savedVessels[selectedVessel].gross_tonnage);
            //         parent.find(`[name^="engine_type"]`).val(savedVessels[selectedVessel].engine);
            //         parent.find(`[name^="bhp_kw"]`).val(savedVessels[selectedVessel].BHP);
            //         parent.find(`[name^="flag"]`).val(savedVessels[selectedVessel].flag);
            //         parent.find(`[name^="trade"]`).val(savedVessels[selectedVessel].trade);
            //         parent.find(`[name^="manning_agent"]`).val(savedVessels[selectedVessel].manning_agent);
            //         parent.find(`[name^="principal"]`).val(savedVessels[selectedVessel].principal.name);
            //         parent.find(`[name^="crew_nationality"]`).val(savedVessels[selectedVessel].crew_nationality);
            //     }
            // });

            $(`[name="imo${count}"]`).change(e => {

                // let vessel = $(`[name="vessel_name${count}"]`);
                let vessel = $(e.target);
                let selectedVessel = vessel.val();
                let parent = vessel.parent().parent();
                
                if(imo[selectedVessel] != undefined){
                    parent.find('[name^="vessel_name"]').val(imo[selectedVessel].name);
                    parent.find('[name^="vessel_type"]').val(imo[selectedVessel].type);
                    parent.find(`[name^="gross_tonnage"]`).val(imo[selectedVessel].gross_tonnage);
                    parent.find(`[name^="engine_type"]`).val(imo[selectedVessel].engine);
                    parent.find(`[name^="bhp_kw"]`).val(imo[selectedVessel].BHP);
                    parent.find(`[name^="flag"]`).val(imo[selectedVessel].flag);
                    parent.find(`[name^="trade"]`).val(imo[selectedVessel].trade);
                    parent.find(`[name^="manning_agent"]`).val(imo[selectedVessel].manning_agent);
                    parent.find(`[name^="principal"]`).val(imo[selectedVessel].pname);
                    parent.find(`[name^="crew_nationality"]`).val(imo[selectedVessel].crew_nationality);
                    parent.find(`[name^="smc"]`).val(imo[selectedVessel].year_build);
                }
            });     
        }

        function checkOverlap(input, type){ 
            let on = "";
            let off = "";

            let conflict = 0;
            let conflicts = [];

            if(type == "sign-on"){
                let temp = $(input).parent().parent().find('.sign-off')[0]; 

                on = input.value;
                off = temp.value;
                conflicts.push($(input));
                conflicts.push($(temp));
            }
            else{
                let temp = $(input).parent().parent().find('.sign-on')[0]; 

                off = input.value;
                on = temp.value;
                conflicts.push($(temp));
                conflicts.push($(input));
            }


            if(on != "" && off != ""){
                let sign_ons = $('.sign-on:not(:visible)');
                let sign_offs = $('.sign-off:not(:visible)');

                let length = sign_ons.length;
                
                for(let i = 0; i < length; i++){
                    let on2 = sign_ons[i].value;
                    let off2 = sign_offs[i].value;

                    clearError(sign_ons[i], $(sign_ons[i]), $('#' + $(sign_ons[i]).attr('name') + 'Error'));
                    clearError(sign_offs[i], $(sign_offs[i]), $('#' + $(sign_offs[i]).attr('name') + 'Error'));

                    if(on2 != "" && off2 != ""){
                        let range1 = moment().range(on, off);
                        let range2 = moment().range(on2, off2);

                        if(range1.overlaps(range2)){
                            conflict++;

                            conflicts.push($(sign_ons[i]));
                            conflicts.push($(sign_offs[i]));
                        }
                    }
                }
            }

            if(conflict > 1){
                swal({
                    type: 'error',
                    title: 'Conflict in dates',
                })

                conflicts.forEach(input => {
                    showError(input[0], input, $('#' + input.attr('name') + 'Error'), 'Date range conflict');
                });
            }
        }

        function getVessels(flag = true){
            $.ajax({
                url: '{{ route('vessels.getAll') }}',
                dataType: 'json',
                success: vessels => {
                    vessels.forEach(vessel => {
                        if(imo[vessel.imo] == undefined){
                            if(vessel.imo != null){
                                imo[vessel.imo] = vessel;
                                imoString += `
                                    <option value="${vessel.imo}">${vessel.imo} (${vessel.name})</option>
                                `;
                            }
                        }
                    });

					if(!flag){
						addSS2();
					}
                }
            });
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        
    </script>
@endpush