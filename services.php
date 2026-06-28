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

    // Saisie du nom
    $wallet['client'] = readline("Nom du client : ");

    // Vérifier que le nom n'est pas vide
    if (nomValide($wallet['client']) == 0) {
        echo "Le nom est obligatoire\n";
        return null;
    }

    // Saisie du téléphone
    $wallet['telephone'] = readline("Entrez le numéro : ");

    // Vérifier que le téléphone n'est pas vide
    if (telephoneValide($wallet['telephone']) == 0) {
        echo "Téléphone obligatoire\n";
        return null;
    }

    // Vérifier que le téléphone contient uniquement des chiffres
    if (telephoneNumerique($wallet['telephone']) == 0) {
        echo "Le téléphone doit contenir uniquement des chiffres\n";
        return null;
    }

    // Vérifier que le téléphone contient exactement 9 chiffres
    if (longueurTelephone($wallet['telephone']) == 0) {
        echo "Le téléphone doit contenir exactement 9 chiffres\n";
        return null;
    }

    // Vérifier le préfixe
    if (prefixeValide($wallet['telephone']) == 0) {
        echo "Préfixe invalide\n";
        return null;
    }

    // Vérifier que le numéro n'existe pas déjà
    if (telephoneExiste($wallet['telephone'], $wallets) == 1) {
        echo "Ce numéro existe déjà\n";
        return null;
    }

    // Saisie du code secret
    $wallet['code'] = readline("Entrez le code secret : ");

    // Vérifier que le code n'est pas vide
    if (codeValide($wallet['code']) == 0) {
        echo "Code obligatoire\n";
        return null;
    }

    // Vérifier que le code n'existe pas déjà
    if (codeExiste($wallet['code'], $wallets) == 1) {
        echo "Ce code existe déjà\n";
        return null;
    }

    // Saisie du solde initial
    $wallet['solde'] = (int) readline("Solde initial : ");

    // Vérifier que le solde est valide
    if (soldeValide($wallet['solde']) == 0) {
        echo "Le solde doit être positif ou nul\n";
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