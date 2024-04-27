<form id="signupform" class="signup_body" action="<?php echo URL . '/index.php?page=signup' ?>" method="post">
    <label for="login">Login</label>
    <div class="form-group">
        <input class="form-control" placeholder="Login" name="login" type="text">
    </div>
    <label for="email">E-mail</label>
    <div class="form-group">
        <input class="form-control" placeholder="email" name="email" type="text">
    </div>
    <label for="email">Hasło</label>
    <div class="form-group">
        <input class="form-control" placeholder="Hasło" name="password1" type="password" value="">
    </div>
    <label for="email">Powtórz hasło</label>
    <div class="form-group">
        <input class="form-control" placeholder="Hasło" name="password2" type="password" value="">
    </div>
    <label for="name">Imię</label>
    <div class="form-group">
        <input class="form-control" placeholder="Login" name="name" type="text">
    </div>
    <label for="lastname">Nazwisko</label>
    <div class="form-group">
        <input class="form-control" placeholder="Login" name="lastname" type="text">
    </div>
    <label for="year">Płeć</label>
    <div class="form-group">
        <label><input type="radio" name="gender" value="male" checked="checked"> Mężczyzna</label><br>
        <label><input type="radio" name="gender" value="female"> Kobieta</label>
    </div>
    <label for="year">Rok urodzenia</label>
    <div class="form-group">
        <input class="form-control" placeholder="Login" name="year" type="text">
    </div>
    <label for="about">Opis</label>
    <div class="form-group">
        <textarea class="form-control" rows="4" id="ftext" ></textarea>
    </div>
        
    <button id="dddd" class="btn btn-lg btn-success btn-block">Wyślij</button>
</form>
