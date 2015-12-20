<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Notas Alumno</title>
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

                echo "<input type='text' hidden='hidden' name='alumne' value=".$id_alumne.">";
                echo "<table class='table table-striped table-bordered'>
                 <thead>
                <tr>
                    <th>Asignatura</th>
                    <th>Nota</th>
                    <th>UF1</th>
                    <th>UF2</th>
                    <th>UF3</th>
                    <th>UF4</th>
                </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Asignatura</th>
                        <th>Nota</th>
                        <th>UF1</th>
                        <th>UF2</th>
                        <th>UF3</th>
                        <th>UF4</th>
                    </tr>
                </tfoot>
                <tbody>";
                while ($sentencia->fetch())
                {
                    echo "<tr>
                            <th>".$nom_assignatura."</th>
                            <th><input type='text' name='nota".$nom_assignatura.$id_assignatura."' size='2' maxlength='2'></th>
                            <th><input type='text' name='uf1".$nom_assignatura.$id_assignatura."' size='2' maxlength='2'></th>
                            <th><input type='text' name='uf2".$nom_assignatura.$id_assignatura."' size='2' maxlength='2'></th>
                            <th><input type='text' name='uf3".$nom_assignatura.$id_assignatura."' size='2' maxlength='2'></th>
                            <th><input type='text' name='uf4".$nom_assignatura.$id_assignatura."' size='2' maxlength='2'></th>
                        </tr>";
                }
                echo "<tbody></table>";
                echo "<h4>Ficha Alumno: ".$nom_alumne.' '.$cognom1_alumne.' '.$cognom2_alumne."</h4>";
            ?>
                <br>
                <br>
                <input id="saveNotasAlumne" name='saveNotasAlumne' type='submit' value='Guardar' class='info btn-primary'>
        </div>
    </form>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>
