<?php
/**
 * Created by PhpStorm.
 * User: Georgi
 * Date: 02-Oct-15
 * Time: 10:11 PM
 */

namespace MVCFramework\ViewHelpers;


class CsrfToken
{
    private function __construct(){
        self::createToken();
    }

    public static function create(){
        return new self();
    }

    private function createToken(){
        $_SESSION["token"] = md5(uniqid(mt_rand(), true));
    }

    public function render() {
        echo "<input type='hidden' name='csrf' value='". $_SESSION["token"]."'>";
    }
}