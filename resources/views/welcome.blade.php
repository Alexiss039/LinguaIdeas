<!DOCTYPE html>
<html lang="en">

<head>
<link rel="shortcut icon" type="image/png" href="assets/img/fon.png">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/fon.png')}}">
  <link rel="icon" type="image/png" href="{{ asset('img/fon.png')}}">
    <title>LinguaIdeas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5977929873864627"
     crossorigin="anonymous"></script>
  </head>

<body>

  @include('Includes.Header.Navbar')

  @yield('content')

  @include('Includes.Footer.Foot')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/index.js')}}"></script>
  <script src="{{ asset('assets/js/main.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
  $(function() {
    $('#successModal').modal('show');
    setTimeout(function() {
        $('#successModal').modal('hide');
    }, 5000);
});
$(document).ready(function() {
  $('#successModal .close').click(function() {
    $('#successModal').modal('hide');
  });
});
</script>

</body>

</html>