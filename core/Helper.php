<?php 
// /**
//  * Lấy ra lỗi validate từ Request để gọi vào view
//  */
// $sessionKey = Session::isInvalid();
// $errors = Session::flash($sessionKey. '_errors_validate');
// if (!function_exists('formError')) {
//     function formError($fieldName, $before='', $after='') {
//         global $errors;
//         if (!empty($errors) && array_key_exists($fieldName, $errors)) {
//             return $before.$errors[$fieldName].$after;
//         }
//         return false;
//     }
// }

// /**
//  * Lấy ra dữ liệu người dùng đã nhập từ Request để hiển thị lại
//  */
// $oldData = Session::flash($sessionKey. '_old_data');
// if (!function_exists('oldData')) {
//     function oldData($fieldName, $default='') {
//         global $oldData;
//         if (!empty($oldData[$fieldName])) {
//             return $oldData[$fieldName];
//         }
        
//         return $default;
//     }
// }
?>