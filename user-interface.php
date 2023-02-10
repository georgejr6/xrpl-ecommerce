<?php

function display_xrp_wallet_form() {
    $xrp_wallet_address = get_user_meta(get_current_user_id(), 'xrp_wallet_address', true);
    ?>
    <form method="post" action="">
        <?php wp_nonce_field( 'xrp_wallet_form_nonce', 'xrp_wallet_form_nonce_field' ); ?>
        <label for="xrp_wallet_address">XRP Wallet Address:</label>
        <input type="text" id="xrp_wallet_address" name="xrp_wallet_address" value="<?php echo $xrp_wallet_address; ?>">
        <input type="submit" value="Save">
    </form>
    <?php
}

function process_xrp_wallet_form() {
    if ( !current_user_can( 'edit_user', get_current_user_id() ) ) {
        return;
    }
    if (isset($_POST['xrp_wallet_address']) && wp_verify_nonce($_POST['xrp_wallet_form_nonce_field'], 'xrp_wallet_form_nonce')) {
        update_user_meta(get_current_user_id(), 'xrp_wallet_address', $_POST['xrp_wallet_address']);
    }
}

// add the necessary hooks here

?>
