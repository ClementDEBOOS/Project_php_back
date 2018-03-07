<?php

use Slim\Http\Request;
use Slim\Http\Response;

// GET
// Liste des 5 derniers évenements (http://127.0.0.1/php_ecran_rest_api/public/evenements)
$app->get('/evenements', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM evenement ORDER BY date_ajout_evenement DESC LIMIT 5"); // Préparation de la requête
    $sth->execute(); // Exécution de la requête
    $evenements = $sth->fetchAll();
    return $this->response->withJson($evenements);
});

// POST
// Ajout d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/nouvelEvenement)
$app->post('/nouvelEvenement', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO `evenement`(`nom_evenement`, `lieu_evenement`, `date_debut_evenement`, `date_fin_evenement`, `date_ajout_evenement`) 
            VALUES (:nom_evenement, :lieu_evenement, :date_debut_evenement, :date_fin_evenement, :date_ajout_evenement);";
    $sth = $this->db->prepare($sql); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("nom_evenement", $input['nom_evenement']);
    $sth->bindParam("lieu_evenement", $input['lieu_evenement']);
    $sth->bindParam("date_debut_evenement", $input['date_debut_evenement']);
    $sth->bindParam("date_fin_evenement", $input['date_fin_evenement']);
    $sth->bindParam("date_ajout_evenement", date('Y-m-d H:i:s'));
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});

// PUT
// Modification d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/majEvenement/3)
$app->put('/majEvenement/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE `evenement` SET `nom_evenement`=:nom_evenement,
                                    `lieu_evenement`=:lieu_evenement,
                                    `date_debut_evenement`=:date_debut_evenement,
                                    `date_fin_evenement`=:date_fin_evenement
                                WHERE `id_evenement`=:id";
    $sth = $this->db->prepare($sql); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("nom_evenement", $input['nom_evenement']);
    $sth->bindParam("lieu_evenement", $input['lieu_evenement']);
    $sth->bindParam("date_debut_evenement", $input['date_debut_evenement']);
    $sth->bindParam("date_fin_evenement", $input['date_fin_evenement']);
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});

// DELETE 
// Suppression d'un evenement (http://127.0.0.1/php_ecran_rest_api/public/suppEvenement/4)
$app->delete('/suppEvenement/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM `evenement` WHERE `id_evenement`=:id"); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("id", $args['id']);
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});
