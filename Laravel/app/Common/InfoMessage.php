<?php
namespace App\Common;
class InfoMessage {
    public function Index() {
        echo \Session::get('message_error')?'<p class="alert alert-danger" role="alert">'.(\Session::get('message_error')).'</p>':'';
        echo \Session::get('message_success')?'<p class="alert alert-success" role="alert">'.(\Session::get('message_success')).'</p>':'';
        echo \Session::get('message_warning')?'<p class="alert alert-warning" role="alert">'.(\Session::get('message_warning')).'</p>':'';
    }
    public function Error($info){
        return '<p class="alert alert-danger" role="alert">'.$info.'</p>';
    }
    public function Success($info){
        return '<p class="alert alert-success" role="alert">'.$info.'</p>';
    }
    public function Warning($info){
        return '<p class="alert alert-warning" role="alert">'.$info.'</p>';
    }
}
