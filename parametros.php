<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Gráficos</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    spl_autoload_register(function ($classe) {
     include $classe . '.php';
    });

    if (isset($_POST['parametros'])) {
        $post = $_POST['parametros'];
    }
?>
        <form action='grafics.php' method='post'>
            <table id="tabalumnes" class="table table-striped table-bordered" cellspacing="0" width="50%">
                <thead>
                    <tr>
                        <th>Nombre</th>
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
                        <th>Nombre</th>
                        <th>Asignatura</th>
                        <th>Nota</th>
                        <th>UF1</th>
                        <th>UF2</th>
                        <th>UF3</th>
                        <th>UF4</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $mysqli = new mysqli
                    ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
                    if ($mysqli -> connect_errno) {
                        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
                    }
                    $curs = $_POST['curso'];
                    $sentencia = $mysqli -> prepare("SELECT AL.NOM_ALUMNE,
                                                    ASI.NOM_ASSIGNATURA,
                                                    NOTA.NOTA,
                                                    NOTA.UF1,
                                                    NOTA.UF2,
                                                    NOTA.UF3,
                                                    NOTA.UF4
                                            FROM NOTA NOTA
                                            INNER JOIN CURS C
                                            ON NOTA.CURS_ID = C.ID_CURS
                                            INNER JOIN ASSIGNATURA ASI
                                            ON ASI.ID_ASSIGNATURA = NOTA.ASSIGNATURA_ID
                                            INNER JOIN ALUMNE AL
                                                ON AL.ID_ALUMNE = NOTA.ALUMNE_ID
                                            WHERE NOM_CURS = ?");
                    $sentencia->bind_param("s",$curs);
                    $sentencia->execute();
                    $sentencia->bind_result($nom_alumne, $nom_assignatura, $nota, $uf1, $uf2, $uf3, $uf4);
                        $var = 'hola';
                    while ($sentencia->fetch())
                    {
                        $idCol = [];
                        array_push($idCol, $uf1);
                        array_push($idCol, $uf2);
                        array_push($idCol, $uf3);
                        array_push($idCol, $uf4);
                        echo '<tr>
                        <th>'.$nom_alumne.'</th>
                        <th>'.$nom_assignatura.'</th>
                        <th>'.$nota.'</th>
                        <th>'.$uf1.'</th>
                        <th>'.$uf2.'</th>
                        <th>'.$uf3.'</th>
                        <th>'.$uf4.'</th>
                        <th><input name="grafico" type="submit" value='.serialize($idCol).' class="info btn-info"></th>
                        </tr>';
                    }
                ?>
                </tbody>
            </table>
        </form>
</body>

</html>
