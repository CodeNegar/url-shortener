@include('parts.header')

    <form class="form-shorten">
      <h1 class="h3 mb-3 font-weight-normal">Please Enter your URL</h1>
      <label for="input-shorten" class="sr-only">Long URL</label>
      <input type="url" class="form-control mb-3" placeholder="http://" name="input-shorten" id="input-shorten" placeholder="Long URL" required autofocus>
      <button class="btn btn-lg btn-primary btn-block mb-3" id="button-shorten" type="submit">Shorten</button>
      <div id="response-shorten" class="alert alert-primary" role="alert">
        
      </div>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>

@include('parts.footer')