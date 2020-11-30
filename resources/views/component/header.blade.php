{{-- @php
    use App\Http\Controllers\DentistController;
    $var=new DentistController();
    $userInfo=$var->UserInfo();

@endphp --}}
<header class="mainHeader">
        <div class="row">

            {{-- Logo Start --}}
            <div class="offset-md-1 col-md-5">
                <img src="{{asset('image/lo-removebg-preview.png')}}" alt="logo2">
                <img src="{{asset('image/Dentalo.png')}}" alt="Logo">
                <div class="clearFix"></div>
            </div>
            {{-- Logo End  --}}

            {{-- NavBar Start --}}
            <div class="col-md-6">
                <nav class="navbar navbar-expand-lg">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">

                      <ul class="navbar-nav">
                        @if (!Session::has('user'))
                          <li class="nav-item">
                            <a class="nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="/Services">Services</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="/AboutUs">About Us</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="/ContactUs">Contact Us</a>
                          </li>
                        @else
                          <li class="nav-item">
                            <form class="form-inline my-2 my-lg-0">
                              <button class="btn btn-outline-success my-2 my-md-0" type="submit">Search</button>
                              <input class="form-control ml-md-2 mr-md-24" type="search" placeholder="Search" aria-label="Search">

                            </form>
                          </li>
                          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              {{-- @foreach ($userInfo as $item)
                              {{$item->firstName}}
                              @endforeach  --}}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="/logout">LogOut</a>
                            </div>
                          </li>
                        @endif
                      </ul>
          
                      
                    </div>
                  </nav>  
            </div>
            {{-- NavBar End  --}}


        </div>
</header>