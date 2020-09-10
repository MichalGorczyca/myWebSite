<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekt OOP</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://kit.fontawesome.com/7e02ae03b6.js" crossorigin="anonymous"></script>
    <style>
    
            * {

        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Montserrat', sans-serif;
        color: black
        }

        body {

        overflow-x: hidden;

        }

        .navbar {

        background-color: #4169E1;
        padding: 15px;
        color: white;

        }

        .home {


        opacity: .5;
        transition: .3;
        color: white;

        }

        .home:hover {

        text-decoration: none;
        opacity: .8;
        color: white;


        }

        .box {

        color: black;

        }

    </style>
</head>
<body>

    <?php include "../includes/nav.php"; ?>

    <div class="wrap">

        <h1>Jednoręki bandyta</h1>

        <section class="game">
            <div class="color"></div>
            <div class="color"></div>
            <div class="color"></div>
        </section>

        <section class="play">
            <input type="number" placeholder="Podaj stawkę" id="bid" class="number">
            <button id="start">Zakręć!</button>
        </section>

        <section class="panel">TWOJE ŚRODKI PRZED KOLEJNĄ GRĄ TO: <span class="wallet"></span></section>

        <section class="score">
            <span class="result"></span> Za tobą <span class="number"></span> gier, w tym <span class="win"></span> wygranych i <span class="loss"></span> przegranych
        </section>
    </div>


    <script src="Wallet.js"></script>
    <script src="Statistics.js"></script>
    <script src="Draw.js"></script>
    <script src="Result.js"></script>
    <script src="Game.js"></script>
    <script src="main.js"></script>
</body>
</html>