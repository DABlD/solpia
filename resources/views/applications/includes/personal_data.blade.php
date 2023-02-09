<div class="row">
    <div class="form-group col-md-3">
        <label for="avatar">Picture</label>
        <input type="file" class="form-control" name="avatar" placeholder="Select Image" accept=".png, .jpg, .jpeg">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="avatarError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-12">
        <label for="avatar">Preview</label>
        <span style="color:red;">
            (Image is automatically resized to 200x200 for system performance. Please upload image in said resolution.)
        </span>
        <br>
        <div class="col-md-3">
            <img id="preview" alt="Select an image first" width="209px" height="196px">
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control aeigh" name="lname" placeholder="Enter Last Name">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="lnameError"></strong>
        </span>
    </div>
    <div class="form-group col-md-2">
        <label for="fname">First Name</label>
        <input type="text" class="form-control aeigh" name="fname" placeholder="Enter First Name" autofocus>
        <span class="invalid-feedback hidden" role="alert">
            <strong id="fnameError"></strong>
        </span>
    </div>
    <div class="form-group col-md-2">
        <label for="mname">Middle Name</label>
        <input type="text" class="form-control" name="mname" placeholder="Enter Middle Name">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="mnameError"></strong>
        </span>
    </div>
    <div class="form-group col-md-1">
        <label for="suffix">Suffix</label>
        <input type="text" class="form-control" name="suffix" placeholder="Enter Suffix">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="suffixError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="birthday">Date of birth</label>
        <input type="text" class="form-control" name="birthday" placeholder="Select Birthday">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="birthdayError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="age">Age</label>
        <input type="number" class="form-control" name="age" placeholder="Enter Age">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="ageError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="birth_place">Place of birth</label>
        <input type="text" class="form-control" name="birth_place" placeholder="Enter Place of Birth">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="birth_placeError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="religion">Religion</label>
        {{-- <input type="text" class="form-control" name="religion" placeholder="Enter Religion"> --}}
        <select class="form-control" name="religion">
            <option></option>
        </select>

        <span class="invalid-feedback hidden" role="alert">
            <strong id="religionError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="address">Address</label>
        <input type="text" class="form-control" name="address" placeholder="Enter Address">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="addressError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="contact">Contact Number</label>
        <input type="text" class="form-control" name="contact" placeholder="Enter Contact Number">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="contactError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="provincial_address">Provincial Address</label>
        <input type="text" class="form-control" name="provincial_address" placeholder="Enter Provincial Address">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="provincial_addressError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="provincial_contact">Provincial Number</label>
        <input type="text" class="form-control" name="provincial_contact" placeholder="Enter Provincial Contact Number">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="provincial_contacttError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Enter Email">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="emailError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="gender">Gender</label>
        <br>
        <label class="radio-inline">
            <input type="radio" name="gender" value="Male" checked> Male
        </label>
        &nbsp; &nbsp;
        <label class="radio-inline">
            <input type="radio" name="gender" value="Female"> Female
        </label>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        <label for="waistline">Waistline(inch)</label>
        <input type="number" class="form-control" name="waistline" placeholder="Enter Waistline">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="waistlineError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="shoe_size">Shoe Size(cm)</label>
        <input type="number" class="form-control" name="shoe_size" placeholder="Enter Shoe Size">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="shoe_sizeError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="clothes_size">Clothes Size</label>
        <select name="clothes_size" class="form-control">
            <option readonly selected value="">Select Clothes Size</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
            <option value="XXL">XXL</option>
            <option value="XXXL">XXXL</option>
        </select>
        <span class="invalid-feedback hidden" role="alert">
            <strong id="clothes_sizeError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        <label for="height">Height(cm)</label>
        <input type="number" class="form-control" name="height" placeholder="Enter Height" value="0">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="heightError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="weight">Weight(kg)</label>
        <input type="number" class="form-control" name="weight" placeholder="Enter Weight" value="0">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="weightError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="bmi">BMI</label>
        <input type="number" class="form-control" name="bmi" placeholder="Enter BMI" value="0">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="bmiError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-2">
        <label for="blood_type">Blood Type</label>
        <select name="blood_type" class="form-control">
            <option readonly selected value="">Select Blood Type</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
        </select>
        <span class="invalid-feedback hidden" role="alert">
            <strong id="blood_typeError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="civil_status">Civil Status</label>
        <select name="civil_status" class="form-control">
            <option readonly selected value="">Select Civil Status</option>
            <option value="Single">Single</option>
            <option value="Married">Married</option>
            <option value="Widowed">Widowed</option>
            <option value="Divorced">Divorced</option>
        </select>
        <span class="invalid-feedback hidden" role="alert">
            <strong id="civil_statusError"></strong>
        </span>
    </div>
{{-- </div>

<div class="row"> --}}
    <div class="form-group col-md-2">
        <label for="eye_color">Eye Color</label>
        <input type="text" class="form-control" name="eye_color" placeholder="Enter Eye Color" value="Black">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="eye_colorError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="tin">TIN No.</label>
        <input type="number" class="form-control" name="tin" placeholder="Enter TIN No.">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="tinError"></strong>
        </span>
    </div>
</div>

<div class="row">
    <div class="form-group col-md-6">
        <label for="sss">SSS No.</label>
        <input type="number" class="form-control" name="sss" placeholder="Enter SSS No.">
        <span class="invalid-feedback hidden" role="alert">
            <strong id="sssError"></strong>
        </span>
    </div>
</div>

@push('after-scripts')
    <script>
        $('[name="birthday"]').flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d',
            maxDate: moment().format('YYYY-MM-DD')
        });
        
        $('[name="birthday"]').change(e => {
            $('[name="age"]').val(moment().diff(e.target.value, 'years'));
        });

        $('[name="weight"], [name="height"]').change(() => {
            let weight = $('[name="weight"]').val();
            let height = $('[name="height"]').val() / 100;
            $('[name="bmi"]').val(Math.round( (weight / (height * height)) * 10 ) / 10);
        });

        let religions = Object.values(JSON.parse('{!! $religions !!}'));
        religions = religions.concat([
            'ROMAN CATHOLIC',
            'CATHOLIC',
            'BORN AGAIN CHRISTIAN',
            'PROTESTANTS',
            'MUSLIMS',
            'IGLESIA NI CRISTO',
            'BUDDHISTS'
        ]);

        $('[name="religion"]').select2({
            placeholder: 'Select Religion',
            data: Array.from(new Set(religions)),
            tags: true,
        });
    </script>
@endpush