
@extends('component/layout')
@section('contant')
{{-- @if (Session::has('user') && (session()->get('user')['userType']=='Dentist')) --}}
@if ($error = Session::get('alert-success'))
	<div class="alert alert-success">
		{{ $error }}
	</div>
@endif

@stop


