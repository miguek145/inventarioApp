<?php
require_once "../phpqrcode/qrlib.php";
require_once "../model/conexionDB.php";

class GeneradorQR{
    public static function generarCodigo(array $arrayIdProductosUnitarios){
        $arrayCodigosQR = []; // Carrito vacío
        
        foreach($arrayIdProductosUnitarios as $idProductoUnitario){
            $nombreArchivo = tempnam(sys_get_temp_dir(), "qr_") . ".png";
            $url = "http://localhost:3000/inventarioApp/controller/verProductoUnitarioController.php?idProductoUnitario=".urlencode($idProductoUnitario);
            QRcode::png($url, $nombreArchivo, 'M', 4, 2);
            $datosCodigo = file_get_contents($nombreArchivo);
            
            $codificacionImagen = 'data:image/png;base64,' . base64_encode($datosCodigo);
            unlink($nombreArchivo);
            
            // Lo guardamos en el carrito
            $arrayCodigosQR[$idProductoUnitario] = $codificacionImagen;
        }
        
        return $arrayCodigosQR; // Devolvemos todo al final
    }
}
?>