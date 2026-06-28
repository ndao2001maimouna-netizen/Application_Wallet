<?php

function nomValide($nom)
{
    if ($nom != "") {
        return 1;
    }

    return 0;
}

function telephoneValide($telephone)
{
    if ($telephone != "") {
        return 1;
    }

    return 0;
}

function telephoneNumerique($telephone)
{
    for ($i = 0; $i < strlen($telephone); $i++) {

        if ($telephone[$i] < '0' || $telephone[$i] > '9') {
            return 0;
        }
    }

    return 1;
}

function longueurTelephone($telephone)
{
    if (strlen($telephone) == 9) {
        return 1;
    }

    return 0;
}

function prefixeValide($telephone)
{
    $prefixe = $telephone[0] . $telephone[1];

    if (
        $prefixe == "77" ||
        $prefixe == "78" ||
        $prefixe == "76" ||
        $prefixe == "75" ||
        $prefixe == "70"
    ) {
        return 1;
    }

    return 0;
}

function telephoneExiste($telephone, array $wallets)
{
    foreach ($wallets as $wallet) {

        if ($wallet['telephone'] == $telephone) {
            return 1;
        }
    }

    return 0;
}

function codeExiste($code, array $wallets)
{
    foreach ($wallets as $wallet) {

        if ($wallet['code'] == $code) {
            return 1;
        }
    }

    return 0;
}

function codeValide($code)
{
    if ($code != "") {
        return 1;
    }

    return 0;
}

function montantNumerique($montant)
{
    for ($i = 0; $i < strlen($montant); $i++) {

        if ($montant[$i] < '0' || $montant[$i] > '9') {
            return 0;
        }
    }

    return 1;
}

function montantValide($montant)
{
    if ($montant > 0) {
        return 1;
    }

    return 0;
}

function soldeValide($solde)
{
    if ($solde >= 0) {
        return 1;
    }

    return 0;
}

function walletExiste($telephone, array $wallets)
{
    foreach ($wallets as $wallet) {

        if ($wallet['telephone'] == $telephone) {
            return 1;
        }
    }

    return 0;
}

function soldeSuffisant($solde, $montant, $frais)
{
    if ($solde >= ($montant + $frais)) {
        return 1;
    }

    return 0;
}

?>