<?php

use XRPValidator\XRPValidator;

function validate_xrp_wallet_address($address) {
    $validator = new XRPValidator();
    return $validator->validate($address);
}
