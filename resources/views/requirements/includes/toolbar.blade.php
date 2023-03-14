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
                    <option value="FISHING">FISHING</option>
                </select>
            </div>
        </div>
    </div>
</div>

@if(in_array(auth()->user()->role, ["Admin", "Crewing Officer", "Crewing Manager"]))
    <div class="pull-right">
    	<a class="btn btn-success" data-toggle="tooltip" title="Add Requirement" onclick="create()">
    		<span class="fa fa-plus"></span>
    	</a>
    </div>
@endif