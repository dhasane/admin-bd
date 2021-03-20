DROP TABLE PRIMERATABLAUSUARIO_3;
DROP TABLE SEGUNDATABLAUSUARIO_3;
DROP TABLE TERCERATABLAUSUARIO_3;

create table primeraTablaUsuario_3
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_3
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_3
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_PRIMER_JOB_USUARIO_3');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_SEGUNDO_JOB_USUARIO_3');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_TERCERO_JOB_USUARIO_3');
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_PRIMER_JOB_USUARIO_3',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_SEGUNDO_JOB_USUARIO_3',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_TERCERO_JOB_USUARIO_3',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/
