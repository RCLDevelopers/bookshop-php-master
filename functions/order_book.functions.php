<?php
function addOrderBook($orderID, $bookID, $count) { //dodanie książki do koszyka
    $db = Database::getInstance();
    $new = false;

    if($orderID != '' && $bookID != '' && $count > 0) {
        if(getOrder($orderID) && ($book = getBook($bookID))) {
            if($book->ilosc_sztuk >= $count) {
                $orderBook = getOrderBook($orderID, $bookID);
                if($orderBook === false) {
                    $cols = array('id_zamowienie' => $orderID, 'id_ksiazka' => $bookID, 'ilosc_sztuk' => $count);
                    $value = prepareInsert($cols);
                    $new = $db->insert("INSERT INTO zamowienie_ksiazka " . $value . "");
                }
                else { //książka jest w koszyku, zmiana ilości sztuk
                    $colsUpdate = array('ilosc_sztuk' => $count);
                    $colsWhere = array('id_zamowienie' => $orderID, 'id_ksiazka' => $bookID);
                    updateOrderBook($colsUpdate, $colsWhere);
                }
            }
        }
    }
    return ($new) ? true : false;
}

function selectOrderBook($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols);
    if(!empty($args))
        $where .= 'WHERE ' . $args; 
    $orderBook = $db->select("SELECT * FROM zamowienie_ksiazka " . $where . "", 'OrderBook');
    return (isset($orderBook[0])) ? $orderBook : false;
}

function getOrderBook($orderID, $bookID) {
    $cols = array('id_zamowienie' => $orderID, 'id_ksiazka' => $bookID);
    $orderBook = selectOrderBook($cols);
    return (isset($orderBook[0])) ? $orderBook[0] : false;
}


function updateOrderBook($colsUpdate = array(), $colsWhere = array()) {
    $db = Database::getInstance();
    $where = '';
    $set = prepareUpdate($colsUpdate);
    $args = prepareWhere($colsWhere);
    $where .= 'WHERE ' . $args;
    $return = $db->update("UPDATE zamowienie_ksiazka SET " . $set . " " . $where . "");
    return $return;
}

function deleteOrderBook($cols) {
    $db = Database::getInstance();
    $delete = false;
    if(isset($cols['id_zamowienie']) && isset($cols['id_ksiazka'])) {
        $where = '';
        $args = prepareWhere($cols);
        if(!empty($args)) {
            $where .= 'WHERE ' . $args; 
            $delete = $db->delete("DELETE FROM zamowienie_ksiazka " . $where . ""); 
        }    
    }
    return $delete;
}
