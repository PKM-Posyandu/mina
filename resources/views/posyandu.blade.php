<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Posyandu Mina</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="{{ asset('assets/css/posyandu.css') }}" />
  </head>

  <body class="bg-white">
    <header
      class="fixed top-4 left-1/2 transform -translate-x-1/2 w-11/12 max-w-7xl bg-white dark:bg-white backdrop-blur-lg shadow-lg rounded-full z-50 transition-colors duration-300"
    >
      <nav class="px-6 py-3 flex justify-between items-center">
        <div class="flex items-center space-x-2 flex-shrink-0">
          <img
            src="{{ asset('assets/images/logo_posyandu_mina.png') }}"
            alt="Logo Posyandu Mina"
            class="w-12 h-12 rounded-full"
          />
          <a
            href="#"
            class="text-xl font-bold text-gray-900 dark:text-gray-900"
          >
            Posyandu Mina
          </a>
        </div>

        <div class="hidden md:flex items-center space-x-4">
          <div
            class="flex items-center space-x-8"
          >
            <a
              href="#beranda"
              class="text-gray-900 hover:text-blue-600"
              >Beranda</a
            >
            <a
              href="#tentang-kami"
              class="text-gray-900 hover:text-blue-600"
              >Tentang Kami</a
            >
            <a
              href="#layanan"
              class="text-gray-900 hover:text-blue-600"
              >Layanan</a
            >
            <a
              href="#galeri"
              class="text-gray-900 hover:text-blue-600"
              >Galeri</a
            >
            <a href="#spm" class="text-gray-900 hover:text-blue-600"
              >SPM</a
            >
            <a
              href="#jadwal"
              class="text-gray-900 hover:text-blue-600"
              >Jadwal</a
            >

            <div class="relative group">
              <a class="text-gray-900 hover:text-blue-600 inline-flex items-center">
                Menu
                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </a>

              <div class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10">
                <a href="pages/inovasi.html" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Inovasi</a>
                <a href="/cakupan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Cakupan</a>
                <a href="https://form.jotform.com/252012498192052" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-700 hover:text-white" target="_blank">Daftar Sekarang</a>
              </div>
            </div>
          </div>
          <input
            type="text"
            placeholder="Cari..."
            class="search-box w-48 bg-white text-gray-900 rounded px-3 py-1 border border-gray-300 focus:w-64 transition-all duration-300"
          />
        </div>
        <div class="md:hidden flex items-center space-x-2">
          <button
            id="menu-btn"
            class="z-50 cursor-pointer text-gray-800 dark:text-gray-200 focus:outline-none"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16m-7 6h7"
              />
            </svg>
          </button>
        </div>
      </nav>

      <div
        id="mobile-menu"
        class="hidden absolute top-full left-0 w-full bg-white dark:bg-white rounded-2xl shadow-lg mt-2 z-40 text-gray-900 backdrop-blur-md transition-all duration-300"
      >
        <div class="flex flex-col px-6 py-4 space-y-4">
          <a
            href="#beranda"
            class="text-gray-900 hover:text-blue-600"
            >Beranda</a
          >
          <a
            href="#tentang-kami"
            class="text-gray-900 hover:text-blue-600"
            >Tentang Kami</a
          >
          <a
            href="#layanan"
            class="text-gray-900 hover:text-blue-600"
            >Layanan</a
          >
          <a href="#galeri" class="text-gray-900 hover:text-blue-600"
            >Galeri</a
          >
          <a href="#spm" class="text-gray-900 hover:text-blue-600"
            >SPM</a
          >
          <a href="#jadwal" class="text-gray-900 hover:text-blue-600"
            >Jadwal</a
          >
          <input
            type="text"
            placeholder="Cari..."
            class="search-box bg-white text-gray-900 rounded px-3 py-1 border border-gray-300"
          />
        </div>
      </div>
    </header>

    <main>
      <section id="beranda" class="relative w-full h-96 overflow-hidden">
        <div
          id="slider"
          class="flex transition-transform duration-700 ease-in-out"
        >
          <div class="w-full h-96 flex-shrink-0">
            <img
              src="{{ asset('assets/images/header-mina.jpg') }}"
              alt="Header Posyandu Mina"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="w-full h-96 flex-shrink-0">
            <img
              src="{{ asset('assets/images/wajah ramah posyandu.jpg') }}"
              alt="Foto 2"
              class="w-full h-full object-cover"
            />
          </div>
          <div class="w-full h-96 flex-shrink-0">
            <img
              src="{{ asset('assets/images/Tumbuh Kembang anak.jpg') }}"
              alt="Foto 3"
              class="w-full h-full object-cover"
            />
          </div>
        </div>

        <button
          onclick="prevTopSlide()"
          class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10"
        >
          ◀
        </button>
        <button
          onclick="nextTopSlide()"
          class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10"
        >
          ▶
        </button>

        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2">
          <span class="indicator w-3 h-3 bg-white rounded-full"></span>
          <span class="indicator w-3 h-3 bg-gray-400 rounded-full"></span>
          <span class="indicator w-3 h-3 bg-gray-400 rounded-full"></span>
        </div>
      </section>

      <div
        id="modal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
      >
        <div
          class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full text-center relative"
        >
          <button
            onclick="closeModal()"
            class="absolute top-2 right-2 text-gray-600 hover:text-black text-2xl"
          >
            ×
          </button>
          <h2 id="modal-title" class="text-xl font-bold mb-4 text-gray-800">
            Judul SPM
          </h2>
          <p id="modal-content" class="text-gray-700">
            Isi penjelasan akan muncul di sini...
          </p>
        </div>
      </div>

      <section id="tentang-kami" class="py-16 bg-gray-50">
        <div
          class="container mx-auto px-6 flex flex-col md:flex-row items-center gap-12"
        >
          <div class="w-full md:w-1/2">
            <div class="image-box"></div>
          </div>
          <div class="w-full md:w-1/2 text-center md:text-left">
            <h2 class="section-title">Tentang Posyandu Mina</h2>
            <p class="section-text text-gray-900">
              <strong>Posyandu ILP Mina RW 012</strong> merupakan pusat
              pelayanan kesehatan masyarakat yang berada di
              <em
                >Jl. Mina Raya 2 Blok Mina, Kelurahan Panunggangan Barat,
                Kecamatan Cibodas, Kota Tangerang</em
              >. Posyandu ini berperan sebagai wadah pelayanan kesehatan bagi
              <strong>ibu, bayi, balita, remaja, hingga lansia</strong> di
              lingkungan RW 012.
            </p>

            <p>
              Didukung oleh <strong>5 orang kader aktif</strong> yang telah
              mengikuti pembinaan dan pelatihan, Posyandu ILP Mina berkomitmen
              memberikan layanan kesehatan rutin seperti
              <strong>penimbangan, imunisasi, pelayanan gizi & PMT</strong>,
              penyuluhan kesehatan, keluarga berencana, serta kunjungan rumah.
              Posyandu ILP Mina telah menerapkan
              <strong>6 Standar Pelayanan Minimal (SPM)</strong> sebagai bentuk
              upaya peningkatan kualitas pelayanan, serta terus melakukan
              <strong>inovasi</strong> demi menghadirkan pelayanan yang lebih
              modern, mudah diakses, dan menyentuh seluruh warga.
            </p>

          
          </div>
        </div>
      </section>

      <section id="layanan" class="py-16 bg-white text-center">
        <div class="container mx-auto px-6">
          <h2 class="section-title">JENIS LAYANAN</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <a href="pages/layanan/tumbuh_kembang.html" class="service-card block">
              <div class="service-image">
                <img
                  src="{{ asset('assets/images/Tumbuh Kembang anak.jpg') }}"
                  class="w-full h-full object-cover"
                />
              </div>
              <h3 class="service-title">Bayi dan Balita</h3>
            </a>

            <a href="pages/layanan/ibu_hamil.html" class="service-card block">
              <div class="service-image">
                <img
                src="{{ asset('assets/images/Konsultasi Ibu hamil.jpg') }}"
                  class="w-full h-full object-cover"
                />
              </div>
              <h3 class="service-title">Ibu Hamil dan Nifas</h3>
            </a>

            <a href="pages/layanan/remaja.html" class="service-card block">
              <div class="service-image">
                <img
                src="{{ asset('assets/images/rame sehat.jpg') }}"
                  class="w-full h-full object-cover"
                />
              </div>
              <h3 class="service-title">Anak Sekolah dan Remaja</h3>
            </a>

            <a href="pages/layanan/lansia.html" class="service-card block">
              <div class="service-image">
                <img
                src="{{ asset('assets/images/Olahraga lansia.jpg') }}"
                  class="w-full h-full object-cover"
                />
              </div>
              <h3 class="service-title">Usia Produktif dan Lansia</h3>
            </a>
          </div>
        </div>
      </section>

      <section id="galeri" class="py-20 bg-gray-50 relative">
        <h2 class="section-title text-center">Galeri Kegiatan</h2>
        <div
          id="gallery-slider-container"
          class="relative w-full overflow-hidden px-4 md:px-0 max-w-7xl mx-auto"
        >
          <div
            id="gallery-slider"
            class="flex transition-transform duration-500 ease-in-out"
          >
            @forelse($images as $image)
            <div class="gallery-item shadow-lg relative">
              <img
                src="{{ Storage::url($image->image_path) }}"
                class="w-full h-full object-cover"
              />
              <div
                class="absolute bottom-0 left-0 right-0 p-2 bg-black/50 text-white text-center text-sm"
              >
                <p>Galeri Kegiatan</p>
              </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-center">Tidak ada gambar di galeri.</p>
            </div>
            @endforelse
          </div>

          <button
            onclick="prevGallerySlide()"
            class="absolute left-6 md:left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10 hover:bg-black/70 transition"
          >
            <i class="fas fa-chevron-left"></i>
          </button>
          <button
            onclick="nextGallerySlide()"
            class="absolute right-6 md:right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10 hover:bg-black/70 transition"
          >
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </section>

      <section id="spm" class="py-12 bg-white">
        <div class="container mx-auto px-6 text-center">
          <h2 class="section-title text-center mb-10">Standar Pelayanan Minimal (SPM)</h2>
          <div class="grid grid-cols-6 gap-8 justify-center items-center mx-auto w-fit">
            <a href="pages/SPM/pendidikan.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Pendidikan.png') }}" alt="Ikon Pendidikan" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>

            <a href="pages/SPM/kesehatan.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Kesehatann.png') }}" alt="Ikon Kesehatan" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>

            <a href="pages/SPM/pekerjaan_umum.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Pekerjaan_Umum.png') }}" alt="Ikon Pekerjaan Umum" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>

            <a href="pages/SPM/perumahan_rakyat.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Perumahan_Rakyat.png') }}" alt="Ikon Perumahan Rakyat" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>

            <a href="pages/SPM/trantibunlinmas.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Trantibunlinmas.png') }}" alt="Ikon Trantibunlinmas" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>

            <a href="pages/SPM/sosial.html" class="w-24 h-24 flex items-center justify-center rounded-2xl overflow-hidden transform transition duration-300 hover:scale-110 hover:shadow-lg">
              <img src="{{ asset('assets/images/Sosial.png') }}" alt="Ikon Sosial" class="h-full w-full object-cover rounded-lg m-0 p-0">
            </a>
          </div>
        </div>
      </section>

      <section
        id="jadwal"
        class="py-16 bg-gradient-to-b from-orange-400 to-pink-400 text-white"
      >
        <div class="container mx-auto px-6 max-w-3xl">
          <h2 class="text-3xl font-bold text-center mb-2">Jadwal Posyandu</h2>
          <p class="text-center text-gray-300 mb-10">
            Jangan lewatkan jadwal rutin kami setiap bulannya.
          </p>

          <h3
            id="schedule-month-title"
            class="text-center text-2xl font-semibold text-cyan-400 mb-6"
          ></h3>

          <div id="schedule-list-container" class="space-y-6"></div>

          <div class="mt-8" align="center">
            <a
              href="https://form.jotform.com/252012498192052"
              class="btn-primary"
              target="_blank"
            >
              Daftar Sekarang
            </a>
          </div>
        </div>
      </section>
    </main>

      <footer id="main-footer" class="bg-white text-gray-800 py-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <!-- KIRI -->
          <div>
            <h3 class="text-lg font-semibold mb-3">Kontak</h3>
            <p>Telp: +62 812-5111-6001 (Admin)</p>
            <p>Email: sipandumina@gmail.com </p>
          </div>

          <!-- TENGAH (Ikuti Kami) -->
          <div class="text-center">
            <h3 class="text-lg font-semibold mb-3">Ikuti Kami</h3>
            <div class="flex justify-center gap-4 text-xl">
              <a href="https://www.instagram.com/posyandu.mina" class="hover:text-gray-600"><i class="fa-brands fa-instagram"></i></a>
              <a href="https://wa.me/6281251116001" class="hover:text-gray-600"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
          </div>

          <!-- KANAN (Alamat) -->
          <div class="text-right">
            <h3 class="text-lg font-semibold mb-3">Alamat</h3>
            <p>Jl. Mina Raya 2 Blok Mina, Kelurahan Panunggangan Barat, Kecamatan Cibodas, Kota Tangerang</p>
            <p class="flex items-center justify-center md:justify-end">
                <i class="fas fa-map-marker-alt mr-2 text-blue-300"></i>
                <a
                  href="https://maps.app.goo.gl/nUcnFhVRrmYprBzL7?g_st=iw"
                  target="_blank"
                  class="hover:underline"
                  >Lihat di Google Maps</a>
              </p>
          </div>

          

        </div>

        <div class="text-center mt-10 text-sm text-gray-500">&copy; 2025 Posyandu Mina | Teknik Informatika Universitas Pamulang</div>
      </footer>


    <script src="{{ asset('assets/js/posyandu.js') }}"></script>
  </body>
</html>


