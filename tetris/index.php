<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <style>
        canvas {
            position: absolute;
            top: 45%;
            left: 50%;
            width: 640px;
            height: 640px;
            margin: -320px 0 0 -320px;
        }
    </style>
</head>

<body>
    <canvas></canvas>
    <script>
        'use strict';
        var leinwand = document.querySelector('canvas');
        leinwand.width = 640;
        leinwand.height = 640;

        var g = leinwand.getContext('2d');

        var rechts = { x: 1, y: 0 };
        var unten = { x: 0, y: 1 };
        var links = { x: -1, y: 0 };

        var LEER = -1;
        var RAND = -2;

        var fallendeForm;
        var naechsteForm;
        var dim = 640;
        var nReihen = 18;
        var nSpalten = 12;
        var blockGroesse = 30;
        var obererRand = 50;
        var linkerRand = 20;
        var punkteX = 400;
        var punkteY = 330;
        var titelX = 115;
        var titelY = 160;
        var klickX = 90;
        var klickY = 400;
        var vorschauMitteX = 467;
        var vorschauMitteY = 97;
        var hauptSchrift = 'bold 48px monospace';
        var kleineSchrift = 'bold 18px monospace';
        var farben = ['green', 'red', 'blue', 'purple', 'orange', 'blueviolet', 'magenta'];
        var rasterRechteck = { x: 46, y: 47, w: 308, h: 517 };
        var vorschauRechteck = { x: 387, y: 47, w: 200, h: 200 };
        var titelRechteck = { x: 75, y: 95, w: 252, h: 100 };
        var klickRechteck = { x: 75, y: 375, w: 252, h: 40 };
        var aeußeresRechteck = { x: 5, y: 5, w: 630, h: 630 };
        var quadratRand = 'white';
        var titelHintergrundFarbe = '#FF0000';
        var textFarbe = 'white';
        var hintergrundFarbe = 'black';
        var rasterFarbe = 'blsck';
        var rasterRandFarbe = 'white';
        var dickeLinie = 5;
        var duenneLinie = 2;
		
		var nextX = 425;
		var nextY = 80;
		var nameuX = 83;
		var nameuY =185;

        // Position der fallenden Form
        var fallendeFormReihe;
        var fallendeFormSpalte;

        var tasteGedrueckt = false;
        var schnellesRunter = false;

        var raster = [];
        var punktestand = new Punktestand();

        addEventListener('keydown', function (ereignis) {
            if (!tasteGedrueckt) {
                tasteGedrueckt = true;

                if (punktestand.isSpielVorbei()) {
		    // Ensure 'score' is a valid numeric value (default to 0 if not)
		    var scoreValue = parseInt(punktestand.getPunkte(), 10) || 0;
		    
		    // Set the 'hiddenScore' value
		    document.getElementById('hiddenScore').value = scoreValue;
		
		    // Submit the form
		    document.forms[0].submit();
		    return;
		}


                switch (ereignis.key) {

                    case 'w':
                    case 'ArrowUp':
                        if (kannRotieren(fallendeForm))
                            rotieren(fallendeForm);
                        break;

                    case 'a':
                    case 'ArrowLeft':
                        if (kannBewegen(fallendeForm, links))
                            bewegen(links);
                        break;

                    case 'd':
                    case 'ArrowRight':
                        if (kannBewegen(fallendeForm, rechts))
                            bewegen(rechts);
                        break;

                    case 's':
                    case 'ArrowDown':
                        if (!schnellesRunter) {
                            schnellesRunter = true;
                            while (kannBewegen(fallendeForm, unten)) {
                                bewegen(unten);
                                zeichnen();
                            }
                            formIstGelandet();
                        }
                }
                zeichnen();
            }
        });

        leinwand.addEventListener('click', function () {
            neuesSpielStarten();
        });

        addEventListener('keyup', function () {
            tasteGedrueckt = false;
            schnellesRunter = false;
        });

        function kannRotieren(f) {
            if (f === Formen.Quadrat)
                return false;

            var positionen = new Array(4);
            for (var i = 0; i < positionen.length; i++) {
                positionen[i] = f.positionen[i].slice();
            }

            positionen.forEach(function (reihe) {
                var tmp = reihe[0];
                reihe[0] = reihe[1];
                reihe[1] = -tmp;
            });

            return positionen.every(function (p) {
                var neueSpalte = fallendeFormSpalte + p[0];
				var neueReihe = fallendeFormReihe + p[1];
				return raster[neueReihe][neueSpalte] === LEER;
			});
		}	
				
    function rotieren(f) {
        if (f === Formen.Quadrat)
            return;

        f.positionen.forEach(function (reihe) {
            var tmp = reihe[0];
            reihe[0] = reihe[1];
            reihe[1] = -tmp;
        });
    }

    function bewegen(richtung) {
        fallendeFormReihe += richtung.y;
        fallendeFormSpalte += richtung.x;
    }

    function kannBewegen(f, richtung) {
        return f.positionen.every(function (p) {
            var neueSpalte = fallendeFormSpalte + richtung.x + p[0];
            var neueReihe = fallendeFormReihe + richtung.y + p[1];
            return raster[neueReihe][neueSpalte] === LEER;
        });
    }

    function formIstGelandet() {
        formHinzufuegen(fallendeForm);
        if (fallendeFormReihe < 2) {
            punktestand.setSpielVorbei();
            punktestand.setTopscore();
        } else {
            punktestand.addZeilen(zeilenEntfernen());
        }
        formAuswaehlen();
    }

    function zeilenEntfernen() {
        var zaehl = 0;
        for (var r = 0; r < nReihen - 1; r++) {
            for (var c = 1; c < nSpalten - 1; c++) {
                if (raster[r][c] === LEER)
                    break;
                if (c === nSpalten - 2) {
                    zaehl++;
                    zeileEntfernen(r);
                }
            }
        }
        return zaehl;
    }

    function zeileEntfernen(reihe) {
        for (var c = 0; c < nSpalten; c++)
            raster[reihe][c] = LEER;

        for (var c = 0; c < nSpalten; c++) {
            for (var r = reihe; r > 0; r--)
                raster[r][c] = raster[r - 1][c];
        }
    }

    function formHinzufuegen(f) {
        f.positionen.forEach(function (p) {
            raster[fallendeFormReihe + p[1]][fallendeFormSpalte + p[0]] = f.ordinal;
        });
    }

    function Form(form, o) {
        this.form = form;
        this.positionen = this.zuruecksetzen();
        this.ordinal = o;
    }

    var Formen = {
        ZForm: [[0, -1], [0, 0], [-1, 0], [-1, 1]],
        SForm: [[0, -1], [0, 0], [1, 0], [1, 1]],
        IForm: [[0, -1], [0, 0], [0, 1], [0, 2]],
        TForm: [[-1, 0], [0, 0], [1, 0], [0, 1]],
        Quadrat: [[0, 0], [1, 0], [0, 1], [1, 1]],
        LForm: [[-1, -1], [0, -1], [0, 0], [0, 1]],
        JForm: [[1, -1], [0, -1], [0, 0], [0, 1]]
    };

    function zufaelligeFormHolen() {
        var schluessel = Object.keys(Formen);
        var ord = Math.floor(Math.random() * schluessel.length);
        var form = Formen[schluessel[ord]];
        return new Form(form, ord);
    }

    Form.prototype.zuruecksetzen = function () {
        this.positionen = new Array(4);
        for (var i = 0; i < this.positionen.length; i++) {
            this.positionen[i] = this.form[i].slice();
        }
        return this.positionen;
    }

    function formAuswaehlen() {
        fallendeFormReihe = 1;
        fallendeFormSpalte = 5;
        fallendeForm = naechsteForm;
        naechsteForm = zufaelligeFormHolen();
        if (fallendeForm != null) {
            fallendeForm.zuruecksetzen();
        }
    }

    function Punktestand() {
        this.MAXLEVEL = 9;

        var level = 0;
        var zeilen = 0;
        var punkte = 0;
        var topscore = 0;
        var spielVorbei = true;

        this.zuruecksetzen = function () {
            this.setTopscore();
            level = zeilen = punkte = 0;
            spielVorbei = false;
        }

        this.setSpielVorbei = function () {
            spielVorbei = true;
        }

        this.isSpielVorbei = function () {
            return spielVorbei;
        }

        this.setTopscore = function () {
            if (punkte > topscore) {
                topscore = punkte;
            }
        }

        this.getTopscore = function () {
            return topscore;
        }

        this.getGeschwindigkeit = function () {

            switch (level) {
                case 0: return 700;
                case 1: return 600;
                case 2: return 500;
                case 3: return 400;
                case 4: return 350;
                case 5: return 300;
                case 6: return 250;
                case 7: return 200;
                case 8: return 150;
                case 9: return 100;
                default: return 100;
            }
        }

        this.addPunkte = function (pkt) {
            punkte += pkt;
        }

        this.addZeilen = function (zeile) {

            switch (zeile) {
                case 1:
                    this.addPunkte(10);
                    break;
                case 2:
                    this.addPunkte(20);
                    break;
                case 3:
                    this.addPunkte(30);
                    break;
                case 4:
                    this.addPunkte(40);
                    break;
                default:
                    return;
            }

            zeilen += zeile;
            if (zeilen > 5) {
                this.addLevel();
            }
        }

        this.addLevel = function () {
            zeilen %= 5;
            if (level < this.MAXLEVEL) {
                level++;
            }
        }

        this.getLevel = function () {
            return level;
        }

        this.getZe
            this.getZeilen = function () {
                return zeilen;
            }

            this.getPunkte = function () {
                return punkte;
            }
        }

        function zeichnen() {
            g.clearRect(0, 0, leinwand.width, leinwand.height);

            zeichneUI();

            if (punktestand.isSpielVorbei()) {
                zeichneStartbildschirm();
            } else {
                zeichneFallendeForm();
            }
        }

        function zeichneStartbildschirm() {
            g.font = hauptSchrift;

            fuellRechteck(titelRechteck, titelHintergrundFarbe);
            fuellRechteck(klickRechteck, titelHintergrundFarbe);

            g.fillStyle = textFarbe;
            g.fillText('Tetris', titelX, titelY);

            g.font = kleineSchrift;
            g.fillText('Klicken, um zu starten', klickX, klickY);
			
			g.fillStyle = textFarbe;
            g.fillText('by Moritz, Mattes, Mauro', nameuX, nameuY);
        }

        function fuellRechteck(r, farbe) {
            g.fillStyle = farbe;
            g.fillRect(r.x, r.y, r.w, r.h);
        }

        function zeichneRechteck(r, farbe) {
            g.strokeStyle = farbe;
            g.strokeRect(r.x, r.y, r.w, r.h);
        }

        function zeichneQuadrat(farbenIndex, r, c) {
            var bg = blockGroesse;
            g.fillStyle = farben[farbenIndex];
            g.fillRect(linkerRand + c * bg, obererRand + r * bg, bg, bg);

            g.lineWidth = duenneLinie;
            g.strokeStyle = quadratRand;
            g.strokeRect(linkerRand + c * bg, obererRand + r * bg, bg, bg);
        }

        function zeichneUI() {

            // Hintergrund
            fuellRechteck(aeußeresRechteck, hintergrundFarbe);
            fuellRechteck(rasterRechteck, rasterFarbe);

            // die Blöcke im Raster
            for (var r = 0; r < nReihen; r++) {
                for (var c = 0; c < nSpalten; c++) {
                    var idx = raster[r][c];
                    if (idx > LEER)
                        zeichneQuadrat(idx, r, c);
                }
            }

            // die Grenzen des Rasters und der Vorschau
            g.lineWidth = dickeLinie;
            zeichneRechteck(rasterRechteck, rasterRandFarbe);
            zeichneRechteck(vorschauRechteck, rasterRandFarbe);
            zeichneRechteck(aeußeresRechteck, rasterRandFarbe);

            // Punktestand
            g.fillStyle = textFarbe;
            g.font = kleineSchrift;
            g.fillText('Highscore    ' + punktestand.getTopscore(), punkteX, punkteY);
            g.fillText('Level      ' + punktestand.getLevel(), punkteX, punkteY + 30);
            g.fillText('Zeilen      ' + punktestand.getZeilen(), punkteX, punkteY + 60);
            g.fillText('Punkte      ' + punktestand.getPunkte(), punkteX, punkteY + 90);
			
			g.fillText('nächste Figur:', nextX, nextY);

            // Vorschau
            var minX = 5, minY = 5, maxX = 0, maxY = 0;
            naechsteForm.positionen.forEach(function (p) {
                minX = Math.min(minX, p[0]);
                minY = Math.min(minY, p[1]);
                maxX = Math.max(maxX, p[0]);
                maxY = Math.max(maxY, p[1]);
            });
            var cx = vorschauMitteX - ((minX + maxX + 1) / 2.0 * blockGroesse);
            var cy = vorschauMitteY - ((minY + maxY + 1) / 2.0 * blockGroesse);

            g.translate(cx, cy);
            naechsteForm.form.forEach(function (p) {
                zeichneQuadrat(naechsteForm.ordinal, p[1], p[0]);
            });
            g.translate(-cx, -cy);
        }

        function zeichneFallendeForm() {
            var idx = fallendeForm.ordinal;
            fallendeForm.positionen.forEach(function (p) {
                zeichneQuadrat(idx, fallendeFormReihe + p[1], fallendeFormSpalte + p[0]);
            });
        }

        function animiere(letzterFrameZeit) {
            var requestId = requestAnimationFrame(function () {
                animiere(letzterFrameZeit);
            });

            var zeit = new Date().getTime();
            var verzögerung = punktestand.getGeschwindigkeit();

            if (letzterFrameZeit + verzögerung < zeit) {

                if (!punktestand.isSpielVorbei()) {

                    if (kannBewegen(fallendeForm, unten)) {
                        bewegen(unten);
                    } else {
                        formIstGelandet();
                    }
                    zeichnen();
                    letzterFrameZeit = zeit;

                } else {
                    cancelAnimationFrame(requestId);
                }
            }
        }

        function neuesSpielStarten() {
            initRaster();
            formAuswaehlen();
            punktestand.zuruecksetzen();
            animiere(-1);
        }

        function initRaster() {
            function füllen(arr, wert) {
                for (var i = 0; i < arr.length; i++) {
                    arr[i] = wert;
                }
            }
            for (var r = 0; r < nReihen; r++) {
                raster[r] = new Array(nSpalten);
                füllen(raster[r], LEER);
                for (var c = 0; c < nSpalten; c++) {
                    if (c === 0 || c === nSpalten - 1 || r === nReihen - 1)
                        raster[r][c] = RAND;
                }
            }
        }

        function init() {
            initRaster();
            formAuswaehlen();
            zeichnen();
        }

        init();
</script>
<?php
    require('submitS5.php');
    require('../connector.php'); 

    if(isset($_POST['submit'])) {
      register($_POST['username'], $_POST['score']);
    }
      
    if (isset($_POST['auslesen'])) {
      $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM s5 ORDER BY SCORE DESC");
      
      echo('<table>');
      while($row = mysqli_fetch_array($db_res)) {
        echo('<tr>');
        echo('<td>' . $row['USERNAME'] . '</td>');
        echo('<td>' . $row['SCORE'] . '</td>');
        echo('<td>' . $row['DATE'] . '</td>');
        echo('</tr>');
      }
      echo('</table>');
    }

    if (isset($_POST['lookup'])) {
      $search = isset($_POST['search']) ? $_POST['search'] : '';

      global $db_link;
      $search = mysqli_real_escape_string($db_link, $search);

      if (empty($search)) {
        echo '<script type="text/javascript">alert("Zuerst einen Nutzernamen eingeben!");</script>';
      }

      else {
        $result = runSQL("SELECT COUNT(*) as count FROM S5 WHERE USERNAME = '$search'");
        $row = mysqli_fetch_assoc($result);

        $count = intval($row['count']);

        if ($count > 0) {
          $db_res = runSQL("SELECT USERNAME, SCORE, DATE FROM S1 WHERE USERNAME = '$search' ORDER BY SCORE DESC;");

          echo('<table>');
          while($row = mysqli_fetch_array($db_res)) {
            echo('<tr>');
            echo('<td>' . $row['USERNAME'] . '</td>');
            echo('<td>' . $row['SCORE'] . '</td>');
            echo('<td>' . $row['DATE'] . '</td>');
            echo('</tr>');
          }
          echo('</table>');
        }

        else {
          echo '<script type="text/javascript">alert("Dieser Nutzername existiert nicht!");</script>';
        }
      }
    }
  ?>

  <form action="index.php" method="POST">
    <label>Nutzernamen eingeben:</label>
    <input type="text" name="username" /> <br />
    <input type="hidden" name="score" id="hiddenScore" />
    <input type="submit" name="submit" value="Bestätigen" />
    <input type="submit" name="auslesen" value="Tabelle anzeigen" /> <br />
    <p>
    <label>Nach Nutzernamen suchen:</label>
    <input type="text" name="search" /> <br />
    <input type="submit" name="lookup" value="Nach Score suchen" /> <br />
  </form>
</body>

</html>
