<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Alta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <a href="index.php">
        <input type='submit' value='Página principal' class='info btn-primary'>
    </a>
</body>

</html>

<?php
if (isset($_POST['altaCurso'])) {
    altaCurso();
} else if (isset($_POST['altaAlumno'])) {
    altaAlumno();
}else if (isset($_POST['altaAsignatura'])) {
    altaAsignatura();
}

function notasAlumnos(){
}


/*
* Funcion alta de alumnos
*/
function altaAlumno(){
    $mysqli = new mysqli( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    //recuperamos el ID de curso que estamos dando de alta al alumno
    //para luego poder insertarlo
    $curs_id = 0;
    $sql = "SELECT ID_CURS from CURS where NOM_CURS = '".$_POST['curso']."'";
    $resultat = $mysqli -> query($sql);
    while($fila=$resultat->fetch_assoc()){
        $curs_id = $fila["ID_CURS"];
    }

    try {
        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
    } catch ( Exception $e ) {
        die( "problema de connexio: " . $e -> getMessage ());
    }

    //hacemos el insert de los datos que hemos recuperado del formulario
    $sentencia = $gbd -> prepare ( "INSERT INTO ALUMNE (ID_ALUMNE, NOM_ALUMNE, COGNOM1_ALUMNE, COGNOM2_ALUMNE, CURS_ID)
    VALUES (:id, :nom_alumne, :cognom1_alumne, :cognom2_alumne, :curs_id)");

    $sentencia -> bindParam ( ':id', $id );
    $sentencia -> bindParam ( ':curs_id', $curs_id );
    $sentencia -> bindParam ( ':nom_alumne', $nom_alumne );
    $sentencia -> bindParam ( ':cognom1_alumne', $cognom1_alumne );
    $sentencia -> bindParam ( ':cognom2_alumne', $cognom2_alumne );
    $nom_alumne = $_POST['name'];
    $cognom1_alumne = $_POST['ap1'];
    $cognom2_alumne = $_POST['ap2'];
    $sentencia -> execute ();
}

function altaCurso(){
    try {
        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
    } catch ( Exception $e ) {
        die( "problema de connexio: " . $e -> getMessage ());
    }

    //hacemos el insert de los datos que hemos recuperado del formulario
    $sentencia = $gbd -> prepare ( "INSERT INTO CURS (ID_CURS, NOM_CURS, NOM_RESPONSABLE) VALUES (:id, :nom_curs, :nom_responsable)" );

    $sentencia -> bindParam ( ':id', $id );
    $sentencia -> bindParam ( ':nom_curs', $nom_curs );
    $sentencia -> bindParam ( ':nom_responsable', $nom_responsable );
    $nom_curs = $_POST['nameCurs'];
    $nom_responsable = $_POST['responsable'];
    $sentencia -> execute ();
}

function altaAsignatura(){
	$mysqli = new mysqli( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    //recuperamos el ID de curso que estamos dando de alta al alumno
    //para luego poder insertarlo
    $curs_id = 0;
    $sql = "SELECT ID_CURS from CURS where NOM_CURS = '".$_POST['curso']."'";
    $resultat = $mysqli -> query($sql);
    while($fila=$resultat->fetch_assoc()){
        $curs_id = $fila["ID_CURS"];
    }

    try {
        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
    } catch ( Exception $e ) {
        die( "problema de connexio: " . $e -> getMessage ());
    }

    //hacemos el insert de los datos que hemos recuperado del formulario
    $sentencia = $gbd -> prepare ( "INSERT INTO ASSIGNATURA (NOM_ASSIGNATURA, NOM_PROFESSOR, CURS_ID)
    VALUES (:nom_assignatura, :nom_professor, :curs_id)");

    $sentencia -> bindParam ( ':curs_id', $curs_id);
    $sentencia -> bindParam ( ':nom_assignatura', $nom_assignatura );
    $sentencia -> bindParam ( ':nom_professor', $nom_professor );

    $nom_assignatura = $_POST['name'];
    $nom_professor = $_POST['prof'];
    $sentencia -> execute ();

}
?>
