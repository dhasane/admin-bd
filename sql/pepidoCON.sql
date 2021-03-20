
create table sustentacion_pepito
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
    
) tablespace tablasProyecto;

insert into sustentacion_pepito values (1,11111,'Glorias');


BEGIN
 
  FOR numero IN 2..100
  LOOP
    insert into sustentacion_pepito values (NUMERO,11111, 'Patricia');
  END LOOP;
 
END;