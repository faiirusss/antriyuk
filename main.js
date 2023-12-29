document.getElementById("keperluan").addEventListener("change", function () {
  var selectedValue = this.value;
  var inputKategoriBaru = document.getElementById("inputKeperluanLainnya");

  // Tampilkan atau sembunyikan input kategori baru berdasarkan pilihan dropdown
  if (selectedValue == "lainnya") {
    inputKategoriBaru.style.display = "block";
  } else {
    inputKategoriBaru.style.display = "none";
  }
});
