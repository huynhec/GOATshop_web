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

  // reSize();

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
  var endDate =  end.format('YYYY-MM-DD');
  $.post("pages/trang-chu/update.php", {
      startDate: startDate,
      endDate: endDate,
  }, function(data, status) {
      $(".main-form").html(data);
  });
});

function addInput() {
  var row = document.querySelector('.main-add .row');

  // Tạo cột chứa trường nhập thuộc tính
  var colInput = document.createElement('div');
  colInput.className = 'col-5';
  var labelInput = document.createElement('label');
  labelInput.className = 'form-label';
  labelInput.textContent = 'Tên thuộc tính:';
  colInput.appendChild(labelInput);
  var inputGroup = document.createElement('div');
  inputGroup.className = 'input-group mb-2';
  var inputText = document.createElement('input');
  inputText.type = 'text';
  inputText.name = 'thuoctinh[]';
  inputText.placeholder = 'Thuộc tính ' + (row.querySelectorAll('.col-5').length + 1 );
  inputText.className = 'form-control';
  inputText.required = true;
  inputGroup.appendChild(inputText);
  colInput.appendChild(inputGroup);

  // Tạo cột chứa trường chọn trạng thái
  var colStatus = document.createElement('div');
  colStatus.className = 'col-2';
  var labelStatus = document.createElement('label');
  labelStatus.className = 'form-label';
  labelStatus.textContent = 'Trạng thái:';
  colStatus.appendChild(labelStatus);
  var selectStatus = document.createElement('select');
  selectStatus.className = 'form-select';
  selectStatus.setAttribute('aria-label', '.trangthai');
  selectStatus.id = 'trangthai';
  selectStatus.name = 'trangthai[]';
  var option1 = document.createElement('option');
  option1.value = '1';
  option1.textContent = 'Hiển thị';
  var option2 = document.createElement('option');
  option2.value = '0';
  option2.textContent = 'Tạm ẩn';
  selectStatus.appendChild(option1);
  selectStatus.appendChild(option2);
  colStatus.appendChild(selectStatus);

  // Tạo cột chứa trường chọn kiểu dữ liệu
  var colDataType = document.createElement('div');
  colDataType.className = 'col-3';
  var labelDataType = document.createElement('label');
  labelDataType.className = 'form-label';
  labelDataType.textContent = 'Kiểu dữ liệu:';
  colDataType.appendChild(labelDataType);
  var br = document.createElement('br');
  colDataType.appendChild(br);
  var radioGroup = document.createElement('div');
  radioGroup.className = 'form-check form-check-inline';
  var radioInput1 = document.createElement('input');
  radioInput1.type = 'radio';
  radioInput1.className = 'form-check-input checkbox';
  radioInput1.id = 'is_num_0_'+ (row.querySelectorAll('.col-4').length + 1);
  radioInput1.value = '0';
  radioInput1.name = 'is_num[' + (row.querySelectorAll('.col-3').length + 1) + ']';
  radioInput1.required = true;
  var radioLabel1 = document.createElement('label');
  radioLabel1.className = 'form-check-label';
  radioLabel1.textContent = 'Kiểu chữ';
  radioLabel1.htmlFor = 'is_num_0_' + (row.querySelectorAll('.col-4').length + 1);
  radioGroup.appendChild(radioInput1);
  radioGroup.appendChild(radioLabel1);
  var radioGroup2 = document.createElement('div');
  radioGroup2.className = 'form-check form-check-inline';
var radioInput2 = document.createElement('input');
  radioInput2.type = 'radio';
  radioInput2.className = 'form-check-input checkbox';
  radioInput2.id = 'is_num_1_' + (row.querySelectorAll('.col-4').length + 1);
  radioInput2.value = '1';
  radioInput2.name = 'is_num[' + (row.querySelectorAll('.col-3').length + 1) + ']';
  radioInput2.required = true;
  var radioLabel2 = document.createElement('label');
  radioLabel2.className = 'form-check-label';
  radioLabel2.textContent = 'Kiểu số';
  radioLabel2.htmlFor = 'is_num_1_' + (row.querySelectorAll('.col-4').length + 1);
  radioGroup2.appendChild(radioInput2);
  radioGroup2.appendChild(radioLabel2);
  colDataType.appendChild(radioGroup);
  colDataType.appendChild(radioGroup2);

  console.log(num);
  console.log(radioInput1)
  // nut xoa
  var colDeleteButton = document.createElement('div');
    colDeleteButton.className = 'col-1';
    var button = document.createElement('button');
    button.type = 'button';
    button.className = 'btn btn-danger';
    button.textContent = 'Xoá';
    button.onclick = function() {
        row.removeChild(colInput);
        row.removeChild(colStatus);
        row.removeChild(colDataType);
        row.removeChild(colDeleteButton);
    };
    colDeleteButton.appendChild(button);


  // Thêm các cột vào hàng
  row.appendChild(colInput);
  row.appendChild(colStatus);
  row.appendChild(colDataType);
  row.appendChild(colDeleteButton);
}


function addInput2() {
  var row = document.querySelector('.main-add .row');

    var colSize = document.createElement('div');
    colSize.className = 'col-5 sizeten';
    var labelSize = document.createElement('label');
    labelSize.textContent = 'Tên size:';
    labelSize.className = 'form-label';
    colSize.appendChild(labelSize);
    var inputContainer1 = document.createElement('div');
    inputContainer1.className = 'inputContainer1';
    var inputGroup1 = document.createElement('div');
    inputGroup1.className = 'input-group mb-2';
    var inputSize = document.createElement('input');
    inputSize.type = 'text';
    inputSize.name = 'tensize[]';
    inputSize.placeholder = 'Tên size ' + (document.querySelectorAll('.sizeten').length + 1);
    inputSize.className = 'form-control';
    inputSize.required = true;
    inputGroup1.appendChild(inputSize);
    inputContainer1.appendChild(inputGroup1);
    colSize.appendChild(inputContainer1);

    var colStatus = document.createElement('div');
    colStatus.className = 'col-3 sizetrangthai';
    var labelStatus = document.createElement('label');
    labelStatus.textContent = 'Trạng thái:';
    labelStatus.className = 'form-label';
    colStatus.appendChild(labelStatus);
    var selectStatus = document.createElement('select');
    selectStatus.className = 'form-select';
    selectStatus.setAttribute('aria-label', '.trangthai');
    selectStatus.name = 'trangthai[]';
    selectStatus.required = true;
    var option1 = document.createElement('option');
    option1.value = '1';
    option1.textContent = 'Hiển thị';
    var option2 = document.createElement('option');
    option2.value = '0';
    option2.textContent = 'Tạm ẩn';
    selectStatus.appendChild(option1);
    selectStatus.appendChild(option2);
    colStatus.appendChild(selectStatus);
    // nut xoa
  var colDeleteButton = document.createElement('div');
  colDeleteButton.className = 'col-2 flx-s';
  var button = document.createElement('button');
  button.type = 'button';
  button.className = 'btn btn-danger';
  button.textContent = 'Xoá';
  button.onclick = function() {
      row.removeChild(colSize);
     
      row.removeChild(colStatus);
      row.removeChild(colDeleteButton);
  };
  colDeleteButton.appendChild(button);


    row.appendChild(colSize);
   
    row.appendChild(colStatus);
    row.appendChild(colDeleteButton);


    
}



  
// CKEDITOR.replace('mota');
ClassicEditor
.create( document.querySelector( '#mota' ) )
.catch( error => {
    console.error( error );
} );


