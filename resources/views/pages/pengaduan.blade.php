<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forum Pengaduan Posyandu Mina</title>

    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}" />
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ["Product Sans", "sans-serif"],
            },
            colors: {
              "logo-blue": "#00BFFF",
              "logo-orange": "#FFA500",
              "logo-pink": "#F900C6",
              "logo-green": "#32CD32",
              "logo-purple": "#9B30FF",
            },
          },
        },
      };
    </script>
  </head>

  <body class="bg-gray-100 text-gray-900 min-h-screen">
    <header class="bg-logo-blue text-white p-4 flex items-center shadow-lg">
      <div class="flex-1">
        <a
          href="/"
          class="bg-white/50 text-black px-3 py-1 rounded hover:bg-white transition font-medium"
        >
          ← Kembali
        </a>
      </div>

      <div class="flex-1 text-center">
        <h1 class="font-bold text-xl text-black">
          <span class="sm:hidden">Forum Pengaduan</span>
          <span class="hidden sm:inline">Forum Pengaduan Posyandu Mina</span>
        </h1>
      </div>

      <div class="flex-1"></div>
    </header>

    <main class="container mx-auto py-10 px-4 max-w-lg">
      <div class="flex justify-center items-center mb-5 space-x-8">
        <img
          src="{{ asset('assets/images/logo_tangkot2.png') }}"
          alt="Logo Kota Tangerang"
          class="w-24 h-24 rounded-full object-cover shadow-xl border-4 border-logo-purple"
        />
        <img
          src="{{ asset('assets/images/logo_posyandu_mina.png') }}"
          alt="Logo Posyandu Mina"
          class="w-24 h-24 rounded-full object-cover shadow-xl border-4 border-gray-400 bg-gray-200"
        />
      </div>

      <form
        action="{{ route('complaints.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="bg-white p-6 sm:p-8 rounded-2xl shadow-2xl space-y-5"
      >
        @csrf
        <h2 class="text-3xl font-bold mb-6 text-center text-logo-orange">
          Form Pengaduan
        </h2>

        <div>
          <label class="block font-medium text-gray-700 mb-1"
            >Nama Lengkap</label
          >
          <input
            type="text"
            name="nama"
            required
            placeholder="Tulis nama lengkap Anda..."
            class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1"
            >Nomor Whatsapp</label
          >
          <input
            type="tel"
            name="whatsapp"
            required
            placeholder="Contoh: 081234567890"
            class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1"
            >Kategori Pengaduan</label
          >
          <select
            name="kategori"
            required
            class="w-full bg-gray-50 text-gray-900 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          >
            <option value="" disabled selected class="text-gray-500">
              -- Pilih Kategori --
            </option>
            <option value="pendidikan" class="text-black">Pendidikan</option>
            <option value="kesehatan" class="text-black">Kesehatan</option>
            <option value="pekerjaan_umum" class="text-black">
              Pekerjaan Umum
            </option>
            <option value="perumahan_rakyat" class="text-black">
              Perumahan Rakyat
            </option>
            <option value="tramtibumlinmas" class="text-black">
              Trantibunlinmas
            </option>
            <option value="sosial" class="text-black">Sosial</option>
          </select>
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1"
            >Isi Pengaduan</label
          >
          <textarea
            name="pesan"
            rows="4"
            required
            placeholder="Jelaskan pengaduan kamu di sini..."
            class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          ></textarea>
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">Alamat Lengkap</label>
          <input
            type="text"
            name="alamat"
            required
            placeholder="Contoh: Jl. Mina 12, Gg. Melati"
            class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">RT</label>
          <input
            type="text"
            name="rt"
            required
            placeholder="Contoh: 01"
            class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:border-logo-pink focus:ring-logo-pink"
          />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1"
            >Upload Bukti (Opsional)</label
          >
          <input
            type="file"
            name="bukti"
            accept="image/*"
            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 file:transition"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-logo-green text-white px-4 py-3 rounded-lg font-bold hover:bg-opacity-80 transition-all shadow-lg"
        >
          Kirim Pengaduan
        </button>
      </form>
    </main>
  </body>
</html>