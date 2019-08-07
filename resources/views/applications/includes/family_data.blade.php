<div id="FD"></div>

@push('before-scripts')
    <script src="{{ asset('js/moment.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>

    <script>
        addFD('Father');
        addFD('Mother');

        $('#FD').append(`
            <u><h3><strong>Spouse</strong></h3></u>
            <div class="Spouse"></div>
            <span class="SpouseCount fd-count">0</span>
            <a class="btn btn-success" onclick="addFD('Spouse')">
                <span class="fa fa-plus"></span>
                Spouse
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

            if(type == 'Spouse' || type == 'Son' || type == 'Daughter' || type == 'Beneficiary'){
                let count = parseInt($(`.${type}Count`)[0].innerText);

                if(type == 'Spouse'){
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

                $(`.${type}Count`)[0].innerText = count + 1;
            }

            let count = $('.fd').length + 1;

            let fd_class = 'form-control';
            let fd_class3 = 'form-control';

            let name = 'fd-name';
            let age = 'fd-age';
            let birthday = 'fd-birthday';
            let occupation = 'fd-occupation';
            let address = 'fd-address';
            let email = 'fd-email';

            // if(type == 'Father' || type == 'Mother' || $(`.${type}`).length == 0){
            if(type == 'Father' || type == 'Mother'){
                appendFD(`<div class="${type}"><u><h3><strong>${type}</strong></h3></u>`);
            }
            // else{
            //     appendFD('<div>');
            // }

            let string = `
                <div class="row fd">
                    
                    <span class="fa fa-times fa-2x" onclick="deleteRow(this, '${type}')"></span>
                    <input type="hidden" name="fd-type${count}" value="${type}">
                    <div class="form-group col-md-3">
                        <label for="fd-name${count}">Name</label>
                        <input type="text" class="${fd_class} ${name}" name="${name}${count}" placeholder="Enter Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-name${count}Error"></strong>
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
                        <label for="fd-email${count}">Email</label>
                        <input type="email" class="${fd_class3} ${email}" name="${email}${count}" placeholder="Enter Email">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-email${count}Error"></strong>
                        </span>
                    </div>

                    <div class="form-group col-md-9">
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