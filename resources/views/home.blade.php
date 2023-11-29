<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вычисление/Проверка ЭЦП(DSA)</title>
</head>
<body>
    <form action="/api/dsa" method="POST">
        <div class="line">
            <input type="text" name="src_file" placeholder="Путь к исходному файлу">
        </div>

        <div class="line">
            <input type="text" name="dsa_file" placeholder="Путь к файлу с ЭЦП">
            <button name="button" value="create">Подписать</button>
        </div>

        <div class="line">
            <input type="text" name="key_file" placeholder="Путь к файлу с ключом">
            <button name="button" value="verify">Проверить ЭЦП</button>
        </div>

    </form>
</body>
</html>

<style>
    input{
        width: 300px
    }

    button{
        width: 150px;
    }

    body{
        background-color: #191919
    }

    .line + .line{
        margin-top: 20px;
    }
</style>