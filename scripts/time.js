function HeureCheck()
{
krucial = new Date;
heure = krucial.getHours();
min = krucial.getMinutes();
sec = krucial.getSeconds();
jour = krucial.getDate();
mois = krucial.getMonth()+1;
annee = krucial.getFullYear();
if (sec < 10) { sec0 = "0"; }
else { sec0 = ""; }
if (min < 10) { min0 = "0"; }
else { min0 = ""; }
if (heure < 10) { heure0 = "0"; }
else { heure0 = ""; }
if (mois < 10) { mois0 = "0"; }
else { mois0 = ""; }
if (jour < 10) { jour0 = "0"; }
else { jour0 = ""; }
if (annee < 10) { annee0 = "0"; }
else { annee0 = ""; }
DinaDate = "" +  annee0 + annee + "-" + mois0 + mois + "-" + jour0 + jour;
total = DinaDate
DinaHeure = heure0 + heure + ":" + min0 + min + ":" + sec0 + sec;
total = DinaHeure
total =  DinaDate + "  &nbsp; " + DinaHeure + "";

document.getElementById("dateheure").innerHTML = total;

tempo = setTimeout("HeureCheck()", 1000)
}
window.onload = HeureCheck;

//Script r�alis� par Max485 membre de XNova
//Message de Tom : La flemme d'en faire un mieux ^^
