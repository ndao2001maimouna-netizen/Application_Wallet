<?php

$wallets = [];
$transactions = [];

function ajouterWallet(array $wallet, array &$wallets){
    $wallets[] = $wallet;
}

function rechercherWallet($telephone, array $wallets){

    foreach($wallets as $key => $wallet){

        if($wallet['telephone'] == $telephone){
            return $key;
        }
    }

    return -1;
}

function transaction(array $transactions){

    if(empty($transactions)){
        echo "Aucune transaction effectuée\n";
        return;
    }

    foreach($transactions as $index => $value){

        echo "Transaction ".($index+1)."\n";
        echo "Type : ".$value['type']."\n";
        echo "Téléphone : ".$value['telephone']."\n";
        echo "Montant : ".$value['montant']."\n";
        echo "--------------------------\n";
    }
}
?>