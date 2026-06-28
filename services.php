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

    $wallet['client'] = readline("Nom du client : ");
    $wallet['telephone'] = readline("Entrez le numéro : ");
    $wallet['code'] = readline("Entrez le code secret : ");
    $wallet['solde'] = (int)readline("Solde initial : ");

    return $wallet;
}

function creationWallet(array $wallet, array &$wallets){

    if(!nomValide($wallet['client'])){
        echo "Nom obligatoire\n";
        return;
    }

    if(telephoneExiste($wallet['telephone'], $wallets)){
        echo "Ce numéro existe déjà\n";
        return;
    }

    if(codeExiste($wallet['code'], $wallets)){
        echo "Ce code existe déjà\n";
        return;
    }

    if(!soldeValide($wallet['solde'])){
        echo "Solde invalide\n";
        return;
    }

    ajouterWallet($wallet, $wallets);

    echo "Wallet créé avec succès\n";
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

    $montant = (int)readline("Montant à retirer : ");

    if(!montantValide($montant)){
        echo "Montant invalide\n";
        return;
    }

    $frais = calculerFrais($montant);

    $montantTotal = $montant + $frais;

    if($wallets[$index]['solde'] < $montantTotal){
        echo "Solde insuffisant\n";
        return;
    }

    $wallets[$index]['solde'] -= $montantTotal;

    $transactions[] = [
        'type' => 'Retrait',
        'telephone' => $telephone,
        'montant' => $montant,
        'frais' => $frais
    ];

    echo "Retrait effectué avec succès\n";
    echo "Frais : ".$frais."\n";
    echo "Nouveau solde : ".$wallets[$index]['solde']."\n";
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