<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Gráficos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>

<body>
    <?php
    spl_autoload_register(function ($classe) {
                                include $classe . '.php';
                            });
//allNoteAlumns();
//cursNoteAlumns('DAW');
//cursNoteAlumnsAssignature('DAW','PHP');
echo "<form action='grafics.php' method='post'>
<button type='submit' name='aceptar' value='allNoteAlumns'>allNoteAlumns</button>
</form>";
echo '<br>';
echo "<form action='grafics.php' method='post'>
<button type='submit' name='aceptar' value='cursNoteAlumns'>cursNoteAlumns</button>
</form>";
echo '<br>';
echo "<form action='grafics.php' method='post'>
<button type='submit' name='aceptar' value='cursNoteAlumnsAssignature'>cursNoteAlumnsAssignature</button>
</form>";
?>

</body>

</html>
