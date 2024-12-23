document.addEventListener("DOMContentLoaded", () => {
  // Form Karyawan
  const employeeForm = document.getElementById("employeeForm");
  if (employeeForm) {
    // Validasi form karyawan sebelum disubmit
    employeeForm.addEventListener("submit", (e) => {
      const employeeName = document.getElementById("employeeName").value.trim();
      const employeePosition = document
        .getElementById("employeePosition")
        .value.trim();

      // Validasi untuk Nama karywan dan Jabatan
      if (!employeeName) {
        e.preventDefault(); // Mencegah form dikirim
        alert("Nama Karyawan wajib diisi!");
        return;
      }

      if (!employeePosition) {
        e.preventDefault(); // Mencegah form dikirim
        alert("Jabatan Karyawan wajib diisi!");
        return;
      }

      // Cek apakah nama karyawan mengandung angka atau karakter khusus (misalnya hanya huruf dan spasi yang diperbolehkan)
      if (!/^[a-zA-Z\s]+$/.test(employeeName)) {
        e.preventDefault();
        alert("Nama hanya boleh mengandung huruf dan spasi.");
        return;
      }

      // Cek apakah Jabatan mengandung angka atau karakter khusus
      if (!/^[a-zA-Z\s]+$/.test(employeePosition)) {
        e.preventDefault();
        alert("Jabatan hanya boleh mengandung huruf dan spasi.");
        return;
      }
    });
  }

  // Form Inventory
  const inventoryForm = document.getElementById("inventoryForm");
  if (inventoryForm) {
    // Validasi form Mahasiswa sebelum disubmit
    inventoryForm.addEventListener("submit", (e) => {
      const itemName = document.getElementById("itemName").value.trim();
      const itemCategory = document.getElementById("itemCategory").value.trim();
      const itemQuantity = document.getElementById("itemQuantity").value.trim();
      const itemPrice = document.getElementById("itemPrice").value.trim();

      // Validasi untuk nama Nama Bahan, Kategori, Jumlah, Harga
      if (!itemName) {
        e.preventDefault(); // Mencegah form dikirim
        alert("Nama Bahan wajib diisi!");
        return;
      }

      if (!itemCategory) {
        e.preventDefault(); // Mencegah form dikirim
        alert("Kategori wajib diisi!");
        return;
      }

      if (!itemQuantity || isNaN(itemQuantity) || itemQuantity <= 0) {
        e.preventDefault(); // Mencegah form dikirim
        alert("JUmlah harus berupa angka positif!");
        return;
      }

      if (!itemPrice || isNaN(itemPrice) || itemPrice <= 0) {
        e.preventDefault(); // Mencegah form dikirim
        alert("Harga harus berupa angka positif!");
        return;
      }

      // Cek apakah nama bahan mengandung angka atau karakter khusus (misalnya hanya huruf, angka, dan spasi yang diperbolehkan)
      if (!/^[a-zA-Z0-9\s]+$/.test(itemName)) {
        e.preventDefault();
        alert("Nama bahan hanya boleh mengandung huruf, angka, dan spasi.");
        return;
      }

      // Cek apakah kategori mengandung angka atau karakter khusus
      if (!/^[a-zA-Z\s]+$/.test(itemCategory)) {
        e.preventDefault();
        alert("Kategori hanya boleh mengandung huruf dan spasi.");
        return;
      }
    });
  }
});

// Fungsi untuk menetapkan cookie
function setCookie(name, value, days) {
  let expires = "";
  if (days) {
    let date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000); // Set masa berlaku cookie
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

// Fungsi untuk mendapatkan nilai cookie
function getCookie(name) {
  let nameEQ = name + "=";
  let ca = document.cookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) === " ") c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
  }
  return null;
}

// Fungsi untuk menghapus cookie
function eraseCookie(name) {
  document.cookie = name + "=; Max-Age=-99999999; path=/";
}
