## Wstęp

Projekt aplikacji internetowej, którego celem jest stworzenie systemu do zarządzania przychodnią dentystyczną. Aplikacja wspiera zarówno pracowników, jak i pacjentów, oferując szereg funkcjonalności dostosowanych do różnych ról użytkowników.

Główne funkcje aplikacji obejmują:

- Rejestrację i logowanie użytkowników
- Panele dedykowane dla Administratora, Dentysty oraz Pacjenta
- Rezerwację i zarządzanie wizytami
- Dwuskładnikową autoryzację (TOTP)
- Dynamiczne obrazki
- Zarządzanie dentystami, usługami oraz danymi pacjentów
- Obsługę ocen
- Obsługę rabatów

## Baza danych

Wykonane są migracje i seedery

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

<details>
<summary><b>Tabele w bazie</b></summary>

Tabela users:
| Kolumna         | Typ      | Opis                                       |
| --------------- | -------- | ------------------------------------------ |
| id              | int      | ID użytkownika (PK)                        |
| username        | string   | Nazwa użytkownika                          |
| email           | string   | Adres e-mail                               |
| phone           | string   | Numer telefonu                             |
| password        | string   | Hasło                                      |
| type            | string   | Typ użytkownika (admin, dentysta, pacjent) |
| remember\_token | string   | Token zapamiętujący sesję                  |
| created\_at     | datetime | Data utworzenia                            |
| updated\_at     | datetime | Data aktualizacji                          |
| totp\_secret    | string   | Sekret do autoryzacji TOTP                 |

Tabela dentists:
| Kolumna         | Typ      | Opis                |
| --------------- | -------- | ------------------- |
| id              | int      | ID dentysty (PK)    |
| user\_id        | int      | ID użytkownika (FK) |
| name            | string   | Imię                |
| surname         | string   | Nazwisko            |
| specialization  | string   | Specjalizacja       |
| license\_number | string   | Numer licencji      |
| image\_path     | string   | Ścieżka do zdjęcia  |
| created\_at     | datetime | Data utworzenia     |
| updated\_at     | datetime | Data aktualizacji   |

Tabela services:
| Kolumna       | Typ      | Opis                                 |
| ------------- | -------- | ------------------------------------ |
| id            | int      | ID usługi (PK)                       |
| dentist\_id   | int      | ID dentysty wykonującego usługę (FK) |
| service\_name | string   | Nazwa usługi                         |
| cost          | decimal  | Koszt usługi                         |
| created\_at   | datetime | Data utworzenia                      |
| updated\_at   | datetime | Data aktualizacji                    |

Tabela reservations:
| Kolumna      | Typ      | Opis                     |
| ------------ | -------- | ------------------------ |
| id           | int      | ID rezerwacji (PK)       |
| user\_id     | int      | ID użytkownika (FK)      |
| service\_id  | int      | ID usługi (FK)           |
| date\_time   | datetime | Termin wizyty            |
| status       | string   | Status rezerwacji        |
| submited\_at | datetime | Data złożenia rezerwacji |
| created\_at  | datetime | Data utworzenia          |
| updated\_at  | datetime | Data aktualizacji        |

Tabela coupons:
| Kolumna              | Typ      | Opis                   |
| -------------------- | -------- | ---------------------- |
| id                   | int      | ID kuponu (PK)         |
| user\_id             | int      | ID użytkownika (FK)    |
| service\_id          | int      | ID usługi (FK)         |
| coupon\_code         | string   | Kod kuponu             |
| discount\_percentage | decimal  | Procent zniżki         |
| valid\_until         | datetime | Termin ważności        |
| is\_used             | boolean  | Czy kupon został użyty |
| created\_at          | datetime | Data utworzenia        |
| updated\_at          | datetime | Data aktualizacji      |

Tabela reviews:
| Kolumna     | Typ      | Opis                |
| ----------- | -------- | ------------------- |
| id          | int      | ID opinii (PK)      |
| dentist\_id | int      | ID dentysty (FK)    |
| user\_id    | int      | ID użytkownika (FK) |
| rating      | int      | Ocena (np. 1–5)     |
| comment     | string   | Komentarz           |
| created\_at | datetime | Data utworzenia     |
| updated\_at | datetime | Data aktualizacji   |

</details>

<!-- ## Modele

Stworzonych jest 6 modeli:

- Coupon
- Dentist
- Reservation
- Review
- Service
- User -->

## Panel dentysty

Na stronie głównej panelu użytkownika znajdują się podstawowe informacje o profilu oraz szybki dostęp do historii zabiegów i nadchodzących wizyt. Dodatkowo prezentowane są trzy najnowsze opinie pacjentów.

Dentysta ma możliwość zarządzania swoimi usługami bezpośrednio z poziomu panelu — może je dodawać, edytować oraz usuwać. Dostępne są również dedykowane widoki: kalendarz zabiegów oraz sekcja ocen i opinii od pacjentów.

W sekcji nadchodzących usług dentysta może potwierdzać lub odrzucać zaplanowane wizyty.
