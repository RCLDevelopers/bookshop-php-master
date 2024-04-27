<?php 

function selectPublisher($cols = array()) {
    $db = Database::getInstance();
    $where = '';
    $args = prepareWhere($cols);
    if(!empty($args))
        $where .= 'WHERE ' . $args;
    $orderby = 'ORDER BY nazwa ASC';
    $pub = $db->select("SELECT * FROM wydawnictwo " . $where . " " . $orderby . "", 'Publisher');
    return (isset($pub[0])) ? $pub : false;
}

function getOnePublisher($cols) {
    $pub = selectPublisher($cols);
    return (isset($pub[0])) ? $pub[0] : false;
}

function getPublisher($ID) {
    $cols = array('id_wydawnictwo' => $ID);
    return getOnePublisher($cols);
}

function getPublisherByName($name) {
    $cols = array('nazwa' => $name);
    return getOnePublisher($cols);
}

function addPublisher($name) {
    $db = Database::getInstance();
    $newPub = false;

    if($name != '') {
        $cols = array('nazwa' => $name);
        $value = prepareInsert($cols);
        $newPub = $db->insert("INSERT INTO wydawnictwo " . $value . "");
    }

    return ($newPub) ? $db->insertID : false;
}