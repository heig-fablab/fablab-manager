<?php

return [
  'realm_public_key' => env('KEYCLOAK_REALM_PUBLIC_KEY', null),

  'user_provider_credential' => env('KEYCLOAK_USER_PROVIDER_CREDENTIAL', 'username'),

  'token_principal_attribute' => env('KEYCLOAK_TOKEN_PRINCIPAL_ATTRIBUTE', 'preferred_username'),
];
