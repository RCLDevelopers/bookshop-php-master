<?php
//dodanie potrzebnych klas i funkcji
require_once 'config.php';

require_once 'classes/Database.php';
require_once 'classes/CurrentUser.php';
require_once 'classes/ShoppingCart.php';

require_once 'classes/Tables/User.php';
require_once 'classes/Tables/Author.php';
require_once 'classes/Tables/Book.php';
require_once 'classes/Tables/BookAuthor.php';
require_once 'classes/Tables/BookCategory.php';
require_once 'classes/Tables/Category.php';
require_once 'classes/Tables/Order.php';
require_once 'classes/Tables/OrderBook.php';
require_once 'classes/Tables/Publisher.php';
require_once 'classes/Tables/Review.php';

require_once 'functions.php';
require_once 'functions/user.functions.php';
require_once 'functions/book.functions.php';
require_once 'functions/category.functions.php';
require_once 'functions/author.functions.php';
require_once 'functions/publisher.functions.php';
require_once 'functions/book_author.functions.php';
require_once 'functions/book_category.functions.php';
require_once 'functions/order.functions.php';
require_once 'functions/order_book.functions.php';
require_once 'functions/review.functions.php';

session_start(); //rozpoczęcie sesji
