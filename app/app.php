<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();

    $server = "mysql:host=localhost:8889;dbname=hair_salon";
    $username = "root";
    $password = "root";
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array("twig.path" => __DIR__."/../views"));

    // Home Page | Manager can add stylists

    $app->get("/", function() use ($app) { // Home page, shows all stylists
        return $app["twig"]->render("index.html.twig", array("stylists" => Stylist::getAll()));
    });

    $app->post("/", function() use ($app) { // Add stylist, refresh home page and show all stylists
        $first_name = filter_var($_POST["first_name"], FILTER_SANITIZE_MAGIC_QUOTES);
        $last_name = filter_var($_POST["last_name"], FILTER_SANITIZE_MAGIC_QUOTES);
        $phone_number = $_POST["phone_number"];
        $new_stylist = new Stylist($first_name, $last_name, $phone_number);
        $new_stylist->save();

        return $app["twig"]->render("index.html.twig", array("stylists" => Stylist::getAll()));
    });

    $app->delete("/", function() use ($app) { // Delete all stylists
        Stylist::deleteAll();
        return $app["twig"]->render("index.html.twig", array("stylists" => Stylist::getAll()));
    });

    // Stylists Page | Manager can add clients to particular stylist

    $app->get("/stylists/{id}", function($id) use ($app) {
        return $app["twig"]->render("stylist.html.twig");
    });

    return $app;
?>
