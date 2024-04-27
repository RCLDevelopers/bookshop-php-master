<?php

//if($currUser->isModerator()) :

    $action  = isset($_GET['action']) ? $_GET['action'] : "";

    if($action == 'add_book') {
        include  'admin/add_book.php';
    }
    else if ($page == 'add_category') { // książka
        include 'admin/add_category.php';
    }
    else {
        header('Location: ' . URL . '/index.php?page=404');
    }


//else :

//endif;
