<div id="EB"></div>

@push('before-scripts')
    <script>
        function addEB(){
            let count = parseInt($('.ebCount')[0].innerText) + 1;

            let string = `
                <div class="row ss">

                    <span class="fa fa-times fa-2x" onclick="deleteRow(this, 'eb')"></span>
                    <div class="form-group col-md-2">
                        <label for="vessel_name${count}">Type</label>
                        <select name="type${count}" class="form-control">
                            <option value="Elementary">Elementary</option>
                            <option value="High School">High School</option>
                            <option value="Vocational">Vocational</option>
                            <option value="Undergraduate">Undergrad</option>
                            <option value="College">College</option>
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="type${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="course${count}">Course</label>
                        <input type="text" class="form-control" name="course${count}" placeholder="Enter Course">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="course${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="from${count}">From</label>
                        <input type="text" class="form-control" name="from${count}" placeholder="Enter Start Year">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="from${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="to${count}">To</label>
                        <input type="text" class="form-control" name="to${count}" placeholder="Enter End Year">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="to${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="school${count}">School</label>
                        <select name="school${count}" class="form-control">
                            <option value=""></option>
                        </select>
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="school${count}Error"></strong>
                        </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="address${count}">Address</label>
                        <input type="text" class="form-control" name="address${count}" placeholder="Enter Address">
                        <span class="invalid-feedback hidden" role="alert">
                            <strong id="address${count}Error"></strong>
                        </span>
                    </div>

                </div>
                <hr>
            `;
            
            $('#EB').append(string);
            $('.ebCount')[0].innerText = count;

            $(`[name="school${count}"]`).select2({
                placeholder: 'Select School',
                tags: true,
                data: Object.values({!! $schools !!})
            });
        }
    </script>
@endpush

@push('after-scripts')
    <script>
        
    </script>
@endpush