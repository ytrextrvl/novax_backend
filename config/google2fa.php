<?php

return [
    'enabled' => env('GOOGLE2FA_ENABLED', true),
    'window' => 4,
    'otp_secret_column' => 'mfa_secret',
];
