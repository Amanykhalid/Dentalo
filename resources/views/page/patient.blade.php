
@extends('component/layout')
@section('contant')
@if ($error = Session::get('alert-success'))
	<div class="alert alert-success">
		{{ $error }}
	</div>
@endif

@stop