<html>
<body>
<div style="width:100%; background-color: #f2f2f2; height:auto; margin: 0 auto; padding: 0; border: 0; font-size: 100%; font: inherit; vertical-align: baseline; line-height: 1;">
    <table bgcolor="#f2f2f2" width="600" height="auto" cellpadding="0" cellspacing="0" border="0"
           style="margin: 0 auto; display:block; border-collapse: collapse;">
        <tr height="20">
            <td></td>
        </tr>

        <tr>
            <td>
                <table width="600" height="auto" cellpadding="0" cellspacing="0" border="0"
                       style="margin: 0 auto; display:block;">
                    <th bgcolor="#fcfbfa" width="600" height="130">
                        <img src="<?= $imageUrl ?>header.png" alt="header"
                             style="background-color: #fcfbfa; width: 600px; height: 130px;">
                        <center>
                            <h1 style="font-family: Arial, Helvetica, sans-serif; color: #383838; width: 450px; font-size: 22px; font-style: normal; font-weight: 700; line-height: 25px; letter-spacing: 0.05em; text-align: center;">
                                ¡Vamos a entregar tu pedido!</h1>
                            <img src="<?= $imageUrl ?>vamos-a-visitarte_2.png" alt="imagen-producto"
                                 style="width: 392px; height: 212px;">
                            <br>
                            <p style="font-family: Arial, Helvetica, sans-serif; color: #383838; width: 324px; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center; "><?= $purchase->client->name . ' ' . $purchase->client->lastname ?>
                                , hoy vamos a entregar un pedido. <br>¡Estate atento!</p>
                            <table bgcolor="white" width="459" height="auto" cellpadding="0" cellspacing="0" border="0"
                                   bordercolor="#E1DADA">
                                <tr bgcolor="#F2F2F2">
                                    <td colspan="3" width="100%">
                                        <p style="margin: 10px; font-family: Arial, Helvetica, sans-serif; color: #373A3C; font-size: 14px; font-style: normal; font-weight: 700; line-height: 28px; letter-spacing: 0px; text-align: left; ">
                                            <strong>Pedido <?= $purchase->shipping_code ?></strong></p>
                                    </td>
                                </tr>
                                <tr bgcolor="#F2F2F2">
                                    <td style="width: 30%">
                                        <p style="text-align: left; margin: 10px;">
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img
                                                        src="<?= $imageUrl ?>check.png" alt="check"
                                                        style="width: 11px; height: 9px;"> Fecha</span><br>
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px;"><?= $today ?></span>
                                        </p>
                                    </td>
                                    <td style="width: 40%">
                                        <p style="text-align: left; margin: 10px;">
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img
                                                        src="<?= $imageUrl ?>check.png" alt="check"
                                                        style="width: 11px; height: 9px;"> Nombre de Conductor</span><br>
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px;"><?= $shippingResource['driver_name'] ?></span>
                                        </p>
                                    </td>
                                    <td style="width: 30%">
                                        <p style="text-align: left; margin: 10px;">
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img
                                                        src="<?= $imageUrl ?>check.png" alt="check"
                                                        style="width: 11px; height: 9px;"> Patente</span><br>
                                            <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px;"><?= $shippingResource['vehicle_license_plate'] ?></span>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <table bgcolor="white" width="459" height="auto" cellpadding="10"
                                               cellspacing="0" border="0">
                                            <tr>
                                                <th style="width: 30%; vertical-align: top;">
                                                    <img src="<?= $purchase->product->getPrincipalImage() ?>"
                                                         alt="imagen-producto" width="124" height="124"
                                                         style=" padding: 10px;">
                                                </th>
                                                <th style="width: 40%; vertical-align: top;">
                                                    <p style="text-align: left;">
                                                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img
                                                                    src="<?= $imageUrl ?>check.png" alt="check"
                                                                    style="width: 11px; height: 9px;">Producto</span><br>
                                                    </p>
                                                    <p style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px; margin-top: -15px;                                                        "><?= $purchase->product->name ?></p>
                                                </th>
                                                <th style="width: 30%; vertical-align: top;">
                                                    <p style="text-align: left;">
                                                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 700; line-height: 17px; letter-spacing: 0em; text-align: left; color: #00C3AC;"><img
                                                                    src="<?= $imageUrl ?>check.png" alt="check"
                                                                    style="width: 11px; height: 9px;">Unidades</span><br>
                                                        <span style="font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: normal; font-weight: 400; line-height: 17px; letter-spacing: 0em; text-align: left; color: #818A91; margin-left: 15px;"><?= $purchase->quantity ?></span>
                                                    </p>
                                                </th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <!-- <p style="color: #383838; width: 383px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center; ">Nos alegra tu venta en feriame y estamos orgullosos <br>sobre tu crecimiento junto a nosotros.</p> -->
                            <p style="font-family: Arial, Helvetica, sans-serif; width: 412px; font-weight: 600; font-size: 18px; line-height: 121.27%; text-align: center; color: #00C3AC; letter-spacing: 0.01em;">
                                Equipo de feriame</p>
                            <br>
                            <br>
                        </center>
                    </th>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="600" height="auto" cellpadding="0" cellspacing="0" border="0"
                       style="margin: 0 auto; display:block;">
                    <th width="600" height="130">
                        <center>
                            <p style="text-align: center; width: 400px; font-size: 14px; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: #383838; line-height: 18px;">
                                Recibiste este correo electrónico porque estás registrado en feriame. Si recibiste esta
                                notificación por error, contáctate con el equipo de Ayuda.</p>
                        </center>
                    </th>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#00c3ac">
                <center>
                    <img src="<?= $imageUrl ?>footer_curva.jpg" alt="footer-line" style="width: 600px; height: 60px;">
                    <img src="<?= $imageUrl ?>footer-logoferiame.png" alt="logo-feriame"
                         style="width: 122px; height: 53px;">
                    <p style="width: 420px; text-align: center; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 12px;">
                        Términos y condiciones, feriame Copyright © 2020</p>
                    <p style="width: 420px; text-align: center; font-weight: 100; font-family: Arial, Helvetica, sans-serif; color: white; font-size: 12px;">
                        <a href="#" style="text-decoration: none; color: white;">Gestionar mis suscripciones</a></p>
                    <a href="https://www.facebook.com/feriame.shop" style="text-decoration: none;"><img
                                src="<?= $imageUrl ?>footer-fb.png" style="width: 26px; height: 26px;"
                                alt="facebook"></a>
                    <a href="https://www.instagram.com/feriame.shop/" style="text-decoration: none;"><img
                                src="<?= $imageUrl ?>footer-ig.png"
                                style="width: 26px; height: 26px; margin-left: 5px; margin-right: 5px;" alt="instagram"></a>
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