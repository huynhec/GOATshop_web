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

    function addInput() {
        var inputContainer = document.getElementById('inputContainer');
        var inputGroup = document.createElement('div');
        inputGroup.className = 'input-group mb-2';

        var input = document.createElement('input');
        input.type = 'text';
        input.name = 'thuoctinh[]'; // Tên thuộc tính là một mảng để có thể lưu nhiều thuộc tính
        input.placeholder = 'Thuộc tính ' + (inputContainer.children.length + 1);
        input.className = 'form-control';
        input.required = true;

        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-danger';
        button.textContent = 'Xoá';
        button.onclick = function() {
            inputContainer.removeChild(inputGroup);
        };

        inputGroup.appendChild(input);
        inputGroup.appendChild(button);
        inputContainer.appendChild(inputGroup);
    }

    function removeInput(button) {
        var inputGroup = button.parentElement;
        var inputContainer = inputGroup.parentElement;
        inputContainer.removeChild(inputGroup);
    }

    function showAttributes(maloai) {
      $.post("get_attributes.php", {
          maloai: maloai,
      }, function(data, status) {
          $("#attributes-container").html(data);
      });
  }
  
CKEDITOR.replace('mota');


