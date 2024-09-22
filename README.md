# Astrokell

Rakendus arvutab algus ja lõpp aja vahele jäävat aega.

Kellaajad sisestatakse 15-minutilise intervalliga (10:00, 10:15, 10:30, 10:45 on korrektsed, 10:11 ei
ole korrektne). Väljund näitab mitu tundi kellaaegade vahemikust langeb ööajale ja mitu päevasele
ajale.

Päevane aeg: 06:00 - 22:00
Ööaeg on: 22:00 - 06:00

Näide:
Sisend:
Algus: 14:00, lõpp: 02:30
Väljund:
öö: 4,5 tundi
päev: 8 tundi

Testid on loodud PHPUnit-iga. Testide käivitamiseks jooksutada projekti juur kaustas 

`./vendor/bin/phpunit`