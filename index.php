<?php

require_once 'init.php'; //dodanie pliku; jeżeli wcześniej plik nie został dodany to go dodaje

$db = Database::getInstance(); //instancja bazy danych

if($db->isConnected) { //sprawdzenie połączenia z bazą danych
    $currUser = new CurrentUser();
    
    //przekierowanie do danej strony
    $page  = isset($_GET['page']) ? $_GET['page'] : "index";

    include  'header.php'; //góra strony
    include  'sidebar_left.php'; //lewa kolumna strony

    if($page == 'index') {
        include  'pages/home.php';
    }
    else if ($page == 'book') { // książka
        include 'pages/book.php';
    }
    else if ($page == 'review') { // recenzja
        include 'pages/review.php';
    }
    else if ($page == 'category') { // książka wg kategorii
        include 'pages/book_category.php';
    }
    else if ($page == 'author') { // książki autora
        include 'pages/book_author.php';
    }
    else if ($page == 'publisher') { // książki wg wydawnictwa
        include 'pages/book_publisher.php';
    }
    else if($page == 'login') { //logowanie
        include  'pages/login.php';
    }
    else if($page == 'signup') { //rejestracja
        include  'pages/signup.php';
    } 
    else if ($page == 'logout') {
        include 'pages/logout.php';
    }
    else if ($page == 'users') { //lista użytkowników
        include 'pages/user_list.php';
    }
    else if ($page == 'books') { //lista książek
        include 'pages/book_list.php';
    }
    else if ($page == 'reviews') { //lista recenzji
        include 'pages/review_list.php';
    }
    else if ($page == 'cart') { //koszyk
        include 'pages/shopping_cart.php';
    }
    else if ($page == 'user') {
        include 'pages/user.php';
    }
    else if ($page == 'reset_password') { //administracja
        include 'pages/reset_password.php';
    }
    else if ($page == 'edit_review') { //edytowanie recenzji
        include 'pages/edit_review.php';
    }
    else if ($page == 'add_review') { //dodanie recenzji
        include 'pages/add_review.php';
    }
    else if ($page == 'admin') { //administracja
        include 'admin/index.php';
    }
    else if ($page == 'create_table') { //uwtorzenie tabel; sql
        include 'create_table.php';
    } else {
        include 'pages/404.php'; //nie znaleziono strony
    }

    include  'sidebar_right.php'; //prawa kolumna strony
    include  'footer.php'; //dół strony

    $db->close(); // zamknięcie połączenia z bazą

}
else {
    echo "Błąd połączenia się z bazą danych: " . $db->error;
}
