SELECT *
FROM SYS.vista_todas_las_tablas;

select *
from sys.espacio_usuario;


create table poder_1
(
    id number primary key,
    nombre varchar2(100) not null,
    cedula number
);

insert into poder_1 values (1, 'pedro', 123554);