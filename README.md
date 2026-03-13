# Navodila za zagon projekta z Dockerjem

Ta projekt vključuje `Dockerfile` in `docker-compose.yml` za enostaven zagon razvojnega okolja s PHP (Apache) in MySQL bazo.

## Predpogoji
- Nameščen [Docker Desktop](https://www.docker.com/products/docker-desktop/) ali Docker Engine.

## Navodila za zagon

1.  **Zagon storitev:**
    V korenski mapi projekta (kjer je `docker-compose.yml`) odprite terminal in zaženite:
    ```bash
    docker compose up -d
    ```
    *Opomba: Zastavica `-d` (detached) pomeni, da se bodo kontejnerji zagnali v ozadju.*

2.  **Dostop do aplikacije:**
    Ko se kontejnerji zaženejo, lahko do aplikacije dostopate na naslovu:
    [http://localhost:8080](http://localhost:8080)

3.  **Podatkovna baza:**
    - Docker ob prvem zagonu samodejno uvozi shemo iz datoteke `news.sql`.
    - Do MySQL baze lahko dostopate preko vrat `3307` (host: `localhost`, uporabnik: `root`, geslo: `root`).
    - Nastavitve v `connection.php` se samodejno berejo iz okoljskih spremenljivk v `docker-compose.yml`.

4.  **Ustavitev storitev:**
    Ko želite končati z delom, v terminalu zaženite:
    ```bash
    docker compose down
    ```

## Pogoste težave
- **Napaka pri uvozu baze:** Če spremenite `news.sql` in želite ponovno uvoziti bazo, morate najprej izbrisati Docker volumen z ukazom `docker compose down -v` in nato ponovno zagnati `docker compose up -d`.
- **Mod_rewrite:** Dockerfile vključuje ukaz `a2enmod rewrite`, kar zagotavlja, da `.htaccess` pravila in "lepi" URL-ji delujejo pravilno.
