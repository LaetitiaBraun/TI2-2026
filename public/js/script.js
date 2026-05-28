/* Regex */
const regexFirstname = /^[a-zA-ZÀ-ÿ\-']{2,}$/;
const regexLastname = /^[a-zA-ZÀ-ÿ\-']{2,}$/;
const regexPhone = /^(0|\+32|0032)[1-9][0-9]{7,8}$/;
const regexPostcode = /^[1-9][0-9]{3}$/;
const regexUsermail = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
const regexMessage = /^[\s\S]{10,}$/;

function validerChamp(valeur, regex, idErreur, messageErreur, idAside) {
    if (regex.test(valeur.trim())) {
        $('#' + idErreur).text('').hide();
        if (idAside) $('#' + idAside).removeClass('aside-error').addClass('aside-ok');
        return true;
    } else {
        $('#' + idErreur).text(messageErreur).show();
        if (idAside) $('#' + idAside).removeClass('aside-ok').addClass('aside-error');
        return false;
    }
}

$('#firstname').on('input', function () {
    validerChamp($(this).val(), regexFirstname, 'inputFirstname', '⚠️ Firstname invalide (Au moins 2 caractères)', 'asideFirstname');
});

$('#lastname').on('input', function () {
    validerChamp($(this).val(), regexLastname, 'inputLastname', '⚠️ Lastname invalide (Au moins 2 caractères)', 'asideLastname');
});

$('#usermail').on('input', function () {
    validerChamp($(this).val(), regexUsermail, 'inputUsermail', '⚠️ Usermail invalide (Ex : Jeandupont@gmail.com)', 'asideUsermail');
});

$('#phone').on('input', function () {
    const cleaned = $(this).val().replace(/[\s\-\.]/g, '');
    validerChamp(cleaned, regexPhone, 'inputPhone', '⚠️ Phone invalide (Ex : 0470123456)', 'asidePhone');
});

$('#postcode').on('input', function () {
    const val = $(this).val().trim();
    const num = parseInt(val, 10);
    const ok = regexPostcode.test(val) && num >= 1000 && num <= 9999;
    if (ok) {
        $('#inputPostcode').text('').hide();
        $('#asidePostcode').removeClass('aside-error').addClass('aside-ok');
    } else {
        $('#inputPostcode').text('⚠️ Postcode invalide (Au moins 4 chiffres, entre 1000 et 9999)').show();
        $('#asidePostcode').removeClass('aside-ok').addClass('aside-error');
    }
});

$('#message').on('input', function () {
    validerChamp($(this).val(), regexMessage, 'inputMessage', '⚠️ Message invalide (Au moins 10 caractères)', 'asideMessage');
});

/* Dark mode */
if (localStorage.getItem('darkMode') === 'true') {
    $('body').addClass('dark');
    $('#btnDark').text('☀️ Light Mode');
}

$('#btnDark').click(function () {
    $('body').toggleClass('dark');
    if ($('body').hasClass('dark')) {
        $(this).text('☀️ Light Mode');
        localStorage.setItem('darkMode', 'true');
    } else {
        $(this).text('🌙 Dark Mode');
        localStorage.setItem('darkMode', 'false');
    }
});

/* Case à cocher */
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('guestbook-form').addEventListener('submit', function(e) {
        if (!document.getElementById('case').checked) {
            e.preventDefault();

            document.getElementById('errorCheckbox').style.display = 'block';
        } else {
            document.getElementById('errorCheckbox').style.display = 'none';
        }
    });
});