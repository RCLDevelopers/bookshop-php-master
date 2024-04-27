<section id="user_list">
	<h2>Lista użytkowników</h2>
	<ul class="user_list_body">
<?php 

$users = selectUser();

if($users) {
	$i = 1;
	foreach($users as $user) {
		echo "<li>" . $i . ". " . $user->login . ",  " . $user->imie . "  " . $user->nazwisko . "</li>";
		$i++;
	}
}
?>
	</ul>
</section>