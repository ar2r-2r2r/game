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

    <div class="container mt-4">
    <div class="col">
        <h1>Форма регистрации</h1>
        <form id='register_form' method="post">
            <label name='lbl-registration-fail'></label>
            <label for="login" name='lbl-login-error'></label>
            <input type="text" class="form-control" name="login" id="login" placeholder="Введите логин"><br>
            <label for="password" name='lbl-password-error'></label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль"><br>
            <button class="btn btn-success" type="button" id='btn-reg'>Зарегистрироваться</button>
        </form>
    </div>
</div>


</body>

</html>