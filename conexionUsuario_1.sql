DROP TABLE PRIMERATABLAUSUARIO_1;
DROP TABLE SEGUNDATABLAUSUARIO_1;
DROP TABLE TERCERATABLAUSUARIO_1;

create table primeraTablaUsuario_1
(
    id number primary key,
    cedula number NOT NULL,
    nombre varchar2(100)
) tablespace tablasProyecto;


DROP TABLE PRIMERATABLAUSUARIO_1;


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

select * 
from informacion_interna_tabla 
where tabla = 'terceraTablaUsuario_5';

select *
from usuario_2;


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

BEGIN
DBMS_SCHEDULER.DROP_JOB ('MI_PRIMER_JOB');
END;
/

select * from dba_jobs;

select owner, job_name, enabled 
from all_scheduler_jobs;


create tablespace UsuariosProyecto DATAFILE 'C:\APP\PROXAR\PRODUCT\18.0.0\ORADATA\XE\UsuariosProyecto.DBF' SIZE 1M AUTOEXTEND ON;




select *
from user_constraints 
where table_name = 'PRIMERATABLAUSUARIO_1';
