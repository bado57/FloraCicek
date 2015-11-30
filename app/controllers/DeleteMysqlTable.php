<?php

class DeleteMysqlTable extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->deleteTable();
    }

    public function deleteTable() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        //Geçiçi Sipariş Tablosunu tamamen boşaltıyorum
        $deletefullsiparis = $Panel_Model->geciciSiparisFullDelete();
        if ($deletefullsiparis) {
            //işleminiz tamamlandı :)
        } else {
            $deletefullsiparis = $Panel_Model->geciciSiparisFullDelete();
        }
    }

}

?>