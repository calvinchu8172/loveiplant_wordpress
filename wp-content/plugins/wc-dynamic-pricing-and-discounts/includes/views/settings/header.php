<?php

/**
 * View for Settings page header (tabs)
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<h2 class="rp_wcdpd_tabs_container nav-tab-wrapper">
    <?php foreach (RP_WCDPD_Settings::get_structure() as $tab_key => $tab): ?>
        <a class="nav-tab <?php echo ($tab_key == $current_tab ? 'nav-tab-active' : ''); ?>" href="admin.php?page=rp_wcdpd_settings&tab=<?php echo $tab_key; ?>"><?php echo $tab['title']; ?></a>
    <?php endforeach; ?>
</h2>
