<?php
function encodeJWT($payload) {
    // Clave secreta para firmar el JWT (asegúrate de mantenerla segura y no exponerla públicamente)
    $secretKey = 'clave_secreta_segura';

    // Encabezado (header) del JWT
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

    // Codificar encabezado y payload a base64 URL-safe
    $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
    $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

    // Crear la firma
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    // Retornar el token completo
    return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
}

function decodeJWT($jwt) {
    // Clave secreta para verificar el JWT
    $secretKey = 'clave_secreta_segura';

    // Separar el JWT en sus partes
    $parts = explode('.', $jwt);
    if (count($parts) !== 3) {
        throw new Exception('Token JWT inválido.');
    }

    $base64UrlHeader = $parts[0];
    $base64UrlPayload = $parts[1];
    $base64UrlSignature = $parts[2];

    // Decodificar el payload
    $payload = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $base64UrlPayload)), true);

    // Verificar la firma
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secretKey, true);
    $validSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

    if ($validSignature !== $base64UrlSignature) {
        throw new Exception('Firma del token JWT no válida.');
    }

    return $payload;
}
?>
