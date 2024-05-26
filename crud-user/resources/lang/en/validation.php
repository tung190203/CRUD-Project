<?php

return [
    'email_does_not_exists' => 'The email does not exists.',
    'invalid_credentials' => 'The email or password is incorrect.',
    'custom' => [
        'name' => [
            'required' => 'The name field is required.',
            'string' => 'The name must be a string.',
        ],
        'email' => [
            'required' => 'The email field is required.',
            'email' => 'The email must be a valid email address.',
            'unique' => 'The email has already been taken.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'string' => 'The password must be a string.',
            'min' => 'The password must be at least :min characters.',
            'max' => 'The password may not be greater than :max characters.',
        ],
    ],
];
