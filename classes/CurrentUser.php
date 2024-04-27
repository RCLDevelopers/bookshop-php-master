<?php
class CurrentUser {

    private $user,
            $isLoggedIn = false,
            $cart;

    public function __construct() {
        $session = isset($_SESSION['login']) ? $_SESSION['login'] : false;
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        if($session) { // true = użytkoniwk zalogowany
            if($this->setUserData($user_id))
                 $this->isLoggedIn = true;
        }
        else {
            $this->isLoggedIn = false;
            $this->user = null;
        }

        $this->cart = new ShoppingCart($this);
    }

    private function setUserData($ID) { //utworzenie obiektu klasy User
        $user = getUser($ID);
        if($user)
            $this->user = $user;
        return ($user) ? true : false;
    }

    public function getUser() {
        return $this->user;
    }

    public function isLoggedIn() {
        return $this->isLoggedIn;
    }

     public function logOut() {
        session_unset();
    }

     public function getCart() {
        return $this->cart;
    }


}