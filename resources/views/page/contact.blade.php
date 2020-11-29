@extends('component/layout')
@section('contant')
<form  class="ConectUs" method="POST" action="/sendMassage">
    @csrf
    <div class="container">
        <h3>Contact  With Us Now ..</h3>
        <div class="row">
            <div class="col-md-6">
                <input name = "FirstName"
                  placeholder="First Name" class="input form-control" required/><br/>
            </div>
            <div class=" col-md-6">
                <input name = "LastName"
                      placeholder="Last Name" class="input form-control" required/><br/>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <input name = "Phone"
                  placeholder="Phone Number" class="input form-control" required/><br/>
            </div>
            <div class=" col-md-6">
                <input name = "Email"
                      placeholder="Email" class="input form-control" required/><br/>
            </div>
        </div>
    </div>
    <div class="container">
        <textarea name="Massage"  cols="30" rows="5"  placeholder="Massage Here" class="input form-control textarea" required></textarea>
    </div>
    <div class="container">
        <button class="btn btn-block" data-toggle="modal" data-target="#Done">Contact Now </button>
        @if ($Success ?? '' ?? '' == $Success ?? '' ?? ''->first('Done'))
        <h4>
            Thx {{$Success ?? '' ?? ''}} For Massage , We will contact you soon via e-mail
        </h4>
        @endif
    </div> 
</form>
@endsection