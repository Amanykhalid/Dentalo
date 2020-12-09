 <!-- Start Add Appointment Modal -->
 <div class="modal fade" id="addAppointment" tabindex="-1" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AppointmentTitle"><i class="far fa-calendar-check"></i>Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  method="POST" class="appointForm">
                    @csrf
                    <input type="text" style="display: none;" class="form-control" value="0" name="appoint_id">
                    <input type="text" name="patientName" class="form-control" placeholder="Patient Name" required>
                    <input type="date" name="date" class="form-control" placeholder="Date" required>
                    <input type="time" name="time" class="form-control" placeholder="Time" required>
                    <input type="text" name="note" class="form-control" placeholder="Note" required>
                    <button class="btn btn-block ajaxApointment">Add Appointment</button>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- End Add Appointment Modal -->