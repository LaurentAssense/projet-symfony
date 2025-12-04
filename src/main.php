<?php
require_once __DIR__ . '/vendor/autoload.php';

use Classes\Client;
use Classes\Fournisseur;

$client = new Client( "Dupont Louis");
$client->addFournisseur( new Fournisseur( "Etablissement René","Saint-Quentin" ) );

print $client->fiche();