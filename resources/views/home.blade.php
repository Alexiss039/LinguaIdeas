@extends('Includes.panel.menu')
<head>
      <style>
    .grafica-container {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
}
  </style>
</head>
@section('content')
<div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Lecciones</p>
                    <h5 class="font-weight-bolder mb-0">
                    {{ \App\Models\Lecciones::count() }}
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M386.539 111.485l15.096 248.955-10.979-.275c-36.232-.824-71.64 8.783-102.657 27.997-31.016-19.214-66.424-27.997-102.657-27.997-45.564 0-82.07 10.705-123.516 27.723L93.117 129.6c28.546-11.803 61.484-18.115 92.226-18.115 41.173 0 73.836 13.175 102.657 42.544 27.723-28.271 59.013-41.721 98.539-42.544zM569.07 448c-25.526 0-47.485-5.215-70.542-15.645-34.31-15.645-69.993-24.978-107.871-24.978-38.977 0-74.934 12.901-102.657 40.623-27.723-27.723-63.68-40.623-102.657-40.623-37.878 0-73.561 9.333-107.871 24.978C55.239 442.236 32.731 448 8.303 448H6.93L49.475 98.859C88.726 76.626 136.486 64 181.775 64 218.83 64 256.984 71.685 288 93.095 319.016 71.685 357.17 64 394.225 64c45.289 0 93.049 12.626 132.3 34.859L569.07 448zm-43.368-44.741l-34.036-280.246c-30.742-13.999-67.248-21.41-101.009-21.41-38.428 0-74.385 12.077-102.657 38.702-28.272-26.625-64.228-38.702-102.657-38.702-33.761 0-70.267 7.411-101.009 21.41L50.298 403.259c47.211-19.487 82.894-33.486 135.045-33.486 37.604 0 70.817 9.606 102.657 29.644 31.84-20.038 65.052-29.644 102.657-29.644 52.151 0 87.834 13.999 135.045 33.486z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Ejercicios</p>
                    <h5 class="font-weight-bolder mb-0">
                    {{ \App\Models\Ejercicios::count() }}
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M96 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32V224v64V448c0 17.7-14.3 32-32 32H128c-17.7 0-32-14.3-32-32V384H64c-17.7 0-32-14.3-32-32V288c-17.7 0-32-14.3-32-32s14.3-32 32-32V160c0-17.7 14.3-32 32-32H96V64zm448 0v64h32c17.7 0 32 14.3 32 32v64c17.7 0 32 14.3 32 32s-14.3 32-32 32v64c0 17.7-14.3 32-32 32H544v64c0 17.7-14.3 32-32 32H480c-17.7 0-32-14.3-32-32V288 224 64c0-17.7 14.3-32 32-32h32c17.7 0 32 14.3 32 32zM416 224v64H224V224H416z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Juegos</p>
                    <h5 class="font-weight-bolder mb-0">
                    {{ \App\Models\Juegos::count() }}
                 
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M192 64C86 64 0 150 0 256S86 448 192 448H448c106 0 192-86 192-192s-86-192-192-192H192zM496 168a40 40 0 1 1 0 80 40 40 0 1 1 0-80zM392 304a40 40 0 1 1 80 0 40 40 0 1 1 -80 0zM168 200c0-13.3 10.7-24 24-24s24 10.7 24 24v32h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H216v32c0 13.3-10.7 24-24 24s-24-10.7-24-24V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h32V200z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Recursos</p>
                    <h5 class="font-weight-bolder mb-0">
                    {{ \App\Models\Recursos::count() }}
                     
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M384 480h48c11.4 0 21.9-6 27.6-15.9l112-192c5.8-9.9 5.8-22.1 .1-32.1S555.5 224 544 224H144c-11.4 0-21.9 6-27.6 15.9L48 357.1V96c0-8.8 7.2-16 16-16H181.5c4.2 0 8.3 1.7 11.3 4.7l26.5 26.5c21 21 49.5 32.8 79.2 32.8H416c8.8 0 16 7.2 16 16v32h48V160c0-35.3-28.7-64-64-64H298.5c-17 0-33.3-6.7-45.3-18.7L226.7 50.7c-12-12-28.3-18.7-45.3-18.7H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H87.7 384z"/></svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4 d-flex justify-content-center">
        <div class="col-lg-5 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-body p-3">
              <div class="border-radius-lg">
                <div class="grafica-container">
                  <canvas id="miGrafica"></canvas>
                </div>
              </div>

              <!-- <div class="container border-radius-lg">
                <div class="row">
                  <div class="col-3 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Lecciones</p>
                    </div>
                    <h4 class="font-weight-bolder">{{ \App\Models\Lecciones::count() }}</h4>
                 
                  </div>
                  <div class="col-3 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Ejercicios</p>
                    </div>
                    <h4 class="font-weight-bolder">{{ \App\Models\Ejercicios::count() }}</h4>
                
                  </div>
                  <div class="col-3 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Juegos</p>
                    </div>
                    <h4 class="font-weight-bolder">{{ \App\Models\Juegos::count() }}</h4>

                  </div>
                  <div class="col-3 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Recursos</p>
                    </div>
                    <h4 class="font-weight-bolder">{{ \App\Models\Recursos::count() }}</h4>
                  </div>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>      
    </div>
  </main>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <script>
   var ctx = document.getElementById('miGrafica').getContext('2d');
    var miGrafica = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Lecciones', 'Ejercicios', 'Juegos', 'Recursos'],
            datasets: [{
                label: 'Mi Dataset',
                data: [{{ \App\Models\Lecciones::count() }}, {{ \App\Models\Ejercicios::count() }},   {{ \App\Models\Juegos::count() }}, {{ \App\Models\Recursos::count() }}],
                backgroundColor: [
                    'rgba(189, 147, 249)',
                    'rgba(152, 255, 197)',
                    'rgba(255, 184, 130)',
                    'rgba(255, 153, 153)'
                ]
            }]
        },
        options: {
            responsive: true
        }
    });

  </script>
@endsection
