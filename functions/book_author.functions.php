<?php
function addBookAuthor($bookID, $authorID) {
    $db = Database::getInstance();
    $new = false;

    if($bookID != '' && $authorID != '') {
        if(getBook($bookID) && getAuthor($authorID)) {
            $cols = array('id_ksiazka' => $bookID, 'id_autor' => $authorID);
            $value = prepareInsert($cols);
            $new = $db->insert("INSERT INTO ksiazka_autor " . $value . "");
        }
    }
    return ($new) ? true : false;
}