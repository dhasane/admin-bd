DROP TABLE PRIMERATABLAUSUARIO_1;
DROP TABLE SEGUNDATABLAUSUARIO_1;
DROP TABLE TERCERATABLAUSUARIO_1;

create table primeraTablaUsuario_1
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table segundaTablaUsuario_1
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


create table terceraTablaUsuario_1
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

create table sustentacion
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;

GRANT CREATE TABLESPACE to GRUPOUSUARIO;

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_PRIMER_JOB_USUARIO_1');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_SEGUNDO_JOB_USUARIO_1');
END;
/

BEGIN
DBMS_SCHEDULER.DROP_JOB('MI_TERCERO_JOB_USUARIO_1');
END;
/





BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_PRIMER_JOB_USUARIO_1',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_SEGUNDO_JOB_USUARIO_1',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/

BEGIN
  DBMS_SCHEDULER.create_job (
    job_name        => 'MI_TERCERO_JOB_USUARIO_1',
    job_type        => 'PLSQL_BLOCK',
    job_action      => 'BEGIN refrescavista; END;',
    start_date      => SYSTIMESTAMP,
    repeat_interval => 'freq=hourly; byminute=0; bysecond=0;',
    enabled         => TRUE);
END;
/


insert into primeratablausuario_1 values (1, 111111, 'PATRICA');

BEGIN
 
  FOR numero IN 1..10
  LOOP
    insert into primeratablausuario_1 values (5,11111, 'Patricia');
  END LOOP;
 
END;

GRANT CREATE SESSION TO pepito;
GRANT CREATE TABLE to pepito;
GRANT CREATE ANY JOB TO pepito;
GRANT CREATE TABLESPACE to pepito;


alter session set "_ORACLE_SCRIPT"=true;

create user pepito IDENTIFIED by pepito DEFAULT TABLESPACE USUARIOSPROYECTO;

