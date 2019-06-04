<?php

require_once '../bootloader.php';

$form = [
    'fields' => [
        'balance' => [
            'label' => 'Įnešti pinigų',
            'type' => 'text',
            'placeholder' => 'Balansas',
            'validate' => [
                'validate_not_empty',
                'validate_is_number',
                'validate_is_positive',
                'validate_min_buy_in'
            ]
        ],
    ],
    'buttons' => [
        'submit' => [
            'text' => 'ĮNEŠTI!'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function validate_is_positive(&$safe_input, &$form) {

    if ($safe_input >= 0) {
        return true;
    } else {
        $form['error_msg'] = 'Buy-in negali būti neigiamas!';
    }
}

function validate_min_buy_in(&$safe_input, &$form) {
    if ($safe_input > 4) {
        return true;
    } else {
        $form['error_msg'] = 'Minimalus buy-in turi būti 5 EUR';
    }
}

function form_success($safe_input, $form) {
    $player = new \App\Player('player_cookie');
    $total_balance = $player->getBalance() + $safe_input['balance'];
    $player->setBalance($total_balance);
}

$show_success_msg = false;

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);

    if ($form_success) {
        $success_msg = strtr('Sėkmingai įnešta "@balance" EUR!', [
            '@balance' => $safe_input['balance']
        ]);
        $show_success_msg = true;
    }
}

$player = new \App\Player('player_cookie');
$player_balance = $player->getBalance();

?>
<html>
    <head>
        <title>Casino Index</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
              crossorigin="anonymous"/>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="index">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php">CASINO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link" href="index.php">Index</a>
                    <a class="nav-item nav-link" href="slot3x3.php">Slot 3x3</a>
                    <a class="nav-item nav-link" href="slot5x3.php">Slot 5x3</a>
                </div>
            </div>
        </nav>

        <section class="index-content">
            <?php if (isset($player_balance)): ?>
                <h2>Balansas: <?php print $player_balance; ?></h2>
            <?php else: ?>
                <h2>Balansas: 0</h2>
            <?php endif; ?>
            <?php require '../core/objects/form.php'; ?>
            <?php if ($show_success_msg): ?>
                <h3><?php print $success_msg; ?></h3>
            <?php endif; ?>
        </section>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
                integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
                integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    </body>
</html>