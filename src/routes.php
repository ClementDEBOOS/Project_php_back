<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

// DEBUT GET -------------------------------------------------------------------------
// Utilisateur (http://127.0.0.1/php_ecran_rest_api/public/utilisateur/nom/mdp)
$app->get('/utilisateur/[{login}/{password}]', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT id_utilisateur, id_habilitation FROM utilisateur WHERE nom_utilisateur=:login AND mot_de_passe_utilisateur=:password");
    $sth->bindParam("login", $args['login']);
    $sth->bindParam("password", $args['password']);
    $sth->execute();
    $utilisateur = $sth->fetchObject();
    return $this->response->withJson($utilisateur);
});

// Liste des 5 dernières actus (http://127.0.0.1/php_ecran_rest_api/public/actus)
$app->get('/actus', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM actualite ORDER BY date_ajout_actualite DESC LIMIT 5");
    $sth->execute();
    $actus = $sth->fetchAll();
    return $this->response->withJson($actus);
});

// Liste des 5 derniers évenements (http://127.0.0.1/php_ecran_rest_api/public/evenements)
$app->get('/evenements', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM evenement ORDER BY date_ajout_evenement DESC LIMIT 5");
    $sth->execute();
    $evenements = $sth->fetchAll();
    return $this->response->withJson($evenements);
});
// FIN GET

// DEBUT POST -----------------------------------------------------------
// Ajout d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/nouvelleActu)
$app->post('/nouvelleActu', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO `actualite`(`titre_actualite`, `contenu_actualite`, `date_ajout_actualite`, `image_url_actualite`) 
            VALUES (:titre_actualite, :contenu_actualite, :date_ajout_actualite, :image_url_actualite);";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("titre_actualite", $input['titre_actualite']);
    $sth->bindParam("contenu_actualite", $input['contenu_actualite']);
    $sth->bindParam("date_ajout_actualite", date('Y-m-d H:i:s'));
    $sth->bindParam("image_url_actualite", $input['image_url_actualite']);
    $sth->execute();
    return $this->response->withJson($input);
});

// Ajout d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/nouvelEvenement)
$app->post('/nouvelEvenement', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO `evenement`(`nom_evenement`, `lieu_evenement`, `date_debut_evenement`, `date_fin_evenement`, `date_ajout_evenement`) 
            VALUES (:nom_evenement, :lieu_evenement, :date_debut_evenement, :date_fin_evenement, :date_ajout_evenement);";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("nom_evenement", $input['nom_evenement']);
    $sth->bindParam("lieu_evenement", $input['lieu_evenement']);
    $sth->bindParam("date_debut_evenement", $input['date_debut_evenement']);
    $sth->bindParam("date_fin_evenement", $input['date_fin_evenement']);
    $sth->bindParam("date_ajout_evenement", date('Y-m-d H:i:s'));
    $sth->execute();
    return $this->response->withJson($input);
});
// FIN POST

// DEBUT PUT
// Modification d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/majActu/7)
$app->put('/majActu/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE `actualite` SET `titre_actualite`=:titre_actualite,
                                   `contenu_actualite`=:contenu_actualite,
                                   `image_url_actualite`=:image_url_actualite
                               WHERE `id_actualite`=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("titre_actualite", $input['titre_actualite']);
    $sth->bindParam("contenu_actualite", $input['contenu_actualite']);
    $sth->bindParam("image_url_actualite", $input['image_url_actualite']);
    $sth->execute();
    return $this->response->withJson($input);
});

// Modification d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/majEvenement/3)
$app->put('/majEvenement/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE `evenement` SET `nom_evenement`=:nom_evenement,
                                   `lieu_evenement`=:lieu_evenement,
                                   `date_debut_evenement`=:date_debut_evenement,
                                   `date_fin_evenement`=:date_fin_evenement
                               WHERE `id_evenement`=:id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("nom_evenement", $input['nom_evenement']);
    $sth->bindParam("lieu_evenement", $input['lieu_evenement']);
    $sth->bindParam("date_debut_evenement", $input['date_debut_evenement']);
    $sth->bindParam("date_fin_evenement", $input['date_fin_evenement']);
    $sth->execute();
    return $this->response->withJson($input);
});
// FIN PUT

// DEBUT DELETE
// Suppression d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/suppActu/13)
$app->delete('/suppActu/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM `actualite` WHERE `id_actualite`=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    return $this->response->withJson($input);
});

// Suppression d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/suppEvenement/4)
$app->delete('/suppEvenement/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM `evenement` WHERE `id_evenement`=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    return $this->response->withJson($input);
});
// FIN DELETE