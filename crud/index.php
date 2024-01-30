<?PHP
require './model/UserModel.php';
$user = new UserModel();
$user__Get_All = $user->User__Get_All();
?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h3 class="section-title">Danh sách tài khoản</h3>
            <div class="table-responsive">
                <table border="0" id="table_js" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên hiển thị</th>
                            <th>Tên tài khoản</th>
                            <th>Phân quyền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($user__Get_All as $item) : ?>
                            <tr>
                                <td><?= $item->mauser ?></td>
                                <td><?= $item->tenhienthi ?></td>
                                <td><?= $item->username ?></td>
                                <td><?= $item->phanquyen == 0 ? 'admin' : ($item->phanquyen == 1 ? 'Nhân viên': 'Khách hàng')  ?></td>
                                <td><?= $item->trangthai == 1 ? 'Hoạt động' : 'Khoá'?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="update_obj(<?= $item->mauser ?>)">Sửa</button>
                                    <button class="btn btn-sm btn-danger" onclick="delete_obj(<?= $item->mauser ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4">
            <div class="main-form">
                <?php require_once 'add.php' ?>
            </div>
        </div>
    </div>
</div>

<script>
    function update_obj(mauser) {
        $.post("crud/update.php", {
            mauser: mauser,
        }, function(data, status) {
            $(".main-form").html(data);
        });
    };

    function delete_obj(mauser) {
        var confirmation = confirm("Bạn có chắc chắn muốn xóa người dùng có ID " + mauser + "?");

        if (confirmation) {
            $.post("crud/action.php?req=delete&mauser=" + mauser,  function(data, status) {
                alert("Người dùng có ID " + mauser + " đã được xóa!");
                location.reload();
            });
        }
    }
</script>