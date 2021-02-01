<?php   

    class Captcha {

        private $code;
    
        public function setCaptcha() {
    
            $this->$code = rand(1000, 5000);
            return $code;
        }
    }

?>