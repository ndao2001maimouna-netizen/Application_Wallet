<?php

require_once 'repository.php';
require_once 'validator.php';

function sassieWallet(array $wallets)
{

    $wallet = [
        'client' => "",
        'telephone' => '',
        'code' => '',
        'solde' => 0
    ];

    $wallet['client'] = readline("Nom du client : ");

    if (nomValide($wallet['client']) == 0) {
        echo "Le nom est obligatoire\n";
        return null;
    }

    $wallet['telephone'] = readline("Entrez le numéro : ");

    if (telephoneValide($wallet['telephone']) == 0) {
        echo "Telephone obligatoire\n";
        return null;
    }

    if (telephoneNumerique($wallet['telephone']) == 0) {
        echo "telephone doit contenir uniquement des chiffres\n";
        return null;
    }

    if (longueurTelephone($wallet['telephone']) == 0) {
        echo " telephone doit contenir exactement 9 chiffres\n";
        return null;
    }

    if (prefixeValide($wallet['telephone']) == 0) {
        echo "Préfixe invalide\n";
        return null;
    }

    if (telephoneExiste($wallet['telephone'], $wallets) == 1) {
        echo "numéro existe deja\n";
        return null;
    }

    $wallet['code'] = readline("Entrez le code secret : ");

    if (codeValide($wallet['code']) == 0) {
        echo "Code obligatoire\n";
        return null;
    }

    if (codeExiste($wallet['code'], $wallets) == 1) {
        echo "Ce code existe deja\n";
        return null;
    }

    $wallet['solde'] = (int) readline("Solde initial : ");

    if (soldeValide($wallet['solde']) == 0) {
        echo " solde doit être positif ou nul\n";
        return null;
    }

    return $wallet;
}


function creationWallet(array $creerWallet, array &$wallets){
    ajouterWallet($creerWallet, $wallets);
}

function depot(array &$wallets, array &$transactions){

    $telephone = readline("Entrez le numéro : ");

    $index = rechercherWallet($telephone, $wallets);

    if($index == -1){
        echo "Numéro introuvable\n";
        return;
    }

    $montant = (int)readline("Montant : ");

    if(!montantValide($montant)){
        echo "Montant invalide\n";
        return;
    }

    $wallets[$index]['solde'] += $montant;

    $transactions[] = [
        'type' => 'Depot',
        'montant' => $montant,
        'telephone' => $telephone
    ];

    echo "Dépôt effectué avec succès\n";
}



function retrait(array &$wallets, array &$transactions){

    $telephone = readline("Entrez le numéro : ");

    $index = rechercherWallet($telephone, $wallets);

    if($index == -1){
        echo "Numéro introuvable\n";
        return;
    }

    $montant = (int) readline("Montant : ");

    if(montantValide($montant) == 0){
        echo "Montant invalide\n";
        return;
    }

    $frais = calculerFrais($montant);

    if (($montant + $frais) > $wallets[$index]['solde']) {
        echo "Solde insuffisant\n";
        return;
    }

    $wallets[$index]['solde'] -= ($montant + $frais);

    echo "Frais appliqués : " . $frais . "\n";
    echo "Nouveau solde : " . $wallets[$index]['solde'] . "\n";

    $transactions[] = [
        'type' => 'Retrait',
        'montant' => $montant,
         'frais' => $frais,
        'telephone' => $telephone
    ];

    echo "Retrait effectué avec succès\n";
}


function calculerFrais($montant){

    if($montant <= 10000){
        return 200;
    }

    if($montant <= 100000){
        return 500;
    }

    $frais = $montant * 0.01;

    if($frais > 5000){
        $frais = 5000;
    }

    return $frais;
}
?>