<?php

return [
    'salt' => env('luser.salt', 'JM2B5QzP3SWF'),
    
    'jwt_alg' => env('luser.jwt_alg', 'HS256'),
    'jwt_iss' => env('luser.jwt_iss', ''),
    'jwt_aud' => env('luser.jwt_aud', ''),
    'jwt_sub' => env('luser.jwt_sub', ''),
    'jwt_jti' => env('luser.jwt_jti', ''),
    'jwt_secrect' => env('luser.jwt_secrect', '6g7s2OQU'),
    'jwt_exptime' => env('luser.jwt_exptime', ''),
    'jwt_notbeforetime' => env('luser.jwt_notbeforetime', ''),
    
    'access_exptime' => env('luser.access_exptime', ''),
];
