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

//code

    $wallet['code'] = readline("Entrez le code secret : ");


//solde
    $wallet['solde'] = (int)readline("Solde initial : ");
    

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