<?php

return [
    /**
     * Name of session key to save current context
     */
    'session_key' => 'laravel_nova_current_context',

    /**
     * Array of available contexts
     *
     * Context format :
     * [
     *     'context_key' => 'theKeyOfYourContext', // key will be stored in database
     *      // Following translation in resources/lang/vendor/laravel-nova-contexts/fr/contexts.php
     *     'public_name_trans_key' => 'theTransKeyOfContextPublicName',
     * ]
     */
    'contexts' => [
        [
            'context_key' => 'main',
            'public_name_trans_key' => 'main_context', // "context_public_name_main_context" translation key
        ],
        /*[
            'context_key' => 'secondary',
            'public_name_trans_key' => 'secondary_context', // "context_public_name_secondary_context" translation key
        ],*/
    ],
];
