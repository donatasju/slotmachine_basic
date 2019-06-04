<?php

require_once '../bootloader.php';

$form = [
    'fields' => [],
    'buttons' => [
        'submit' => [
            'text' => 'Drožti!'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function form_success($safe_input, $form) {
    $images_array = [
        'vienas' => './images/4.jpg',
        'du' => './images/5.jpg',
        'trys' => './images/6.jpg'
    ];

    $slot5x3 = new \App\Slotmachine5x3($images_array);
    $slot5x3->spin();

    if ($slot5x3->checkWin()) {
        $player = new \App\Player('player_cookie');
        $total_balance = $player->getBalance() + (1 * \App\Slotmachine::FAIRNESS_CONF * (3 ** 5));
        $player->setBalance($total_balance);
    } else {
        $player = new \App\Player('player_cookie');
        $total_balance = $player->getBalance() - 1;
        $player->setBalance($total_balance);
    }
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
}

$images_array = [
    'vienas' => './images/4.jpg',
    'du' => './images/5.jpg',
    'trys' => './images/6.jpg'
];

$slot5x3 = new \App\Slotmachine5x3($images_array);

$slot5x3->spin();

?>
<html>
    <head>
        <title>Casino Slot 5x3</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
              crossorigin="anonymous"/>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="slot5x3">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php">SUKA</a>
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

        <section class="slot5x3-content">
            <h1>5x3 Rukyk</h1>

            <div class="slot5x3-images">
                <?php foreach ($slot5x3->getResult() as $images_array): ?>
                    <div class="image-container">
                        <?php foreach ($images_array as $image): ?>
                            <div class="slot-image" style="background-image: url(<?php print $image; ?>)"></div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php require '../core/objects/form.php'; ?>

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