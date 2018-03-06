<?php

use Slim\Http\Request;
use Slim\Http\Response;

// GET
// Liste des 5 dernières actus (http://127.0.0.1/php_ecran_rest_api/public/actus)
$app->get('/actus', function (Request $request, Response $response, array $args) {
    $sth = $this->db->prepare("SELECT * FROM actualite ORDER BY date_ajout_actualite DESC LIMIT 5");
    $sth->execute();
    $actus = $sth->fetchAll();
    return $this->response->withJson($actus);
});

// POST
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

// PUT
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

// DELETE
// Suppression d'une actualite (http://127.0.0.1/php_ecran_rest_api/public/suppActu/13)
$app->delete('/suppActu/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM `actualite` WHERE `id_actualite`=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    return $this->response->withJson($input);
});