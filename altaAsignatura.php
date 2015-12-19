<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Alta Asignatura</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>


<body>
    <form action='gestion.php' method='post'>
        <div class="combo">
            <h3>Alta Asignatura</h3>
            <br> Nombre
            <input type="text" name="name">
            <br> Profesor
            <input type="text" name="prof">
            <br>
            <br> Curso
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
            <br>
            <br>
            <input id="altaAsignatura" name='altaAsignatura' type='submit' value='Guardar' class='info btn-primary'>
        </div>
    </form>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>