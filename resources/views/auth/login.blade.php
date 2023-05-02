@extends('layouts.form')
<head>
<title>
    Login - Ingresar
  </title>
</head>
@section('content')

<section>
      <div class="page-header min-vh-75">
        <div class="container" style="max-height: 680px;">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-1">
                <div align="center">
                  <a href="{{ url('/') }}">
                    <img src="assets/img/fon.gif" style="width: 190px; height: 190px;" alt="Logo">
                  </a>
                </div>
                <div class="card-header pb-0 text-center bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Bienvenido</h3>
               
                  @if($errors->any())
                  <p class="mb-0">Se encontro el siguiente error</p>
                  <div class="alert alert-danger" role="alert">
                   {{ $errors->first() }}
                  </div>
                  @else
                  <p class="mb-0">Digita tus credenciales para ingresar al sistema</p>
                  @endif
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('login') }}">
                  @csrf
                    <label>Correo Electrónico</label>
                    <div class="mb-3">
                      <input type="email" class="form-control" placeholder="Correo Electrónico" aria-label="Email" aria-describedby="email-addon" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <label>Contraseña</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Contraseña" aria-label="Password" aria-describedby="password-addon" name="password" required autocomplete="current-password">
                    </div>
                    <div class="form-check form-switch">
                      <a  href="{{ route('password.request') }}">  
                      <label style="padding-left: 34px;">¿Olvidaste tu contraseña?</label>
                      </a>
                    </div>
                    
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Ingresar</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register')}}" class="text-info text-gradient font-weight-bold">Registrate</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>
@endsection
