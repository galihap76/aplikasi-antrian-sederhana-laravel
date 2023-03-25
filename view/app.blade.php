<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=7tW19wIl"></script>
  </head>
    
  <body>

       @if ($app = Session::get('app'))
                    <script>
                        Swal.fire({
                            title: 'SUCCESS',
                            text: '{{ $app }}',
                            icon: 'success'
                        })
                    </script>
      @endif
        
    <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5 shadow">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"> <i class="bi bi-app-indicator"></i> Aplikasi Antrian Sederhana</a>
<a href="{{url('logout')}}" class="text-white" style="text-decoration:none;">Log out</a>
      </div>
    </nav>
    <!-- Akhir navbar -->
      
      <!--  Bel antrian -->
      <audio src="{{asset('bel/bel_antrian.mp3')}}"></audio>
      <!--  </Akhir bel antrian -->
      
      <div class="container mt-5 d-flex align-items-center justify-content-center">
          <div class="row">
              <div class="col">
                <div class="card shadow-sm p-3 mb-5 bg-body rounded" style="width: 18rem;">
                  <div class="card-body ">
                    <h1 class="card-title text-center"><i class="bi bi-person-circle"></i></h1>
                      
                      <!--   Tampilkan data nomor antrian-->

                        <h3 class="card-text text-center mt-3"><div class="nomor"></div></h3>

                      <!--   </Akhir Tampilkan data nomor antrian-->
                      
                      <form method="post" action="/update-antrian">
                          @csrf
                          <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="btn btn-success mt-3 me-3"><i class="bi bi-volume-up-fill"></i> Panggil</button>
                        <button type="button" class="btn btn-success mt-3" id="tambah-antrian"><i class="bi bi-plus-circle"></i> Tambah</button>
                          </div>
                      </form>
                  </div>
                </div>
              </div>
          </div>
      </div>
      
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="{{ asset('js/script.js') }}"></script>
  </body>
</html>