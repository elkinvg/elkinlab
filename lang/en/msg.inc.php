<?php

$tasks_form = array(
    'tasks_editor_title' => 'Tasks Editor',
    'button_add' => 'Add New',
    'button_modify' => 'Change Selected',
    'button_delete' => 'Delete Selected',
    'button_params' => 'Parameters for Selected',
    'title' => 'Task editor',
    'note' => 'All fields are necessary',
    'button_ok' => 'Save',
    'button_cancel' => 'Cancel',
    'app_name_caption' => 'Application Name',
    'caption_caption' => 'Task Friendly Name',
    'par_number_caption' => 'Parameters Number',
    'status_caption' => 'Task Status',
    'popularity_caption' => 'Popularity Counter',
    'complexity_caption' => 'Complexity Level (0..2)',
    'sequence_caption' => 'Sequence',
    'description_en_caption' => 'Description (en)',
    'remark_en_caption' => 'Remark (en)',
    'description_ru_caption' => 'Description (ru)',
    'remark_ru_caption' => 'Remark (ru)',
    'del_caption' => 'Delete Task?',
    'button_del' => 'Delete the selected task',
    'button_cancel' => 'Cancel',
    'no_sel_warning' => 'No selection',
    'warn_date_fromat' => 'Date fromat: YYYY-MM-DD HH:MM',
    'warn_station' => 'At least 1 station must be selected',
    'del_warning' => 'The task and all of its parameters and associated jobs would be permanently deleted and cannot be recovered. Are you sure?',
    'job_enqueued' => 'job enqueued'
);

$jobs_new = array(
    'jobs_new_title' => 'New job',
    'complexity' => 'Complexity',
    'caption' => 'Name',
    'description' => 'Description',
    'remark' => 'Remark',
    'complexity_at' => array('for newbies', 'for advanced', 'for experts'),
    'caption_tt' => 'Specify parameters for the job and set it to handling queue',
    'description_tt' => 'View this task type full description',
    'jobs_new_note' => 'Use Name column as a link to fill up new job parameters form and launch it, and Description column - to view the full description.<br>Another way to create a new job - "Jobs->Create Job->Add new".'
);

$job_params_form = array(
    'title' => 'Set Your Job Parameters',
    'note' => 'All fields are necessary. Type: 0-numeric(int, float, bool), 1-string, 2-date (YYYY-MM-DD HH:MM). You may set "Your Value" and Min, Max for time spans.',
    'note_1' => 'Data input format: YYY-MM-DD HH:MM ',
    'note_2' => 'oldest:',
    'note_3' => 'Maximum number of histogram bins:',
    'caption' => 'Parameter Name',
    'name' => 'Actual Name',
    'type' => 'Type',
    'def_val' => 'Your Value',
    'min_val' => 'Min Value',
    'max_val' => 'Max Value',
    'dtitle_templ' => 'From Template ( ',
    'dtitle_new' => 'New ( ',
    'use_station' => 'Use station',
    'start_time' => 'Select data from',
    'end_time' => 'Select data until',
    'num_of_bins' => 'Number of bins in the histogram',
    'rank' => 'Coincidence rank',
    'comments' => 'Comments',
    'min_of_hist' => 'Minimum of the histogram',
    'max_of _hist' => 'Maximum of the histogram',
    'log_scale' => 'Log scale'
);

$reg_form = array(
    'title' => 'New account',
    'profile_title' => 'Edit Account',
    'first_name_caption' => 'First Name',
    'last_name_caption' => 'Last Name',
    'email_caption' => 'Email',
    'password_caption' => 'Password',
    'password2_caption' => 'Retype Password',
    'icq_caption' => 'ICQ UIN',
    'skype_caption' => 'Skype Name',
    'education_caption' => 'Education',
    'education_undefined' => 'your education',
    'education_primary' => 'primary',
    'education_secondary' => 'secondary',
    'education_high' => 'high school',
    'occupation_caption' => 'Occupation',
    'birth_year_caption' => 'Year of Birth',
    'sex_caption' => 'Sex',
    'sex_undefined' => 'your sex',
    'sex_male' => 'Male',
    'sex_female' => 'Female',
    'country_caption' => 'Country',
    'country_undefined' => 'your country',
    'region_caption' => 'Region/State',
    'city_caption' => 'City',
    'language_caption' => 'Language',
    'language_undefined' => 'your language',
    'language_en' => 'English',
    'language_ru' => 'Russian',
    'news_subscr_caption' => 'News Subscription',
    'note' => 'Asterisk * mark required fields.',
    'warn_length' => 'length range',
    'warn_letters_only' => 'may consist of letters only',
    'warn_digits_only' => 'may consist of digits only',
    'warn_not_selected' => 'not selected',
    'warn_illegal_syntax' => 'illegal syntax',
    'warn_symbols' => 'a-z A-Z 0-9 _',
    'warn_symbols_2' => 'may consist of a-z, 0-9, underscores, begin with a letter',
    'warn_number' => 'not a valid number representation',
    'warn_age' => 'sorry, age range',
    'warn_password' => 'Passwords mismatch',
    'button_register' => 'ok, I\'m going to register',
    'button_profile' => 'change profile',
    'button_ok' => 'Register',
    'button_ok_profile' => 'Save',
    'button_cancel' => 'Cancel'
);

$jobs_table = array(
    //'begin' => ''
    'update'=>'Update',
    'period'=>'Period: ',
    'parameter'=>'parameter',
    'value'=>'value',
    'pars_jobs'=>'Parameters of job',
    'links' => 'links for download',
    'csv_link_pre' => 'Data ',
    'csv_link_post' => ' for Excel (Histograms)',
    'no_data'=>'no links',
    'actions'=>'Actions',
    'new_job'=>'Change parameters (new job)',
    'back'=>'back job\'s list',
    'job_info'=>'Job\'s information',
    'started'=>'Started: ',
    'finished'=>'Finished: ',
    'user'=>'User: ',
    'status'=>'Job\'s status',
    'disabled'=>'Disabled',
    'pending'=>'Pending',
    'running'=>'Running',
    'completed'=>'completed',
    'failed'=>'Failed',
    'gotojob' => 'go to the Job\'s page ',
    'add_descr'=>'add/change description',
);
?>

