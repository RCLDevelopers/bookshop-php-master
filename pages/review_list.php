<section id="book_list">
	
    <div class="book_reviews">
        <h3>Recenzje</h3>    
<?php 

$reviews = selectReview();

if($reviews) :
	foreach($reviews as $review) : ?>
        <div class="review">
            <div class="title">
                <a href="<?php echo URL . '/index.php?page=review&id=' .$review->id_recenzja ?>"><?php echo $review->tytul; ?></a>
            </div>
        </div>
<?php
	endforeach;
endif;
?>
    </div>
</section>