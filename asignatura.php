<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Asignatura</title>
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
            <h3>Asignatura</h3>
            <br>
            <table class='table table-striped table-bordered'>
                <tr>
                    <th>Asignatura</th>
                    <th>
                        <input type="text" name="name">
                    </th>
                </tr>
                <tr>
                    <th>Profesor</th>
                    <th>
                        <input type="text" name="prof">
                    </th>
                </tr>
                <tr>
                    <th>Curso</th>
                    <th>
                        <select id="curso" name="curso" class="selectpicker">
                            <?php
                    //Cargamos la combo con una consulta a la BD recuperando los nombres de los cursos
                        try{
                            $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                            foreach( $gbd -> query ("SELECT NOM_CURS from CURS") as $fila ) {
                               echo "<option>".$fila["NOM_CURS"]."</option>";
                            }
                            $gbd = null ;
                        } catch ( PDOException $e ) {
                            print "¡Error!: " . $e -> getMessage () . "<br/>" ;
                            die();
                        }
                    ?>
                        </select>
                    </th>
                </tr>
            </table>
            <br>
            <input id="altaAsignatura" name='altaAsignatura' type='submit' value='Guardar' class='info btn-primary'>
            <br>
            <h3>Asignaturas</h3>
            <!-- Inicio Busqueda por parametros -->
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Asignatura</th>
                        <th>Responsapble</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Asignatura</th>
                        <th>Responsable</th>
                        <th>Eliminar</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        try{
                            $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                            foreach( $gbd -> query ("SELECT ID_ASSIGNATURA, NOM_ASSIGNATURA, NOM_PROFESSOR FROM ASSIGNATURA") as $fila ) {
                               echo "<tr><th>".$fila["NOM_ASSIGNATURA"]."</th><th>".$fila["NOM_PROFESSOR"]."</th><th><input id='eliminarAsignatura' name='eliminarAsignatura' type='submit' value='Eliminar ".$fila["ID_ASSIGNATURA"]."' class='delete btn-primary'></th><tr>";
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
