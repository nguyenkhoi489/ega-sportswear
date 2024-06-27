<?php

/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see              https://docs.woocommerce.com/document/template-structure/
 * @package          WooCommerce\Templates
 * @version          7.0.1
 * @flatsome-version 3.16.2
 *
 * @flatsome-parallel-template {
 * form-login-lightbox-left-panel.php
 * form-login-lightbox-right-panel.php
 * }
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

do_action('woocommerce_before_customer_login_form'); ?>

<div class="account-container lightbox-inner">

	<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

		<div class="col2-set row row-divided row-large" id="customer_login">

			<div class="col-1 large-6 col pb-0">

			<?php endif; ?>

			<div class="account-login-inner">
				<div class="wrap-title-login">
					<h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
					<p>Nhập email và mật khẩu của bạn:</p>
				</div>

				<!-- <h3 class="uppercase"><?php esc_html_e('Login', 'woocommerce'); ?></h3> -->

				<form class="woocommerce-form woocommerce-form-login login" method="post">

					<?php do_action('woocommerce_login_form_start'); ?>

					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide custom_iu_login_home">
						<!-- <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label> -->
						<input placeholder="Email" type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																																						?>
					</p>
					<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide custom_iu_login_home">
						<!-- <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label> -->
						<input placeholder="Mật khẩu" class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
					</p>

					<p class="privacy-policy">
						This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.
					</p>

					<?php do_action('woocommerce_login_form'); ?>

					<p class="form-row">
						<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
							<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e('Remember me', 'woocommerce'); ?></span>
						</label>
						<?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit<?php if (fl_woocommerce_version_check('7.0.1')) {
																																																		echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '');
																																																	} ?>" name="login" value="<?php esc_attr_e('Đăng nhập', 'woocommerce'); ?>"><?php esc_html_e('ĐĂNG NHẬP', 'woocommerce'); ?></button>
					</p>
					<br>
					<p class="woocommerce-LostPassword lost_password custom-text-login">
						Khách hàng mới?
						<a href="/auth-register/">Tạo tài khoản</a>
					</p>
					<p class="woocommerce-LostPassword lost_password custom-text-login">
						Quên mật khẩu?
						<!-- <?php echo esc_url(wp_lostpassword_url()); ?> -->
						<a href="/reset-password"><?php esc_html_e('Khôi phục mật khẩu', 'woocommerce'); ?></a>
					</p>

					<?php do_action('woocommerce_login_form_end'); ?>

				</form>
			</div>

			<?php if ('yes' === get_option('woocommerce_enable_myaccount_registration')) : ?>

			</div>

			<div class="col-2 large-6 col pb-0">

				<div class="account-register-inner">

					<h3 class="uppercase"><?php esc_html_e('Register', 'woocommerce'); ?></h3>

					<form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action('woocommerce_register_form_tag'); ?>>

						<?php do_action('woocommerce_register_form_start'); ?>

						<?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
								<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																																?>
							</p>

						<?php endif; ?>

						<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
							<label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
							<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : ''; ?>" /><?php // @codingStandardsIgnoreLine 
																																																																																																																								?>
						</p>

						<?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>

							<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
								<label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?>&nbsp;<span class="required">*</span></label>
								<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
							</p>

						<?php else : ?>

							<p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>

						<?php endif; ?>

						<?php do_action('woocommerce_register_form'); ?>

						<p class="woocommerce-form-row form-row">
							<?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
							<button type="submit" class="woocommerce-Button woocommerce-button button<?php if (fl_woocommerce_version_check('7.0.1')) {
																																													echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '');
																																												} ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
						</p>

						<?php do_action('woocommerce_register_form_end'); ?>

					</form>

				</div>

			</div>

		</div>
	<?php endif; ?>

</div>

<?php do_action('woocommerce_after_customer_login_form'); ?>