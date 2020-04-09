# Induviduell uppgift

## How to use: ##
Ladda ner projektet.
Starta igång XAMPP

Öppna PhPmyadmin och importera in SQL filen så du får likadan databas-struktur.
Öppna 'index.php' 
Utgå ifrån Index-sidan.

**Två användare finns redan skapade. "admin" & "user".**
- *Lösenord: "123";*
- **Users** kan logga in, se produkter, lägga till produkter i kundvagn och beställa produkter.
- **Admin** kan allt som users kan men även delete, edit och create produkter.

Testa logga in med någon av dessa eller skapa en egen användare.

När du loggat in via någon användare så är det viktigt att spara ner din *token* som du ska ha med dig för att testa allting manuellt.

Nu med hjälp av token så kan du använda dig av allt på sidan. Följ instruktionerna på sidan så borde du klara dig fint.


## Skapa upp mappstruktur
    config: för databashanteraren och inställningar
    files: php kod som ska sköta uppladdningen av filer och i vilken mapp dem ska hamna.
    object: Sköter alla objekt som kommer skapas och användas under projektets gång. 
    products: Allting som har med products att göra t.ex (add, remove, update products).
    uploads: Här hamnar filer som laddats upp.
    users: Allting som har med users att göra ( login, logout, register etc).



## Svårigheter

Har varit så otroligt bekväm med sessions att tokens till en början var ett hinder. 
Men mot slutet av projektet så fall poletten ner kring tokens men då var det mesta redan klart och hade inte mycket tid att göra om strukturen och valde att ha den som den var orginellt.

