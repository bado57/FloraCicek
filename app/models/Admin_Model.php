<?php
    class Admin_Model extends Model{
        public function __construct() {
            //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
            parent::__construct();
        }
        //kullanıcı giriş kontrolü
        public function userControl($array=array()) {
            $sql="SELECT * FROM fwkullanicilar WHERE fwkullaniciAd=:kadi AND fwkullaniciSifre=:password";
            $count=$this->db->affectedRows($sql,$array);
            if($count>0){
              $sql="SELECT * FROM fwkullanicilar WHERE fwkullaniciAd=:kadi AND fwkullaniciSifre=:password";  
              return $this->db->select($sql,$array);
            }else{
                return false;
            }
        }
    
    }
?>