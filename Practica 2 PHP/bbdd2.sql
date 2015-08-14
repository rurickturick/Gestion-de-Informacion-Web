/*DROP DATABASE practica;*/
CREATE DATABASE practica;

USE practica;


CREATE TABLE IF NOT EXISTS usuarios (
  usuario varchar(50) NOT NULL,
  nombre varchar(50) NOT NULL,
  apellidos varchar(50) NOT NULL,
  dni varchar(10) NOT NULL,
  correo varchar(50) NOT NULL,
  password varchar(20) NOT NULL,
   PRIMARY KEY(dni));




CREATE TABLE IF NOT EXISTS teatro (
  Id tinyint(3) unsigned NOT NULL auto_increment,
  nombre_teatro varchar(100) NOT NULL DEFAULT '' ,
  nombre_obra varchar(100) NOT NULL DEFAULT '' ,
  descripcion varchar(200) ,
  sesion1 time NOT NULL DEFAULT '00:00:00' ,
  sesion2 time NOT NULL DEFAULT '00:00:00' ,
  sesion3 time NOT NULL DEFAULT '00:00:00' ,
  nume_filas tinyint(2) unsigned NOT NULL DEFAULT '0' ,
  nume_asientos tinyint(2) unsigned NOT NULL DEFAULT '0' ,
  PRIMARY KEY (Id) ,
  KEY nombre_teatro (nombre_teatro) 
);


CREATE TABLE IF NOT EXISTS entradas (
  Id tinyint(6) unsigned NOT NULL auto_increment,
  Id_teatro tinyint(3) unsigned NOT NULL DEFAULT '0' ,
  sesion tinyint(1) unsigned NOT NULL DEFAULT '0' ,
  fila tinyint(2) unsigned NOT NULL DEFAULT '0' ,
  asiento tinyint(2) unsigned NOT NULL DEFAULT '0' ,
  dia date NOT NULL DEFAULT '0000-00-00' ,
  PRIMARY KEY (Id),
  CONSTRAINT FOREIGN KEY(Id_teatro) REFERENCES teatro(Id) ON DELETE CASCADE
);

