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
            <h3>Cursos</h3>
            <br> Nombre Curso
            <input type="text" name="nameCurs">
            <br> Nombre Responsable
            <input type="text" name="responsable">
            <br>
            <br>
            <input id="curso" name='altaCurso' type='submit' value='Guardar' class='info btn-primary'>
            <br>
            <h3>Cursos</h3>
            <!-- Inicio Busqueda por parametros -->
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Responsapble</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Curso</th>
                        <th>Responsable</th>
                        <th>Eliminar</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        try{
                            $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                            foreach( $gbd -> query ("SELECT NOM_CURS, NOM_RESPONSABLE, ID_CURS FROM CURS") as $fila ) {
                               echo "<tr><th>".$fila["NOM_CURS"]."</th><th>".$fila["NOM_RESPONSABLE"]."</th><th><input id='eliminarCurso' name='eliminarCurso' type='submit' value='Eliminar ".$fila["ID_CURS"]."' class='delete btn-primary'></th><tr>";
                            }
                            $gbd = null ;
                        } catch ( PDOException $e ) {
                            print "¡Error!: " . $e -> getMessage () . "<br/>" ;
                            die();
                        }
                    ?>
                </tbody>
            </table>
            <br>
            <br>
        </div>
    </form>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>
