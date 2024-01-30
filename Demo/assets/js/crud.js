window.addEventListener("load", function () {
  $("#table_js").DataTable({
    order: [[0, "desc"]], // Sắp xếp theo cột đầu tiên (index 0) giảm dần ("desc")
  });
});
