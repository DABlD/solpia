@extends('layouts.error')

@section('code', 'Invalid Access')
@section('title', __('Error'))

@section('image')
<div style="background-image: url({{ asset('/svg/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message', __("You're not permitted to access this link"))