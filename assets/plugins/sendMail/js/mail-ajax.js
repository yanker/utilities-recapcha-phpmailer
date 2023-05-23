(function ($) {

  "use strict";
  //


  $.exists = function (selector) {
    return $(selector).length > 0;
  };

  $(document).on("ready", function () {
    formSendValidation();
  });

  /*--------------------------------------------------------------
      Ajax Contact Form 
    --------------------------------------------------------------*/
  
  // Contact Form
  function formSendValidation() {
    if ($.exists(config.form.submit_form)) {      
      $().hide();

      $(config.form.submit_form).on('click', function (event) {
        
        event.preventDefault();

        grecaptcha.ready(function () {
          grecaptcha.execute(config.form.SITE_KEY_RECAPCHA, {
            action: 'validar_formulario'
          }).then(function (token) {
            $(config.form.name_form).prepend('<input type="hidden" name="token" id="token" value="' + token + '">');
            $(config.form.name_form).prepend('<input type="hidden" name="action" id="action" value="validar_formulario">');

            // Get Dates & Tratamiento
            // ###########################################
            var name = $.trim($('#name').val());
            var subject = $.trim($('#subject').val());
            var phone = $.trim($('#phone').val());
            var email = $.trim($('#email').val());
            var msg = $.trim($('#msg').val());
            var politic = $('#politic').is(':checked');
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            // Google Recapcha
            var token = $('#token').val();
            var action = $('#action').val();

            // ###########################################

            // Regex Email
            if (!regex.test(email)) {
              $(config.messages.alert_div).html(config.messages.alert_email);
              return false;
            }

            // Validación            
            if (politic != true) {
              $(config.messages.alert_div).html(config.messages.alert_politic);
            }
            else {              
              // Not Empty
              if (name != '' && email != '' && msg != '' && subject != '' && phone != '') {

                // Change Text Button Send
                var button = $(config.form.submit_form);
                button.html(config.messages.button_sending);
                setTimeout(function () {
                  button.html(config.messages.button_send);
                }, 2500);                

                var values = "name=" + name +
                  "&subject=" + subject +
                  "&phone=" + phone +
                  "&email=" + email +
                  "&politic=" + politic +
                  "&msg=" + msg +
                  "&token=" + token +
                  "&action=" + action
                $.ajax({
                  type: "POST",
                  url: config.form.url_form_send,
                  dataType: 'html', //Tipo de Respuesta
                  data: values,
                  success: function (data) {

                    // Clean inputs
                    $('#name').val('');
                    $('#subject').val('');
                    $('#phone').val('');
                    $('#email').val('');
                    $('#msg').val('');

                    // Msg
                    $(config.messages.alert_div).html(data);                    
                  },
                  error: function (e) {
                    // Msg Error
                    $(config.messages.alert_div).html(e);
                    //console.log('error' + e);
                  }

                });
              } else {
                $(config.messages.alert_div).html(config.messages.alert_required);
              }
            }
            return false;
          });
        });
      });
    }
  }
})(jQuery); // End of use strict