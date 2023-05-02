<!DOCTYPE html>
<html lang="en">

<head>
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