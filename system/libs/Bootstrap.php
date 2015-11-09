<?php

class Bootstrap {

    public $_url;
    public $_controllerName;
    public $_methodName = 'index';
    public $_controllerPath = 'app/controllers/';
    //şu an çalışan controller
    public $_controller;

    //construct yönlendirmeyi yapacak
    public function __construct() {
        //aşağıdaki fonksiyon url i alıypruz $this->_url şeklinde
        $this->getUrl();
        //class yükleme
        $this->loadController();
        $this->callMethod();
    }

    //url i alıyoruz ilk iş olarak
    public function getUrl() {
        $this->_url = isset($_GET["url"]) ? $_GET["url"] : null;
        if ($this->_url != null) {
            $this->_url = rtrim($this->_url, "/");
            $this->_url = explode("/", $this->_url);
        } else {
            unset($this->_url);
        }
    }

    public function loadController() {
        //set değilse index in indexler
        if (count($this->_url) == 0) {
            $this->_controllerName = "Home";
            if (!isset($this->_url[0])) {
                include $this->_controllerPath . 'Home.php';
                $this->_controller = new $this->_controllerName();
            } else {
                $fileName = $this->_controllerPath . "Home.php";
                if (file_exists($fileName)) {
                    include $fileName;
                    //class varsa
                    if (class_exists($this->_controllerName)) {
                        //sınıf çağırma
                        $this->_controller = new $this->_controllerName();
                    } else {
                        
                    }
                } else {
                    
                }
            }
        } else if (count($this->_url) == 1) {
            $this->_controllerName = "PagerLoad";

            if (!isset($this->_url[0])) {
                include $this->_controllerPath . $this->_controllerName . '.php';
                $this->_controller = new $this->_controllerName();
            } else {
                $fileName = $this->_controllerPath . $this->_controllerName . ".php";
                if (file_exists($fileName)) {
                    include $fileName;
                    //class varsa
                    if (class_exists($this->_controllerName)) {
                        //sınıf çağırma
                        $this->_controller = new $this->_controllerName();
                    } else {
                        
                    }
                } else {
                    
                }
            }
        } else {
            if (!isset($this->_url[0])) {
                include $this->_controllerPath . $this->_controllerName . '.php';
                $this->_controller = new $this->_controllerName();
            } else {
                $this->_controllerName = $this->_url[0];
                $fileName = $this->_controllerPath . $this->_controllerName . ".php";
                if (file_exists($fileName)) {
                    include $fileName;
                    //class varsa
                    if (class_exists($this->_controllerName)) {
                        //sınıf çağırma
                        $this->_controller = new $this->_controllerName();
                    } else {
                        
                    }
                } else {
                    
                }
            }
        }
    }

    public function callMethod() {
        //paremetre varsa
        if (count($this->_url) == 0) {
            if (isset($this->_url[1])) {
                //method ismini atıyorum
                $this->_methodName = "index";
                if (method_exists($this->_controller, $this->_methodName)) {
                    //paremetesiz metodu çağırma
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Coontroller içinde bulunmadı";
                    header("Location:" . SITE_URL);
                }
            } else {
                if (method_exists($this->_controller, $this->_methodName)) {
                    //kullanıcı bi metod girmedi ise ilgili kontrolün metodunu çağır yani default gibi
                    //control adını girmişim ama method girmemişim
                    //heryere index metodu girmeliyim ki ayni sınıfa kullanıcı sadece controller girmiş olsa da bu metdo çalışsın
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Controller içinde İndex metodu bulunamadı bulunmadı";
                    header("Location:" . SITE_URL);
                }
            }
        } else if (count($this->_url) == 1) {
            $this->_methodName = "index";
            if (isset($this->_url[1])) {
                //method ismini atıyorum
                if (method_exists($this->_controller, $this->_methodName)) {
                    //paremetesiz metodu çağırma
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Coontroller içinde bulunmadı";
                    header("Location:" . SITE_URL);
                }
            } else {
                if (method_exists($this->_controller, $this->_methodName)) {
                    //kullanıcı bi metod girmedi ise ilgili kontrolün metodunu çağır yani default gibi
                    //control adını girmişim ama method girmemişim
                    //heryere index metodu girmeliyim ki ayni sınıfa kullanıcı sadece controller girmiş olsa da bu metdo çalışsın
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Controller içinde İndex metodu bulunamadı bulunmadı";
                    header("Location:" . SITE_URL);
                }
            }
        } else {
            $this->_methodName = $this->_url[1];
            if (isset($this->_url[1])) {
                //method ismini atıyorum
                if (method_exists($this->_controller, $this->_methodName)) {
                    //paremetesiz metodu çağırma
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Coontroller içinde bulunmadı";
                    header("Location:" . SITE_URL);
                }
            } else {
                if (method_exists($this->_controller, $this->_methodName)) {
                    //kullanıcı bi metod girmedi ise ilgili kontrolün metodunu çağır yani default gibi
                    //control adını girmişim ama method girmemişim
                    //heryere index metodu girmeliyim ki ayni sınıfa kullanıcı sadece controller girmiş olsa da bu metdo çalışsın
                    $this->_controller->{$this->_methodName}();
                } else {
                    //echo "Controller içinde İndex metodu bulunamadı bulunmadı";
                    header("Location:" . SITE_URL);
                }
            }
        }
    }

}
?>

