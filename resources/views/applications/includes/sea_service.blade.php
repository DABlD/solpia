<div id="sea-services"></div>

@push('before-scripts')
    <script>
        var savedVessels = {};
        var savedVesselsString = "";

        var availableRanksString = `
            <option></option>
            @foreach($categories as $category => $ranks)
                <optgroup label="{{ $category }}"></optgroup>
                @foreach($ranks as $rank)
                    <option value="{{ $rank->name }}">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $rank->name }} ({{ $rank->abbr }})
                    </option>
                @endforeach
            @endforeach
        `;

        function addSS(){
            savedVesselsString == "" ? getVessels() : addSS2();
        }

        function addSS2(){
            let count = parseInt($('.ssCount')[0].innerText) + 1;

            let string = `
                <div class="row ss">
                    
                    <span class="fa fa-times fa-2x" onclick="deleteRow(this, 'ss')"></span>
                    <div class="form-group col-md-3">
                        <label for="vessel_name${count}">Vessel Name</label>
                        <select class="form-control" name="vessel_name${count}">
                            <option value=""></option>
                            ${savedVesselsString}
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="vessel_name${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="rank${count}">Rank</label>
                        <select class="form-control" name="rank${count}">
                            <option value=""></option>
                            ${availableRanksString}
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="rank${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="vessel_type${count}">Vessel Type</label>
                        <input type="text" class="form-control" name="vessel_type${count}" placeholder="Enter Vessel Type">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="vessel_type${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="gross_tonnage${count}">Gross Tonnage</label>
                        <input type="text" class="form-control" name="gross_tonnage${count}" placeholder="Enter Gross Tonnage">
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
                        <input type="text" class="form-control" name="trade${count}" placeholder="Enter Trade">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="trade${count}Error"></strong>
                        </span>
                    </div>
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
                        <input type="text" class="form-control" name="crew_nationality${count}" placeholder="Crew Nationality">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="crew_nationality${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sign_on${count}">Sign On</label>
                        <input type="text" class="form-control" name="sign_on${count}" placeholder="Sign On Date">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="sign_on${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="sign_off${count}">Sign Off</label>
                        <input type="text" class="form-control" name="sign_off${count}" placeholder="Sign Off Date">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="sign_off${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="remarks${count}">Remarks</label>
                        <input type="text" class="form-control" name="remarks${count}" placeholder="Remarks">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="remarks${count}Error"></strong>
                        </span>
                    </div>

                </div>
                <hr>
            `;
            
            $('#sea-services').append(string);
            $(`[name="vessel_name${count}"]`).select2({
                placeholder: 'Select or Input Vessel',
                tags: true
            });

            $(`[name="rank${count}"]`).select2({
                placeholder: 'Select Rank',
            });

            $(`[name="vessel_name${count}"]`).change(() => {
                let selectedVessel = $(`[name="vessel_name${count}"]`).val();
                if(savedVessels[selectedVessel] != undefined){
                    $(`[name="vessel_type${count}"]`).val(savedVessels[selectedVessel].type);
                    $(`[name="gross_tonnage${count}"]`).val(savedVessels[selectedVessel].gross_tonnage);
                    $(`[name="engine_type${count}"]`).val(savedVessels[selectedVessel].engine);
                    $(`[name="bhp_kw${count}"]`).val(savedVessels[selectedVessel].BHP);
                    $(`[name="flag${count}"]`).val(savedVessels[selectedVessel].flag);
                    $(`[name="trade${count}"]`).val(savedVessels[selectedVessel].trade);
                    $(`[name="manning_agent${count}"]`).val(savedVessels[selectedVessel].manning_agent);
                    $(`[name="principal${count}"]`).val(savedVessels[selectedVessel].principal.name);
                    $(`[name="crew_nationality${count}"]`).val(savedVessels[selectedVessel].crew_nationality);
                }
            });

            $(`[name="sign_off${count}"], [name="sign_on${count}"]`).flatpickr({
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: moment().format('YYYY-MM-DD')
            });
            $('.ssCount')[0].innerText = count;
        }

        function getVessels(){
            savedVesselsString = "";

            $.ajax({
                url: '{{ route('vessels.getAll') }}',
                dataType: 'json',
                success: vessels => {
                    vessels.forEach(vessel => {
                        savedVessels[vessel.name] = vessel;
                        savedVesselsString += `
                            <option value="${vessel.name}">${vessel.name}</option>
                        `;
                    });
                    addSS2();
                }
            });
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        
    </script>
@endpush