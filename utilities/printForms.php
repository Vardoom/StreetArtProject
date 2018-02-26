<?php

function printLoginForm($askedPage) {
    echo <<<CHAINE_DE_FIN
<form class="form-inline" action="index.php?page=$askedPage&todo=login" method="post" >
    <div class="form-group">
        <label class="sr-only" for="exampleInputEmail3">Login</label>
        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Login" name="login" required>
    </div>
    <div class="form-group">
        <label class="sr-only" for="exampleInputPassword3">Password</label>
        <input type="password" class="form-control" name="mdp" id="exampleInputPassword3" placeholder="Mot de passe" required>
    </div>
    <button type="submit" class="btn btn-default">Sign in</button>
</form>
 
CHAINE_DE_FIN;
}

function printLogoutForm() {
    echo <<<CHAINE_DE_FIN
  <form class="form-inline" action="index.php?todo=logout" method="post" >
    <button type="submit" class="btn btn-default">Se déconnecter</button>
  </form>

CHAINE_DE_FIN;
}
