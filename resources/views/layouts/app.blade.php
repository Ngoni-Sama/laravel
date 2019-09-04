<!DOCTYPE html>
<html>
<head>
   <meta name="viewport" content="width=device-width">
   <title>Dev Test</title>
   <link rel="stylesheet" href="{{asset('css/app.css')}}">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic|Material+Icons">
   <link rel="stylesheet" href="https://unpkg.com/vue-material@beta/dist/vue-material.min.css">
   <link rel="stylesheet" href="https://unpkg.com/vue-material@beta/dist/theme/default.css">
</head>
<body>
  <div id="app"></div>
  @yield('content')
  @if ($app_url)
      <script type="text/javascript">
          window.app_url = "{{ $app_url }}";
      </script>
  @endif
  <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
</body>
</html>
