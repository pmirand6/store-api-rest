<?php
$responsable = $provider->getResponsable();
$responsableFirstName = $responsable instanceof ProviderContacts ? $responsable->firstname : null;
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
                            <br>
                            <br>
                            <h1 style="color: #383838; font-family: Arial;font-size: 22px;font-style: normal;font-weight: 700;line-height: 25px;letter-spacing: 0.05em;text-align: center;">Te damos la bienvenida a feriame</h1>
                            <br>
                            <br>
                            <img src="<?= $imageUrl ?>ilus-bienvenida.png" alt="ilus-bienvenida" style="width: 319px; height: 185px;">
                            <br>
                            <br>
                            <p style="color: #383838; width: 420px; font-family: Arial; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center;"><strong><?= $responsableFirstName ?></strong>, es un gusto tenerte como nuestro proveedor y socio estratégico.</p>
                            <br>
                            <p style="color: #383838; width: 420px;font-family: Arial; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center; ">Nos queda un paso más, por favor ingresar a este link para finalizar el proceso de alta.</p>
                            <br>
                            <br>
                            <a href="<?= $url ?>" style="text-decoration: none;"><img src="<?= $imageUrl ?>boton-ingresaraqui.png" alt="ingresar-aqui"></a>
                            <br>
                            <br>
                            <p style="color: #383838; font-family: Arial; font-size: 16px; font-style: normal; font-weight: 400; line-height: 21px; letter-spacing: 0px; text-align: center;">Tu usuario es:<br> <span style="color: #00C3AC; text-decoration: none;"><?= $provider->email ?></span></p>
                            <br>
                            <br>
                            <img src="<?= $imageUrl ?>linea.png" alt="linea" style="width: 420px; height: 1px;">
                            <br>
                            <br>
                            <p style="color: #00C3AC; font-family: Arial; font-size: 14px; font-style: normal; font-weight: 700; line-height: 16px; letter-spacing: 0.01em; text-align: center;">Cordiales saludos <br>Equipo de feriame</p>
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