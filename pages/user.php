<?php
if(isset($_GET['id']) && ($user = getUser($_GET['id']))) :
    $reviews = getReviewByUser($user->id_czytelnik);
?>
<section id="user_list">
	<h2>Lista recenzji użytkownika <?php echo $user->getName(); ?></h2>
	<ul class="user_list_body">

<?php 
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
	</ul>
</section>
<?php
endif;
?>