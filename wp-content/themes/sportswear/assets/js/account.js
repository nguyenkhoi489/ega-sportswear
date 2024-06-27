jQuery(document).ready(function ($) {
  url_check_active_tab();

  $(".woocommerce-form-register__submit").click(function () {
    console.log('ok');
    let billing_first_name = $("#reg_billing_first_name").val();
    let billing_last_name = $("#reg_billing_last_name").val();
    // let billing_phone = $("#reg_billing_phone").val();
    let reg_billing_birth_date = $("#reg_billing_birth_date").val();
    let email = $("#reg_email").val();
    let user_gender = $("#user_gender").val();
    let password = $("#reg_password").val();
    let _nonce = $('[name="_wpnonce"]').val();



    console.log(
      "billing_first_name :" + billing_first_name,
      "billing_last_name :" + billing_last_name,
      // "billing_phone :" + billing_phone,
      "reg_billing_birth_date :" + reg_billing_birth_date,
      "email :" + email,
      "password :" + password,
      "_nonce :" + _nonce,
      "user_gender", user_gender
    );






    let errorCheck = [];
    let allInput = $(".box-register input.input-text");
    allInput.each((Key, Element) => {
      if (!$(Element).val()) {
        errorCheck.push(Element);
      } else {
        if ($(Element).hasClass("error")) {
          $(Element).removeClass("error");
        }
      }
    });
    if (errorCheck.length) {
      errorCheck.forEach((item) => {
        if (!$(item).hasClass("error")) {
          $(item).addClass("error");
        }
      });
      return;
    }
    // if (!validatePhoneNumber(billing_phone)) {
    //   Swal.fire({
    //     icon: "error",
    //     title: "Oops...",
    //     text: "Số điện thoại không hợp lệ!",
    //   });
    //   return;
    // }
    if (!ValidateEmail(email)) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email không hợp lệ!",
      });
      return;
    }

    $.ajax({
      url: flatsomeVars.ajaxurl,
      data: {
        action: 'register_account',
        billing_first_name: billing_first_name,
        billing_last_name: billing_last_name,
        // billing_phone: billing_phone,
        billing_email: email,
        password: password,
        _nonce: _nonce,
        user_gender: user_gender,
        reg_billing_birth_date: reg_billing_birth_date,
      },
      type: "post",
      beforeSend: function () {
        jQuery("html").append(
          `<div class="loader_append"><div class="loader"></div></div>`
        );
      },
      success: function (response) {
        console.log(response);
        jQuery("html").find('.loader_append').remove();
        console.log(JSON.parse(response));

        let resJson = JSON.parse(response);
        if (resJson.error == false) {
          Swal.fire({
            icon: "success",
            title: "Success",
            text: resJson.message,
            confirmButtonText: "Xác nhận"
          }).then((results) => {
            if (results.isConfirmed) {
              window.location.href = '/tai-khoan/';
              return;
            }
          });

        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: resJson.message
          });
        }
      },
      error: function (response) {
        console.log(JSON.parse(response));
      }
    })
  });
  $(".btn-submit__edit-account").click(function () {
    let user_id = $('input[type="hidden"][name="user_id"]').val();
    let _nonce = $('input[type="hidden"][name="_nonce_field"]').val();
    let billing_first_name = $("#billing_first_name").val();
    let billing_last_name = $("#billing_last_name").val();
    let billing_phone = $("#billing_phone").val();
    let billing_email = $("#billing_email").val();
    let billing_company = $("#billing_company").val();
    let billing_address_1 = $("#billing_address_1").val();
    let password = $("#password").val();
    let re_password = $("#repassword").val();

    if (!billing_first_name) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Họ và tên không được để trống!",
      });
      return;
    }
    if (!billing_phone) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Số điện thoại không được để trống!",
      });
      return;
    }
    if (!billing_email) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Email không được để trống!",
      });
      return;
    }

    if (!billing_address_1) {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Địa chỉ không được để trống!",
      });
      return;
    }

    if (password) {
      if (!re_password) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Vui lòng nhập lại mật khẩu mới!",
        });
        return;
      }
      if (password != re_password) {
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Nhập lại mật khẩu mới không chính xác!",
        });
        return;
      }
    }
    Swal.fire({
      title: "Chú ý?",
      text: "Bạn đang yêu cầu thay đổi thông tin cá nhân?",
      icon: "question",
      confirmButtonText: "Xác nhận"
    }).then((results) => {
      if (results.isConfirmed) {
        $.ajax({
          url: flatsomeVars.ajaxurl,
          data: {
            action: 'update_account_ajax',
            user_id: user_id,
            billing_first_name: billing_first_name,
            billing_last_name: billing_last_name,
            billing_phone: billing_phone,
            billing_email: billing_email,
            billing_address_1: billing_address_1,
            billing_company: billing_company,
            password: password,
            _nonce: _nonce
          },
          type: "post",
          beforeSend: function () {
            jQuery("html").append(
              `<div class="loader_append"><div class="loader"></div></div>`
            );
          },
          success: function (response) {
            jQuery("html").find('.loader_append').remove();

            let resJson = JSON.parse(response);
            if (resJson.error == false) {
              Swal.fire({
                icon: "success",
                title: "Success",
                text: resJson.message,
                confirmButtonText: "Xác nhận"
              }).then((results) => {
                if (results.isConfirmed) {
                  location.reload();
                  return;
                }
              });

            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: resJson.message
              });
            }
          }
        })
      }
    });
  })
});

const url_check_active_tab = () => {
  const url = new URL(window.location.href);
  const pathName = url.pathname;
  if (pathName == "/tai-khoan/") {
    jQuery("li.tab_url.login").addClass("active");
    jQuery("li.tab_url.register").removeClass("active");
  } else {
    jQuery("li.tab_url.login").removeClass("active");
    jQuery("li.tab_url.register").addClass("active");
  }
};

function validatePhoneNumber(phoneNumber) {
  var regex =
    /^(\+?84|0)((91|92|94|88|83|84|85|81|82|86|96|97|98|32|33|34|35|36|37|38|39|89|90|93|70|79|77|76|78|87|55|077|055|089)\d{7})$/;

  return regex.test(phoneNumber);
}
function ValidateEmail(mail) {
  const regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  return regex.test(mail);
}
