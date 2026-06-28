<?php

require_once 'repository.php';
require_once 'validator.php';

function sassieWallet(){

    $wallet = [
        'client' => "",
        'telephone' => '',
        'code' => '',
        'solde' => 0
    ];
//client
    $wallet['client'] = readline("Nom du client : ");

//telephone
    $wallet['telephone'] = readline("Entrez le numéro : ");

if (telephoneNumerique($telephone) == 0) {
    echo "Le téléphone doit contenir uniquement des chiffres\n";
    return;
}

if (longueurTelephone($telephone) == 0) {
    echo "Le téléphone doit contenir 9 chiffres\n";
    return;
}

if (prefixeValide($telephone) == 0) {
    echo "Préfixe invalide\n";
    return;
}

if (telephoneExiste($telephone, $wallets) == 1) {
    echo "Ce numéro existe déjà\n";
    return;
}

if (!walletExiste($telephone, $wallets)) {
    echo "Numéro introuvable\n";
    return;
}

//code

    $wallet['code'] = readline("Entrez le code secret : ");

if (!codeValide($code)) {
    echo "Code obligatoire\n";
    return;
}

if (codeExiste($code, $wallets)) {
    echo "Ce code existe déjà\n";
    return;
}
//solde
    $wallet['solde'] = (int)readline("Solde initial : ");
    

if (!montantNumerique($montant)) {
    echo "Montant invalide\n";
    return;
}

if (!montantValide($montant)) {
    echo "Le montant doit être supérieur à 0\n";
    return;
}

if (!soldeSuffisant($solde, $montant, $frais)) {
    echo "Solde insuffisant\n";
    return;
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

    $montant = (int)readline("Montant : ");

    if(!montantValide($montant)){
        echo "Montant invalide\n";
        return;
    }

    if($montant > $wallets[$index]['solde']){
        echo "Solde insuffisant\n";
        return;
    }

    $wallets[$index]['solde'] -= $montant;

    $transactions[] = [
        'type' => 'Retrait',
        'montant' => $montant,
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