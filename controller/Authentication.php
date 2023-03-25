<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Class authentication di gunakan untuk memproses autentikasi pada aplikasi
class Authentication extends Controller
{

    private $username;
    private $password;
    private $password2;

    // Method untuk mengeset username yang sudah di-htmlentities
    public function setUsername($username)
    {
        $this->username = htmlentities($username);
    }

    // Method untuk mengeset password yang sudah di-htmlentities
    public function setPassword($password)
    {
        $this->password = htmlentities($password);
    }

    // Method untuk mengeset password2 yang sudah di-htmlentities
    public function setPassword2($password2)
    {
        $this->password2 = htmlentities($password2);
    }

    // Method untuk mendapatkan nilai username
    public function getUsername()
    {
        return $this->username;
    }

    // Method untuk mendapatkan nilai password
    public function getPassword()
    {
        return $this->password;
    }

    // Method untuk mendapatkan nilai password2
    public function getPassword2()
    {
        return $this->password2;
    }


    // Function untuk validasi form menggunakan Validator
    private function validateForm(Request $request, array $rules)
    {
        $validator = Validator::make($request->all(), $rules);
        return $validator;
    }

    // Function untuk halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Function untuk halaman app
    protected function app()
    {

        // Variabel nomor antrian berfungsi untuk mengambil data nomor antrian pada tabel tbl_nomor_antrian
        $nomor_antrian = DB::select('select nomor_antrian from tbl_nomor_antrian where id = ?', [1]);

        // Kembalikan data nomor antrian ke halaman app
        return view('app', ['nomor_antrian' => $nomor_antrian]);
    }

    // Function untuk halaman proses login
    public function proses_login(Request $request)
    {
        // set nilai username dari inputan form login
        $this->setUsername($request->username);

        // set nilai password dari inputan form login
        $this->setPassword($request->password);

        // Ambil data dari tabel tbl_auth berdasarkan username
        $user = DB::table('tbl_auth')->where('username', $this->getUsername())->first();

        // jika username tidak ditemukan dalam tabel tbl_auth
        if (!$user) {

            // menampilkan flash message bahwa username tidak valid
            Session::flash('username_tidak_valid', 'Username tidak valid.');

            // redirect ke halaman login
            return redirect('/login');
        }

        // menyimpan nilai username dan password pada array credentials
        $credentials = [
            'username' => $this->getUsername(),
            'password' => $this->getPassword()
        ];

        // memeriksa apakah password yang dimasukkan sesuai dengan password pada database
        $password_verify = Hash::check($this->getPassword(), $user->password);

        // jika username dan password sesuai
        if (Auth::guard('m_auth')->attempt($credentials)) {

            // jika password juga sesuai untuk mencocokkan password yang telah ter hash dalam tabel tbl_auth
            if ($password_verify) {

                // membuat session baru
                $request->session()->regenerate();

                // menampilkan flash message bahwa login berhasil
                Session::flash('app', 'Selamat datang ' . $this->getUsername() . '.');

                // Buat cookie dalam 2 hari
                $minutes = 60 * 24 * 2;
                
                // redirect ke halaman dashboard beserta cookie
                return redirect()->intended('/app')->withCookie(cookie('log_', $this->getUsername(), $minutes));
            }
        }

        // jika password tidak sesuai 
        if (!$password_verify) {

            // menampilkan flash message bahwa password tidak valid
            Session::flash('password_tidak_valid', 'Password tidak valid.');

            // redirect ke halaman login
            return redirect('/login');
        }
    }


    // Function proses registrasi
    public function proses_registrasi(Request $request)
    {

        // Inisialisasi variabel validasi
        $validatedData = $this->validateForm($request, [
            'username' => 'unique:tbl_auth'
        ]);

        // Cek jika username sudah ada yang memiliki
        if ($validatedData->fails()) {

            // Berikan pesan jika username sudah ada yang memiliki dalam tabel tbl_auth
            Session::flash('username', 'Username sudah ada yang memiliki.');

            // Redirect ke halaman login
            return redirect('/registrasi');
        }

        // Buat variabel untuk melakukan tambah username dan password
        $registrasi = DB::table('tbl_auth')->insert([
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        // Jika berhasil registrasi
        if ($registrasi) {

            // Berikan pesan jika proses registrasi telah di sukses 
            Session::flash('registrasi_sukses', 'Berhasil registrasi. Silakan login terlebih dahulu.');

            // Dan redirect ke halaman login
            return redirect('/login');
        }
    }

    // Function untuk halaman registrasi
    public function registrasi()
    {

        return view('auth.registrasi');
    }

    // Function untuk halaman lupa password
    public function lupa_password()
    {
        return view('auth.lupa_password');
    }

    // Function untuk proses lupa password
    public function proses_lupa_password(Request $request)
    {

        // set nilai username dari inputan form lupa password
        $this->setUsername($request->username);

        // set nilai password dari inputan form lupa password
        $this->setPassword($request->password);

        // set nilai password kedua dari inputan form lupa password
        $this->setPassword2($request->password2);

        // Buat variabel affected untuk melakukan update password dalam tabel tbl_auth 
        $affected = DB::table('tbl_auth')
            ->where('username', $this->getUsername())
            ->update(['password' => Hash::make($this->getPassword())]);

        // Jika username itu tidak ada
        if (!$affected) {

            // Berikan pesan tertentu bahwa username dalam tabel tbl_auth tidak ada
            Session::flash('gagal_di_ubah', 'Username tidak ada. Lupa password gagal di ubah.');

            // Lalu alihkan ke halaman lupa password
            return redirect('/lupa_password');


            // Jika selain pengguna memasukkan password itu tidak sesuai dengan konfirmasi password         
        } else if ($this->getPassword() !== $this->getPassword2()) {

            // Berikan pesan tertentu bahwa konfirmasi password tidak sesuai
            Session::flash('gagal_konfirmasi', 'Konfirmasi password tidak sesuai.');

            // Lalu alihkan ke halaman lupa password
            return redirect('/lupa_password');

            // Tapi jika tidak ada data yang invalid, berarti proses ubah password berhasil  
        } else if ($affected) {

            // Berikan pesan tertentu bahwa password berhasil di ubah
            Session::flash('sukses_di_ubah', 'Berhasil mengubah password.');

            // Lalu alihkan ke halaman login
            return redirect('/login');
        }
    }

    // Function untuk logout
    public function logout(Request $request)
    {
        // Melakukan logout pada user yang sedang login
        Auth::guard('m_auth')->logout();

        // Membatalkan sesi yang sedang berjalan
        $request->session()->invalidate();

        // Membuat token baru untuk menghindari serangan CSRF
        $request->session()->regenerateToken();

        // Menampilkan pesan sukses pada session
        Session::flash('logout', 'Anda berhasil logout.');

        // Kembali ke halaman login dan hapus cookie
        return redirect('/login')->withCookie(Cookie::forget('log_'));
    }
}
