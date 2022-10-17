<?php
echo '<pre>';
if (!empty($errors)) {
    //Test session gửi từ getUser (UserController)
    echo 'Tổng hợp lỗi từ request->session trong users/add';

    echo '<pre>';
    print_r($errors);
    echo '</pre>';

    echo '<pre>';
    print_r($old);
    echo '</pre>';

    echo '<pre>';
    print_r($msg);
    echo '</pre>';
}
?>

<form action="<?php echo __WEB__ROOT; ?>/user/postuser" method="post">
    <input type="text" name='fullname' placeholder="Nhập họ và tên"></br>
    <input type="text" name='email' placeholder="Nhập email"></br>
    <input type="text" name='password' placeholder="Nhập mật khẩu"></br>
    <input type="text" name='confirm_password' placeholder="Xác nhận mk"></br>
    <input type="text" name='phone' placeholder="Nhập số điện thoại"></br>
    <button type="submit">Submit</button>
</form>