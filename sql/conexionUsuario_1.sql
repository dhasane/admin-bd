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


-- SACAR JOB, DUEÑO DEL JOB Y SI ESTÁ ACCTIVO O NO
select owner, job_name, enabled 
from all_scheduler_jobs, (
    SELECT username
    FROM ALL_USERS
) usuarios 
where owner = usuarios.username;

SELECT *
FROM SYS.permisos_usuario_tabla
where tabla = 'PRIMERATABLAUSUARIO_1';


select *
from sys.vista_Procedimientos;

select *
from sys.vista_Paquetes;

select *
from sys.vista_Funciones;