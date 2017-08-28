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


session_start();
$verrad = "";
$ruta_raiz = "..";
if (!$dependencia and ! $depe_codi_territorial)
    include "../rec_session.php";

if (!$dep_sel)
    $dep_sel = $dependencia;
$depeBuscada = $dep_sel;
?>
<html>
    <head>
        <title>Generacion planilla de entrega</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <link href="<?= $ruta_raiz . $ESTILOS_PATH2 ?>bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= $ruta_raiz . $_SESSION['ESTILOS_PATH_ORFEO'] ?>">
        <script src="<?= $ruta_raiz ?>/estilos/js/jquery-3.1.1.min.js" type="text/javascript"></script>
        <script src="<?= $ruta_raiz ?>/estilos/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div id="spiffycalendar" class="text"></div>
        <link rel="stylesheet" type="text/css" href="js/spiffyCal/spiffyCal_v2_1.css">
        <?
        $ruta_raiz = "..";
        include_once "$ruta_raiz/include/db/ConnectionHandler.php";
        $db = new ConnectionHandler("$ruta_raiz");
        if (!$dep_sel)
            $dep_sel = $dependencia;
        $depeBuscada = $dep_sel;
//
        if ($generar_listado and ! $cancelarAnular) {
            $indi_generar = "SI";
        } else {
            $indi_generar = "NO";
        }
//Modificado skina
        //if($indi_generar=="SI")
        //{

        $encabezado = "" . session_name() . "=" . session_id() . "&krd=$krd&num=$num&hora_ini=$hora_ini&hora_fin=$hora_fin&minutos_ini=$minutos_ini&minutos_fin=$minutos_fin&tip_radi=$tip_radi&fecha_busqH=$fecha_busqH&fecha_busq=$fecha_busq&dep_sel=$dep_sel&dep_sel_dest=$dep_sel_dest&filtroSelect=$filtroSelect&nomcarpeta=$nomcarpeta";
        $linkPagina = "$PHP_SELF?$encabezado&orderTipo=$orderTipo&orderNo=$orderNo";
        $encabezado = "" . session_name() . "=" . session_id() . "&adodb_next_page=1&krd=$krd&num=$num&hora_ini=$hora_ini&hora_fin=$hora_fin&minutos_ini=$minutos_ini&minutos_fin=$minutos_fin&tip_radi=$tip_radi&fecha_busqH=$fecha_busqH&fecha_busq=$fecha_busq&dep_sel=$dep_sel&dep_sel_dest=$dep_sel_dest&filtroSelect=$filtroSelect&nomcarpeta=$nomcarpeta&orderTipo=$orderTipo&orderNo=";
        ?>
        <script>
            function Marcar()
            {
                marcados = 0;
                for (i = 2; i < document.gen_lisDefi.elements.length; i++)
                {
                    if (document.gen_lisDefi.elements[i].checked == 1)
                    {
                        marcados++;
                    }
                }
                if (marcados >= 1)
                {
                    document.gen_lisDefi.submit();
                } else
                {
                    alert("Debe marcar un elemento");
                }
            }
        </script>

        <?
        if (strlen($orderNo) == 0) {
            $orderNo = "1";
            $order = 1;
        } else {
            $order = $orderNo + 1;
        }

        //Condicion Dependencia
        $dependencia_busq1 = " and h.depe_codi = '$dep_sel'";
        if ($dep_sel_dest == 0)
            $dependencia_busq2 = " ";
        else
            $dependencia_busq2 = " and h.depe_codi_dest = '$dep_sel_dest'";
        //Construccion Condicion de Fechas//
        $fecha_ini = $fecha_busq;
        $fecha_fin = $fecha_busqH;
        $fecha_ini = mktime($hora_ini, $minutos_ini, 00, substr($fecha_busq, 5, 2), substr($fecha_busq, 8, 2), substr($fecha_busq, 0, 4));
        $fecha_fin = mktime($hora_fin, $minutos_fin, 59, substr($fecha_busqH, 5, 2), substr($fecha_busqH, 8, 2), substr($fecha_busqH, 0, 4));

        $where_fecha = " and h.hist_fech BETWEEN
		" . $db->conn->DBTimeStamp($fecha_ini) . " and " . $db->conn->DBTimeStamp($fecha_fin);
        //Condicion Tipo Radicacion
        if ($tip_radi == 0) {
            $where_tipRadi = "";
        } else {
            $where_tipRadi = " and CAST(c.radi_nume_radi as varchar(15)) like '%$tip_radi'";
        }
        include "$ruta_raiz/include/query/tx/queryParamListaImpresos.php";
        $rs = $db->conn->Execute($isql);
        //$db->conn->debug=true;


        if (!$rs->EOF) {
            ?>	
            <br>
        <center>
            <div id="titulo" style="width: 40%;" align="center">Generacion listado de entrega</div>
            <table border=1 cellspace=2 cellpad=2 WIDTH=40%  class="t_bordeGris">
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">Fecha inicial :
                    </td>
                    <td  width="65%" height="25" class="listado2">
                        <?= $fecha_busq . " " . $hora_ini . " : " . $minutos_ini . ":00" ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">Fecha final :
                    </td>
                    <td  width="65%" height="25" class="listado2">
                        <?= $fecha_busqH . " " . $hora_fin . " : " . $minutos_fin . ":59" ?>
                    </td>
                </tr>
                <tr>
                    <td align="right" bgcolor="#CCCCCC" height="25" class="titulos2">Fecha generación :
                    </td>
                    <td  width="65%" height="25" class="listado2">
                        <? echo date("Y-m-d - H:i:s"); ?>
                    </td>
                </tr>	
            </table>

            <form name=gen_lisDefi  action='generaListaImpresos.php?<?= $encabezado ?>' method="post">
                <table border=0 cellspace=2 cellpad=2 WIDTH=40%  class="t_bordeGris" >
                    <tr tr align= "right">
                        <td width="1120" height="26" colspan="2" valign="top" class="listado1"> 

                            <INPUT TYPE=submit name=gen_lisDefi Value=' Confirmar ' class=botones id=Confirmar onclick="Marcar();">
                            <INPUT TYPE=submit name=cancelarListado value=Cancelar class=botones></td></tr>
                </table>
        </center>
        <?
        $pager = new ADODB_Pager($db, $isql, 'adodb', true, $orderNo, $orderTipo);
        $pager->checkAll = true;
        $pager->checkTitulo = true;
        $pager->toRefLinks = $linkPagina;
        $pager->toRefVars = $encabezado;
        $pager->Render($rows_per_page = 15, $linkPagina, $checkbox = chkEnviar);
    }
    //Modificado skina - Si la seleccion es "Generar" pero no se encuentra ningun valor sobre el rango
    elseif ($generar_listado) {
        echo "<hr><center><b><span class='alarmas'>No se encuentra ningun radicado con el criterio de selección</span></center></b></hr>";
    }
    ?>	
</form>
<?
//}
//Modificado skina - Si su selección es "Cancelar"
if ($cancelarAnular) {
    echo "<hr><center><b><span class='alarmas'>Operacion CANCELADA</span></center></b></hr>";
}
?>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
</body>

</html>