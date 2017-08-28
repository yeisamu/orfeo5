<?php
/**
 * En este frame se van cargado cada una de las funcionalidades del sistema
 *
 * Descripcion Larga
 *
 * @category
 * @package      SGD Orfeo
 * @subpackage   Main
 * @author       Community
 * @author       Skina Technologies SAS (http://www.skinatech.com)
 * @license      GNU/GPL <http://www.gnu.org/licenses/gpl-2.0.html>
 * @link         http://www.orfeolibre.org
 * @version      SVN: $Id$
 * @since
 */

        /*---------------------------------------------------------+
        |                     INCLUDES                             |
        +---------------------------------------------------------*/


        /*---------------------------------------------------------+
        |                    DEFINICIONES                          |
        +---------------------------------------------------------*/


        /*---------------------------------------------------------+
        |                       MAIN                               |
        +---------------------------------------------------------*/


$krdOld = $krd;
session_start();

if (!$krd)
    $krd = $krdOld;
if (!$ruta_raiz)
    $ruta_raiz = "..";
//include "$ruta_raiz/rec_session.php";
include_once("$ruta_raiz/include/db/ConnectionHandler.php");
include_once "$ruta_raiz/include/tx/Historico.php";
$db = new ConnectionHandler("$ruta_raiz");
//$db->conn->debug = true;
$encabezadol = "$PHP_SELF?" . session_name() . "=" . session_id() . "&dependencia=$dependencia&krd=$krd&codig=$codig&cod=$cod";
?>
<script>
    function regresar() {
        window.location.reload();
    }
    function NuevoV(codp) {
        window.open("relacionTiposAlmac2.php?<?= session_name() . "=" . session_id() ?>&krd=<?= $krd ?>&codp=" + codp + "", "Relacion Tipos de Almacenamiento", "height=250,width=850,scrollbars=yes");

    }
    function NuevoT(codp) {
        window.open("relacionTiposAlmac.php?<?= session_name() . "=" . session_id() ?>&krd=<?= $krd ?>&codp=" + codp + "", "Relacion Tipos de Almacenamiento", "height=450,width=850,scrollbars=yes");

    }
    function Editar(code, codp, codig) {
        window.open("editTiposAlmac.php?<?= session_name() . "=" . session_id() ?>&krd=<?= $krd ?>&cod=" + code + "&codp=" + codp + "&codig=" + codig + "", "Edicion Tipos de Almacenamiento", "height=150,width=650,scrollbars=yes");

    }
    function Borrar(cod)
    {
        window.open("bortipo.php?<?= session_name() . "=" . session_id() ?>&krd=<?= $krd ?>&cod=" + cod + "&tipo=2", "Borrar Tipos", "height=150,width=150,scrollbars=yes");
    }
</script>
<head>
    <title>Edición de edificios</title>
    <link href="<?= $ruta_raiz . $ESTILOS_PATH2 ?>bootstrap.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?= $ruta_raiz . $_SESSION['ESTILOS_PATH_ORFEO'] ?>">
</head>

<form name="ediEdificio" action="<?= $encabezadol ?>" method="post" >
    <center>
        <div id="titulo" style="width: 90%;" align="center">Edicion de edificios</div>
        <table border="1" width="90%" cellpadding="0"  class="borde_tab">
            <?
            $codp = $cod;
            ?>
            <tr><td class="listado2" colspan="6" align="center"><input type="button" class="botones"  align="middle" name="nuevo" value="Nuevo" onClick="NuevoV(<?= $codp ?>);">
                    <input type="button" class="botones_largo"  align="middle" name="nuevo" value="Nuevo ingreso grupo" onClick="NuevoT(<?= $codp ?>);">
                    <input type="button" name="cerrar" class="botones" value="Salir" onClick="window.close();"></td></tr>
            <tr>
                <td class="listado2" colspan="6" >
                    <?
                    $sq = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_cod_padre='$cod'";
                    $rt = $db->conn->Execute($sq);
                    if (!$rt->EOF)
                        $nop = $rt->fields['SGD_EIT_NOMBRE'];
                    $nod = explode(' ', $nop);
                    echo $nod[0] . "  ";
                    $c = 0;
                    $cp = 0;
                    $conD = $db->conn->Concat("sgd_eit_codigo", "'-'", "sgd_eit_nombre");
//$sqli="select ($conD) as detalle,sgd_eit_codigo from sgd_eit_items where sgd_eit_codigo='$cod'";
                    $sqli = "select ($conD) as detalle,sgd_eit_codigo from sgd_eit_items where sgd_eit_cod_padre='$cod'";
//$db->conn->debug=true;
                    $rsi = $db->conn->Execute($sqli);
                    print $rsi->GetMenu2('codig', $codig, true, false, "", "class='select'; onchange=submit();");
                    /* if(!$rsi->EOF)$nomp[$cp]=$rsi->fields['SGD_EIT_NOMBRE'];
                      //$sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$cod'";
                      $sql="select * from sgd_eit_items where sgd_eit_cod_padre = '$cod'";
                      $rs=$db->conn->Execute($sql);
                      while(!$rs->EOF){
                      $nom[$c]=$rs->fields['SGD_EIT_NOMBRE'];
                      $codi[$c]=$rs->fields['SGD_EIT_CODIGO'];
                      ?>
                      <tr>
                      <td class="titulos5"><?=$cod?></td>
                      <td class="titulos5"><?=$nomp[$cp]?></td>
                      <td class="titulos5"><?=$codi[$c]?></td>
                      <td class="titulos5"><?=$nom[$c]?></td>
                      <td class="titulos5"><input type="radio" name="edit" value="1" onClick="Editar(<?=$codi[$c]?>,<?=$codp?>)" <?=$sel?> align="absmiddle"></td>
                      <td class="titulos5"><input type="radio" name="borr" value="1" onClick="Borrar(<?=$codi[$c]?>)" <?=$sel2?> align="absmiddle"></td></tr>
                      <?
                      $c++;
                      $rs->MoveNext();
                      } */
                    ?>
            </tr>
            <tr>
                <td class="titulos2"><b>Codigo del Padre</b></td>
                <td class="titulos2"><B>Nombre del Padre</B></td>
                <td class="titulos2"><b>Codigo del Hijo</b></td>
                <td class="titulos2"><B>Nombre del Hijo</B></td>
                <td class="titulos2"><B>Editar</B></td>
                <td class="titulos2"><B>Borrar</B></td></tr>

            <?
            $sqt = "select count(sgd_eit_codigo) as co from sgd_eit_items where sgd_eit_codigo='$cod'";
            $rsty = $db->conn->Execute($sqt);
            if (!$rsty->EOF)
                $c = $rsty->fields['CO'];
            $cp++;
            $tm = $c;
            for ($i = 0; $i < $tm; $i++) {
                $sqli = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codig'";
//$db->conn->debug=true;
                $rsi = $db->conn->Execute($sqli);
                if (!$rsi->EOF)
                    $nomp[$cp] = $rsi->fields['SGD_EIT_NOMBRE'];
                $codigo = $codig;
                $sql = "select * from sgd_eit_items where sgd_eit_cod_padre = '$codig'";
                $rs = $db->conn->Execute($sql);
                while (!$rs->EOF) {
                    $nom[$c] = $rs->fields['SGD_EIT_NOMBRE'];
                    $codi[$c] = $rs->fields['SGD_EIT_CODIGO'];
                    ?>
                    <tr><td class="listado2"><?= $codigo ?></td>
                        <td class="listado2"><?= $nomp[$cp] ?></td>
                        <td class="listado2"><?= $codi[$c] ?></td>
                        <td class="listado2"><?= $nom[$c] ?></td>
                        <td class="listado2"><input type="radio" name="edit" value="1" onClick="Editar(<?= $codi[$c] ?>,<?= $codp ?>,<?= $codig ?>)" <?= $sel ?> align="absmiddle"></td>
                        <td class="listado2"><input type="radio" name="borr" value="1" onClick="Borrar(<?= $codi[$c] ?>)" <?= $sel2 ?> align="absmiddle"></td></tr>
                    <?
                    $c++;
                    $rs->MoveNext();
                }
                $cp++;
            }

            $tm1 = $c;
            for ($i = $tm; $i < $tm1; $i++) {
                $sqli = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
                $rsi = $db->conn->Execute($sqli);
                if (!$rsi->EOF)
                    $nomp[$cp] = $rsi->fields['SGD_EIT_NOMBRE'];
                $codigo = $codi[$i];
                $sql = "select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
                $rs = $db->conn->Execute($sql);
                while (!$rs->EOF) {
                    $nom[$c] = $rs->fields['SGD_EIT_NOMBRE'];
                    $codi[$c] = $rs->fields['SGD_EIT_CODIGO'];
                    ?>
                    <tr><td class="listado2"><?= $codigo ?></td>
                        <td class="listado2"><?= $nomp[$cp] ?></td>
                        <td class="listado2"><?= $codi[$c] ?></td>
                        <td class="listado2"><?= $nom[$c] ?></td>
                        <td class="listado2"><input type="radio" name="edit" value="1" onClick="Editar(<?= $codi[$c] ?>,<?= $codp ?>,<?= $codig ?>)" <?= $sel ?> align="absmiddle"></td>
                        <td class="listado2"><input type="radio" name="borr" value="1" onClick="Borrar(<?= $codi[$c] ?>)" <?= $sel2 ?> align="absmiddle"></td></tr>
                    <?
                    $c++;
                    $rs->MoveNext();
                }
                $cp++;
            }

            $tm2 = $c;
            for ($i = $tm1; $i < $tm2; $i++) {
                $sqli = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
                $rsi = $db->conn->Execute($sqli);
                if (!$rsi->EOF)
                    $nomp[$cp] = $rsi->fields['SGD_EIT_NOMBRE'];
                $codigo = $codi[$i];
                $sql = "select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
                $rs = $db->conn->Execute($sql);
                while (!$rs->EOF) {
                    $nom[$c] = $rs->fields['SGD_EIT_NOMBRE'];
                    $codi[$c] = $rs->fields['SGD_EIT_CODIGO'];
                    ?>
                    <tr><td class="listado2"><?= $codigo ?></td>
                        <td class="listado2"><?= $nomp[$cp] ?></td>
                        <td class="listado2"><?= $codi[$c] ?></td>
                        <td class="listado2"><?= $nom[$c] ?></td>
                        <td class="listado2"><input type="radio" name="edit" value="1" onClick="Editar(<?= $codi[$c] ?>,<?= $codp ?>,<?= $codig ?>)" <?= $sel ?> align="absmiddle"></td>
                        <td class="listado2"><input type="radio" name="borr" value="1" onClick="Borrar(<?= $codi[$c] ?>)" <?= $sel2 ?> align="absmiddle"></td></tr>
                    <?
                    $c++;
                    $rs->MoveNext();
                }
                $cp++;
            }

            $tm3 = $c;
            for ($i = $tm2; $i < $tm3; $i++) {
                $sqli = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
                $rsi = $db->conn->Execute($sqli);
                if (!$rsi->EOF)
                    $nomp[$cp] = $rsi->fields['SGD_EIT_NOMBRE'];
                $codigo = $codi[$i];
                $sql = "select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
                $rs = $db->conn->Execute($sql);
                while (!$rs->EOF) {
                    $nom[$c] = $rs->fields['SGD_EIT_NOMBRE'];
                    $codi[$c] = $rs->fields['SGD_EIT_CODIGO'];
                    ?>
                    <tr><td class="listado2"><?= $codigo ?></td>
                        <td class="listado2"><?= $nomp[$cp] ?></td>
                        <td class="listado2"><?= $codi[$c] ?></td>
                        <td class="listado2"><?= $nom[$c] ?></td>
                        <td class="listado2"><input type="radio" name="edit" value="1" onClick="Editar(<?= $codi[$c] ?>,<?= $codp ?>,<?= $codig ?>)" <?= $sel ?> align="absmiddle"></td>
                        <td class="listado2"><input type="radio" name="borr" value="1" onClick="Borrar(<?= $codi[$c] ?>)" <?= $sel2 ?> align="absmiddle"></td></tr>
                    <?
                    $c++;
                    $rs->MoveNext();
                }
                $cp++;
            }

            $tm4 = $c;
            for ($i = $tm3; $i < $tm4; $i++) {
                $sqli = "select sgd_eit_nombre from sgd_eit_items where sgd_eit_codigo='$codi[$i]'";
//$db->conn->debug=true;
                $rsi = $db->conn->Execute($sqli);
                if (!$rsi->EOF)
                    $nomp[$cp] = $rsi->fields['SGD_EIT_NOMBRE'];
                $codigo = $codi[$i];
                $sql = "select * from sgd_eit_items where sgd_eit_cod_padre = '$codi[$i]'";
                $rs = $db->conn->Execute($sql);
                while (!$rs->EOF) {
                    $nom[$c] = $rs->fields['SGD_EIT_NOMBRE'];
                    $codi[$c] = $rs->fields['SGD_EIT_CODIGO'];
                    ?>
                    <tr><td class="listado2"><?= $codigo ?></td>
                        <td class="listado2"><?= $nomp[$cp] ?></td>
                        <td class="listado2"><?= $codi[$c] ?></td>
                        <td class="listado2"><?= $nom[$c] ?></td>
                        <td class="listado2"><input type="radio" name="edit" value="1" onClick="Editar(<?= $codi[$c] ?>,<?= $codp ?>,<?= $codig ?>)" <?= $sel ?> align="absmiddle"></td>
                        <td class="listado2"><input type="radio" name="borr" value="1" onClick="Borrar(<?= $codi[$c] ?>)" <?= $sel2 ?> align="absmiddle"></td></tr>
        <?
        $c++;
        $rs->MoveNext();
    }
    $cp++;
}
?>
            </form>
        </table>
    </center>