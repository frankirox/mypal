<?php

use common\db\TranslatedMessagesMigration;

class m160711_004044_miranda_auth_spanish_translations extends TranslatedMessagesMigration
{

    public function getLanguage()
    {
        return 'es-ES';
    }

    public function getCategory()
    {
        return 'miranda/auth';
    }

    public function getTranslations()
    {
        return [
            'Account Recovery' => 'Recuperar cuenta',
            'Are you sure you want to delete your profile picture?' => '¿Está usted seguro que desea borrar su imagen de perfil?',
            'Are you sure you want to unlink this authorization?' => '¿Está usted seguro que desea desvincular esta autorización?',
            'Authentication error occurred.' => 'Ha ocurrido un error de autenticación',
            'Authorization' => 'Autorización',
            'Authorized Services' => 'Servicios autorizados',
            'Captcha' => 'Captcha',
            "Can't access to your account?" => '¿No puedes acceder a tu cuenta?',
            'Change profile picture' => 'Cambiar imagen de perfil',
            'Check your E-mail for further instructions' => 'Verifique su E-mail para más instrucciones',
            'Check your e-mail {email} for instructions to activate account' => 'Verifique su E-mail {email} para activar su cuenta',
            'Click to connect with service' => 'Haga click para vincular con el servicio',
            'Click to unlink service' => 'Haga click para desvincular el servicio',
            'Confirm E-mail' => 'Confirmar E-mail',
            'Confirm' => 'Confirmar',
            'Could not send confirmation email' => 'El E-mail de confirmación no pudo ser enviado',
            'Current password' => 'Contraseña actual',
            'Do you remember your password? Sign In' => '¿Ya recuerda su contraseña? Inicie sesión',
            'E-mail confirmation for' => 'Confirmación de E-mail para',
            'E-mail confirmed' => 'E-mail confirmado',
            'The E-mail address {email} has been confirmed' => 'La dirección e-mail {email} fué confirmada',
            'E-mail is invalid' => 'E-mail no válido',
            'E-mail with activation link has been sent to <b>{email}</b>. This link will expire in {minutes} min.' => 'Un enlace ha sido enviado a <b>{email}</b>, dicho enlace expirará en {minutes} minutos',
            'E-mail' => 'E-mail',
            'Forgot password?' => '¿Ólvido su contraseña?',
            'Follow this link to confirm your E-mail and activate account:' => 'Sigue el siguiente enlace para confirmar tu dirección de E-mail y para activar tu cuenta',
            'Hello, you have been registered on' => 'Hola, te has registrado en',
            'Incorrect username or password' => 'Usuario o contraseña inválida',
            'Login has been taken' => 'Se ha iniciado sesión',
            'Login' => 'Iniciar sesión',
            'Logout' => 'Cerrar sesión',
            'Non Authorized Services' => 'Servicios no autorizados',
            'Password has been updated' => 'La contraseña fue actualizada',
            'Password recovery' => 'Recuperación de contraseña',
            'Password reset for' => 'Reestablecer contraseña de',
            'Password' => 'Contraseña',
            'Registration - confirm your e-mail' => 'Registro - confirme su E-mail',
            'Registration' => 'Registro',
            'Remember me' => 'Recordarme',
            'Remove profile picture' => 'Eliminar imagen de perfil',
            'Repeat password' => 'Repetir contraseña',
            'Reset Password' => 'Reestablecer contraseña',
            'Reset' => 'Reestablecer',
            'Save Profile' => 'Guardar perfil',
            'Save profile picture' => 'Guardar imagen de perfil',
            'Set Password' => 'Establecer contraseña',
            'Set Username' => 'Establecer nombre de usuario',
            'Signup' => 'Regístrese',
            'This E-mail already exists' => 'Este E-mail ya se encuentra registrado',
            'Token not found. It may be expired' => 'Token no encontrado, podría haber expirado, pruebe reestablecer su contraseña nuevamente.',
            'Too many attempts' => 'Demasiados intentos',
            'Unable to send message for email provided' => 'No es posible enviar mensajes al E-mail especificado',
            'Update Access Credentials' => 'Actualizar credenciales de acceso',
            'Update Credentials' => 'Actualizar credenciales',
            'Update Password' => 'Actualizar contraseña',
            'Update Profile' => 'Actualizar perfil',
            'Username' => 'Usuario',
            'User Profile' => 'Perfil del usuario',
            "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it." => 'User with the same email as in {client} account already exists but isn\'t linked to it. Login using email first to link it.',
            'Wrong password' => 'Contraseña erronea',
            'You could not login from this IP' => 'No puede inciar sesión desde su dirección IP actual',
            'Your access credentials has been updated' => 'Sus credenciales de acceso han sido actualizados con éxito'
        ];
    }
}
