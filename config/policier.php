<?php

return [
    "signkey" => app_env("APP_JWT_SECRET"),

    /**
    * Token expiration time
    */
    "exp" => 3600 * 24 * 3,

    /**
     * Configures the issuer
     */
    "iss" => app_env("APP_JWT_ISSUER", "app.example.com"),

    /**
     * Configures the audience
     */
    "aud" => app_env("APP_JWT_AUD", "app.example.com"),
];
