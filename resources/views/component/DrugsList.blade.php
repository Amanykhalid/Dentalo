@php
use App\Http\Controllers\DentistController;
$dentist=new DentistController();
$alldrugs=$dentist->allDrugs();
@endphp

<div class="drugsList">
    <div class="container mainForm">
        <div class="row">
            <h3> <i class="fas fa-pills"></i> Drugs List</h3>
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
                <button class="btn" data-toggle="modal" data-target="#addDrug">Add Drug</button>
            </div>
        </div>

        <div class="row rowHeader">
            <div class="col-md-1">No.</div>
            <div class="col-md-2">Drug Name</div>
            <div class="col-md-2">Generic Name</div>
            <div class="col-md-2">Brand Name</div>
            <div class="col-md-2">Cost</div>
            <div class="col-md-1">Update</div>
            <div class="col-md-1">Delete</div>
        </div>
        <div class="allitems">
            @foreach ($alldrugs as $indx=>$item)
                <div class="row">
                    <div class="col-md-1">{{$indx+1}}</div>
                    <div class="col-md-2">{{$item->DrugName}}</div>
                    <div class="col-md-2">{{$item->GenericName}}</div>
                    <div class="col-md-2">{{$item->BrandName}}</div>
                    <div class="col-md-2">{{$item->Cost}}</div>
                    <div class="col-md-1">
                            <button class="btn" type="submit" data-toggle="modal" data-target="#editDrug{{$item->id}}">
                              <i class="fas fa-edit"></i>
                            </button>
                        <!-- Start Edit Drug Modal -->
                        <div class="modal fade" id="editDrug{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel2">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-pills"></i> Edit Drug</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    <form action="/editDrug/{{$item->id}}" method="POST">
                                            @csrf
                                            <input type="text" name="DrugName" class="form-control" required value="{{$item->DrugName}}">
                                            <input type="text" name="GenericName" class="form-control"value="{{$item->GenericName}}" required>
                                            <input type="text" name="BrandName" class="form-control" value="{{$item->BrandName}}" required>
                                            <input type="text" name="Cost" class="form-control" value="{{$item->Cost}}" required>
                                            <button type="submit" class="btn btn-block">Edit Drug</button>
                                        </form>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <!-- End Edit Drug Modal -->
                    </div>
                    <div class="col-md-1">
                        <form action="/deleteDrug/{{$item->id}}" method="POST">
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
     


    <!-- Start Add Drug Modal -->
    <div class="modal fade" id="addDrug" tabindex="-1" aria-labelledby="exampleModalLabel2">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AppointmentTitle"><i class="fas fa-pills"></i> Add Drug</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/addDrug" method="POST">
                        @csrf
                        <input type="text" name="DrugName" class="form-control" placeholder="Drug Name" required>
                        <input type="text" name="GenericName" class="form-control" placeholder="Generic Name" required>
                        <input type="text" name="BrandName" class="form-control" placeholder="Brand Name" required>
                        <input type="text" name="Cost" class="form-control" placeholder="Cost" required>
                        <button type="submit" class="btn btn-block">Add Drugs</button>
                    </form>
                </div>  
            </div>
        </div>
    </div>
<!-- End Add End Modal -->
 
</div>