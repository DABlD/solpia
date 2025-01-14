<div id="FD"></div>

@push('before-scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>

    <script>
        $('#FD').append(`
            <u><h3><strong>Father</strong></h3></u>
            <div class="Father"></div>
            <span class="FatherCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Father')">
                <span class="fa fa-plus"></span>
                Father
            </a>

            <u><h3><strong>Mother</strong></h3></u>
            <div class="Mother"></div>
            <span class="MotherCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Mother')">
                <span class="fa fa-plus"></span>
                Mother
            </a>

            <u><h3><strong>Spouse</strong></h3></u>
            <div class="Spouse"></div>
            <span class="SpouseCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Spouse')">
                <span class="fa fa-plus"></span>
                Spouse
            </a>

            <u><h3><strong>Partner</strong></h3></u>
            <div class="Partner"></div>
            <span class="PartnerCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Partner')">
                <span class="fa fa-plus"></span>
                Partner
            </a>
            
            <u><h3><strong>Son</strong></h3></u>
            <div class="Son"></div>
            <span class="SonCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Son')">
                <span class="fa fa-plus"></span>
                Son
            </a>
            
            <u><h3><strong>Daughter</strong></h3></u>
            <div class="Daughter"></div>
            <span class="DaughterCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Daughter')">
                <span class="fa fa-plus"></span>
                Daughter
            </a>
            
            <u><h3><strong>Beneficiary</strong></h3></u>
            <div class="Beneficiary"></div>
            <span class="BeneficiaryCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Beneficiary')">
                <span class="fa fa-plus"></span>
                Beneficiary
            </a>
        `);

        function addFD(type){
            let fd_class2 = 'form-control';

            let count = parseInt($(`.${type}Count`)[0].innerText);

            if(type == 'Spouse' || type == 'Partner'){
                if(count != 0){
                    swal({
                        type: 'error',
                        title: 'Only 1 spouse is allowed',
                        showConfirmButton: false,
                        timer: 800
                    });

                    return;
                }
            }
            else if(type == 'Mother' || type == 'Father'){
                if(count != 0){
                    swal({
                        type: 'error',
                        showConfirmButton: false,
                        timer: 800
                    });

                    return;
                }
            }

            $(`.${type}Count`)[0].innerText = count + 1;

            count = $('.fd').length + 1;

            let fd_class = 'form-control';
            let fd_class3 = 'form-control';

            let fname = 'fd-fname';
            let mname = 'fd-mname';
            let lname = 'fd-lname';
            let suffix = 'fd-suffix';
            let age = 'fd-age';
            let birthday = 'fd-birthday';
            let occupation = 'fd-occupation';
            let address = 'fd-address';
            let email = 'fd-email';

            let string = `
                <div class="row fd">
                    
                    <span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
                    <input type="hidden" name="fd-type${count}" value="${type}">
                    <div class="form-group col-md-3">
                        <label for="fd-lname${count}">Last Name</label>
                        <input type="text" class="${fd_class} ${lname}" name="${lname}${count}" placeholder="Enter Last Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-lname${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-fname${count}">First Name</label>
                        <input type="text" class="${fd_class} ${fname}" name="${fname}${count}" placeholder="Enter First Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-fname${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-mname${count}">Middle Name</label>
                        <input type="text" class="${fd_class} ${mname}" name="${mname}${count}" placeholder="Enter Middle Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-mname${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-suffix${count}">Suffix</label>
                        <input type="text" class="${fd_class} ${suffix}" name="${suffix}${count}" placeholder="Enter Suffix">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-suffix${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-birthday${count}">Birthday</label>
                        <input type="text" class="${fd_class} ${birthday}" name="${birthday}${count}" placeholder="Select Birthday">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-birthday${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-age${count}">Age</label>
                        <input type="number" class="${fd_class} ${age}" name="${age}${count}" placeholder="Enter Age">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-age${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-occupation${count}">Occupation</label>
                        <input type="text" class="${fd_class2} ${occupation}" name="${occupation}${count}" placeholder="Enter Occupation">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-occupation${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-email${count}">Contact (Email, Tel, Mobile, etc.)</label>
                        <input type="email" class="${fd_class3} ${email}" name="${email}${count}" placeholder="Enter Contact">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-email${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="fd-address${count}">Address</label>
                        <input type="text" class="${fd_class} ${address}" name="${address}${count}" placeholder="Enter Address">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-address${count}Error"></strong>
                        </span>
                    </div>
                </div>
                <hr>`;
            // </div>`;

            // appendFD(string, ctr? ` .${type}` : '');
            appendFD(string, ` .${type}`);
            $(`[name="${birthday}${count}"]`).flatpickr({
                altInput: true,
                altFormat: 'F j, Y',
                dateFormat: 'Y-m-d',
                maxDate: moment().format('YYYY-MM-DD')
            });

            $(`[name="${birthday}${count}"]`).change(e => {
                $(`[name="${age}${count}"]`).val(moment().diff(e.target.value, 'years'));
            });

            // MOVE COUNT AND BUTTON
            // if($(`.${type}`).length == 1){
            //     $(`.${type}Count`).next().prependTo($(`.${type}`));
            //     $(`.${type}Count`).prependTo($(`.${type}`));
            // }
        }

        function appendFD(string, addClass = ""){
            $('#FD' + addClass).append(string);
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        
    </script>
@endpush