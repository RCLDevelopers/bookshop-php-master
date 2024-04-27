<?php

function selectOrder($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols); //przygotowanie klauzuli WHERE
    if(!empty($args))
        $where .= 'WHERE ' . $args;
    $order = $db->select("SELECT * FROM zamowienie " . $where . "", 'Order');
    return (isset($order[0])) ? $order : false;
}

function addOrder($cols) { //nowa zamowienie
    $db = Database::getInstance();
    $newOrder = false;

    if($cols['id_czytelnik'] != '' &&  $cols['data_wystawienia'] != '') {
        $value = prepareInsert($cols); //przygotowanie kolumn i ich wartości
        $newOrder = $db->insert("INSERT INTO zamowienie " . $value . "");
    }

    return ($newOrder) ? $db->insertID : false; //zwraca nowe ID z bazy
}

function getOneOrder($cols) {
    $order = selectOrder($cols);
    return (isset($order[0])) ? $order[0] : false;
}

function getOrder($ID) {
    $cols = array('id_zamowienie' => $ID);
    $order = selectOrder($cols);
    return getOneOrder($cols);
}

function getNewOrder($userID) {
    $cols = array('id_czytelnik' => $userID, 'zrealizowane' => '0');
    $order = getOneOrder($cols);
    if(!$order) {
        $cols = array(
            'id_czytelnik' => $userID, 
            //'koszt' => '0.00',
            'data_wystawienia' => date("Y-m-d H:i:s")
            //'zrealizowane' => '0'
            );
        $orderID = addOrder($cols);
        if($orderID)
            $order = getOrder($orderID);
    }
    return ($order) ? $order : false;
}

function getOrderCost($orderID) {
    $db = Database::getInstance();
    $where = '';
    $cols = array('zk.id_zamowienie' => $orderID);
    $args = prepareWhere($cols);
    if(!empty($args))
        $where .= 'WHERE ' . $args;
    $cost = $db->select("SELECT SUM(k.cena * zk.ilosc_sztuk) as cost FROM ksiazka AS k
    INNER JOIN zamowienie_ksiazka AS zk ON k.id_ksiazka = zk.id_ksiazka " . $where . "");

    return (isset($cost[0])) ? $cost[0]->cost : false;
}