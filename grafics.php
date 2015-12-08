<?php
$notasCurso = 'Notas Curso ';
if (isset($_POST['aceptar'])) {
    $post = $_POST['aceptar'];
    if ($post=='Todas las notas') {
        allNoteAlumns();
    }else if(strstr($post, $notasCurso)){
        $porciones = explode(" ", $post);
        cursNoteAlumns($porciones[2]);
    }
} else if (isset($_POST['grafico'])) {
    $array_notes = [];
    $array_notes = unserialize(stripslashes($_POST['grafico']));
    declaraGlobals($array_notes);
}

/*
* Funcion que nos devuelve las notas de todos los alumnos de un mismo curso de una asignatura
* Parametros CURSO, ASIGNATURA
* return array
*/

function buscarPorParametro($curs, $assign, $alumn){
    $array_notes = [];
    $mysqli = new mysqli
    ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }

    $sentencia = $mysqli -> prepare("SELECT NOTA FROM NOTA WHERE CURS_ID IN (SELECT ID_CURS FROM CURS WHERE NOM_CURS = ? AND ASSIGNATURA_ID IN (SELECT ID_ASSIGNATURA FROM ASSIGNATURA WHERE NOM_ASSIGNATURA LIKE ?))");
    $sentencia->bind_param("sss",$curs, $assign,$alumn);
    $sentencia->execute();

    $sentencia->bind_result($nota);
    while ($sentencia->fetch())
    {
        array_push($array_notes, $nota);
    }
    declaraGlobals($array_notes);
}

/*
* Funcion que nos devuelve las notas de todos los alumnos
* Parametros
* return array
*/
function allNoteAlumns(){
    $array_notes = [];
    $mysqli = new mysqli
    ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }
    $resultat = $mysqli -> query("SELECT NOTA from NOTA" );
    while($fila=$resultat->fetch_assoc()){
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
    $mysqli = new mysqli
    ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }

    $sentencia = $mysqli -> prepare("SELECT NOTA FROM NOTA WHERE CURS_ID IN (SELECT ID_CURS FROM CURS WHERE NOM_CURS = ?)" );
    $sentencia->bind_param("s",$curs);
    $sentencia->execute();

    $sentencia->bind_result($nota);
    while ($sentencia->fetch())
    {
        array_push($array_notes, $nota);
    }
    declaraGlobals($array_notes);
}

/*
* Funcion que nos devuelve las notas de todos los alumnos de un mismo curso de una asignatura
* Parametros CURSO, ASIGNATURA
* return array
*/
function cursNoteAlumnsAssignature($curs, $assign){
    $array_notes = [];
    $mysqli = new mysqli
    ( "localhost" , "root" , "adminuser" , "ESCOLA_DB");
    if ($mysqli -> connect_errno) {
        echo "problema al connectar MySQL: " . $mysqli -> connect_error;
    }

    $sentencia = $mysqli -> prepare("SELECT NOTA FROM NOTA WHERE CURS_ID IN (SELECT ID_CURS FROM CURS WHERE NOM_CURS = ? AND ASSIGNATURA_ID IN (SELECT ID_ASSIGNATURA FROM ASSIGNATURA WHERE NOM_ASSIGNATURA LIKE ?))");
    $sentencia->bind_param("ss",$curs, $assign);
    $sentencia->execute();

    $sentencia->bind_result($nota);
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

    function dibuixaEix($draw, $strokeColor) {

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

    function dibuixaBarres($draw, $strokeColor) {

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
        dibuixaEix($draw, $strokeColor);
        dibuixaBarres($draw, $strokeColor);

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

        /*
         * Misc.
         */
        header("Content-Type: image/png");
        echo $imagick->getImageBlob();

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

        inici();
    }

?>
