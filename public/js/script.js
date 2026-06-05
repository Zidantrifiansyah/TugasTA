// 1. FITUR DARK MODE
const btnTema = document.getElementById("btnTema");
const ikonTema = document.getElementById("ikonTema");
const body = document.body;

// Pengecekan saat halaman dimuat
if (localStorage.getItem("tema") === "dark") {
  body.classList.add("dark-mode");
  if (ikonTema) {
    ikonTema.classList.remove("bi-moon-fill");
    ikonTema.classList.add("bi-sun-fill");
  }
}

// Event klik tombol tema
if (btnTema) {
  btnTema.addEventListener("click", function () {
    body.classList.toggle("dark-mode");

    if (body.classList.contains("dark-mode")) {
      localStorage.setItem("tema", "dark");
      if (ikonTema) {
        ikonTema.classList.remove("bi-moon-fill");
        ikonTema.classList.add("bi-sun-fill");
      }
    } else {
      localStorage.setItem("tema", "light");
      if (ikonTema) {
        ikonTema.classList.remove("bi-sun-fill");
        ikonTema.classList.add("bi-moon-fill");
      }
    }
  });
}

// 2. FITUR SALURKAN DAN KURANGI STOK (TERSIMPAN OTOMATIS)
let dataStok = JSON.parse(localStorage.getItem("dataStokTakjil")) || {};

function aturFiturSalurkan() {
  const tombolSalurkan = document.querySelectorAll(".btn-salurkan");

  tombolSalurkan.forEach(function (tombol) {
    const cardBody = tombol.closest(".card-body");
    const stokElement = cardBody.querySelector(".stok-menu");
    const namaMenu = cardBody.querySelector(".nama-menu").textContent.trim();

    // --- 1. SAAT HALAMAN DIMUAT ---
    if (dataStok.hasOwnProperty(namaMenu)) {
      stokElement.textContent = dataStok[namaMenu];
    } else {
      dataStok[namaMenu] = parseInt(stokElement.textContent);
      localStorage.setItem("dataStokTakjil", JSON.stringify(dataStok));
    }

    if (dataStok[namaMenu] === 0) {
      tombol.disabled = true;
      tombol.textContent = "Habis";
    }

    // --- 2. SAAT TOMBOL SALURKAN DIKLIK ---
    tombol.addEventListener("click", function () {
      if (dataStok[namaMenu] > 0) {
        dataStok[namaMenu]--;
        stokElement.textContent = dataStok[namaMenu];

        localStorage.setItem("dataStokTakjil", JSON.stringify(dataStok));

        alert("Berhasil menyalurkan 1 porsi " + namaMenu);

        if (dataStok[namaMenu] === 0) {
          tombol.disabled = true;
          tombol.textContent = "Habis";
        }
      } else {
        alert("Maaf, stok " + namaMenu + " sudah habis!");
      }
    });
  });
}

// Hanya jalankan fungsi jika tombolnya ada (mencegah error di halaman kelola.html)
if (document.querySelector(".btn-salurkan")) {
  aturFiturSalurkan();
}

// 3. FITUR RENCANA PENYALURAN (WISHLIST)
let rencana = JSON.parse(sessionStorage.getItem("rencanaTakjil")) || [];

function updateRencanaCount() {
  const countElement = document.getElementById("badgeRencana");
  if (countElement) {
    countElement.textContent = rencana.length;
  }
}

function tambahKeRencana(namaMenu) {
  if (!rencana.includes(namaMenu)) {
    rencana.push(namaMenu);
    sessionStorage.setItem("rencanaTakjil", JSON.stringify(rencana));
    updateRencanaCount();
    alert(namaMenu + " ditambahkan ke Rencana Penyaluran!");
  } else {
    alert(namaMenu + " sudah ada di Rencana Penyaluran!");
  }
}

// Fungsi ini telah diperbarui untuk fitur bonus (Hapus item spesifik)
function tampilkanRencana() {
  const daftarRencana = document.getElementById("daftarRencanaModal");
  if (!daftarRencana) return;

  daftarRencana.innerHTML = "";

  if (rencana.length === 0) {
    daftarRencana.innerHTML =
      '<li class="list-group-item text-center text-muted">Daftar rencana kosong</li>';
  } else {
    // Menambahkan parameter 'index' untuk mengetahui posisi urutan data
    rencana.forEach(function (item, index) {
      const li = document.createElement("li");
      // Menambahkan class d-flex agar nama item dan tombol sejajar (kiri-kanan)
      li.className =
        "list-group-item d-flex justify-content-between align-items-center fw-medium";
      li.textContent = item;

      // Membuat elemen tombol hapus spesifik (X)
      const btnHapus = document.createElement("button");
      btnHapus.className = "btn btn-sm btn-outline-danger border-0";
      btnHapus.innerHTML = '<i class="bi bi-x-circle-fill"></i>';

      // Event listener khusus untuk menghapus item ini dari array
      btnHapus.addEventListener("click", function () {
        rencana.splice(index, 1); // Membuang 1 data dari array pada posisi index tersebut
        sessionStorage.setItem("rencanaTakjil", JSON.stringify(rencana)); // Simpan kembali ke memory
        updateRencanaCount(); // Perbarui angka notifikasi merah
        tampilkanRencana(); // Render ulang isi modal
      });

      // Memasukkan tombol ke dalam elemen li, lalu masukkan li ke daftar modal
      li.appendChild(btnHapus);
      daftarRencana.appendChild(li);
    });
  }
}

function hapusRencana() {
  rencana = [];
  sessionStorage.removeItem("rencanaTakjil");
  updateRencanaCount();
  tampilkanRencana();
}

function aktifkanTombolRencana() {
  const tombolRencana = document.querySelectorAll(".btn-tambah-rencana");

  tombolRencana.forEach(function (tombol) {
    tombol.addEventListener("click", function (e) {
      e.preventDefault(); // Mencegah browser melompat ke atas saat tombol diklik
      const cardBody = e.target.closest(".card-body");
      const namaMenu = cardBody.querySelector(".nama-menu").textContent;
      tambahKeRencana(namaMenu);
    });
  });
}

if (document.querySelector(".btn-tambah-rencana")) {
  aktifkanTombolRencana();
}

// Menjalankan fungsi tampilkanRencana secara otomatis saat tombol Keranjang di klik
const btnBukaModal = document.querySelector('[data-bs-target="#modalRencana"]');
if (btnBukaModal) {
  btnBukaModal.addEventListener("click", tampilkanRencana);
}

updateRencanaCount();
