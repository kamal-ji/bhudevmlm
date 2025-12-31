<?php

return [
    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase/tiara-adb0a-281e02efd5b2.json')),
    ],

    'project_id' => env('FIREBASE_PROJECT_ID', 'tiara-adb0a'), // your Firebase project ID
];
