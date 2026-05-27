/* Regex */

const regexFirstname = /^*{2,}$/;
const regexLastname = /^*{2,}$/;
const regexPhone = /^[0-9]{0,13}{+32}$/;
const regexPostcode = /^{4,}{1000,9999}$/;
const regexUsermail = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
const regexMessage = /^*{10,}$/;

function validerChamp(valeur, regex, idErreur, messageErreur) {
  if (regex.test(valeur.trim())) {
    $('#' + idErreur).text('').hide();
      return true;
  } else {
    $('#' + idErreur).text(messageErreur).show();
      return false;
  }
}

$('#inputFirstname').on('input', function () {
    validerChamp($(this).val(), regexFirstname, 'errFirstname', '⚠️ Firstname invalide (Au moins 2 caractères)');
});

$('#inputLastname').on('input', function () {
    validerChamp($(this).val(), regexLastname, 'errLastname', '⚠️ Lastname invalide (Au moins 2 caractères)');
});

$('#inputPhone').on('input', function () {
    validerChamp($(this).val(), regexPhone, 'errPhone', '⚠️ Phone invalide (Ex : 0470123456)');
});

$('#inputPostcode').on('input', function () {
    validerChamp($(this).val(), regexPostcode, 'errPostcode', '⚠️ Postcode invalide (Au moins 4 chiffres, entre 1000 et 9999)');
});

$('#inputUsermail').on('input', function () {
    validerChamp($(this).val(), regexUsermail, 'errUsermail', '⚠️ Usermail invalide (Ex : Jeandupont@gmail.com)');
});

$('#inputMessage').on('input', function () {
    validerChamp($(this).val(), regexMessage, 'errMessage', '⚠️ Message invalide (Au moins 10 caractères)');
});

/* Dark mode */

$('#btnDark').click(function () {
    $('body').toggleClass('dark');
        if ($('body').hasClass('dark')) {
    $(this).text('☀️ Light Mode');
    } else {
        $(this).text('🌙 Dark Mode');
    }
});