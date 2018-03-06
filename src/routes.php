<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// Utilisateur (http://127.0.0.1/php_ecran_rest_api/public/utilisateur/nom/mdp)
$app->get('/utilisateur/[{login}/{password}]', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT id_utilisateur, id_habilitation FROM utilisateur WHERE nom_utilisateur=:login AND mot_de_passe_utilisateur=:password");
    $sth->bindParam("login", $args['login']);
    $sth->bindParam("password", $args['password']);
    $sth->execute();
    $utilisateur = $sth->fetchObject();
    return $this->response->withJson($utilisateur);
});
