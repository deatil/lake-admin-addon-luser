<?php

return [
    'salt' => env('luser.salt', 'sdfgsdfgsd34245f'),
    
    'jwt_alg' => env('luser.jwt_alg', 'HS256'),
    'jwt_iss' => env('luser.jwt_iss', ''),
    'jwt_aud' => env('luser.jwt_aud', ''),
    'jwt_tokenid' => env('luser.jwt_tokenid', ''),
    'jwt_secrect' => env('luser.jwt_secrect', ''),
    'jwt_exptime' => env('luser.jwt_exptime', ''),
    'jwt_notbeforetime' => env('luser.jwt_notbeforetime', ''),
    
    'access_exptime' => env('luser.access_exptime', ''),
];
