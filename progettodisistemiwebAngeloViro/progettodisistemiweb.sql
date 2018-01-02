use facebook;
CREATE TABLE `utente` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) DEFAULT NULL,
  `Cognome` varchar(20) DEFAULT NULL,
  `Data_nascita` date DEFAULT NULL,
  `Citta` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `Password` varchar(60) DEFAULT NULL,
  `Tipo` int(11) DEFAULT NULL,
prifile_pic varchar(30),
is_confirmed boolean,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB ;
create table post(
id int auto_increment,
timestamp date,
content varchar(30),
is_fixed boolean,
id_autore int,
index f(id_autore),
primary key(id),
foreign key(id_autore) references utente(id))Engine='InnoDB';
create table commento(
id int auto_increment,
timestamp date,
content varchar(30),
id_autore int,
id_post int,
index f(id_autore),
index g(id_post),
primary key(id),
foreign key(id_autore) references utente(id),
foreign key(id_post) references post(id))Engine='InnoDB';
create table notifica(
id int auto_increment,
timestamp date,
content varchar(30),
link varchar(30),
letta boolean,
id_utente int,
index f(id_utente),
primary key(id),
foreign key(id_utente) references utente(id))Engine='InnoDB';
create table pagina(
id int auto_increment,
nome varchar(30),
pic varchar(30),
id_proprietario int,
index f(id_proprietario),
primary key(id),
foreign key(id_proprietario) references utente(id))Engine='InnoDB';
create table utente_segue_pagina(
id_utente int,
id_pagina int,
index f(id_utente),
index g(id_pagina),
primary key(id_utente,id_pagina),
foreign key(id_utente) references utente(id),
foreign key(id_pagina) references pagina(id))Engine='InnoDB';
create table utente_stringe_amicizia(
id_utente_richiedente int,
id_utente int,
stato varchar(30),
index f(id_utente_richiedente),
index g(id_utente),
primary key(id_utente_richiedente,id_utente),
foreign key(id_utente_richiedente) references utente(id),
foreign key(id_utente) references utente(id))Engine='InnoDB';
create table like_post(
id_utente int,
id_post int,
index f(id_utente),
index g(id_post),
primary key(id_utente,id_post),
foreign key(id_utente) references utente(id),
foreign key(id_post) references post(id))Engine='InnoDB';
create table like_commento(
id_utente int,
id_commento int,
index f(id_utente),
index g(id_commento),
primary key(id_utente,id_commento),
foreign key(id_utente) references utente(id),
foreign key(id_commento) references commento(id))Engine='InnoDB';
alter table Utente add ban boolean;

select * from utente