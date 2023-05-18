@extends('layouts.form')
<head>
<title>
    Login - Registrarse
  </title>
</head>
@section('content')

<section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-1">
                <div align="center">
                  <a href="{{ url('/') }}">
                    <img src="assets/img/fon.gif" style="width: 190px; height: 190px;" alt="Logo">
                  </a>
                </div>
                <div class="card-header pb-0 text-center bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Registrarse</h3>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('register') }}">
                  @csrf
               
                    <label>Nombre</label>
                    <div class="mb-1">
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Digita tu nombre" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>       
                    <label>Correo Electrónico</label>
                    <div class="mb-1">
                      <input type="email" class="form-control" placeholder="Correo electrónico" aria-label="Email" aria-describedby="email-addon" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    <label>Contraseña</label>
                    <div class="mb-1">
                      <input id="password" type="password"  placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    </div>
                    <label>Confirmar contraseña</label>
                    <div class="mb-1">
                      <input id="password-confirm" type="password" placeholder="Confirmar contraseña" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>                    
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-2 mb-0">Crear cuenta</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-2 text-sm mx-auto">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login')}}" class="text-info text-gradient font-weight-bold">Ingresar</a>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection