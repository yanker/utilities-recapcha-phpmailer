# PhpMailer + Ajax + Recapcha v3

Formulario genérico con ajax, php mailer y recapcha google

## Description

Este mini proyecto realiza el envío de emails desde una web a diversas cuentas. Cuenta con ficheros de configuración para PHPMAILER y para AJAX

## Getting Started

### Dependencies

PHPMailer

```
composer require phpmailer/phpmailer
```

### Installing

- Descargar el repositorio
- Definir un sitio en google recapcha para obtener el SITE_KEY y el SECRET_KEY, necesarios para configurar la aplicación [Google Recaptcha](https://www.google.com/recaptcha/admin)
- En el formulario que está en el index.html deberemos enlazar al CND de jquery y bootstrap (si lo tenemos en local deberemos enlazar a nuestros archivos locales). Deberá estar antes `</html>`

```
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js" integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

```

- Posteriormente haremos lo mismo con el script de google recapcha donde deberemos indicar en la llamada nuestro SITE_KEY

```
    <script src="https://www.google.com/recaptcha/api.js?render=SITE_KEY"></script>
```

- Por último integramos nuestros archivos para el envio del formulario ajax y su validación

```
    <script src="assets/plugins/sendMail/js/mail-config.js"></script>
    <script src="assets/plugins/sendMail/js/mail-ajax.js"></script>
```

NOTA: el formulario se compone de los campos:

- Nombre completo
- Email
- Asunto
- Teléfono Móvil
- Mensaje
- Politica Privacidad

Si queremos agregar o quitar alguno, deberemos editar los ficheros assets/js/mail-ajax.js y assets/php/mail.php

### Configuration

- Deberemos modificar el archivo mail-config.js para adaptarlo a nuestras necesidades y configuraciones

```
const config = {
  form: {
    name_form: '#contact-form',
    submit_form: '#contact-form #submit',
    url_form_send: 'assets/php/mail.php',
    SITE_KEY_RECAPCHA: 'key_recapcha',
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
```

- Haremos lo mismo con con el archivo php/config-mail.php para adaptarlo a nuestras necesidades NOTA: para hacer test, podemos configurar la variable MAIL_TEST = true para recibir los correos a un email de test y para mostrar la respuesta de phpMailer por pantalla

## Version History

- 1.0
  - Initial Commit (23-05-2023)

## References

- [bootstrap](https://getbootstrap.com/docs/4.6/getting-started/introduction/)
- [phpMailer](https://github.com/PHPMailer/PHPMailer)
