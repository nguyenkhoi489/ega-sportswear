<h2 class="title-reset-pass">Tạo tài khoản</h2>
<div class="custom_reset_layout">
<form method="post" class="woocommerce-ResetPassword lost_reset_password">

<p class="form-row form-row-last custom_ui_login">
	<h3>Phục hồi mật khẩu</h3>
</p>
<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first custom_ui_login">
	<input placeholder="Email" class="woocommerce-Input woocommerce-Input--text input-text custom_ui_login" type="text" name="user_login" id="user_login" autocomplete="username">
</p>

<div class="clear"></div>


<p class="woocommerce-form-row form-row custom_ui_login custom-buton-reset">
	<input type="hidden" name="wc_reset_password" value="true">
	<button type="submit" class="woocommerce-Button button" value="Reset password">GỬI</button>
	<a href="/">Hủy</a>
</p>

<input type="hidden" id="woocommerce-lost-password-nonce" name="woocommerce-lost-password-nonce" value="93068182a5"><input type="hidden" name="_wp_http_referer" value="/my-account/lost-password/">
</form>
</div>