<div class="box-register woocommerce-form woocommerce-form-register register">
	<h2>Tạo tài khoản</h2>
	<?= wp_nonce_field('create_new_account') ?>
	<p class="form-row form-row-last custom_ui_login">
		<!-- <label for="reg_billing_last_name">Họ<span class="required">*</span></label> -->
		<input placeholder="Họ" type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="">
	</p>
	<p class="form-row form-row-first custom_ui_login">
		<!-- <label for="reg_billing_first_name">Tên<span class="required">*</span></label> -->
		<input placeholder="Tên" type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="">
	</p>
	<p class="form-row form-row-wide custom_ui_login">
		<input type="radio" id="user_gender" name="user_gender" value="male"> <label for="Male">Male</label>
		<input type="radio" id="user_gender" name="user_gender" value="female"> <label for="Female">Female</label>
	</p>

	<!-- <p class="form-row form-row-wide">
		<label for="reg_billing_phone">Số điện thoại&nbsp;<span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="">
	</p> -->
	<p class="form-row form-row-wide custom_ui_login">
		<input placeholder="mm/dd/yyyy" type="text" class="input-text" name="billing_birth_date" id="reg_billing_birth_date" value="">
	</p>
	<div class="clear"></div>


	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide custom_ui_login">
		<!-- <label for="reg_email">Địa chỉ email&nbsp;<span class="required">*</span></label> -->
		<input name="billing_email" placeholder="Email" type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="">
	</p>


	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide custom_ui_login">
		<!-- <label for="reg_password">Mật khẩu&nbsp;<span class="required">*</span></label> -->
		<input placeholder="Mật khẩu" type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password">
	</p>
	<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
		This site is protected by reCAPTCHA and the Google Privacy Policy and Terms of Service apply.
	</p>
	<p class="woocommerce-form-row form-row custom_ui_login custom-buton-login">
		<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register">
			Đăng ký
		</button>
	</p>

	<p class="form-row form-row-wide custom-login-back-home">
		<i class="fas fa-long-arrow-alt-left"></i>
		<a href="/"> Quay lại trang chủ</a>
	</p>
</div>