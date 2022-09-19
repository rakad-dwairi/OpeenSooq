<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'jwt' => [
        'issuer' => 'https://api.example.com',  //name of your project (for information only)
        'audience' => 'https://frontend.example.com',  //description of the audience, eg. the website using the authentication (for info only)
        'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
        'expire' => 300,  //the short-lived JWT token is here set to expire after 5 min.
    ],
    'openWeatherUrl' => 'http://api.openweathermap.org/data/2.5/weather' , //?id=524901&appid=b5f63057c58a389cdec0f9a779d35fda'
    'open_weather_app_key' => 'b5f63057c58a389cdec0f9a779d35fda'

];
