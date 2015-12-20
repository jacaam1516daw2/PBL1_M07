<!DOCTYPE html>
<html lang="ca">

<head>
    <title>Alta</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
}else if (isset($_POST['saveNotasAlumne'])) {
    saveNotasAlumne();
}

function saveNotasAlumne(){
    $mysqli = new mysqli( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }

    $sentencia = $mysqli -> prepare("SELECT ASS.ID_ASSIGNATURA,
                                            ASS.NOM_ASSIGNATURA,
                                            ASS.CURS_ID
                                    FROM ASSIGNATURA ASS
                                    INNER JOIN CURS C
                                        ON ASS.CURS_ID = C.ID_CURS
                                    INNER JOIN ALUMNE AL
                                        ON AL.CURS_ID = C.ID_CURS
                                    WHERE AL.ID_ALUMNE = ?");

    $sentencia->bind_param("s", $id_alumne);
    $id_alumne = $_POST['alumne'];
    $sentencia->execute();
    $sentencia->bind_result($id_assignatura, $nom_assignatura, $curs_id);

    while ($sentencia->fetch())
    {
        $nota = $_POST['nota'.$nom_assignatura.$id_assignatura];
        $uf1 = $_POST['uf1'.$nom_assignatura.$id_assignatura];
        $uf2 = $_POST['uf2'.$nom_assignatura.$id_assignatura];
        $uf3 =  $_POST['uf3'.$nom_assignatura.$id_assignatura];
        $uf4 = $_POST['uf4'.$nom_assignatura.$id_assignatura];
        guardaNota($nota, $uf1, $uf2, $uf3, $uf4, $id_assignatura, $id_alumne, $curs_id);
    }

}

function guardaNota($nota, $uf1, $uf2, $uf3, $uf4, $id_assignatura, $id_alumne, $curs_id){
    try {
        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
    } catch ( Exception $e ) {
        die( "problema de connexio: " . $e -> getMessage ());
    }

    $sentencia = $gbd -> prepare ( "INSERT INTO NOTA (ASSIGNATURA_ID, CURS_ID, ALUMNE_ID, NOTA, UF1, UF2, UF3, UF4) VALUES (:id_assignatura, :curs_id, :id_alumne, :nota, :uf1, :uf2, :uf3, :uf4)");

    $sentencia -> bindParam ( ':id_assignatura', $id_assignatura );
    $sentencia -> bindParam ( ':curs_id', $curs_id);
    $sentencia -> bindParam ( ':id_alumne', $id_alumne );
    $sentencia -> bindParam ( ':nota', $nota );
    $sentencia -> bindParam ( ':uf1', $uf1);
    $sentencia -> bindParam ( ':uf2', $uf2);
    $sentencia -> bindParam ( ':uf3', $uf3);
    $sentencia -> bindParam ( ':uf4', $uf4);
    $sentencia -> execute ();
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
