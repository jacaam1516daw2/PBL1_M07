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
/*
* Aqui recuperamos la EL post para saber
* quien nos llama y los parametros que nos envia
*/

$notasCurso = 'Notas Curso ';
$find = 'Asignatura ';
if (isset($_POST['aceptar'])) {
    $post = $_POST['aceptar'];
    $assig = strpos($post,$find);

    if ($post=='Todas las notas') {
        allNoteAlumns();
    } else if($assig===0){
        $porciones = explode(" ", $post);
        cursNoteAlumnsAssignature($porciones[1], $porciones[2]);
    }else if(strstr($post, $notasCurso)){
        // aquí recuperamos el nombre del curso cortando
        // la cadena y sabemos que siempre nos vendrá en la ultima posición.
        $porciones = explode(" ", $post);
        cursNoteAlumns($porciones[2]);
    }

} else if (isset($_POST['grafico'])) {
    $array_notes = [];
    $porciones = explode(" ", $_POST['grafico']);
    //recuperamos las UFS que nos envian por array
    $array_notes = unserialize(stripslashes($porciones[1]));
    declaraGlobals($array_notes);
}else if (isset($_POST['eliminarNotas'])) {
    eliminarNotas();
}

function eliminarNotas(){
 try {
        $gbd = new PDO ( 'mysql:host=localhost;dbname=ESCOLA_DB' , 'root' , 'adminuser' );
    } catch ( Exception $e ) {
        echo "<br><br><br><br><h3>Error al guardar</h3>";
        die( "problema de connexio: " . $e -> getMessage ());
    }
    //Tenemos activado DELETE ON CASCADE, al eliminar un curso se eliminan las assignaturas las notas etc
    $sentencia = $gbd -> prepare ( "DELETE FROM NOTA WHERE ID_NOTA = :nota_id");
    $sentencia -> bindParam ( ':nota_id', $nota_id);
    $porciones = explode(" ", $_POST['eliminarNotas']);
    $nota_id = $porciones[1];
    $sentencia -> execute ();
    echo "<br><br><br><br><h3>El registro se ha guradado correctamente</h3>";
}

/*
* Funcion que nos devuelve las notas de todos los alumnos
* Parametros
* return array
*/
function allNoteAlumns(){
    $array_notes = [];
    $mysqli = new mysqli( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }
    //$resultat = $mysqli -> query("SELECT NOTA, NOM_ALUMNE, COGNOM1_ALUMNE,  COGNOM2_ALUMNE from NOTA INNER JOIN ALUMNE ON ALUMNE_ID = ID_ALUMNE" );
    $resultat = $mysqli -> query("SELECT NOTA from NOTA" );
    while($fila=$resultat->fetch_assoc()){
        //$array_notes[$fila["NOM_ALUMNE"].' '.$fila["COGNOM1_ALUMNE"].' '.$fila["COGNOM2_ALUMNE"]] = $fila["NOTA"];
        array_push($array_notes, $fila["NOTA"]);
    }
   declaraGlobals($array_notes);

}

/*
* Funcion que nos devuelve las notas de todos los alumnos de un mismo curso de todas las asignaturas
* Parametros CURSO
* return array
*/
function cursNoteAlumns($curs){
    $array_notes = [];
    $mysqli = new mysqli( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }

    $sentencia = $mysqli -> prepare("SELECT N.NOTA,
                                            AL.NOM_ALUMNE,
                                            AL.COGNOM1_ALUMNE,
                                            AL.COGNOM2_ALUMNE
                                    FROM NOTA N
                                    INNER JOIN ALUMNE AL
                                        ON N.ALUMNE_ID = AL.ID_ALUMNE
                                    INNER JOIN CURS C
                                        ON C.ID_CURS = N.CURS_ID
                                    WHERE C.NOM_CURS = ?");
    $sentencia->bind_param("s",$curs);
    $sentencia->execute();

    $sentencia->bind_result($nota, $nom_alumne, $cognom1_alumne, $cognom2_alumne);
    while ($sentencia->fetch())
    {
        //$array_notes[$nom_alumne.' '.$cognom1_alumne.' '.$cognom2_alumne] = $nota;
        array_push($array_notes, $nota);
    }
    declaraGlobals($array_notes);
}

/*
* Funcion que nos devuelve las notas de todos los alumnos de un mismo curso de una asignatura
* Parametros CURSO, ASIGNATURA
* return array
*/
function cursNoteAlumnsAssignature($assign, $curs){
    $array_notes = [];
    $mysqli = new mysqli("localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }
    $porciones = explode(" ", $_POST['grafico']);
    $sentencia = $mysqli -> prepare("SELECT N.NOTA,
                                            AL.NOM_ALUMNE,
                                            AL.COGNOM1_ALUMNE,
                                            AL.COGNOM2_ALUMNE
                                    FROM NOTA N
                                    INNER JOIN ALUMNE AL
                                        ON N.ALUMNE_ID = AL.ID_ALUMNE
                                    INNER JOIN CURS C
                                        ON C.ID_CURS = N.CURS_ID
                                    INNER JOIN ASSIGNATURA ASS
	                                   ON ASS.CURS_ID = N.CURS_ID
                                    WHERE C.NOM_CURS = ?
                                    AND ASS.NOM_ASSIGNATURA = ?");
    $sentencia->bind_param("ss",$curs, $assign);
    $sentencia->execute();

    $sentencia->bind_result($nota, $nom_alumne, $cognom1_alumne, $cognom2_alumne);
    while ($sentencia->fetch())
    {
        array_push($array_notes, $nota);
    }
    declaraGlobals($array_notes);
}


    /*
     * Funció dibuixaEix:
     *
     * Dibuixa de forma dinàmica l'eix
     * cartesià (segons la variable global alumnes).
     *
     */

    function dibuixaEix($draw) {

        /*
         * Declaració de les variables de l'eix.
         */
        $pixels = $GLOBALS['pixels'];
        $nAlumnes = $GLOBALS['alumnes'];

        /*
         * Declaració del color de línia.
         */
        $strokeColor = new \ImagickPixel($GLOBALS['strokeColor']);

        /*
         * Configuració de les propietats de línia.
         */
        $draw->setStrokeColor($strokeColor);
        $draw->setStrokeOpacity(1);
        $draw->setStrokeWidth(2);

        /*
         * Dibuix dels eixos X i Y.
         */
        $draw->line(0, 0, $pixels*$nAlumnes, 0);
        $draw->line(0, 0, 0, -$pixels*10);

        /*
         * Dibuix de les marques de l'eix Y.
         */
        for ($i = 0; $i <= $pixels*10; $i++)
            if ($i%$pixels == 0)
                $draw->line(0, -$i, -5, -$i);

        /*
         * Dibuix de les marques de l'eix X.
         */
        for ($i = 0; $i <= $pixels*$nAlumnes; $i++)
            if ($i%$pixels == 0)
                $draw->line($i, 0, $i, 5);

    }

    /*
     * Funció dibuixaBarres:
     *
     * Dibuixa de forma dinàmica (segons la quantitat de posicions de l'array
     * $array_notes) les barres del gràfic.
     *
     * En cas que la nota d'una de les posicions de l'array sigui inferior a 5,
     * és a dir, suspès, la barra que la representa serà de color vermell.
     * En cas contrari, si l'alumne ha aprovat, la barra serà de color verd.
     * Les variables $fillColorA i $fillColorS guarden el color dels aprovats
     * i suspesos (respectivament) en notació hexadecimal.
     *
     */

    function dibuixaBarres($draw) {

        /*
         * Declaració de les variables apuntadores al vector global.
         */
        $pixels = $GLOBALS['pixels'];
        $array_notes = $GLOBALS['notes'];

        /*
         * Declaració dels colors de línia.
         */
        $strokeColor = new \ImagickPixel($GLOBALS['strokeColor']);

        /*
         * Declaració dels colors d'aprovat i suspès.
         */
        $fillColorA = new \ImagickPixel($GLOBALS['fillColorA']);
        $fillColorS = new \ImagickPixel($GLOBALS['fillColorS']);

        /*
         * Configuració de les propietats de línia.
         */
        $draw->setStrokeColor($strokeColor);
        $draw->setStrokeOpacity(1);
        $draw->setStrokeWidth(2);

        /*
         * Dibuix de les barres.
         *
         * En cas que $key (cadascun dels valors de $array_notes) sigui menor
         * que 5 (és a dir, suspès), la barra resultant serà vermella. Sinó,
         * serà verda.
         *
         * La variable $i és un comptador que va sumant píxels per dibuixar cada
         * barra al costat de l'anterior.
         *
         */
        $i = 0;
        foreach ($array_notes as $key) {

            if ($key < 5)
                $draw->setFillColor($fillColorS);
            else
                $draw->setFillColor($fillColorA);

            $draw->rectangle($i, 0, $i+$pixels, -$key*$pixels);
            $i += $pixels;

        }

    }

    /*
     * Funció inici:
     *
     * Funció "main" del programa. A partir d'aquí s'inicialitzen els valors
     * necessaris per al funcionament del programa, es realitza la translació
     * del punt d'origen i es fan les crides a les funcions que fan la tasca de
     * dibuixar l'eix cartesià i les barres.
     *
     * En aquesta funció es defineixen també el color de fons i els marges del
     * gràfic respecte la imatge.
     *
     * La imatge no es printa a la pantalla fins que el programa no arriba a la
     * sentència de dibuix de l'objecte $imagick.
     *
     */
    function inici() {

        /*
         * Declaració de les variables apuntadores a l'array global.
         */
        $array_notes = $GLOBALS['notes'];
        $nAlumnes = $GLOBALS['alumnes'];
        $pixels = $GLOBALS['pixels'];
        $marge = $GLOBALS['marge'];

        /*
         * Declaració del context ImagickDraw ($draw); translació del punt
         * d'origen a la cantonada inferior esquerra.
         *
         * Degut a que la Y augmenta en sentit descendent, els valors verticals
         * han d'augmentar negativament
         */
        $draw = new \ImagickDraw();
        $draw->translate($marge, 500 - $marge);

        /*
         * Crida de les funcions que dibuixen el gràfic.
         */
        dibuixaEix($draw);
        dibuixaBarres($draw);

        /*
         * Declaració de la imatge (objecte $imagick)
         */
        $imagick = new \Imagick();
        $imagick->newImage($nAlumnes*$pixels + 2*$marge, 500, $GLOBALS['backgroundColor']);
        $imagick->setImageFormat("png");

        /*
         * Dibuix final de la imatge. Ara es quan apareix tot a la pantalla.
         */
        $imagick->drawImage($draw);

        $imagick->setImageFormat ("png");
        file_put_contents ("image/grafico.png", $imagick);
        /*
         * Misc.
         */
        //header("Content-Type: image/png");
       // echo $imagick->getImageBlob();

        echo "<div id='container'><img src='/image/grafico.png'/></div>";

    }

    /*
     * Funció declaraGlobals:
     *
     * Declara les variables globals que el programa utilitza. Aquestes són:
     *
     * strokeColor: color de la línia.
     * fillColorA: color dels aprovats.
     * fillColorS: color dels suspesos.
     * backgroundColor: color de fons.
     *
     * pixels: proporció de píxels per cada unitat del gràfic
     * marge: pixels de marge que es deixen als costats del gràfic
     *
     * notes: array que conté les notes dels alumnes, enviat desde la DB
     * alumnes: nombre total de posicions de l'array notes (una nota per alumne)
     *
     */
    function declaraGlobals($array_notes) {

        /*
         * Declaració dels colors
         */
        $GLOBALS['strokeColor'] = '#000000';
        $GLOBALS['fillColorA'] = '#90EE90';
        $GLOBALS['fillColorS'] = '#FF8383';
        $GLOBALS['backgroundColor'] = '#FFFFFF';
        /*
         * Declaració de les proporcions del gràfic
         */
        $GLOBALS['pixels'] = 45;
        $GLOBALS['marge'] = 20;

        /*
         * Declaració de les dades
         */
        $GLOBALS['notes'] = $array_notes;
        $GLOBALS['alumnes'] = count($GLOBALS['notes']);

        session_start();
        $_SESSION["array_notes"]=$array_notes;

        inici();
    }

?>
        <br>
        <a href="index.php">
            <input type='submit' value='Página principal' class='info btn-primary'>
        </a>
</body>

</html>
