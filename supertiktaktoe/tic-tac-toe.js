const SPIELFELD_KLASSE = "spielfeld";
const SPIELANZEIGE_KLASSE = "spielanzeige";
const FELD_KLASSE = "feld";
const SPIELER1_KLASSE = "spieler1";
const SPIELER2_KLASSE ="spieler2";

const spielfeld = document.querySelector("." + SPIELFELD_KLASSE);
const spielanzeige = document.querySelector("." + SPIELANZEIGE_KLASSE);

const felder = document.querySelectorAll("." + FELD_KLASSE);

let aktuelleKlasse;

spielStarten(); 

function klickVerarbeiten(ereignis){
    const feld = ereignis.target
    if (spielsteinSetzen(feld) === true) {
        zugBeenden();
    }
}

function spielsteinSetzen(feld) {
    if(
        feld.classList.contains(SPIELER1_KLASSE) ||
        feld.classList.contains(SPIELER2_KLASSE)
    ) {
        return false;
    }
    feld.classList.add(aktuelleKlasse);
    feld.disabled =true;
    return true;
}

function spielStarten() {
    for (const feld of felder){
        feld.addEventListener("click", klickVerarbeiten);
    }
    zugBeenden();
}


function zugBeenden() {
    if (aktuelleKlasse === SPIELER1_KLASSE){
        aktuelleKlasse = SPIELER2_KLASSE;
    } else if (aktuelleKlasse === SPIELER2_KLASSE) {
        aktuelleKlasse = SPIELER1_KLASSE;
    } else {
        aktuelleKlasse = Math.random() < 0.5 ? SPIELER1_KLASSE : SPIELER2_KLASSE;
    }
    spielanzeigeAktualisieren();
}

function spielanzeigeAktualisieren(){
    spielanzeige.classList.remove(SPIELER1_KLASSE, SPIELER2_KLASSE);

    if (aktuelleKlasse === SPIELER1_KLASSE){
    spielanzeige.innerText = "Spieler 1 ist am Zug";
    } else {
    spielanzeige.innerText = "Spieler 2 ist am Zug";
    }
    spielanzeige.classList.add(aktuelleKlasse);
}