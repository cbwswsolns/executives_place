<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>

    <meta charset="utf-8">

    <meta
      name="viewport"
      content="width=device-width, initial-scale=1">

    <title>Executives Place</title>

    <link
      href="{{ asset('css/app.css') }}"
      rel="stylesheet">


    <link
      rel="stylesheet" 
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

  </head>

    <body>

      <header class="header">

        <div id="app-head">

          <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark p-3">

            <a
              class="navbar-brand"
              href="/">Executives Place</a>

          </nav>
              
        </div>
          
      </header>

      <main role="main">

        <div id="content">

          @yield('content')

        </div>

      </main>

      <!-- FOOTER -->
      <footer class="footer bg-dark">

        <div class="container-fluid">

          <div class="row">

            <div class="p-3 col-6 text-left">

              &copy; 2022 Executives Place

            </div>

            <div class="p-3 col-6 text-right"></div>

          </div>

        </div>

      </footer>

      <script
        src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
      </script>
      
      <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous">
      </script>

      <script
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous">
      </script>

      <script src="{{ asset('js/app.js') }}">
      </script>

    </body>

</html>
