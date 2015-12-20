<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Alta Alumno</title>
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
            <h3>Alta Alumno</h3>
            <table class='table table-striped table-bordered'>
                <tr>
                    <th>Nombre</th>
                    <th>
                        <input type="text" name="name">
                    </th>
                </tr>
                <tr>
                    <th>Apellido 1</th>
                    <th>
                        <input type="text" name="ap1">
                    </th>
                    <tr>
                        <th>Apellido 2</th>
                        <th>
                            <input type="text" name="ap2">
                        </th>
                    </tr>
                    <tr>
                        <th>Curso</th>
                        <th>
                            <select id="curso" name="curso" class="selectpicker">
                                <?php
                                    //Cargamos la combo con una consulta a la BD recuperando los cursos
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
            <input id="altaAlumno" name='altaAlumno' type='submit' value='Guardar' class='info btn-primary'>
            <h3>Asignaturas</h3>
            <!-- Inicio Busqueda por parametros -->
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Appelido 1</th>
                        <th>Appelido 2</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nombre</th>
                        <th>Appelido 1</th>
                        <th>Appelido 2</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                        try{
                            $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                            foreach( $gbd -> query ("SELECT ID_ALUMNE, NOM_ALUMNE, COGNOM1_ALUMNE, COGNOM2_ALUMNE FROM ALUMNE") as $fila ) {
                               echo "<tr>
                                        <th>".$fila["NOM_ALUMNE"]."</th>
                                        <th>".$fila["COGNOM1_ALUMNE"]."</th>
                                        <th>".$fila["COGNOM2_ALUMNE"]."</th>
                                        <th><input id='eliminarAlumno' name='eliminarAlumno' type='submit' value='Eliminar ".$fila["ID_ALUMNE"]."' class='delete btn-primary'></th>
                                    <tr>";
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
