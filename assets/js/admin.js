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

  // Tạo trường nhập văn bản mới
  var inputText = document.createElement('input');
  inputText.type = 'text';
  inputText.name = 'thuoctinh[]'; // Tên thuộc tính được coi là một mảng để lưu nhiều thuộc tính
  inputText.placeholder = 'Thuộc tính ' + (inputContainer.children.length + 1);
  inputText.className = 'form-control';
  inputText.required = true;

  // Tạo trường chọn dropdown mới để chọn trạng thái
  var selectStatus = document.createElement('select');
  selectStatus.className = 'form-select';
  selectStatus.name = 'trangthai';
  var option1 = document.createElement('option');
  option1.value = '1';
  option1.textContent = 'Hiển thị';
  var option2 = document.createElement('option');
  option2.value = '0';
  option2.textContent = 'Tạm ẩn';
  selectStatus.appendChild(option1);
  selectStatus.appendChild(option2);

  // Tạo hai trường radio mới để chọn kiểu dữ liệu
  var radioGroup = document.createElement('div');
  radioGroup.className = 'form-check';

  var radioLabel1 = document.createElement('label');
  radioLabel1.className = 'form-check-label';
  radioLabel1.textContent = 'Kiểu chữ: ';
  var radioInput1 = document.createElement('input');
  radioInput1.type = 'radio';
  radioInput1.className = 'form-check-input';
  radioInput1.name = 'is_num' + (inputContainer.children.length + 1);
  radioInput1.value = '0';
  radioInput1.required = true;
  radioLabel1.appendChild(radioInput1);

  var radioLabel2 = document.createElement('label');
  radioLabel2.className = 'form-check-label';
  radioLabel2.textContent = 'Kiểu số: ';
  var radioInput2 = document.createElement('input');
  radioInput2.type = 'radio';
  radioInput2.className = 'form-check-input';
  radioInput2.name = 'is_num' + (inputContainer.children.length + 1);
  radioInput2.value = '1';
  radioLabel2.appendChild(radioInput2);

  // Tạo nút xóa
  var button = document.createElement('button');
  button.type = 'button';
  button.className = 'btn btn-danger';
  button.textContent = 'Xoá';
  button.onclick = function() {
      inputContainer.removeChild(inputGroup);
  };

  // Thêm các phần tử vào nhóm
  inputGroup.appendChild(inputText);
  inputGroup.appendChild(selectStatus);
  radioGroup.appendChild(radioLabel1);
  radioGroup.appendChild(radioLabel2);
  inputGroup.appendChild(radioGroup);
  inputGroup.appendChild(button);

  // Thêm nhóm vào container
  inputContainer.appendChild(inputGroup);
}


    function showAttributes(maloai) {
      $.post("get_attributes.php", {
          maloai: maloai,
      }, function(data, status) {
          $("#attributes-container").html(data);
      });
  }
  
CKEDITOR.replace('mota');


