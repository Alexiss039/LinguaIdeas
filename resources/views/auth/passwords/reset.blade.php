@extends('layouts.form')
<head>
<title>
    Restablecer contraseña
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
                    <img src="https://linguaideas.com/assets/img/fon.gif" style="width: 190px; height: 190px;" alt="Logo">
                  </a>
                </div>
                <div class="card-header pb-0 text-center bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Restablecer</h3>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('password.update') }}">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">

                    <label>Correo Electrónico</label>
                    <div class="mb-1">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                    </div>
                    <label>Contraseña</label>
                    <div class="mb-1">
                    <input id="password" type="password" placeholder="Contraseña" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <label>Confirmar contraseña</label>
                    <div class="mb-1">
                    <input id="password-confirm" placeholder="Confirmar contraseña" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>                    
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Actualizar contraseña</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</section>

@endsection