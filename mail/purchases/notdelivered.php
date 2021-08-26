<html>
    <body>
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
                                    <h1 style="font-family: Arial; font-size: 22px; font-style: normal; font-weight: 700; line-height: 25px; letter-spacing: 0.05em; text-align: center; color: #383838;">Te visitamos el día de hoy</h1>
                                    <br>
                                    <p style="font-family: Arial, Helvetica, sans-serif; color: #383838; width: 420px; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center; ">
                                        <strong><?= $purchase->client->name . ' ' . $purchase->client->lastname ?></strong>, te informamos que hoy te visitamos para entregarte tu pedido y no te encontramos en tu domicilio.
                                        <br>
                                        <br>
                                        Por lo cual, <strong>procedimos a dejarlo en el <?= $node['name'] ?></strong>, tal como lo indicaste en el proceso de compra.
                                    </p>
                                    <br>
                                    <br>
                                    <table bgcolor="white" width="459" height="auto" cellpadding="0" cellspacing="0" border="0" bordercolor="#E1DADA">
                                        <tr bgcolor="#F2F2F2">
                                            <td colspan="3" width="100%">
                                                <p style="margin: 10px; font-family: Arial, Helvetica, sans-serif; color: #373A3C; font-size: 14px; font-style: normal; font-weight: 700; line-height: 28px; letter-spacing: 0px; text-align: left; "><strong>Pedido <?= $purchase->shipping_code ?></strong></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding: 10px 0;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="width: 50%">
                                                            <p style="text-align: left; padding: 0 20px;">
                                                                <img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px; margin-right: 5px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;">Dirección del nodo</span><br>
                                                            </p>
                                                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 35px; margin-top: -10px;"><?= $node['streetName'] ?></p>
                                                        </td>
                                                        <td style="width: 50%">
                                                            <p style="text-align: left; padding: 0 20px; ">
                                                                <img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px; margin-right: 5px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;">Horario de atención</span><br>
                                                            </p>
                                                            <p style="padding-right: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 35px; margin-top: -10px;"><?= $node['workDays'][0] ?> a <?= $node['workDays'][1] ?>
                                                                de <?= $node['workHourStart'] ?> a <?= $node['workHourEnd'] ?></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="padding: 10px 0;">
                                                <table style="width: 100%;">
                                                    <tr>
                                                        <td style="width: 50%">
                                                            <p style="text-align: left; padding: 0 20px;">
                                                                <img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px; margin-right: 5px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;">Modalidad Entrega</span><br>
                                                            </p>
                                                            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 35px; margin-top: -10px;">Nodo</p>
                                                        </td>
                                                        <td style="width: 50%">
                                                            <p style="text-align: left; padding: 0 20px; ">
                                                                <img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px; margin-right: 5px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;">E-mail</span><br>
                                                            </p>
                                                            <p style="padding-right: 10px; font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 35px; margin-top: -10px;"><?= $node['email'] ?></p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 30%; vertical-align: top;">
                                                <img src="<?= $purchase->product->getPrincipalImage() ?>" alt="imagen-producto" style="width: 124px; height: 124px;">
                                            </td>
                                            <td style="width: 40%; vertical-align: top;">
                                                <p style="text-align: left; margin: 10px;">
                                                    <img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px; margin-right: 5px;"><span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;">Producto</span><br>
                                                </p>
                                                <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 25px; margin-top: -10px;"><?= $purchase->product->name ?></p>
                                            </td>
                                            <td style="width: 30%; vertical-align: top;">
                                                <p style="text-align: left; margin: 10px;">
                                                    <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img src="<?= $imageUrl ?>check.png" alt="check" style="width: 11px; height: 9px;"> Unidades</span><br>
                                                    <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px;"><?= $purchase->quantity ?></span>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <!-- <p style="color: #383838; width: 383px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center; ">Nos alegra tu venta en feriame y estamos orgullosos <br>sobre tu crecimiento junto a nosotros.</p> -->
                                    <br>
                                    <img src="<?= $qrUrl ?>qr.png" alt="check" width="260" height="260">
                                    <br>
                                    <br>
                                    <p style="font-family: Arial, Helvetica, sans-serif; width: 412px; font-weight: 600; font-size: 18px; line-height: 121.27%; text-align: center; color: #00C3AC; letter-spacing: 0.01em;">Equipo de feriame</p>
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
    </body>
</html>