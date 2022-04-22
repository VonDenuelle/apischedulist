<?php
    class JWT{

        // Generates JWT
        public function generate_jwt($headers, $payload, $secret = 'secret') {
            $headers_encoded = $this->base64url_encode(json_encode($headers));
            
            $payload_encoded = $this->base64url_encode(json_encode($payload));
            
            $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
            $signature_encoded = $this->base64url_encode($signature);
            
            $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
            
            return $jwt;
        }


        // Encode Base64 Strings tp Base64Url
        public function base64url_encode($str) {
            return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
        }
    }