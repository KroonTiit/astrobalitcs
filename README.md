# astrobalitcs

Kirjuta PHP-s või JavaScriptis järgmine lahendus:
Sisendiks on algus- ja lõppkellaaeg (2 parameetrit), 24-tunni süsteemis, formaadiga HH:MM,
string.

Kellaajad sisestatakse 15-minutilise intervalliga (10:00, 10:15, 10:30, 10:45 on korrektsed, 10:11 ei
ole korrektne). Sisendandmeid on vaja valideerida ning tagastada kasutajale vastav veateade.
Lahendus peab tagastama info, mitu tundi kellaaegade vahemikust langeb ööajale ja mitu päevasele
ajale.

Päevane aeg: 06:00 - 22:00
Ööaeg on: 22:00 - 06:00

Lahendus peaks sisaldama ka kellaaegade funktsiooni automaattestimist.
Boonusena (ei ole kohustuslik) võiks lahendusel ka kasutajasõbralik ning tänapäevane UI
sisendandmete sisestamiseks ning vastuse kuvamiseks.

Näide:
Sisend:
Algus: 14:00, lõpp: 02:30
Väljund:
öö: 4,5 tundi
päev: 8 tundi