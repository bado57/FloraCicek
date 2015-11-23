<?php

class Cookie {

    //get ve set cookie değişkeni tanımlama ve tanımladığım değişkeni alma şeklinde
    public static function set($key, $val) {
        //istediğim her yerden değer atayabiliyorum
        setcookie($key, $val, time() + (60 * 60 * 60 * 24));
    }

    //get cookie
    public static function get($key) {
        if (isset($_COOKIE[$key])) {
            return $_COOKIE[$key];
        } else {
            return false;
        }
    }

    //delete cookie
    public static function deleteCookie($key, $val) {
        setcookie($key, $val, time() - 3600);
    }

    //change cookie
    public static function changeCookie($key, $val) {
        setcookie($key, $val);
    }

    //cookie varmı
    public static function chechkCookie($key) {
        if (isset($_COOKIE['olmayan'])) {
            return true;
        } else {
            return false;
        }
    }

}

//Kullanımı=>Cookie::get($key)
?>

