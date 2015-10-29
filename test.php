<?php
$a = [
    [
        'id' => 1,
        'player1' => [
            'name' => 'Name 1',
            'email' => 'Email 1'
        ],
        'player2' => [
            'name' => 'Name 2',
            'email' => 'Email 2'
        ],
        'winner' => 1,
        'wintype' => 'normal'
    ],
    [
        'id' => 2,
        'player1' => [
            'name' => 'Name 3',
            'email' => 'Email 3'
        ],
        'player2' => [
            'name' => 'Name 4',
            'email' => 'Email 4'
        ],
        'winner' => 1,
        'wintype' => 'super'
    ],
    [
        'id' => 3,
        'player1' => [
            'name' => 'Name 5',
            'email' => 'Email 5'
        ],
        'player2' => [
            'name' => 'Name 6',
            'email' => 'Email 6'
        ],
        'winner' => 2,
        'wintype' => 'superduper'
    ],
    [
        'id' => 4,
        'player1' => [
            'name' => 'Name 7',
            'email' => 'Email 7'
        ],
        'player2' => [
            'name' => 'Name 8',
            'email' => 'Email 8'
        ],
        'winner' => 2,
        'wintype' => 'domination'
    ],
];

echo json_encode($a);