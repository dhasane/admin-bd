DROP TABLE PRIMERATABLAUSUARIO_4;
DROP TABLE SEGUNDATABLAUSUARIO_4;
DROP TABLE TERCERATABLAUSUARIO_4;

create table primeraTablaUsuario_4
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_4
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_4
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;