<?php 
function getAuthorByBook($ID) {
    $db = Database::getInstance();
    $args = prepareWhere(array('k.id_ksiazka' => $ID));
    $where = 'WHERE ' . $args;
    $sql = "SELECT a.* FROM autor AS a
    INNER JOIN ksiazka_autor AS ka ON a.id_autor = ka.id_autor 
    INNER JOIN ksiazka AS k ON ka.id_ksiazka = k.id_ksiazka " . $where . " ";

    $author = $db->select($sql, 'Author');
    return (isset($author[0])) ? $author : false;
}

function selectAuthor($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols);
    if(!empty($args))
        $where .= 'WHERE ' . $args; 
    $orderby = 'ORDER BY nazwisko ASC';
    $author = $db->select("SELECT * FROM autor " . $where . " " . $orderby . "", 'Author');
    return (isset($author[0])) ? $author : false;
}

function getOneAuthor($cols) {
    $author = selectAuthor($cols);
    return (isset($author[0])) ? $author[0] : false;
}

function getAuthor($ID) {
    $cols = array('id_autor' => $ID);
    return getOneAuthor($cols);
}

function getAuthorByName($name, $lastname = '') {
    $cols = array('imie' => $name, 'nazwisko' => $lastname);
    return getOneAuthor($cols);
}

function addAuthor($name, $lastname = '') {
    $db = Database::getInstance();
    $newAuthor = false;

    if($name != '') {
        $cols = array('imie' => $name, 'nazwisko' => $lastname);
        $value = prepareInsert($cols);
        $newAuthor = $db->insert("INSERT INTO autor " . $value . "");
    }

    return ($newAuthor) ? $db->insertID : false;
}