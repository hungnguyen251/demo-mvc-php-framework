<?php

class JsonResponse
{
    /*
    * return Json Http Response
    */
    static public function json($data=[]) {
        //Xóa bất kì chuỗi có thể tạo ra lỗi JSON như PHP Notice...
        ob_clean();

        //Xóa các header nếu được thêm trước đó
        header_remove(); 

        //Thiết lập header Content type to JSON
        header("Content-type: application/json; charset=utf-8");

        //Thiết lập HTTP response code, 2xx = SUCCESS, 
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(["jsonError" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"jsonError":"unknown"}';
            }
            //Thiết lập HTTP response code: 500 - Internal Server Error
            http_response_code(500);
        } else {
            //Thiết lập HTTP response code, 2xx = SUCCESS, 
            http_response_code(200);
        }

        // encode trả ra dữ liệu dang json
        echo $json;

        exit();
    }
}