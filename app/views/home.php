<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
    <script src="ajax.js"></script>
    <title>Document</title>
</head>


<body>
    <div class="home">
        <button class="homebtn"><a href="/login">Авторизироваться</a></button><br>
        <button class="homebtn"><a href="/register">Регистрация</a></button>
        <?php
        if (isset($_COOKIE['user'])) :
        ?>
            <p>Привет <?= $_COOKIE['user'] ?>. Чтобы выйти нажмите <button class ="homebtn" id='btn-logout'>здесь</button></p>
        <?php
        endif;
        ?>
    </div>
</body>

</html>