<?php
session_start();

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';


error_reporting(E_ALL ^ E_DEPRECATED);

\mywishlist\database\Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "conf" . DIRECTORY_SEPARATOR . "conf.ini");

$container = new Slim\Container(['settings' => ['displayErrorDetails' => true]]);
$app = new Slim\App($container);

$app->get('/participant',
    function (Request $rq, Response $rs, $args): Response {

        //display all cards
        $listl = \mywishlist\models\Liste::all();
        $vue = new \mywishlist\views\VueParticipant($listl->toArray());

        return $rs->write($vue->render(1));

    });

// Display a list with his ID
$app->post('/participant',
    function (Request $rq, Response $rs, $args): Response {
        $id = $_POST['id'];
        $listl = \mywishlist\models\Liste::where("no", "=", $id)->get();
        $vue = new \mywishlist\views\VueParticipant($listl->toArray());
        $rs->getBody()->write($vue->render(2));
        return $rs;
    });


//display a specific item
$app->get('/participant/3/:idItem',
    function (Request $rq, Response $rs, $args): Response {

        $listl = \mywishlist\models\Item::find(1);
        $vue = new \mywishlist\views\VueParticipant([$listl]);

        return $rs->write($vue->render(3));
    });


$app->get('/login',
    function (Request $rq, Response $rs, $args): Response {

        $oui = new \mywishlist\controllers\UserController();


        return $rs->write($oui->getRender());
    });

$app->post('/login',
    function (Request $rq, Response $rs, $args): Response {
    $username = $_POST["login"];
    $password = $_POST["pwd"];
        $oui = new \mywishlist\controllers\UserController();


        return $rs->write($oui->connectUser($username,$password));
    });
$app->run();