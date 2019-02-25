<div id="FD"></div>

@push('before-scripts')
    <script>
        asd = () => {
            window.scrollTo(0,document.body.scrollHeight);
        }

        addFD('Father');
        addFD('Mother');

        function addFD(type){
            let count = $('.fd').length + 1;
            let ctr = 1;

            let fd_class = 'form-control aeigh';

            let name = 'fd-name';
            let age = 'fd-age';
            let birthday = 'fd-birthday';
            let occupation = 'fd-occupation';
            let address = 'fd-address';

            if(type == 'Father' || type == 'Mother' || $(`.${type}`).length == 0){
                // console.log('zxc');
                appendFD(`<div class="${type}"><u><h3><strong>${type}</strong></h3></u>`);
                ctr = 0;
            }
            else{
                appendFD('<div>');
            }

            let string = `
                <div class="row fd">
                    <input type="hidden" class="fd-type" value="${type}">
                    <div class="form-group col-md-3">
                        <label for="fd-name${count}">Name</label>
                        <input type="text" class="${fd_class} ${name}" name="${name}${count}" placeholder="Enter Name">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-name${count}Error"></strong>
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
                        <label for="fd-birthday${count}">Birthday</label>
                        <input type="text" class="${fd_class} ${birthday}" name="${birthday}${count}" placeholder="Select Birthday">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-birthday${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="fd-occupation${count}">Occupation</label>
                        <input type="text" class="${fd_class} ${occupation}" name="${occupation}${count}" placeholder="Enter Occupation">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-occupation${count}Error"></strong>
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="fd-address${count}">Address</label>
                        <input type="text" class="${fd_class} ${address}" name="${address}${count}" placeholder="Enter Address">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="fd-address${count}Error"></strong>
                        </span>
                    </div>
                </div>
                <hr>
            </div>`;

            // appendFD(string, ctr? ` .${type}` : '');
            appendFD(string, ` .${type}`);
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