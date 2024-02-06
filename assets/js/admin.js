// TOGGLE SIDEBAR
const menuBar = document.getElementById("menu-bar");
const sidebar = document.getElementById("sidebar");

menuBar.addEventListener("click", function () {
  sidebar.classList.toggle("hide");
});

window.addEventListener("load", function () {
  $("#table_js").DataTable({
    // order: [[0, "desc"]], // Sắp xếp theo cột đầu tiên (index 0) giảm dần ("desc")
  });

  reSize();

  window.addEventListener("resize", function () {
    reSize();
  });
});

function reSize() {
  if (this.window.innerWidth < 1200) {
    sidebar.classList.add("hide");
  } else {
    sidebar.classList.remove("hide");
  }
}

$('#daterange').daterangepicker({
  opens: 'left'
}, function(start, end, label) {
  var startDate = start.format('YYYY-MM-DD');
  var endDate = end.format('YYYY-MM-DD');
  $.post("pages/trang-chu/update.php", {
      startDate: startDate,
      endDate: endDate,
  }, function(data, status) {
      $(".main-form").html(data);
  });
});

CKEDITOR.replace('mota');


