@if (!Session::has('user')) 
@extends('component/layout')
@section('contant')
    <div class="login-wrap">
        <div class="container">
          @if ($error = $errors->first('email'))
            <div class="alert alert-danger">
              <i class="fas fa-times-circle"></i>{{ $error }} 
            </div>
          @endif
            <ul class="nav nav-tabs">
              <li><a data-toggle="tab" href="#signIn" class="active">Sign In</a></li>
              <li><a data-toggle="tab" href="#signUp">Sign Up </a></li>
            </ul>
            <div class="tab-content">
              {{-- Login Start  --}}
              <div id="signIn" class="tab-pane fadeIn active">
                <h4>Start Sassion Now ...</h4>

                {{-- Login Form Start  --}}
                <form action="\login" method="POST">
                    @csrf
                    <label for="email">User Name</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <button type="submit" class="btn btn-block">Login</button>
                    @if ($error = $errors->first('password'))
                      <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i>{{ $error }} 
                      </div>
                    @endif
                </form>
                {{-- Login Form End  --}}

                <div class="hr"></div>
                <div class="foot-lnk">
                    <a href="#forgot">Forgot Password?</a>
                </div>
              </div>
              {{-- Login End  --}}

              {{-- Sign Up Start  --}}
              <div id="signUp" class="tab-pane fade">
                  <ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#Patient" class="active">Patient</a></li>
                    <li><a data-toggle="tab" href="#Dentist">Dentist </a></li>
                  </ul>
                  <div class="tab-content">
                      <div id="Patient" class="tab-pane fadeIn active Patient">
                          <form action="/patient" method="POST" enctype="multipart/form-data">
                              @csrf
                              <label for="firstName">First Name</label>
                              <input type="text" name="firstName" class="form-control" id="firstName" required>
                              <label for="lastName">Last Name</label>
                              <input type="text" name="lastName" class="form-control" id="lastName" required>
                              <label for="photoPat">Image</label>
                              <div class="ImgPat">
                                <input type="file" name="photoPat" id="photoPat" class="form-control inputfile" required>
                                <label for="photoPat"><i class="fas fa-camera"></i> Add Photo</label>
                              </div>
                              <label for="email">Email</label>
                              <input type="email" name="email" class="form-control" id="email" required>
                              <label for="password">Password</label>
                              <input type="password" name="password" class="form-control" id="password" required>
                              <button type="submit" class="btn btn-block">Sign Up</button>
                          </form>
                      </div>
                      <div id="Dentist" class="tab-pane fade Dentist">
                          <form action="/dentist" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label for="firstName">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" required>
                            <label for="lastName">Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="lastName" required>
                            <label for="photoDen">Image</label>
                            <div class="ImgPat">
                              <input type="file" name="photoDen" id="photoDen" class="form-control inputfile" required>
                              <label for="photoDen"><i class="fas fa-camera"></i> Add Photo</label>
                            </div>
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>

                            <h4>Clinic Information</h4>
                            <label for="clinicName" >Clinic Name</label>
                            <input type="text" name="clinicName" id="clinicName" class="form-control" required>
                            <label for="clinicPhone" >Clinic Phone</label>
                            <input type="number" name="clinicPhone" id="clinicPhone" class="form-control" required>
                            <label for="photoCli">Image</label>
                            <div class="ImgPat">
                              <input type="file" name="photoCli" id="photoCli" class="form-control inputfile" required>
                              <label for="photoCli"><i class="fas fa-camera"></i> Add Photo</label>
                            </div>
                            <label for="clinicAddress" >Clinic Address</label>
                            <input type="text" name="clinicAddress" id="clinicAddress" class="form-control" required>
                            <button type="submit" class="btn btn-block">Sign Up</button>
                          </form>
                    </div>
                  </div>
              </div>
              {{-- Sign Up End  --}}
            </div>
          </div>
        
    </div>
@endsection

@endif
