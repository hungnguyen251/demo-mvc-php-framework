<?php 
/**
 * Lấy ra lỗi validate từ Request để gọi vào view
 */
$sessionKey = Session::isInvalid();
$errors = Session::flash($sessionKey. '_errors_validate');
if (!function_exists('formError')) {
    function formError($fieldName, $before='', $after='') {
        global $errors;
        if (!empty($errors) && array_key_exists($fieldName, $errors)) {
            return $before.$errors[$fieldName].$after;
        }
        return false;
    }
}

/**
 * Lấy ra dữ liệu người dùng đã nhập từ Request để hiển thị lại
 */
$oldData = Session::flash($sessionKey. '_old_data');
if (!function_exists('oldData')) {
    function oldData($fieldName, $default='') {
        global $oldData;
        if (!empty($oldData[$fieldName])) {
            return $oldData[$fieldName];
        }
        
        return $default;
    }
}

/**
 * Lấy ra dữ liệu người dùng đã nhập từ Request để hiển thị lại
 */
if (!function_exists('uploadFileImage')) {
    function uploadFileImage($imageFile) {
        //Check file ảnh upload
        $target_dir = __WEB__ROOT."/public/dist/img/";
        //Đường dẫn lưu file trên server
        $target_file   = $target_dir . basename($imageFile["name"]);

        $allowUpload   = true;
        //Lấy phần mở rộng của file (txt, jpg, png,...)
        $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        //Những loại file được phép upload
        $allowtypes    = array('jpg', 'png', 'jpeg');
        //Kích thước file lớn nhất được upload (bytes)
        $maxfilesize   = 10000000;//10MB

        //1. Kiểm tra file có bị lỗi không?
        if ($imageFile['error'] != 0) {
        $errUpload = "<br>File bạn chọn đã bị lỗi.";
        }

        //2. Kiểm tra loại file upload có được phép không?
        if (!in_array($fileType, $allowtypes )) {
        $errUpload = "<br>Chỉ chấp nhận file ảnh có đuôi là png, jpg, jpeg.";
        $allowUpload = false;
        }
        
        //3. Kiểm tra kích thước file upload có vượt quá giới hạn cho phép
        if ($imageFile["size"] > $maxfilesize) {
        $errUpload = "<br>Vượt quá kích thước cho phép là 10MB";
        $allowUpload = false;
        }

        //4. Kiểm tra file đã tồn tại trên server chưa?
        if (file_exists($target_file)) {
        $errUpload = "<br>Đã tồn tại file này trên hệ thống.";
        $allowUpload = false;
        }

        if ($allowUpload) {
            //Lưu file vào thư mục được chỉ định trên server
            if (move_uploaded_file($imageFile["tmp_name"], $target_file)) {
                $errUpload = "<br>File ". basename( $imageFile["name"])." tải lên thành công.";
            } else {
                $errUpload = "<br>Xảy ra lỗi trong quá trình tải ảnh.";
            }
        }

        return $errUpload;
    }
}
?>