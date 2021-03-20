DROP TABLE PRIMERATABLAUSUARIO_2;
DROP TABLE SEGUNDATABLAUSUARIO_2;
DROP TABLE TERCERATABLAUSUARIO_2;

create table primeraTablaUsuario_2
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_2
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_2
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_PRIMER_JOB_USUARIO_2');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_SEGUNDO_JOB_USUARIO_2');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_TERCERO_JOB_USUARIO_2');
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_PRIMER_JOB_USUARIO_2',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_SEGUNDO_JOB_USUARIO_2',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_TERCERO_JOB_USUARIO_2',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

insert into primprimeratablausuario_2 values (1, 111111, 'PATRICA');

BEGIN
 
  FOR numero IN 1..10
  LOOP
    insert into tablaTBS_1 values (5,'nombre_'||numero);
  END LOOP;
 
END;


select *
from sys.espacio_usuario;
