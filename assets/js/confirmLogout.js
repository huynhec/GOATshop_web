
function confirmLogout() {
    Swal.fire({
        title: 'Xác nhận đăng xuất',
        text: 'Bạn có chắc chắn muốn đăng xuất không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Hủy',
    }).then((result) => {
        // Nếu người dùng đồng ý, thực hiện đăng xuất
        if (result.isConfirmed) {
            window.location.href = "../auth/pages/action.php?req=dang-xuat";
        }
    });

    return false; // Ngăn chặn hành động mặc định của thẻ 'a'
}
