<?php

class Response
{
    public function redirect($uri='', $http_response_code = 301) {
        if (preg_match('~^(http|https)~is', $uri)) {
            $url = $uri;
        } else {
            $url = __WEB__ROOT.'/'.$uri;
        }

        header("Location: " .$url);
        exit;
    }

    /**
     * Response array->json
     */
    public function json($data=[]) {
        //Xóa bất kì chuỗi có thể tạo ra lỗi JSON như PHP Notice...
        ob_clean();

        //Xóa các header nếu được thêm trước đó và Thiết lập header Content type to JSON
        header_remove(); 
        header("Content-type: application/json; charset=utf-8");

        //Thiết lập HTTP response code, 2xx = SUCCESS, 
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(["jsonError" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"jsonError":"Đã xảy ra lỗi"}';
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

    /**
     * Response array->xml
     */
    public function handleXml($data=[], $xmlData) {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (is_array($value)) {            
                    if (!is_numeric($key)) {
                        //Thêm phần tử key vào trong XML node 
                        $xmlData = $xmlData->addChild($key);
                        $this->handleXml($value, $xmlData);
                    } else {
                        $this->handleXml($value, $xmlData);
                    }
                } else {
                    $xmlData->addChild($key, $value);
                }
            }
        }
    }

    public function toXml($data=[]) {
        if (!empty($data)) {
            $xmlData = new SimpleXMLElement('<?xml version="1.0"?><data></data>');
            $this->handleXml($data,$xmlData);
            
            $domXml = new DOMDocument();
            //Định dạng đầu ra xuống dòng
            $domXml->formatOutput = true;
            $domXml->loadXML($xmlData->asXML());

            echo htmlentities($domXml->saveXML());
            exit();
        }

        return false;
    }
}