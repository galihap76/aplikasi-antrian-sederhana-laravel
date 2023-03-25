@extends('auth.layout')
@section('title', 'Registrasi')

@section('content')

 <!-- Section -->
 <section class="vh-100">

    <!-- Container -->
    <div class="container h-100">

      <!-- Row -->
      <div class="row d-flex justify-content-center align-items-center h-100">

        <!-- Col -->
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">

          <!-- Card -->
          <div class="card" style="border-radius: 1rem;">

            <!-- Card body -->
            <div class="card-body p-5">

              <!-- Registrasi -->
              <h3 class="mb-5 text-center">Registrasi</h3>
              <!-- </Akhir registrasi -->

              <!-- Form -->
              <form method="post" action="/proses_registrasi">
                  @csrf
                  
                   @if ($username = Session::get('username'))
                    <script>
                        Swal.fire({
                            title: 'ERROR',
                            text: '{{ $username}}',
                            icon: 'error'
                        })
                    </script>
                  @endif
                  
                <!-- Username -->
                <div class="mb-4">
                  <label class="form-label" for="username">Username</label>
                  <input type="text" id="username" class="form-control registrasi_username" name="username" autocomplete="off" required />
                </div>
                <!-- </Akhir username -->

                <!-- Password -->
                <div class="mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" name="password" class="form-control" required />
                </div>
                <!-- </Akhir password -->

                <!-- Tombol registrasi -->
                <div class="text-center">
                  <button class="btn btn-primary w-75 text-center rounded-pill s" type="submit">Registrasi</button>
                </div>
                <!-- </Akhir tombol registrasi -->

              </form>
              <!-- </Akhir form -->

              <!-- Garis -->
              <hr class="my-4">
              <!-- </Akhir garis -->

              <!-- Login -->
              <div class="text-center">
                <a href="{{url('login')}}">Kembali</a>
              </div>
              <!-- </Akhir login -->

            </div>
            <!-- </Akhir card body -->

          </div>
          <!-- </Akhir card -->

        </div>
        <!-- </Akhir col -->

      </div>
      <!-- </Akhir row -->

    </div>
    <!-- </Akhir container -->

  </section>
  <!-- </Akhir section -->
  @endsection