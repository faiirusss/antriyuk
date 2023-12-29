$(document).ready(function () {
  $("#keyword").on("keyup", function () {
    $("#container").load(
      "ajax/search.php?keyword=" + encodeURIComponent($("#keyword").val())
    );
  });
});

// AJAX JQUERY
// $(document).ready(function () {
//   // event ketika keyword ditulis
//   $("#keyword").on("keyup", function () {
//     $("#containers").load(
//       "ajax/search.php?keyword=" + encodeURIComponent($("#keyword").val())
//     );
//   });
// });

function select_all() {
  if (jQuery("#delete").prop("checked")) {
    jQuery("input[type=checkbox]").each(function () {
      jQuery("#" + this.id).prop("checked", true);
    });
  } else {
    jQuery("input[type=checkbox]").each(function () {
      jQuery("#" + this.id).prop("checked", false);
    });
  }
}

function delete_all() {
  var check = confirm("Apakah kamu yakin menghapus?");
  if (check == true) {
    jQuery.ajax({
      url: "hapusdata.php",
      type: "post",
      data: jQuery("#frm").serialize(),
      success: function (result) {
        jQuery("input[type=checkbox]").each(function () {
          if (jQuery("#" + this.id).prop("checked")) {
            jQuery("#box" + this.id).remove();
          }
        });

        // Setelah menghapus data, refresh halaman
        window.location.href = "index.php";
      },
    });
  }
}
