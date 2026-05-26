const regexFirstname = ;
const regexLastname = ;
const regexPhone = ;
const regexPostcode = ;
const regexUsermail = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
const regexMessage = ;

function validerChamp(valeur, regex, idErreur, messageErreur) {
  if (regex.test(valeur.trim())) {
    $('#' + idErreur).text('').hide();
      return true;
  } else {
    $('#' + idErreur).text(messageErreur).show();
      return false;
  }
}