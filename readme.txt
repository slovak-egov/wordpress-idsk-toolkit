=== ID-SK Toolkit ===
Contributors: slovenskoit
Tags: idsk, id-sk, toolkit, idsk-toolkit, idsk toolkit, id-sk toolkit
Requires at least: 5.4
Tested up to: 5.8
Stable tag: 1.5.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Súbor nástrojov funkcionalít k ID-SK téme.

== Popis ==

Súbor nástrojov funkcionalít k ID-SK téme. Tento súbor odporúčame používať spoločne s WordPress témou [ID-SK Template](https://wordpress.org/themes/idsk-template/).

Pre viac informácií o jednotlivých komponentoch a spôsoboch ich použitia navštívte [ID-SK Frontend – Jednotný dizajn manuál elektronických služieb](https://idsk.gov.sk/).

== Copyright ==
ID-SK Toolkit WordPress plugin, Copyright 2021 Slovensko IT, a.s..
ID-SK is distributed under the terms of the GNU GPLv2 or later and under the terms of [Open Government Licence v3.0](https://www.nationalarchives.gov.uk/doc/open-government-licence/version/3/)

== Frequently Asked Questions ==

= When FAQ will be availiable? =

Soon.

== Changelog ==

= 1.6.0 =
* Pridanie funkcionality cookies
* Zmena nastavení štýlu zobrazenia bočného panela v komponente Úvodný blok
* Aktualizácia komponentu Záložky na novšiu verziu
* Odstránenie nastavení rozloženia komponentu Súvisiaci obsah
* Odstránenie vlastných článkov - Aktuality inštitúcií

= 1.5.0 =
* Aktualizácia komponentov k ID-SK 2.6.2
* Doplnenie vzorov stránok
* Doplnenie nového komponentu
 * Oddeľovač
* Odstránenie Grafového komponentu
* Fix v komponente Tlačidlo
* Fix pre WordPress 5.8

= 1.4.3 =
* Doplnená podpora jazykových mutácií

= 1.4.2 =
* Fix v Grafovom komponente.

= 1.4.1 =
* Doplnenie nového komponentu
 * Stepper banner
* Fixy v existujúcich komponentoch

= 1.4.0 =
* Doplnenie metaboxov pre stránky
* Rozšírené vyhľadávanie pre ID-SK tému
* Globálne úpravy v existujúcich komponentoch ID-SK
* Komponent Karta - doplnené dynamické pridávanie tagov

= 1.3.1 =
* Globálne úpravy v existujúcich komponentoch ID-SK
* Doplnenie odsadení zľava zprava pre grid column komponent
* Fixy v existujúcich komponentoch

= 1.3.0 =
* Doplnenie nových komponentov
 * Akordeón
 * Oznámenie
 * Tlačidlo
 * Nadpis
 * Skrytý text
 * Zoznamy
 * Vsadený text
 * Záložky
* Fixy v existujúcich komponentoch.

= 1.2.0 =
* Pridanie nových komponentov.
 * Grafový komponent
 * Mapový komponent
* Fixy v existujúcich komponentoch.

= 1.1.0 =
* Pridanie nových ID-SK komponentov
* Optimalizácia kódu, oprava chýb

= 1.0.0 =
* Vydanie pluginu

== Upgrade Notice ==

= 1.6.0 =
* Doplnenie funkcionality cookies.
* Zmena nastavení štýlu zobrazenia bočného panela v komponente Úvodný blok.
* Aktualizácia komponentu Záložky na novšiu verziu.
* Odstránenie nastavení rozloženia komponentu Súvisiaci obsah.
* Odstránenie vlastných článkov - Aktuality inštitúcií.

= 1.5.0 =
* Aktualizácia komponentov k ID-SK 2.6.2
* Doplnenie vzorov stránok
* Doplnenie nového komponentu
 * Oddeľovač
* Odstránenie Grafového komponentu
* Fix v komponente Tlačidlo
* Fix pre WordPress 5.8

= 1.4.3 =
Doplnená podpora jazykových mutácií.

= 1.4.2 =
Fix v Grafovom komponente.

= 1.4.1 =
Doplnenie nového komponentu Stepper banner, fixy v existujúcich komponentoch.

= 1.4.0 =
Globálne úpravy v existujúcich komponentoch, doplnená nová funkcionalita k ID-SK téme.

= 1.3.1 =
Globálne úpravy a fixy v existujúcich komponentoch.

= 1.3.0 =
Pridanie nových komponentov, fixy v existujúcich komponentoch.

= 1.2.0 =
Pridanie nových komponentov, fixy v existujúcich komponentoch.

= 1.1.0 =
Pridanie nových komponentov, optimalizácia kódu.

= 1.0.0 =
Vydanie pluginu pre použitie spoločne s ID-SK témou.

== Rozširujúce funkcionality ==

1. Gutenberg ID-SK komponenty
2. Gutenberg ID-SK vzory
3. Podpora nahrávania SVG obrázkov
4. Cookies

== Shortcodes & Custom functions ==

= Cookies =

Základné cookies sú automaticky povolené pre vyhľadávacie stroje.

Zobrazenie všetkých aktívnych cookies v tabuľkovom zozname:
~~~
[idsk-cookie-list]
~~~

**Cookies môžete blokovať v textovom editore nasledovne:**

Doplní na stránku obsah v bloku ak sú nastavené základné cookies:
~~~
[idsk-cookie]Your content[/idsk-cookie]
~~~

Doplní na stránku obsah v bloku ak sú prijaté cookies so špecifickým ID:
~~~
[idsk-cookie id="example1"]Your content[/idsk-cookie]
~~~

**Taktiež môžete blokovať cookies v PHP nasledovne:**

Doplní na stránku obsah ak sú nastavené základné cookies:
~~~
if ( function_exists('idsktk_cookies_allowed') && idsktk_cookies_allowed() ) {
    // Your code
}
~~~

Doplní na stránku obsah ak sú prijaté cookies so špecifickým ID:
~~~
if ( function_exists('idsktk_cookies_allowed') && idsktk_cookies_allowed('example1') ) {
    // Your code
}
~~~

**Stránka s nastaveniami cookies a pridanie vlastných cookies**

Pridanie začiarkavacieho políčka s povolením cookies:
~~~
[idsk-cookie-allow id="example1" title="Cookie name/Cookie category name"]
Cookie details
[/idsk-cookie-allow]
~~~
* Ak nieje uvedené ID, zobrazí sa začiarkavacie políčko pre základné cookies

Pridanie tlačidla pre uloženie nastavení cookies. Tlačidlo je potrebné umiestniť na rovnakú stránku ako začiarkavacie políčka s povolením cookies.
~~~
[idsk-cookie-submit title="Save settings"]
~~~