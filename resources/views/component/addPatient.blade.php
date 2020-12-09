   <!-- Start Add Patient Modal -->
   <div class="modal fade addPatient" id="addPatient" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Patient</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-success success_msg" style="display: none;">  
                 <h5><i class="fas fa-check-circle"></i> Added New Patient Success</h5>
            </div>
            <div class="alert alert-danger filed_msg" style="display: none;">  
                <h5><i class="fas fa-times"></i> Patient Already Exits</h5>
           </div>
            <form id="patientForm1" method="POST">
                @csrf
                <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
                <input type="text" name="middleName" class="form-control" placeholder="Middle Name">
                <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
                <input type="date" name="birthDay" class="form-control" placeholder="Birth Day" required>
                <div class="genderform form-control">
                    <label for="gemder">Gender</label>
                    <input type="radio" name="gender" id="male" value="male" checked>
                        Male
                    <input  type="radio" name="gender" id="female" value="female">
                        Female
                </div>
                <input type="text" name="contact" class="form-control" placeholder="Contact No" required>
                <input type="email" name="email" class="form-control" placeholder="Email ">
                <input type="text" name="address" class="form-control" placeholder="Address" required>
                <input type="text" name="note" class="form-control" placeholder="Note">
                <button class="btn btn-block savePatient1">Add Patient</button>
            </form>
        
        </div>
    </div>
</div>
<!-- End Add Patient Modal -->