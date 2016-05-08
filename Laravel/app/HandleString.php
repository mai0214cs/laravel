<?php
namespace App;
class HandleString {
    public static function Cryption($tring){
        $result = hash_init('md5', HASH_HMAC, 'MaiDucThach');
        hash_update($result, $tring);
        return hash_final($result);
    }
}
