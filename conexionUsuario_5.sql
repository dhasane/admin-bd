DROP TABLE PRIMERATABLAUSUARIO_5;
DROP TABLE SEGUNDATABLAUSUARIO_5;
DROP TABLE TERCERATABLAUSUARIO_5;


create table primeraTablaUsuario_5
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_5
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_5
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;
