DROP TABLE PRIMERATABLAUSUARIO_6;
DROP TABLE SEGUNDATABLAUSUARIO_6;
DROP TABLE TERCERATABLAUSUARIO_6;

create table primeraTablaUsuario_6
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_6
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_6
(
     id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;