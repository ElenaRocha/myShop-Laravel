import { Passkeys } from '@laravel/passkeys';

document.getElementById('login-passkey')?.addEventListener('click', async () => {
    try {
        const res = await Passkeys.verify();
        if (res.redirect) window.location.href = res.redirect;
    } catch (e) {
        alert('No se pudo iniciar sesión con passkey: ' + e.message);
    }
});

document.getElementById('register-passkey')?.addEventListener('click', async () => {
    try {
        await Passkeys.register({ name: 'Mi dispositivo' });
        alert('Passkey registrada. Ya puedes entrar sin contraseña.');
    } catch (e) {
        alert('No se pudo registrar la passkey: ' + e.message);
    }
});