<?php

/**
 * Volume Pricing Table - Inline - Horizontal
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="rp_wcdpd_product_page">
    <div class="rp_wcdpd_product_page_title"><?php echo RP_WCDPD_Settings::get('promo_volume_pricing_table_title'); ?></div>
    <div class="rp_wcdpd_pricing_table">

        <table>
            <tbody>
                <tr>
                    <?php foreach ($table_data as $range): ?>
                        <td>
                            <span class="quantity">
                                <?php echo $range['range_label']; ?>
                            </span>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($table_data as $range): ?>
                        <td>
                            <span class="amount">
                                <?php echo $range['range_price']; ?>
                            </span>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>

    </div>
</div>
