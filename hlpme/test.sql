SELECT * FROM jobs INNER JOIN jobpars ON (jobs.task_id=jobpars.task_id AND jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT') WHERE jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=1427278898 and UNIX_TIMESTAMP(jobs.started) <= 1428422898;

SELECT * FROM jobs INNER JOIN jobpars ON (task_id AND job_id ) WHERE jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=1427278898 and UNIX_TIMESTAMP(jobs.started) <= 1428422898;

SELECT * FROM jobs INNER JOIN jobpars USING (task_id,job_id) INNER JOIN jobpars ON (jobpars.name='COMMENT') WHERE jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=1427278898 and UNIX_TIMESTAMP(jobs.started) <= 1428422898;

SELECT jobs.*, jobpars.job_id, jobpars.task_id, jobpars.name, jobpars.caption FROM jobs, jobpars  WHERE jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT'  AND jobs.task_id=jobpars.task_id AND jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=1427278898 and UNIX_TIMESTAMP(jobs.started) <= 1428422898;

SELECT jobs.*, tasks.caption, jobpars.def_val, users.first_name, users.last_name FROM jobs, jobpars, tasks, users  WHERE jobs.job_id=jobpars.job_id AND jobpars.name='COMMENT' AND jobs.task_id=jobpars.task_id AND jobs.task_id=tasks.task_id AND users.uuid=jobs.user_id AND jobs.job_status<10 AND UNIX_TIMESTAMP(jobs.started) >=1427278898 and UNIX_TIMESTAMP(jobs.started) <= 1428422898;
