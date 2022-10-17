<?php
use App\App;

class Session 
{
    /**
     *  Check data(key, value) =>set session
     *  Check data(key) =>get session
     */
    static public function data($key='',$value='') {
        $sessionKey = self::isInvalid();

        if (!empty($value)) {
            if (!empty($key)) {
                $_SESSION[$sessionKey][$key] =  $value; //Set session
                return true;
            }
            return false;

        } else {
            if (empty($key)) {
                if (isset($_SESSION[$sessionKey])) {
                    return $_SESSION[$sessionKey];
                }
            } else {
                if (isset($_SESSION[$sessionKey][$key])) {
                    return $_SESSION[$sessionKey][$key]; //Get session
                }
            }
        }
    }

    /**
     * Xoa key cua session hoac xoa toan bo
     */
    static public function delete($key='') {
        $sessionKey = self::isInvalid();

        if (!empty($key)) {
            if (isset($_SESSION[$sessionKey][$key])) {
                unset($_SESSION[$sessionKey][$key]);
                return true;
            }
            return false;
        } else {
            unset($_SESSION[$sessionKey]);
            return true;
        }

        return false;
    }

    /**
     * Flash session, giong session nhung se xoa session sau khi lay du lieu
     */
    static public function flash($key='',$value='') {
        $flashSession = self::data($key,$value);
        if (empty($value)) {
            self::delete($key);
        }

        return $flashSession;
    }

    static public function showErrors($message) {
        $data = ['message' => $message];
        App::$app->loadError('exception', $data);
        die();
    }

    static public function isInvalid() {
        global $config;
        
        if (!empty($config['session'])) {
            $sessionConfig = $config['session'];
            if (!empty($sessionConfig['session_key'])) {
                $sessionKey = $sessionConfig['session_key'];
                return $sessionKey;
            } else {
                self::showErrors('Thiếu cấu hình session, vui lòng kiểm tra lại file session.php');
            }
        } else {
            self::showErrors('Thiếu cấu hình session, vui lòng kiểm tra lại file session.php');
        }
    }
}