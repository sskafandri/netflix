<?php

require_once("PayPal-PHP-SDK/autoload.php");


$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'AdmIhBcuay5VOwbfnUcA3_ABlPhr9ISg5v4LtHxkWoeYZuxXuZYC-1oN1d_B3t-GhbsKHsVJypMmclVE',     // ClientID
        'EIENuZsXZR9enPEv4bVU5dEHczKrCjtSAMbRK2Hb-ZC103maCc1zzS8eACyT34LWqw8igCU6s_6-FaBx'      // ClientSecret
    )
);
?>