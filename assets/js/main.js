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
