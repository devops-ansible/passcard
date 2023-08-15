# PassCard

Eine regelkonforme Passwort-Bildung in Kombination mit einer sicheren Aufbewahrung und gleichzeitiger Merkbarkeit von Passworten ist nicht immer einfach. Insbesondere, wenn (Firmen-)Vorgaben ein regelmäßiges Ändern von Passworten vorschreiben.

Der Verein &bdquo;Deutschland sicher im Netz e.V.&ldquo; (DsiN) hat für diese Problematik eine <a href="https://www.sicher-im-netz.de/dsin-muster-passwortkarte">Muster-Passwort-Karte</a> erstellt, welche Unternehmen dazu animieren soll, selbst eigene individualisierte Passwort-Karten anzubieten.

<div style="text-align: center;">
	<img src="https://www.sicher-im-netz.de/sites/default/files/media/dsin_passwortkarte_2_web_0.png" />
</div>

Dieses Web-Tool ermöglicht es, basierend auf dieser Idee verschiedene Passwort-Karten (bzw. zunächst nur Web-Views der Passwort-Karten) zu erstellen.

## System-Voraussetzungen

* Eine PHP-Version &geq; `PHP 7.1` wird benötigt.
* Da mit `.htaccess`-Dateien der Zugriff auf Subverzeichnisse eingeschränkt wird, ist ein `Apache`-Webserver zu empfehlen.
* Das Projekt setzt Dritt-Bibliotheken ein, welche durch den Paket-Manager `composer` installiert werden.

Zum Einsatz kommen folgende Bibliotheken:

* `Twig` als PHP-Template-Engine, <a href="https://twig.symfony.com/doc/2.x/">vgl. Dokumentation</a>
* `jQuery` als JavaScript-Bibliothek, <a href="https://api.jquery.com/">vgl. Dokumentation</a>
* `Bootstrap v4.0` als Styling-Framework zum vereinfachten Aufbau eines übersichtlichen Layouts, <a href="https://getbootstrap.com/docs/4.0/getting-started/introduction/">vgl. Dokumentation</a>

Generell hilfreich für Dokumentationen: <a href="https://devdocs.io">devdocs.io</a>

## Installieren der Bibliotheken

Diese Anleitung ist auf Unix-Systeme ausgelegt. Für Windows-Systeme muss Adäquates recherchiert werden.

* Lade `composer` herunter – vgl. <a href="https://getcomposer.org/download/">getcomposer.org/download</a>.
* Installiere `composer` global – vgl. <a href="https://getcomposer.org/doc/00-intro.md#globally">getcomposer.org/doc/00-intro.md#globally</a>
* Lade mit Hilfe folgenden Befehls die Dritt-Bibliotheken herunter. Dadurch ist das Web-Tool lauffähig.

```sh
composer install
```

## Konfiguration des Tools

Die Standard-Konfiguration des Tools erfolgt durch die Datei `.env` im Basis-Ordner. Beim ersten Ausführen des Tools wird diese als Kopie von `.env.example`, welche die vordefinierten Werte enthält, angelegt und kann anschließend angepasst werden.

Folgende Umgebungsvariablen gibt es, um das Tool zu konfigurieren:

| Variable     | Default | Beschreibung |
| ------------ | ------- | ------------ |
| CHARLIST     | abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789@#*?$&/+-_=! | dies ist eine Auflistung aller verfügbaren Zeichen, welche auf der Passwort-Karte verwendet werden können (<em>keine Leerzeichen und Zeilenumbrüche in die Konfigurationsdatei übernehmen!</em>) |
| MATRIXWIDTH  | 26      | die Anzahl der Spalten der Passwort-Karte |
| MATRIXHEIGHT | 12      | die Anzahl der Zeilen der Passwort-Karte  |
| MATRIXSTROKE | 3       | zur besseren Lesbarkeit werden jeweils nach `x` Zeilen / Spalten dickere Zellen-Trennstriche eingezeichnet |
| HORIESC      | `true`  | wenn `true`: horizontal keine sich wiederholenden Zeichen |
| VERTESC      | `true`  | wenn `true`: vertikal keine sich wiederholenden Zeichen |
| DIAGESC      | `true`  | wenn `true`: diagonal keine sich wiederholenden Zeichen |
| COLCHAR      | A       | Nummerierung der Spalten – Standard entsprechend Excel `A`, `AA`, etc. |
| ROWCHAR      | 1       | Nummerierung der Zeilen – Standard entsprechend Excel arabischen Zahlen |
| PERSISTENCE  | `false` | Um eine persistente Passwort-Karte zu erstellen kann an dieser Stelle ein INTEGER-Faktor angegeben werden. Standardmäßig ist diese Variable nicht gesetzt / `false` |
| MINPERSSEED  | 1000    | kleinste akzeptierte Persistenz-Zahl, wenn diese als GET-Parameter an das Tool übergeben wird |
| DEFAULTINFO  | `EMPTY` | Diese Variable bietet die Möglichkeit, eine Standard-Informations-Box mit Text befüllen. Standardmäßig ist dieser Text leer und damit gibt es keine Info-Box. |

## Funktion des Tools

In der Standard-Konfiguration wird bei jedem Neu-Laden der Webseite des Tools eine neue, zufällig zusammen gesetzte Passwort-Karte erstellt.

Um für verschiedene Konfigurationen Standard-Karten hinterlegen zu können, welche jedes mal identisch wiederhergestellt werden, gibt es die Möglichkeit spezielle Konfigurationsdateien nach dem Muster `.env.*` anzulegen. Um eine solche Spezial-Karte anschließend anzuzeigen, muss die Webseite des Tools mit dem GET-Parameter `?conf=*` aufgerufen werden.

Wenn die Umgebungsvariable `PERSISTENCE` in der Konfigurationsdatei auf einen Integer-Wert gesetzt ist, wird stets die selbe Passwort-Karte erstellt. Den selben Effekt kann man mit Hilfe des GET-Parameters `?persistent=1234` erzeugt werden. Die übergebene Zahl muss mindestens `MINPERSSEED` erreichen, anderenfalls wird der Persistenz-Effekt ignoriert und eine zufällige Passwort-Karte generiert.

### Fiducia GAD

Die Fiducia GAD, welche Kunde der it-e ist, empfiehlt es sich z.B. auf Grund zweier sich gegenseitig einschränkender Passwortrichtlinien ein Passwort mit genau 8 Zeichen Länge bestehend aus Kleinbuchstaben und Ziffern zu erstellen. Für eine exemplarische persistente Passwort-Karte für diese Anforderungen kann eine Konfiguration `.env.fiducia` wie folgt aussehen:

```
CHARLIST="abcdefghijklmnopqrstuvwxyz0123456789"

MATRIXWIDTH=24
MATRIXHEIGHT=12
MATRIXSTROKE=4

DIAGESC=true
HORIESC=true
VERTESC=true

COLCHAR="A"
ROWCHAR="1"

PERSISTENCE=1234

DEFAULTINFO="Für die Fiducia GAD empfiehlt es sich, das monatliche Passwort aus 8 Zeichen mit ausschließlich Kleinbuchstaben und Ziffern zusammen zu stellen. Auf diese Anforderung ist diese Passwort-Karte angepasst."
```

oder minimalisiert unter Verwendung der weiteren Standard-Einstellungen:

```
CHARLIST="abcdefghijklmnopqrstuvwxyz0123456789"

MATRIXWIDTH=24
MATRIXSTROKE=4

PERSISTENCE=1234

DEFAULTINFO="Für die Fiducia GAD empfiehlt es sich, das monatliche Passwort aus 8 Zeichen mit ausschließlich Kleinbuchstaben und Ziffern zusammen zu stellen. Auf diese Anforderung ist diese Passwort-Karte angepasst."
```
