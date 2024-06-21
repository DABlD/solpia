<div class="row">
    <div class="col-md-3">
        <div class="row" style="display: flex;">
            <div class="col-md-4 iLabel" style="margin: auto;">
                Filter by fleet
            </div>
            <div class="col-md-8 iInput">
                <select id="fleet" class="form-control">
                    <option value="%%">All Fleet</option>
                    <option value="FLEET A">FLEET A</option>
                    <option value="FLEET B">FLEET B</option>
                    <option value="FLEET C">FLEET C</option>
                    <option value="FLEET D">FLEET D</option>
                    <option value="FLEET E">FLEET E</option>
                    <option value="TOEI">TOEI</option>
                    @if(auth()->user()->fleet == "TOEI" || auth()->user()->role == "Admin")
                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->fleet }} - {{ auth()->user()->fname }}</option>
                    @endif
                    <option value="FISHING">FISHING</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row" style="display: flex;">
            <div class="col-md-4 iLabel" style="margin: auto;">
                Filter by Status
            </div>
            <div class="col-md-8 iInput">
                <select id="status" class="form-control">
                    <option value="%%">All</option>
                    <option value="AVAILABLE" selected>AVAILABLE</option>
                    <option value="COMPLETED">COMPLETED</option>
                    <option value="ON HOLD">ON HOLD</option>
                    <option value="CANCELLED">CANCELLED</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="row" style="display: flex;">
            <div class="col-md-4 iLabel" style="margin: auto;">
                Filter by Vessel
            </div>
            <div class="col-md-8 iInput">
                <select id="fVessel" class="form-control">
                    <option value="%%">All</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="pull-right">
@if(in_array(auth()->user()->role, ["Admin", "Crewing Officer", "Crewing Manager"]))
	<a class="btn btn-primary" data-toggle="tooltip" title="Add Requirement" onclick="create()">
		<span class="fa fa-plus"></span>
	</a>

    <a class="btn btn-success" data-toggle="tooltip" title="Export Requirements" onclick="exporto()">
        <span class="fa fa-file-text"></span>
    </a>
@endif
</div>