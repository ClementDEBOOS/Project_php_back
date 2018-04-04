<?php

use Slim\Http\Request;
use Slim\Http\Response;

// GET
// Liste des plannings (http://127.0.0.1/php_ecran_rest_api/public/plannings)
$app->get('/plannings', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM planning"); // Préparation de la requête
    $sth->execute(); // Exécution de la requête
    $plannings = $sth->fetchAll();
    return $this->response->withJson($plannings);
});

// POST
// Ajout d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/nouveauPlanning)
$app->post('/nouveauPlanning', function ($request, $response) {
    $input = $request->getParsedBody();
    $sql = "INSERT INTO `planning`(`formation`, `lundi_salle`, `mardi_salle`, `mercredi_salle`, `jeudi_salle`, `vendredi_salle`)
            VALUES (:formation, :lundi_salle, :mardi_salle, :mercredi_salle, :jeudi_salle, :vendredi_salle);";
    $sth = $this->db->prepare($sql); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("formation", $input['formation']);
    $sth->bindParam("lundi_salle", $input['lundi_salle']);
    $sth->bindParam("mardi_salle", $input['mardi_salle']);
    $sth->bindParam("mercredi_salle", $input['mercredi_salle']);
    $sth->bindParam("jeudi_salle", $input['jeudi_salle']);
    $sth->bindParam("vendredi_salle", $input['vendredi_salle']);
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});

// PUT
// Modification d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/majPlanning/7)
$app->put('/majPlanning/[{id}]', function ($request, $response, $args) {
    $input = $request->getParsedBody();
    $sql = "UPDATE `planning` SET `formation`=:formation,
                                    `lundi_salle`=:lundi_salle,
                                    `mardi_salle`=:mardi_salle,
                                    `mercredi_salle`=:mercredi_salle,
                                    `jeudi_salle`=:jeudi_salle,
                                    `vendredi_salle`=:vendredi_salle
                                WHERE `id_planning`=:id";
    $sth = $this->db->prepare($sql); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("id", $args['id']);
    $sth->bindParam("formation", $input['formation']);
    $sth->bindParam("lundi_salle", $input['lundi_salle']);
    $sth->bindParam("mardi_salle", $input['mardi_salle']);
    $sth->bindParam("mercredi_salle", $input['mercredi_salle']);
    $sth->bindParam("jeudi_salle", $input['jeudi_salle']);
    $sth->bindParam("vendredi_salle", $input['vendredi_salle']);
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});

// DELETE
// Suppression d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/suppPlanning/13)
$app->delete('/suppPlanning/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM `planning` WHERE `id_planning`=:id"); // Préparation de la requête
    // Bindings de la requête
    $sth->bindParam("id", $args['id']);
    $sth->execute(); // Exécution de la requête
    return $this->response->withJson($input);
});
