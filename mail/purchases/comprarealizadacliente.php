<?php
$delivery = $purchase->deliveryType->delivery_type;
switch ($delivery) {
    case 'node':
        $entrega = 'Nodo Feriame';
        $texto = "¡Gracias por tu compra! te recordamos que tu pedido <strong>" . strtoupper($purchase->shipping_code) . "</strong> se entregara en la siguiente modalidad <strong>$entrega</strong> en el siguiente domicilio <strong>{$node->data->streetName}</strong>.";
        break;

    case 'takeaway':
        $entrega = 'Retiro en Persona';
        $texto = "¡Gracias por tu compra! te recordamos que tu pedido <strong>" . strtoupper($purchase->shipping_code) . "</strong> se entregara en la siguiente modalidad <strong>$entrega</strong> en el siguiente domicilio <strong>" . $purchase->product->providers->formatted_address . "</strong>.";
        break;

    case 'delivery':
        $entrega = 'Entrega a Domicilio';
        $texto = "¡Gracias por tu compra! te recordamos que tu pedido <strong>" . strtoupper($purchase->shipping_code) . "</strong> se entregara en la siguiente modalidad <strong>$entrega</strong> en el siguiente domicilio <strong>" . $purchase->client->getPrincipalAddress() . "<strong>.";
        break;
    
    default:
        $entrega = '';
        $texto = '';
        break;
}
?>
<div style="width:100%; background-color: #f2f2f2; height:auto; margin: 0 auto; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; line-height: 1;">
    <table bgcolor="#f2f2f2" width="600" height="auto" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; display:block; border-collapse: collapse;">
        <tr height="20">
            <td></td>
        </tr>
        
        <tr>
            <td>
                <table width="600" height="auto" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; display:block;">
                    <th bgcolor="#fcfbfa" width="600" height="130">
                        <img src="<?= $imageUrl ?>header.png" alt="header" style="background-color: #fcfbfa; width: 600px; height: 130px;">
                        <center>
                            <h1 style="font-family: Arial; font-size: 22px; font-style: normal; font-weight: 700; line-height: 25px; letter-spacing: 0.05em; text-align: center; color: #383838;">¡<?= $purchase->client->name ?>, tu compra ha sido confirmada!</h1>
                            <br>
                            <br>
                            <img src="<?= $imageUrl ?>ilus-tupedido.png" alt="tu-pedido" style="width: 161px; height: 167px;">
                            <br>
                            <br>
                            <p style="font-family: Arial;font-size: 16px;font-style: normal;font-weight: 100;line-height: 21px;letter-spacing: 0px;text-align: center; width: 420px; color: #383838;">
                                <?= $texto ?>
                            </p>
                            <img src="<?= $imageUrl ?>linea.png" alt="linea" style="width: 420px; height: 1px;">
                            <p style="width: 420px; font-family: Arial; font-size: 16px; font-style: normal; font-weight: 100; line-height: 21px; letter-spacing: 0px; text-align: center; color: #383838;"><strong>Queremos que nos cuentes tu experiencia</strong><br>para seguir creciendo,<br> creando una nueva forma de ferias online.</p>
                            <br>
                            <div style="border: 1px solid #DADADA; width: 524px;">
                                <table bgcolor="white" width="524" height="auto" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; display:block;">
                                    <tr>
                                        <th height="141" width="3"></th>
                                        <th height="141" width="125">
                                            <img src="<?= $purchase->product->getPrincipalImage() ?>" alt="imagen-producto" width="124" height="124" style=" padding: 10px;">
                                        </th>
                                        <th height="141" width="259">
                                            <p style="color: #383838; font-family: Arial; font-size: 16px; font-style: normal; font-weight: 400; line-height: 20px; letter-spacing: 0em; text-align: left; margin-top: -5px;"><?= substr($purchase->product->name, 0, 51) ?>...</p>
                                            <p style="color: #383838; font-family: Arial; font-size: 18px; font-style: normal; font-weight: 700; line-height: 12px; letter-spacing: 0px; text-align: left;">$<?= number_format($purchase->product->price, 2) ?> x <?= $purchase->quantity ?>u</p>
                                            <p style="color: #818A91; font-family: Arial; font-size: 14px; font-style: normal; font-weight: 400; line-height: 0px; letter-spacing: 0em; text-align: left;"><?= $entrega ?></p>
                                        </th>
                                        <th height="141" width="152"><a href=<?=$_ENV['FRONT']?> style="text-decoration: none;"><img src="<?= $imageUrl ?>boton-calificarcompra.png" alt="calificar-compra" style="width: 168px; height: 55px; margin-top: 10px;"></a></th>
                                        <th height="141" width="3"></th>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <br>
                        </center>
                    </th>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" height="auto" cellpadding="0" cellspacing="0" border="0" style="margin: 0 auto; display:block;">
                    <th width="600" height="130">
                        <center>
                            <p style="text-align: center; width: 400px; font-size: 14px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: #383838; line-height: 18px;">Recibiste este correo electrónico porque estás registrado en feriame. Si recibiste esta notificación por error, contáctate con el equipo de Ayuda.</p>
                        </center>
                    </th>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#00c3ac">
                <center>
                    <img src="<?= $imageUrl ?>footer_curva.jpg" alt="footer-line" style="width: 600px; height: 60px;">
                    <img src="<?= $imageUrl ?>footer-logoferiame.png" alt="logo-feriame" style="width: 122px; height: 53px;">
                    <p style="width: 420px; text-align: center; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 12px;">Términos y condiciones, feriame Copyright © 2020</p>
                    <p style="width: 420px; text-align: center; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 12px;"><a href="#" style="text-decoration: none; color: white;">Gestionar mis suscripciones</a></p>
                    <a href="https://www.facebook.com/feriame.shop" style="text-decoration: none;"><img src="<?= $imageUrl ?>footer-fb.png" style="width: 26px; height: 26px;" alt="facebook"></a>
                    <a href="https://www.instagram.com/feriame.shop/" style="text-decoration: none;"><img src="<?= $imageUrl ?>footer-ig.png" style="width: 26px; height: 26px; margin-left: 5px; margin-right: 5px;" alt="instagram"></a>
                    <br>
                    <br>
                    <br>
                </center>
            </td>
        </tr>
    </table>
</div>