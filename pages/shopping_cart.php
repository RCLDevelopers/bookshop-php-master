<?php
if(isset($_POST['book_id']) && isset($_POST['count']) ) { //edytownie ilości książek
    $bookID = $_POST['book_id'];
    $count = $_POST['count'];
    $update = $currUser->getCart()->updateCount($bookID, $count); 
    if($update)
        echo '<script> alert("Zmieniono ilość książek"); </script>';
    else
        echo '<script> alert("Wystąpił błąd"); </script>';
}

if(isset($_POST['delete']) && isset($_POST['book_id']) ) { //usunięcie książki z kaszyka
    $bookID = $_POST['book_id'];
    $delete = $currUser->getCart()->deleteBook($bookID); 
    if($delete)
        echo '<script> alert("Usunięto książkę z koszyka"); </script>';
    else
        echo '<script> alert("Wystąpił błąd"); </script>';
}


?>
 
 <section id="cart">
    <h2>Koszyk</h2>
    <div class="book_list">

<?php 
$books = $currUser->getCart()->getBook();

if($books) :
	foreach($books as $book) : 
        $count = $currUser->getCart()->getCount($book->id_ksiazka);
    ?>
        <div class="book">
            <div class="cover"><a href="<?php echo URL . "/index.php?page=book&id=" . $book->id_ksiazka; ?>"><img src="<?php echo $book->zdjecie_okladki; ?>" alt="okladka" /></a></div>
            <div class="title"><a href="<?php echo URL . "/index.php?page=book&id=" . $book->id_ksiazka; ?>"><?php echo $book->tytul; ?></a></div>
            <div class="count">
                <form action="<?php echo URL . '/index.php?page=cart'?>" method="post" >
                    <div class="count_width input-group input-group-sm">
                        <span class="input-group-addon" >Ilość sztuk:</span>
                        <input type="text" class="form-control" name="count" value="<?php echo $count; ?>" >
                        <span class="input-group-btn">
                        <input type="hidden"  name="book_id" value="<?php echo $book->id_ksiazka; ?>" >
                        <button class="btn btn-default">Zmień</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="delete">
                <form action="<?php echo URL . '/index.php?page=cart'?>" method="post" >
                    <div class="count_width input-group input-group-sm">
                        <input type="hidden"  name="delete" value="true" >
                        <input type="hidden"  name="book_id" value="<?php echo $book->id_ksiazka; ?>" >
                        <button class="btn btn-default btn-sm">Usuń</button>
                    </div>
                </form>
            </div>
            <div class="price"><?php echo number_format($book->cena * $count, 2, ',', ' '); ?> zł</div>
            
        </div>
<?php
	endforeach;
?>

<div class="sum">
    <div class="cost">Koszt: <?php echo number_format($currUser->getCart()->getCost(), 2, ',', ' '); ?> zł</div>
    <br><button type="button" class="btn btn-lg btn-warning">Zapłać</button>
</div>

<?php   
else :
    echo 'Koszyk jest pusty';
endif;
?>
        
    </div>


 </section>


