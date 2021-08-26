<?php

return [
    'url' => 'https://tiendadev.feriame.com',
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'contractEmail' => 'info@feriame.com',
    'infoEmail' => 'info@feriame.com',
    'RECAPTCHA_SECRET' => '6LfevS0aAAAAAK9b_R75pu3IeZwIFOmnTnncAgFQ',
    'GOOGLE_PLACES_TOKEN' => 'AIzaSyC5snGdsHrwZ0MhQs9Wy4BMmsbA5EdOHI0',
    'api_logistica' => [
        'URI' => $_ENV['API_LOGISTICA']
    ],
    'api_facturacion' => [
        'URI' => $_ENV['API_FACTURACION']
    ],
    'front' => [
        'URI' => $_ENV['FRONT']
    ],
    'firebase_token' => 'AAAAR0R_8nQ:APA91bFMalr028v1GkhIRWbKWJLqiidjKeUYuFyjXz1DcUQSQ4I5r-HPc5lEWJcxlX0NRBIRYZZ35E0TWIjRVsw3WaSE1Y_IFkadJxyHxfGU6Rv0sMLtI1Ysir5qNpcGs7ry-BPrsZZ7',
    'firebase_api_url' => 'https://fcm.googleapis.com/fcm/send',
    'mercadopago' => [
        'application_id' => $_ENV['MERCADOPAGO_APPLICATION_ID'],
        'redirect_uri'=> $_ENV['MERCADOPAGO_REDIRECT_URI'],
    ],
    'client_image_preference' => [
        'avatar' => 'avatar',
        'picture' => 'picture'
    ]
];
