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
    <div class="combo">
        <form action='parametros.php' method='post'>
            <table class='table table-striped table-bordered'>
                <tr>
                    <th>
                        <h3>Graficos por parámetors</h3></th>
                    <!-- Inicio Busqueda por parametros -->
                </tr>
                <tr>
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

                <!-- FIN Busqueda por parametros -->
                <tr>
                    <th>
                        <input id="parametros" name='parametros' type='submit' value='Buscar' class='info btn-primary'>
                    </th>
                </tr>
            </table>
        </form>
        <!-- Inicio Gestion alumnos -->

        <br>
        <table class='table table-striped table-bordered'>
            <tr>
                <th>
                    <h3>Gestión de la escuela</h3></th>
            </tr>
            <tr>
                <th>
                    <form action='curso.php' method='post'>
                        <input id="curso" name='curso' type='submit' value='Cursos' class='info btn-primary'>
                    </form>
                </th>
            </tr>
            <tr>
                <th>
                    <form action='asignatura.php' method='post'>
                        <input id="asignatura" name='asignatura' type='submit' value='Asignaturas' class='info btn-primary'>
                    </form>
                </th>
            </tr>
            <tr>
                <th>
                    <form action='alumno.php' method='post'>
                        <input id="alumno" name='alumno' type='submit' value='Alumnos' class='info btn-primary'>
                    </form>
                </th>
            </tr>
            <tr>
                <th>
                    <form action='notas.php' method='post'>
                        <input id="notasAlumno" name='notasAlumno' type='submit' value='Notas' class='info btn-primary'>
                    </form>
                </th>
            </tr>
        </table>
    </div>
    <!-- FIN Gestion alumnos -->
    <!-- Inicio Botonera Lateral -->
    <form action='grafics.php' method='post' class="botonera">
        <div id="botones">
            <input id='allNoteAlumns' name='aceptar' type='submit' value='Todas las notas' class='btn btn-primary'>
            <br>
            <?php
                //Cargamos los botones de la barra lateral de forma dinamica montando el componente input
                //con una consulta a la BD recuperando los nombres de los cursos
                    try{
                        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                        foreach( $gbd -> query ("SELECT NOM_CURS from CURS") as $fila ) {
                            echo "<input id='cursNoteAlumns".$fila["NOM_CURS"]."' name='aceptar' type='submit' value='Notas Curso ".$fila["NOM_CURS"]."' class='btn btn-primary'>";
                            echo "<br>";
                        }
                        $gbd = null ;
                    } catch ( PDOException $e ) {
                        print "¡Error!: " . $e -> getMessage () . "<br/>" ;
                        die();
                    }

                 //Cargamos los botones de la barra lateral de forma dinamica montando el componente input
                //con una consulta a la BD recuperando los nombres de los cursos y de las asignatura
                // EL boton es nombre curso y asignatura del curso
                    try{
                        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
                        foreach( $gbd -> query ("SELECT ASI.NOM_ASSIGNATURA, C.NOM_CURS from ASSIGNATURA ASI INNER JOIN CURS C ON C.ID_CURS = ASI.CURS_ID ") as $fila ) {
                            echo "<input id='cursNoteAlumnsAssignature".$fila["NOM_ASSIGNATURA"]."' name='aceptar' type='submit' value='Notas Curso ".$fila["NOM_CURS"]." Asignatura ".$fila["NOM_ASSIGNATURA"]."' class='btn btn-primary'>";
                            echo "<br>";
                        }
                        $gbd = null ;
                    } catch ( PDOException $e ) {
                        print "¡Error!: " . $e -> getMessage () . "<br/>" ;
                        die();
                    }
                ?>
        </div>
        <!-- FIN Botonera Lateral -->
    </form>
</body>

</html>
