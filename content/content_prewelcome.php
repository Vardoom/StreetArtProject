<style>
    body{
        background-image: url("images/prewelcome.jpeg");
        background-position: center;
    }
    div.centre {
        position:absolute;
        left: 50%;
        top: 50%;
        width: 1000px;
        height: 200px;
        margin-left: -500px; /* Cette valeur doit être la moitié négative de la valeur du width */
        margin-top: -80px; /* Cette valeur doit être la moitié négative de la valeur du height */
    }
    nav.navbar-perso{
        background-color: transparent;
        border-color: transparent;
    }
    .titresite{
        color: #000000;
        font-size: 100px;
        font-family: "Impact", "Book Antiqua", Palatino, serif;
    }
    .cliquezici{
        color: #000000;
        font-size: 15px;
        font-family: "Impact", "Book Antiqua", Palatino, serif;
    }
</style>

<div class="centre">
    <div class="col-md-12 text-center">
        <h1 class="titresite">Street Art Project</h1> </br>
    </div>
</div>

<nav class="navbar navbar-perso navbar-fixed-bottom">
    <div class="container">
        <div class="col-md-13 text-center">
            <h3 class="cliquezici">Cliquez ci-dessous</h3>
            <a class="btn" href="index.php?page=welcome" role="button">
                <img src="images/triangletransp.png" alt="triangle" height="100">
            </a>
        </div>
    </div>
</nav>