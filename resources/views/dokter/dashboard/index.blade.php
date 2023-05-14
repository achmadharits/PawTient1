@extends('layouts.app')
@section('content')
@include('partials.sidebar')
<div id="main" class='layout-navbar'>
    @include('partials.navbar')
  {{-- main content --}}
  <div id="main-content">
      <div class="page-heading">
        <div class="page-title">
          <div class="row mb-4">
            <div class="col-12 col-md-6 order-md-1 order-last">
              <h3>Selamat datang, {{ Auth::guard('dokter')->user()->nama }}!</h3>
              @if(session()->has('error'))
              <div class="alert alert-light-danger color-danger">
                  {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
                  {{ session()->get('error') }}
              </div>
              @endif
            </div>
          </div>
        </div>

        <section class="section">
          <div class="card">
            <div class="card-body">
                <h5>Ini adalah dashboard dokter gigi</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Officiis nobis eius distinctio quisquam doloremque atque dignissimos, iure quae fugit tempore eum hic accusamus a provident, sint asperiores cupiditate? Reiciendis, eius!</p>
            </div>
          </div>
        </section>
      </div>
  </div>
  {{-- end of main content --}}
</div>
@endsection