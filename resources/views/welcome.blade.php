<!DOCTYPE html>
<html lang="en">

<head>
<link rel="shortcut icon" type="image/png" href="assets/img/fon.png">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/fon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('img/fon.png')}}">
    <title>LinguaIdeas</title>

</head>

<body>

  @include('Includes.Header.Navbar')

  @yield('content')

  @include('Includes.Footer.Foot')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/index.js')}}"></script>
  <script src="{{ asset('assets/js/main.js')}}"></script>

</body>

</html>