<div class="changePassword">
    <div class="container mainForm">
        <form action="/resetPass" method="POST">
            @csrf
            <div class="row">
                <h3> <i class="fas fa-lock-open"></i> Change Password</h3>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-4">
                    <label for="CurrentPassword">Current PaasWord</label>
                </div>
                <div class="col-md-4">
                    <input type="password" name="CurrentPassword" id="CurrentPassword" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-4">
                    <label for="NewPassword">New PaasWord</label>
                </div>
                <div class="col-md-4">
                    <input type="password" name="NewPassword" id="NewPassword" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="offset-md-2 col-md-4">
                    <label for="ConNewPassword">Confirm New PaasWord</label>
                </div>
                <div class="col-md-4">
                    <input type="password" name="ConNewPassword" id="ConNewPassword" class="form-control">

                </div>
            </div>
            <div class="row butt">
                <button class="btn btn-block"> Reset</button><br>
                @if ($error = $errors->first('password'))
                <div class="alert alert-danger">
                  <i class="fas fa-times-circle"></i>{{ $error }} 
                </div>
              @endif
            </div>
        </form>
    </div>
    
</div>