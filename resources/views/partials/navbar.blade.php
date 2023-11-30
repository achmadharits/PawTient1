  {{-- navbar --}}
  <header class='mb-3'>
    <nav class="navbar navbar-expand navbar-light navbar-top">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <iconify-icon icon="akar-icons:text-align-justified"></iconify-icon>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown ms-auto">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600">
                                  @auth('dokter')
                                    {{ Auth::guard('dokter')->user()->nama }}
                                  @endauth
                                  @auth('pasien')
                                    {{ Auth::guard('pasien')->user()->nama }}
                                  @endauth
                                  @guest
                                 {{-- // untu default --}}
                                  @endguest
                                </h6>
                                <p class="mb-0 text-sm text-gray-600"> 
                                  @auth('dokter')
                                    Dokter Hewan
                                  @endauth
                                  @auth('pasien')
                                    Pasien
                                  @endauth
                                </p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    @auth('dokter')
                                    <img src="{{ asset('asset/img/doc.png') }}">
                                    @endauth
                                    @auth('pasien')
                                    <img src="{{ asset('asset/img/patient-male.png') }}">
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                        <li>
                            <h6 class="dropdown-header">Menu</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('profil') }}">
                                Edit Profil
                            </a>
                        </li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                Keluar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
{{-- end of navbar --}}