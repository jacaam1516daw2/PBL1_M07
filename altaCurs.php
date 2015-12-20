<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Alta Curs</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <form action='gestion.php' method='post'>
        <div class="combo">
            <h3>Alta Curso</h3>
            <br> Nombre Curso
            <input type="text" name="nameCurs">
            <br> Nombre Responsable
            <input type="text" name="responsable">
            <br>
            <br>
            <br>
            <br>
            <input id="altaCurso" name='altaCurso' type='submit' value='Guardar' class='info btn-primary'>
        </div>
    </form>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>
