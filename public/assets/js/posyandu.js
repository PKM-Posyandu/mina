/* === SCHEDULE DATA AND LOGIC (NEW) === */

const SCHEDULE_TEMPLATES = [
  {
    title: "Skrining Usia Produktif & Lansia",
    desc: "Cek tensi, gula darah, dan lingkar perut",
    dayOrder: 1, // Sabtu Pertama (First Saturday)
    time: "08:00 - 10:00 WIB",
  },
  {
    title: "Pekan Imunisasi Polio",
    desc: "Imunisasi serentak untuk balita",
    dayOrder: 2, // Sabtu Kedua (Second Saturday)
    time: "08:00 - 11:00 WIB",
  },
  {
    title: "Penimbangan & Vitamin A",
    desc: "Untuk semua balita terdaftar",
    dayOrder: 3, // Sabtu Ketiga (Third Saturday)
    time: "08:00 - 11:00 WIB",
  },
];

/**
 * Menghitung tanggal N (dayOrder) dari hari tertentu (dayOfWeek: 0=Minggu, 6=Sabtu)
 * di bulan yang sedang berjalan.
 */
function getDateForDayOrder(dayOfWeek, dayOrder) {
  const date = new Date();
  const year = date.getFullYear();
  const month = date.getMonth();

  let count = 0;
  let resultDate = null;

  for (let i = 1; i <= 31; i++) {
    const d = new Date(year, month, i);
    if (d.getMonth() !== month) break; // Sudah pindah bulan

    // date.getDay() returns 0 for Sunday, 6 for Saturday
    if (d.getDay() === dayOfWeek) {
      count++;
      if (count === dayOrder) {
        resultDate = d;
        break;
      }
    }
  }
  return resultDate;
}

/* === END SCHEDULE DATA AND LOGIC === */

document.addEventListener("DOMContentLoaded", () => {
  /* ================= MOBILE MENU ================= */
  (function mobileMenuInit() {
    const menuBtn = document.getElementById("menu-btn");
    const mobileMenu = document.getElementById("mobile-menu");
    if (!menuBtn || !mobileMenu) return;
    menuBtn.addEventListener("click", () =>
      mobileMenu.classList.toggle("hidden")
    );
  })();

  /* ================= HERO / TOP SLIDER (id="slider") ================= */
  (function heroSliderInit() {
    const heroEl = document.getElementById("slider");
    if (!heroEl) return;

    const slides = Array.from(heroEl.querySelectorAll(":scope > div"));
    if (!slides.length) return;

    const indicators = Array.from(document.querySelectorAll(".indicator")); // optional
    let heroIndex = 0;
    let heroInterval = null;
    const HERO_DELAY = 5000;

    function heroUpdate() {
      heroEl.style.transform = `translateX(-${heroIndex * 100}%)`;
      if (indicators.length) {
        indicators.forEach((dot, i) => {
          dot.classList.toggle("bg-white", i === heroIndex);
          dot.classList.toggle("bg-gray-400", i !== heroIndex);
        });
      }
    }

    function heroNext() {
      heroIndex = (heroIndex + 1) % slides.length;
      heroUpdate();
    }

    function heroPrev() {
      heroIndex = (heroIndex - 1 + slides.length) % slides.length;
      heroUpdate();
    }

    window.nextTopSlide = heroNext;
    window.prevTopSlide = heroPrev;

    function heroStart() {
      heroInterval = setInterval(heroNext, HERO_DELAY);
    }

    function heroStop() {
      if (heroInterval) {
        clearInterval(heroInterval);
        heroInterval = null;
      }
    }

    heroEl.addEventListener("mouseenter", heroStop);
    heroEl.addEventListener("mouseleave", heroStart);

    heroUpdate();
    heroStart();
  })();

  (function gallerySliderInit() {
    const gallerySlider = document.getElementById("gallery-slider");
    if (!gallerySlider) return;

    const galleryItems = Array.from(gallerySlider.children);
    let currentGalleryIndex = 0;

    // Fungsi untuk menghitung berapa banyak item yang ditampilkan per geseran
    const getItemsPerView = () => {
      // Sesuaikan dengan media query di CSS
      if (window.innerWidth >= 1024) {
        return 3; // Desktop: 3 item
      } else if (window.innerWidth >= 768) {
        return 2; // Tablet: 2 item
      } else {
        return 1; // Mobile: 1 item
      }
    };

    // Fungsi untuk mendapatkan lebar pergeseran berdasarkan item pertama
    const getItemShiftAmount = () => {
      if (galleryItems.length === 0) return 0;

      // Offset yang digunakan adalah lebar item PERTAMA + margin kanannya
      const item = galleryItems[0];
      // Menggunakan getBoundingClientRect() untuk mendapatkan lebar aktual termasuk padding/border
      const itemWidth = item.getBoundingClientRect().width;

      // Asumsi margin kanan/kiri 0.5rem (total 1rem) di desktop/tablet, dan 1rem (total 2rem) di mobile
      // Ini lebih aman daripada hardcode, tapi kita bisa tebak lebar margin dari CSS.
      // Lebih baik menggeser berdasarkan lebar container dan index.

      // Kita gunakan item.offsetWidth dan menambahkan margin manual (1rem = 16px)
      let margin = window.innerWidth >= 768 ? 16 : 32; // 1rem di desktop/tablet, 2rem di mobile
      if (window.innerWidth < 768) {
        margin = 32; // 1rem margin kiri + 1rem margin kanan = 2rem
      } else {
        margin = 16; // 0.5rem margin kiri + 0.5rem margin kanan = 1rem
      }

      return itemWidth + margin;
    };

    // Fungsi utama untuk menggeser galeri
    const galleryUpdate = () => {
      // Hitung batas maksimum index yang bisa digeser
      const itemsPerView = getItemsPerView();
      const maxIndex = galleryItems.length - itemsPerView;

      // Pastikan index tidak melebihi batas (penting saat resize)
      if (currentGalleryIndex > maxIndex) {
        currentGalleryIndex = maxIndex > 0 ? maxIndex : 0;
      }

      // Hitung posisi geser baru berdasarkan lebar item
      const offset = currentGalleryIndex * getItemShiftAmount();

      gallerySlider.style.transform = `translateX(-${offset}px)`;
    };

    window.nextGallerySlide = () => {
      const itemsPerView = getItemsPerView();
      const maxIndex = galleryItems.length - itemsPerView;

      if (currentGalleryIndex < maxIndex) {
        currentGalleryIndex++;
      } else {
        currentGalleryIndex = 0; // Loop ke awal
      }
      galleryUpdate();
    };

    window.prevGallerySlide = () => {
      const itemsPerView = getItemsPerView();
      const maxIndex = galleryItems.length - itemsPerView;

      if (currentGalleryIndex > 0) {
        currentGalleryIndex--;
      } else {
        currentGalleryIndex = maxIndex > 0 ? maxIndex : 0; // Loop ke akhir
      }
      galleryUpdate();
    };

    // Panggil saat resize untuk memastikan item yang terlihat dan posisi geser benar
    window.addEventListener("resize", galleryUpdate);

    // Panggil sekali untuk memastikan posisi awal
    galleryUpdate();
  })();

  /* ================= SEARCH FUNCTION (UPGRADED) ================= */
  (function searchInit() {
    const searchInputs = document.querySelectorAll(".search-box");

    // Create a results container dynamically
    const resultsContainer = document.createElement("div");
    resultsContainer.id = "search-results";
    resultsContainer.className = "container mx-auto px-6 py-8 hidden"; // Initially hidden

    // Find a good place to insert the results, e.g., after the hero section
    const heroSection = document.getElementById("beranda");
    if (heroSection && heroSection.parentNode) {
      heroSection.parentNode.insertBefore(
        resultsContainer,
        heroSection.nextSibling
      );
    }

    // Keyword dictionary for smarter searching
    const searchableSections = [
      {
        id: "tentang-kami",
        title: "Tentang Kami",
        keywords: ["tentang kami", "posyandu mina", "profil", "sejarah"],
      },
      {
        id: "layanan",
        title: "Layanan",
        keywords: [
          "layanan",
          "jenis layanan",
          "imunisasi",
          "gizi",
          "lansia",
          "ibu hamil",
          "remaja",
          "tumbuh kembang",
          "daftar",
        ],
      },
      {
        id: "jadwal",
        title: "Jadwal & Pengaduan",
        keywords: [
          "jadwal",
          "pengaduan",
          "skrining",
          "polio",
          "vitamin",
          "oktober",
        ],
      },
    ];

    const handleSearch = (event) => {
      const query = event.target.value.toLowerCase().trim();

      if (query.length < 3) {
        resultsContainer.innerHTML = "";
        resultsContainer.classList.add("hidden");
        return;
      }

      let resultsHTML = `<h2 class="section-title text-center mb-6">Hasil Pencarian untuk "${query}"</h2>`;
      let found = false;

      searchableSections.forEach((sectionInfo) => {
        // New logic: check against keywords array
        const isMatch = sectionInfo.keywords.some((keyword) =>
          keyword.includes(query)
        );

        if (isMatch) {
          found = true;
          resultsHTML += `
                    <div class="mb-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                        <h3 class="font-bold text-xl mb-2 text-gray-800 dark:text-gray-100">${sectionInfo.title}</h3>
                        <p class="text-gray-600 dark:text-gray-300">Ditemukan kata kunci yang cocok di bagian ini.</p>
                        <a href="#${sectionInfo.id}" class="text-blue-500 hover:underline mt-2 inline-block">Lihat Bagian &raquo;</a>
                    </div>
                `;
        }
      });

      if (!found) {
        resultsHTML += `<p class="text-center text-gray-500">Tidak ada hasil yang ditemukan.</p>`;
      }

      resultsContainer.innerHTML = resultsHTML;
      resultsContainer.classList.remove("hidden");

      // If user clears the search, hide results
      if (query === "") {
        resultsContainer.classList.add("hidden");
      }
    };

    searchInputs.forEach((input) => {
      input.addEventListener("keyup", handleSearch);
    });
  })();

  /* ================= DYNAMIC SCHEDULE (NEW) ================= */
  (function initDynamicSchedule() {
    const scheduleContainer = document.getElementById(
      "schedule-list-container"
    );
    const monthTitle = document.getElementById("schedule-month-title");
    if (!scheduleContainer || !monthTitle) return;

    const today = new Date();
    // Use 'id-ID' for Indonesian format
    const monthYearTitle = today.toLocaleString("id-ID", {
      month: "long",
      year: "numeric",
    });

    // 1. Update Judul Bulan (yang berwarna biru)
    monthTitle.innerText = monthYearTitle;

    let scheduleHTML = "";
    const saturdayCode = 6; // Saturday is 6 in JavaScript Date.getDay()

    SCHEDULE_TEMPLATES.forEach((item) => {
      // Asumsi semua kegiatan diadakan di hari SABTU (dayOfWeek = 6)
      const eventDate = getDateForDayOrder(saturdayCode, item.dayOrder);

      if (eventDate) {
        const dayName = eventDate.toLocaleString("id-ID", { weekday: "long" });
        const dateString = eventDate.getDate().toString().padStart(2, "0"); // Contoh: 04
        // Ambil nama bulan pendek (Okt, Nov)
        const monthNameShort = eventDate.toLocaleString("id-ID", {
          month: "short",
        });

        scheduleHTML += `
                <div class="bg-blue-800/50 backdrop-blur-md rounded-xl p-6 shadow-lg flex justify-between items-center">
                    <div>
                        <h4 class="font-semibold text-lg">${item.title}</h4>
                        <p class="text-gray-300 text-sm">${item.desc}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="text-cyan-400 font-bold">${dayName}, ${dateString} ${monthNameShort}</p>
                        <p class="text-sm">${item.time}</p>
                    </div>
                </div>
            `;
      }
    });

    scheduleContainer.innerHTML = scheduleHTML;
  })();
});

// ===================== AUTO SLIDER GALERI ===================== //
let galleryIndex = 0;
const gallerySlider = document.getElementById("gallery-slider");
const galleryItems = document.querySelectorAll("#gallery-slider .gallery-item");
const galleryTotal = galleryItems.length;

function updateGallerySlide() {
  gallerySlider.style.transform = `translateX(-${galleryIndex * 100}%)`;
}

function nextGallerySlide(auto = false) {
  galleryIndex = (galleryIndex + 1) % galleryTotal;
  updateGallerySlide();

  if (!auto) resetGalleryAutoSlide();
}

function prevGallerySlide() {
  galleryIndex = (galleryIndex - 1 + galleryTotal) % galleryTotal;
  updateGallerySlide();
  resetGalleryAutoSlide();
}

// Auto-slide setiap 3 detik
let galleryAutoSlide = setInterval(() => nextGallerySlide(true), 3000);

function resetGalleryAutoSlide() {
  clearInterval(galleryAutoSlide);
  galleryAutoSlide = setInterval(() => nextGallerySlide(true), 3000);
}
