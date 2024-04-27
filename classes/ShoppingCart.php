<?php 
class ShoppingCart {
    
    public $currUser,
            $sessionCart = array(),
            $order;

    public function __construct($currUser) {
        $this->currUser = $currUser;
        if($this->currUser->isLoggedIn()) { 
            $this->order = getNewOrder($this->currUser->getUser()->id_czytelnik); //nowe lub obecne zamowienia (w koszyku)
        }
        
        $_SESSION['session_cart'] = (isset($_SESSION['session_cart'])) ? $_SESSION['session_cart'] : array(); //koszyk dla niezarejestrowanych użytkowników
        $this->sessionCart = $_SESSION['session_cart'];

    }

    public function addBook($bookID, $count) { //dodanie ksiazki do koszyka
        $add = false;
        if($this->currUser->isLoggedIn())
           $add = addOrderBook($this->order->id_zamowienie, $bookID, $count); 
        else {
            $this->addSessionCart($bookID, $count);
            $add = true;
        }
        return $add;
    }

    public function getBook() { // lista książek w koszyku
        $books = array();
        if($this->currUser->isLoggedIn())
            $books = getBookByOrder($this->order->id_zamowienie);
        else
            foreach($this->sessionCart as $bookCart) { 
                $book = getBook($bookCart['book_id']);
                if($book)
                    $books[] = $book;
            }
        return $books;
    }

    public function getCount($bookID) { // zwraca ilość zamowionych książek (osobno dla każdej książki)
        $count = 1;
        if($this->currUser->isLoggedIn())
            $count = getOrderBook($this->order->id_zamowienie, $bookID)->ilosc_sztuk;
        else
            foreach($this->sessionCart as $bookCart) {
                if($bookCart['book_id'] == $bookID) {
                    $count = $bookCart['count'];
                    break;
                }
            }
        return $count;
    }

    public function getCost() { //całkowity koszt książek w koszyku
        $cost = 0;
        if($this->currUser->isLoggedIn())
            $cost = getOrderCost($this->order->id_zamowienie);
        else
            foreach($this->sessionCart as $bookCart) {
                $book = getBook($bookCart['book_id']);
                if($book)
                    $cost += $bookCart['count'] * $book->cena;         
            }

        if(!$cost)
            $cost = '0.00';
        return $cost;
    }

    public function updateCount($bookID, $count) { //zmienia ilość zamówionych książek
        $update = false;
        if($this->currUser->isLoggedIn()) {
            $book = getBook($bookID);
            if($book) {
                if($count > 0) {
                    $count = ($book->ilosc_sztuk < $count) ? $book->ilosc_sztuk : $count;
                    $colsUpdate = array('ilosc_sztuk' => $count);
                    $colsWhere = array('id_zamowienie' => $this->order->id_zamowienie, 'id_ksiazka' => $bookID);
                    $update = updateOrderBook($colsUpdate, $colsWhere);
                }
                else 
                    $update = $this->deleteBook($bookID);
            }
        }
        else {
            $this->addSessionCart($bookID, $count);
            $update = true;
        }
        return $update;
    }

    public function deleteBook($bookID) { //usunięcie książki z koszyka
        $delete = false;
        if($this->currUser->isLoggedIn()) {
            $colsWhere = array('id_zamowienie' => $this->order->id_zamowienie, 'id_ksiazka' => $bookID);
            $delete = deleteOrderBook($colsWhere);
        }
        else {
            $this->deleteSessionCart($bookID);
            $delete = true;
        }
        return $delete;
    }



    private function addSessionCart($bookID, $count) { //dodaje i edytuje zamowienie dla niezarejestrowanego użytkownika
        $add = false;
        $book = getBook($bookID);
        if($book) {
            $count = ($book->ilosc_sztuk < $count) ? $book->ilosc_sztuk : $count;
            $i = 0;
            foreach($_SESSION['session_cart'] as $bookCart) {
                if($bookCart['book_id'] == $bookID) {
                    $add = true;
                    $_SESSION['session_cart'][$i]['count'] = $count;
                    break;
                }
                $i++;
            }

            if(!$add) { //dodanie książki 
                $_SESSION['session_cart'][] = array(
                    'book_id' => $bookID,
                    'count' => $count
                );
            }
            $this->sessionCart = $_SESSION['session_cart'];
        }
        
    }

    private function deleteSessionCart($bookID) { 
        $i = 0;
        foreach($_SESSION['session_cart'] as $bookCart) {
            if($bookCart['book_id'] == $bookID) {
                unset($_SESSION['session_cart'][$i]);
                break;
            }
            $i++;
        }
        $this->sessionCart = $_SESSION['session_cart'];
    }
    
}