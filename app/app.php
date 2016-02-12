<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/book.php";

    session_start();
    if(empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get('/', function () use ($app) {
        return $app['twig']->render('home.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post('/created', function () use ($app) {
        $contact = new Contact($_POST['name'], $_POST['number'], $_POST['address']);
        $contact->save();
        return $app['twig']->render('created_contact.html.twig', array('newcontact' => $contact));
    });

    $app->post('/delete_tasks', function() use ($app) {
        Contact::deleteAll();
        return $app['twig']->render('deleted.html.twig');
    });

    return $app;
?>
