create table Campionato
(
Nazionalita varchar(20),
NumSerie int (1) NOT NULL,
PRIMARY KEY(Nazionalita)
);

create table Serie
(
NomeSerie varchar(20),
Livello int(1) NOT NULL,
RF_Campionato varchar(20),
PRIMARY KEY(NomeSerie),
FOREIGN KEY(RF_Campionato) references Campionato(Nazionalita)
);

create table Squadra
(
NomeSquadra varchar(20),
Punti int(3),
Citta varchar(20) NOT NULL,
Via varchar(20) NOT NULL,
Civico varchar(20) NOT NULL,
Saldo int(3) NOT NULL,
RF_Serie varchar(20),
PRIMARY KEY(NomeSquadra),
FOREIGN KEY(RF_Serie) references Serie(NomeSerie)
);

create table Calendario
(
ID int(4) auto_increment,
DataIncontro date NOT NULL,
NumGiornata int(2) NOT NULL,
Punteggio_1 int(2),
Punteggio_2 int(2),
PRIMARY KEY(ID)
);

create table Giocatore
(
CF int(4) auto_increment,
Nome varchar(20) NOT NULL,
Cognome varchar(20) NOT NULL,
Ruolo varchar(14) NOT NULL,
DataNasc date NOT NULL,
Sponsor varchar(20),
Eta int(2) NOT NULL,
Valore int(3) NOT NULL,
Nazionalita varchar(20) NOT NULL,
RF_Squadra varchar(20),
PRIMARY KEY(CF),
FOREIGN KEY(RF_Squadra) references Squadra(NomeSquadra)
);

create table Incontro
(
RF_Serie varchar(20),
RF_Calendario int(2),
RF_Squadra1 varchar(20),
RF_Squadra2 varchar(20),
FOREIGN KEY(RF_Serie) references Serie(NomeSerie),
FOREIGN KEY(RF_Calendario) references Calendario(ID),
FOREIGN KEY(RF_Squadra1) references Squadra(NomeSquadra),
FOREIGN KEY(RF_Squadra2) references Squadra(NomeSquadra)
);

