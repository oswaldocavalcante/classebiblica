<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://oswaldocavalcante.com
 * @since      1.0.0
 *
 * @package    Classebiblica
 * @subpackage Classebiblica/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<form method="post" action="options.php">
    <?php
        settings_fields( 'classebiblica_settings' );
        do_settings_sections( 'classebiblica_settings' );
    ?>

    <h1>Classe Bíblica - Configurações</h1>
    <div class="mb-3">
        <label class="form-label">RSS Feed URL</label>
        <input type="text" name="feedURL" value="<?php echo get_option( 'feedURL' ) ?>" class="form-control" id="feedURL">
        <div id="feedHelp" class="form-text">Type the RSS Feed URL.</div>
    </div>
    <div class="mb-3">
        <label class="form-label">TAG to Analyze</label>
        <input type="text" name="xmlTAG" value="<?php echo get_option( 'xmlTAG' ) ?>" class="form-control" id="xmlTAG">
    </div>
    <button type="submit" class="btn btn-primary">Carregar</button>
</form>