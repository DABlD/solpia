<div class="row">
    <div class="col-md-3">
        <div class="row" style="display: flex;">
            <div class="col-md-4 iLabel" style="margin: auto;">
                Filter by Fleet
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
                    <option value="%%" selected>All</option>
                    <option value="PASSED">PASSED</option>
                    <option value="REJECTED">REJECTED</option>
                    <option value="ON BOARD">ON BOARD</option>
                    <option value="FOR APPROVAL">FOR APPROVAL</option>
                    <option value="PENDING">PENDING</option>
                    <option value="FOR MEDICAL">FOR MEDICAL</option>
                </select>
            </div>
        </div>
    </div>
</div>

<br>

<div class="row">
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

    <div class="col-md-3">
        <div class="row" style="display: flex;">
            <div class="col-md-4 iLabel" style="margin: auto;">
                Filter by Rank
            </div>
            <div class="col-md-8 iInput">
                <select id="fRank" class="form-control">
                    <option value="%%">All</option>
                </select>
            </div>
        </div>
    </div>
</div>