@php
use App\Http\Controllers\DentistController;
$dentist=new DentistController();
$allProcedures=$dentist->allProcedures();
@endphp

<div class="procedures">
    <div class="container mainForm">
        <div class="row">
            <h3> <i class="fas fa-tooth"></i> Procedures List</h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group flex-nowrap">
                    <div class="input-group-prepend">
                         <span class="input-group-text"
                          id="addon-wrapping"><i class="fas fa-search"></i></span>
                     </div>
                         <input type="text" class="form-control"
                           placeholder="Search" aria-label="Search"
                           aria-describedby="addon-wrapping"/>
                </div>
            </div>
            <div class="col-md-4 offset-md-2">
                <button class="btn" data-toggle="modal" data-target="#addProcedure">Add Procedure</button>
            </div>
        </div>

        <div class="row rowHeader">
            <div class="col-md-2">No.</div>
            <div class="col-md-2">Procedure Name</div>
            <div class=" offset-md-4 col-md-1">Update</div>
            <div class="col-md-1">Delete</div>
        </div>
        <div class="allitems">
            @foreach ($allProcedures as $indx=>$item)
                <div class="row">
                    <div class="col-md-2">{{$indx+1}}</div>
                    <div class="col-md-2">{{$item->ProcedureName}}</div>
                    <div class="offset-md-4 col-md-1">
                            <button class="btn" type="submit" data-toggle="modal" data-target="#editProcedure{{$item->id}}">
                              <i class="fas fa-edit"></i>
                            </button>
                        <!-- Start Edit Procedure Modal -->
                        <div class="modal fade" id="editProcedure{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AppointmentTitle">Edit Procedure</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="/editProcedure/{{$item->id}}" method="POST">
                                            @csrf
                                            <input type="text" name="ProcedureName" class="form-control" required value="{{$item->ProcedureName}}">
                                            <button type="submit" class="btn btn-block">Edit Procedure</button>
                                        </form>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Procedure Modal -->
                    </div>
                    <div class="col-md-1">
                        <form action="/deleteProcedure/{{$item->id}}" method="POST">
                            @csrf
                            <button class="btn" type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
     


    <!-- Start Add Procedure Modal -->
    <div class="modal fade" id="addProcedure" tabindex="-1" aria-labelledby="exampleModalLabel2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-tooth"></i> Add Procedure</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/addProcedure" method="POST">
                        @csrf
                        <input type="text" name="ProcedureName" class="form-control" placeholder="Procedure Name" required>
                        <button type="submit" class="btn btn-block">Add Procedure</button>
                    </form>
                </div>  
            </div>
        </div>
    </div>
<!-- End Add Procedure Modal -->
</div>
