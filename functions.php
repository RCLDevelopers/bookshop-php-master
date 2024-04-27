<?php

function prepareWhere($cols = array()) { //zamienia array na string
    $args = array();
    foreach ($cols as $field=>$value)
        if($value != '')
			$args[] = $field ." = '".addslashes(trim($value))."'";
    $output = implode( ' AND ', $args ); //rozdziela wartości tablicy; zwraca string
    return $output;
}

function prepareInsert($cols = array()) { //zamienia array na string
    $fields = array_keys( $cols );
    $values = array();
	foreach ($cols as $field=>$value)
	    $values[] = addslashes(trim($value));
    $output = "(" . implode( ',', $fields ) . ") VALUES ('" . implode( "','", $values ) . "')"; // cześć zapytania sql dla insert
    return $output;
}

function prepareUpdate($cols = array()) {
    $args = array();
    foreach ($cols as $field=>$value)
        if($value != '')
			$args[] = $field ." = '".addslashes(trim($value))."'";
    $output = implode( ', ', $args ); //rozdziela wartości tablicy; zwraca string
    return $output;
}

