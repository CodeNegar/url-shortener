<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Yet another URL shortener, this time using Laravel">
    <meta name="author" content="">

    <title>URL Shortener</title>

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">

  </head>

  <body class="text-center">
    <form class="form-shorten">
      <h1 class="h3 mb-3 font-weight-normal">Please Enter your URL</h1>
      <label for="input-shorten" class="sr-only">Long URL</label>
      <input type="url" class="form-control mb-3" placeholder="http://" name="input-shorten" id="input-shorten" placeholder="Long URL" required autofocus>
      <button class="btn btn-lg btn-primary btn-block mb-3" id="button-shorten" type="submit">Shorten</button>
      <div id="response-shorten" class="alert alert-primary" role="alert">
        
      </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>

  </body>
</html>
