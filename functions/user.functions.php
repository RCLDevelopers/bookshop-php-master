<?php

function selectUser($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols); //przygotowanie klauzuli WHERE
    if(!empty($args))
        $where .= 'WHERE ' . $args; 
    $user = $db->select("SELECT * FROM czytelnik " . $where . "", 'User');
    return (isset($user[0])) ? $user : false;
}

function addUser($login, $password, $email) { //nowe konto
    $db = Database::getInstance();
    $newUser = false;

    if($login != '' &&  $password != '' && $email != '') {
        $cols = array('login' => $login, 'haslo' => $password, 'email' => $email);
        $value = prepareInsert($cols); //przygotowanie kolumn i ich wartości
        $newUser = $db->insert("INSERT INTO czytelnik " . $value . "");
    }

    return ($newUser) ? $db->insertID : false; //zwraca nowe ID z bazy
}

function updateUser($colsUpdate = array(), $colsWhere = array()) {
    $db = Database::getInstance();
    $where = '';
    $set = prepareUpdate($colsUpdate);
    $args = prepareWhere($colsWhere);
    $where .= 'WHERE ' . $args;
    $return = $db->update("UPDATE czytelnik SET " . $set . " " . $where . "");
    return $return;
}

function checkUserPassword($login, $password) { //sprawdza poprawność hasło podczas logowania
    $cols = array('login' => $login, 'haslo' => $password);
    $user = selectUser($cols);
    return ($user) ? true : false;
}

function getOneUser($cols) {
    $user = selectUser($cols);
    return (isset($user[0])) ? $user[0] : false;
}

function getUser($ID) {
    $cols = array('id_czytelnik' => $ID);
    return getOneUser($cols);
}

function getUserByEmail($email) {
    $cols = array('email' => $email);
    return getOneUser($cols);
}

function getUserID($login) {
    $cols = array('login' => $login);
    $user = getOneUser($cols);
    return ($user) ? $user->id_czytelnik : 0;
}

function getUserPassword($userID) {
    $db = Database::getInstance();
    $cols = array('id_czytelnik' => $userID);
    $where = prepareWhere($cols);
    $user = $db->select("SELECT haslo FROM czytelnik WHERE " . $where . "");
    return (isset($user[0])) ? $user[0]->haslo : '';
}

function userExist($login) { //sprawdzenia czy użytkownik istnieje; do walidacji formularza
    return (getUserID($login) != 0) ? true : false;
}

function emailExist($email) { //sprawdzenia czy email istnieje; do walidacji formularza
    $cols = array('email' => $email);
    $user = selectUser($cols);
    return ($user) ? true : false;
}


function resetPassword($userID, $password) {
    $colsUpdate = array('haslo' => $password);
    $colsWhere = array('id_czytelnik' => $userID);
    return updateUser($colsUpdate, $colsWhere);
}

