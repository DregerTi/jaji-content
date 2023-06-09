import { Notyf } from 'notyf';

// Create an instance of Notyf
const notyf = new Notyf({
    duration: 5000,
    position: {
        x: 'right',
        y: 'bottom',
    },
});

let messages = document.querySelectorAll('#notyf-message');

messages.forEach(message => {
    if (message.className === ' success') {
        notyf.success(message.innerHTML);
    }

    if (message.className === 'error') {
        notyf.error(message.innerHTML);
    }

    if (message.className === ' info') {
        notyf.open({
            type: 'info',
            message: '<b>Info</b> - ' + message.innerHTML,
        });
    }

    if (message.className === 'warning') {
        notyf.open({
            type: 'warning',
            message: '<b>Warning</b> - ' + message.innerHTML
        });
    }
});