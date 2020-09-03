<?php

return [
    'salt' => env('luser.salt', 'lBASCP2TVHUI'),
    
    'jwt_alg' => env('luser.jwt_alg', 'HS256'),
    'jwt_iss' => env('luser.jwt_iss', ''),
    'jwt_aud' => env('luser.jwt_aud', ''),
    'jwt_sub' => env('luser.jwt_sub', ''),
    'jwt_jti' => env('luser.jwt_jti', ''),
    'jwt_exptime' => env('luser.jwt_exptime', ''),
    'jwt_notbeforetime' => env('luser.jwt_notbeforetime', ''),
    
    'jwt_signer_type' => env('luser.jwt_signer_type', 'RSA'),
    'jwt_secrect' => env('luser.jwt_secrect', 'yWdqBfGu'),
    'jwt_private_key' => env('luser.jwt_private_key'),
    'jwt_public_key' => env('luser.jwt_public_key'),
    
    'access_exptime' => env('luser.access_exptime', ''),
];
