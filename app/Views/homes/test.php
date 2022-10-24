<?php
echo '<pre>';
echo (!empty($msg))?$msg:false;
echo '</pre>';
?>

<form action="<?php echo __WEB__ROOT; ?>/home/test" method="post">
    <input type="text" name='fullname' placeholder="Nhập họ và tên" value="<?php echo oldData('fullname'); ?>"></br>
    <?php echo formError('fullname', '<span style="color:red;">','</span>') ;?></br>
    <input type="text" name='email' placeholder="Nhập email"></br>
    <?php echo formError('email', '<span style="color:red;">','</span>') ;?></br>
    <input type="text" name='password' placeholder="Nhập mật khẩu"></br>
    <?php echo formError('password', '<span style="color:red;">','</span>') ;?></br>
    <input type="text" name='confirm_password' placeholder="Xác nhận mk"></br>
    <?php echo formError('confirm_password', '<span style="color:red;">','</span>') ;?></br>
    <input type="text" name='phone' placeholder="Nhập số điện thoại"></br>
    <?php echo formError('phone', '<span style="color:red;">','</span>');?></br>
    <button type="submit">Submit</button>
</form>