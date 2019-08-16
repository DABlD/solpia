{{ dd('zxcasdasdasdasdasd') }}
<form action="{{ route('logout') }}" method="POST" id="form">@csrf</form>
<script>document.getElementById("form").submit();</script>