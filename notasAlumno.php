<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Notas Alumno</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action='gestion.php' method='post'>
        <div class="combo">
            <h3>Notas Alumno</h3>
            <?php
                $mysqli = new mysqli
                ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
                if ($mysqli -> connect_errno) {
                    echo "problema al connectar MySQL: " . $mysqli -> connect_error;
                }

                $sentencia = $mysqli -> prepare("SELECT NOM_ASSIGNATURA,
                                                        ID_ASSIGNATURA,
                                                        AL.NOM_ALUMNE,
                                                        AL.COGNOM1_ALUMNE,
                                                        AL.COGNOM2_ALUMNE
                                                FROM ASSIGNATURA ASS
                                                INNER JOIN CURS C
                                                    ON ASS.CURS_ID = C.ID_CURS
                                                INNER JOIN ALUMNE AL
                                                    ON AL.CURS_ID = C.ID_CURS
                                                WHERE AL.ID_ALUMNE = ?");

                $sentencia->bind_param("s", $id_alumne);
                $porciones = explode(" ", $_POST['notasAl']);
                $id_alumne = $porciones[2];
                $sentencia->execute();
                $sentencia->bind_result($nom_assignatura, $id_assignatura, $nom_alumne, $cognom1_alumne, $cognom2_alumne);
                echo "<table border='1'><tr><td colspan='2'>FICHA ALUMNO</td></tr>";
                while ($sentencia->fetch())
                {
                    echo "<tr><td>".$nom_assignatura."</td><td align='center'><input type='text' name='nota' size='2' maxlength='2'></td></tr>";
                }
                echo "<tr><td colspan='2'>".$nom_alumne.' '.$cognom1_alumne.' '.$cognom2_alumne."</td></tr></table>";
            ?>
                <br>
                <br>
                <input id="altaAlumno" name='altaAlumno' type='submit' value='Guardar' class='btn btn-primary'>
        </div>
    </form>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>
