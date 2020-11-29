{{-- Start Model  --}}
<div class="modal fade" id="@yield('modelId')" tabindex="-1" aria-labelledby="exampleModalLabel3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-user-injured"></i> Edit Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @yield('modelBody')
            </div>  
        </div>
    </div>
</div>
<!-- End  Modal -->