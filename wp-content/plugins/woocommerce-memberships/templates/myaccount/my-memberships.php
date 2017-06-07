<?php
/**
 * WooCommerce Memberships
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@skyverge.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Memberships to newer
 * versions in the future. If you wish to customize WooCommerce Memberships for your
 * needs please refer to http://docs.woothemes.com/document/woocommerce-memberships/ for more information.
 *
 * @package   WC-Memberships/Templates
 * @author    SkyVerge
 * @copyright Copyright (c) 2014-2015, SkyVerge, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/**
 * Renders a section on My Account page to list customer memberships
 *
 * @param \WC_Memberships_User_Membership[] $customer_memberships Array of user membership objects
 * @param int $user_id The current user ID
 *
 * @version 1.4.0
 * @since 1.0.0
 */
?>

<h2><?php echo esc_html( apply_filters( 'wc_memberships_my_memberships_title', __( 'My Memberships', WC_Memberships::TEXT_DOMAIN ) ) ); ?></h2>

<?php
/**
 * Fired before My Memberships table in My Account page
 *
 * @since 1.4.0
 */
do_action( 'wc_memberships_before_my_memberships' );
?>

<table class="shop_table shop_table_responsive my_account_orders my_account_memberships">

	<thead>
		<tr>
			<?php
				/**
				 * Filter My Memberships table columns in My Account page
				 *
				 * @since 1.4.0
				 * @param array $my_memberships_columns Associative array of column ids and names
				 */
				$my_memberships_columns = apply_filters( 'wc_memberships_my_memberships_column_names', array(
					'membership-plan'       => __( 'Plan', WC_Memberships::TEXT_DOMAIN ),
					'membership-start-date' => __( 'Signed up', WC_Memberships::TEXT_DOMAIN ),
					'membership-end-date'   => __( 'Expires', WC_Memberships::TEXT_DOMAIN ),
					'membership-status'     => __( 'Status', WC_Memberships::TEXT_DOMAIN ),
					'membership-actions'    => '&nbsp;',
				), $user_id );
			?>
			<?php foreach ( $my_memberships_columns as $column_id => $column_name ) : ?>
				<?php
					if ( 'membership-actions' === $column_id ) {
						/**
						 * Fires after the membership columns, before the actions column in my memberships table header
						 *
						 * @since 1.0.0
						 * @deprecated Use 'wc_memberships_my_memberships_column_names' filter hook
						 * @param WC_Memberships_User_Membership $user_membership
						 */
						do_action( 'wc_memberships_my_memberships_column_headers' );
					}
				?>
				<th class="<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
			<?php endforeach; ?>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $customer_memberships as $customer_membership ) : ?>

			<?php
				if ( ! $customer_membership->get_plan() ) :
					continue;
				endif;
			?>

			<tr class="membership">
				<?php foreach ( $my_memberships_columns as $column_id => $column_name ) : ?>

					<?php if ( has_action( 'wc_memberships_my_memberships_column_' . $column_id ) ) : ?>

						<?php do_action( 'wc_memberships_my_memberships_column_' . $column_id, $customer_membership ); ?>

					<?php elseif ( 'membership-plan' == $column_id ) : ?>

						<td class="membership-plan" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php $members_area = $customer_membership->get_plan()->get_members_area_sections(); ?>
							<?php if ( wc_memberships_is_user_active_member( get_current_user_id(), $customer_membership->get_plan() ) && ! empty ( $members_area ) && is_array( $members_area ) ) : ?>
								<a href="<?php echo esc_url( wc_memberships_get_members_area_url( $customer_membership->get_plan_id(), $members_area[0] ) ); ?>"><?php echo esc_html( $customer_membership->get_plan()->get_name() ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $customer_membership->get_plan()->get_name() ); ?>
							<?php endif;  ?>
						</td>

					<?php elseif ( 'membership-start-date' == $column_id ) : ?>

						<td class="membership-start-date" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( $start_date = $customer_membership->get_local_start_date( 'timestamp' ) ) : ?>
								<time datetime="<?php echo date( 'Y-m-d', $start_date ); ?>" title="<?php echo esc_attr( date_i18n( wc_date_format(), $start_date ) ); ?>"><?php echo date_i18n( wc_date_format(), $start_date ); ?></time>
							<?php else : ?>
								<?php esc_html_e( 'N/A', WC_Memberships::TEXT_DOMAIN ); ?>
							<?php endif; ?>
						</td>

					<?php elseif ( 'membership-end-date' == $column_id ) : ?>

						<td class="membership-end-date" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php if ( $end_date = $customer_membership->get_local_end_date( 'timestamp' ) ) : ?>
								<time datetime="<?php echo date( 'Y-m-d', $end_date ); ?>" title="<?php echo esc_attr( date_i18n( wc_date_format(), $end_date ) ); ?>"><?php echo date_i18n( wc_date_format(), $end_date ); ?></time>
							<?php else : ?>
								<?php esc_html_e( 'N/A', WC_Memberships::TEXT_DOMAIN ); ?>
							<?php endif; ?>
						</td>

					<?php elseif ( 'membership-status' == $column_id ) : ?>

						<td class="membership-status" style="text-align:left; white-space:nowrap;" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php echo esc_html( wc_memberships_get_user_membership_status_name( $customer_membership->get_status() ) ); ?>
						</td>

					<?php elseif ( 'membership-actions' == $column_id ) :

						/**
						 * Fires after the membership columns, before the actions column in my memberships table
						 *
						 * @since 1.0.0
						 * @deprecated Use 'wc_memberships_my_memberships_column_names' filter hook and matching id actions
						 * @param WC_Memberships_User_Membership $user_membership
						 */
						do_action( 'wc_memberships_my_memberships_columns', $customer_membership );

						?>
						<td class="membership-actions order-actions" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php

							wc_enqueue_js("
								jQuery( '.membership-actions' ).on( 'click', '.button.cancel', function( e ) {
									return confirm( '" . esc_html__( 'Are you sure that you want to cancel your membership?', WC_Memberships::TEXT_DOMAIN ) . "' );
								} );
							");

							global $post;
							echo wc_memberships_get_members_area_action_links( 'my-memberships', $customer_membership, $post );
							?>
						</td>

					<?php endif; ?>

				<?php endforeach; ?>
			</tr>

		<?php endforeach; ?>
	</tbody>
</table>

<?php

/**
 * Fired after My Memberships table in My Account page
 *
 * @since 1.4.0
 */
do_action( 'wc_memberships_after_my_memberships' );
