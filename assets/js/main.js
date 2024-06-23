function checkLogin() {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  });
  Toast.fire({
    icon: "warning",
    title: "Bạn cần đăng nhập trước!",
  });
}
// Đảm bảo trang đã tải xong HTML trước khi thực hiện JavaScript
document.addEventListener("DOMContentLoaded", function () {
  // Lấy danh sách các carousel item và các nút prev, next
  var carouselItems = document.querySelectorAll('.carousel-item');
  var prevButton = document.querySelector('.carousel-control-prev');
  var nextButton = document.querySelector('.carousel-control-next');

  // Lấy chỉ số hiện tại của carousel
  var currentIndex = 0;

  // Hàm chuyển đổi slide
  function showSlide(index) {
    // Ẩn tất cả các slide
    carouselItems.forEach(function (item) {
      item.classList.remove('active');
    });

    // Hiển thị slide ứng với index được truyền vào
    carouselItems[index].classList.add('active');
  }

  // Hiển thị slide đầu tiên khi trang được tải
  showSlide(currentIndex);

  // Xử lý sự kiện khi nhấn nút Previous
  prevButton.addEventListener('click', function () {
    currentIndex--;
    if (currentIndex < 0) {
      currentIndex = carouselItems.length - 1;
    }
    showSlide(currentIndex);
  });

  // Xử lý sự kiện khi nhấn nút Next
  nextButton.addEventListener('click', function () {
    currentIndex++;
    if (currentIndex >= carouselItems.length) {
      currentIndex = 0;
    }
    showSlide(currentIndex);
  });

  // Tự động chuyển slide sau mỗi 5 giây
  setInterval(function () {
    currentIndex++;
    if (currentIndex >= carouselItems.length) {
      currentIndex = 0;
    }
    showSlide(currentIndex);
  }, 4000);
});

//luot xem
function viewSanpham(masp, makh) {
  $.ajax({
    type: "POST",
    url: "components/action.php",
    data: { action: "view", masp: masp, makh: makh },
    success: function (response) {
      $("#view-count").text(response);
    },
  });
}

// function viewSanpham(masp, makh, district, city) {
//   $.ajax({
//       type: "POST",
//       url: "components/action.php",
//       data: { action: "view", masp: masp, makh: makh, district: district, city: city },
//       success: function (response) {
//           $("#view-count").text(response);
//       },
//   });
// }


let timer;
let timeCounter = 0;
let masp; // Khai báo biến masp ở cấp độ toàn cục
let typetrack;

function startTimer(element) {
  // Lấy masp từ thuộc tính data-masp
  masp = element.getAttribute('data-masp');
  typetrack = 2;
  // Khởi động đồng hồ
  timer = setInterval(() => updateTime(), 1000);
}

function endTimer() {
  clearInterval(timer);
  if (timeCounter > 3) {
    saveTime(); // Không cần truyền masp ở đây vì nó là biến toàn cục
  }
  timeCounter = 0;
}

function updateTime() {
  timeCounter++;
}

function saveTime() {
  $.ajax({
    type: "POST",
    url: "components/action.php",
    data: { action: "timetracking", masp: masp, timeCounter: timeCounter, typetrack: typetrack, },
    success: function (response) {
      console.log("Request successful!");
    },
  });
}

//chuyển ảnh
function changeImage(image) {
  document.getElementById('currentImage').src = image;
}


// thêm giỏ hàng và mua
let idsize = null;

function selectSize(size) {
  // Loại bỏ lớp "selected" từ tất cả các kích thước trước đó
  $('.size-option').removeClass('selected');
  // Thêm lớp "selected" cho kích thước được chọn
  $(`#size-label-${size}`).addClass('selected');
  idsize = size;
}
function addCartSizeView(masp) {
  // Kiểm tra xem đã chọn size chưa
  var selectedSize = document.querySelector('input[name="size"]:checked');

  if (!selectedSize) {
    // Nếu chưa chọn size, hiển thị thông báo với SweetAlert2
    Swal.fire({
      icon: 'warning',
      title: 'Vui lòng chọn kích thước',
      text: 'Bạn cần chọn kích thước trước khi thêm vào giỏ hàng.',
    });
    return;
  }
  $.ajax({
    type: "POST",
    url: "./components/action.php",
    data: {
      action: "add",
      masp: masp,
      idsize: idsize
    },
    success: function (response) {
      console.log(response);
      $("#cart-item").text(response);
      Swal.fire({
        icon: "success",
        title: "Đã thêm vào giỏ",
        confirmButtonText: "Đóng",
      });
    },
  });

}

function buyNowView(masp) {
  // Kiểm tra xem đã chọn size chưa
  var selectedSize = document.querySelector('input[name="size"]:checked');
  const cartDiv = document.querySelector('.navbar-display-cart');


  if (!selectedSize) {
    // Nếu chưa chọn size, hiển thị thông báo với SweetAlert2
    Swal.fire({
      icon: 'warning',
      title: 'Vui lòng chọn kích thước',
      text: 'Bạn cần chọn kích thước trước khi thêm vào giỏ hàng.',
    });
    return;
  }
  $.ajax({
    type: "POST",
    url: "./components/action.php",
    data: {
      action: "add",
      masp: masp,
      idsize: idsize
    },
    success: function (response) {
      console.log(response);
      $("#cart-item").text(response);
      cartDiv.click();
    },
  });
}