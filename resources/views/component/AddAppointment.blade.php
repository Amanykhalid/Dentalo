<!-- Start Add Appointment Modal -->
<div class="modal fade" id="addAppointment" tabindex="-1" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AppointmentTitle">Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/addAppointment/0" method="POST">
                    @csrf
                    <input type="text" name="patientName" class="form-control" placeholder="Patient Name" required>
                    <input type="date" name="date" class="form-control" placeholder="Date" required>
                    <input type="time" name="time" class="form-control" placeholder="Time" required>
                    <input type="text" name="note" class="form-control" placeholder="Note" required>
                    <button type="submit" class="btn btn-block">Add Appointment</button>
                </form>
            </div>  
        </div>
    </div>
</div>
<!-- End Add Appointment Modal -->