<?php

return [
    'enabled' => env('NOVA_TWO_FA_ENABLE', true),
    'mandatory' => env('NOVA_TWO_FA_MANDATORY', false),
    'user_table' => 'users',
    'user_id_column' => 'id',
    'user_model' => \App\Models\User::class,
    'encrypt_google2fa_secrets' => false,
];
