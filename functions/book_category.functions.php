<?php
function addBookCategory($bookID, $catID) {
    $db = Database::getInstance();
    $new = false;

    if($bookID != '' && $catID != '') {
        if(getBook($bookID) && getCategory($catID)) {
            $cols = array('id_ksiazka' => $bookID, 'id_kategoria' => $catID);
            $value = prepareInsert($cols);
            $new = $db->insert("INSERT INTO ksiazka_kategoria " . $value . "");
        }
    }
    return ($new) ? true : false;
}