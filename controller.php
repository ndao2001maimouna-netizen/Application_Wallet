<?php

require_once 'services.php';

function afficherMenu(){
    echo "\n==========MENU DISTRIBUTEUR=========\n";
    echo "1. Créer Wallet\n";
    echo "2. Faire Dépot\n";
    echo "3. Faire Retrait\n";
    echo "4. Lister les Transactions\n";
    echo "0. Quitter\n";
    echo "====================================\n";
}

function application(){

    global $wallets, $transactions;

    afficherMenu();

    do{
        $choix = readline("Votre choix : ");

        switch($choix){

            case 1:
                echo "\nCréation Wallet\n";
                $nouveauWallet = sassieWallet();
                creationWallet($nouveauWallet, $wallets);
            break;

            case 2:
                echo "\nFaites vos Dépots\n";
                depot($wallets, $transactions);
            break;

            case 3:
                echo "\nFaites vos Retraits\n";
                retrait($wallets, $transactions);
            break;

            case 4:
                echo "\nListe des Transactions\n";
                transaction($transactions);
            break;

            case 0:
                echo "\nQuitter\n";
            break;

            default:
                echo "\nChoix invalide\n";
            break;
        }

    }while($choix != 0);
}
?>