const config = {
  form: {
    name_form: '#contact-form',
    submit_form: '#contact-form #submit',
    url_form_send: 'assets/php/mail.php',
    SITE_KEY_RECAPCHA: 'SITE_KEY',
  },
  messages: {
    alert_div: '#st-alert',
    button_sending: 'Sending ...',
    button_send: 'Send',
    alert_email:'<div class="alert alert-warning"><strong>Atención!</strong> Por favor introduce un email válido<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
    alert_required:'<div class="alert alert-danger"><strong>Atención!</strong> Todos los campos son obligatorios.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
    alert_politic:'<div class="alert alert-warning"><strong>Atención!</strong> Debe aceptar la política de privacidad.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>',
  },
};