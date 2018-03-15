<?php

/**
 * Volume Pricing Table - Inline - Vertical
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

                <?php foreach ($table_data as $range): ?>

                    <tr>
                        <td class="rp_wcdpd_longer_cell">
                            <span class="quantity">
                                <?php echo $range['range_label']; ?>
                            </span>
                        </td>
                        <td class="rp_wcdpd_longer_cell">
                            <span class="amount">
                                <?php echo $range['range_price']; ?>
                            </span>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>
