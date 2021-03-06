<?php

$tasks_form = array(
    'tasks_editor_title' => 'Редактор задач',
    'button_add' => 'Добавить новую',
    'button_modify' => 'Изменить выбранную',
    'button_delete' => 'Удалить выбранную',
    'button_params' => 'Параметры выбранной',
    'title' => 'Редактор задач',
    'note' => 'Необходимы все поля',
    'button_ok' => 'Сохранить',
    'button_cancel' => 'Отбой',
    'app_name_caption' => 'Имя приложения',
    'caption_caption' => 'Название задачи',
    'par_number_caption' => 'Количество параметров',
    'status_caption' => 'Статус задачи',
    'popularity_caption' => 'Уровень популярности',
    'complexity_caption' => 'Уровень сложности (0..2)',
    'sequence_caption' => 'Порядок следования',
    'description_en_caption' => 'Описание (англ.)',
    'remark_en_caption' => 'Примечание (англ.)',
    'description_ru_caption' => 'Описание (рус.)',
    'remark_ru_caption' => 'Примечание (рус.)',
    'del_caption' => 'Удалить задачу?',
    'button_del' => 'Удалить выбранную задачу',
    'button_cancel' => 'Передумал',
    'no_sel_warning' => 'Ничего не выбрано',
    'warn_date_fromat' => 'Формат даты: ГГГГ-ММ-ДД ЧЧ:ММ',
    'warn_station' => 'По крайней мере 1 станция должна быть выбрана',
    'del_warning' => 'Задача и все ее параметры и ассоциированные задания будут удалены без возможности восстановления. Вы уверены?',
    'job_enqueued' => 'задача в очереди'
);

$jobs_new = array(
    'jobs_new_title' => 'Новое задание',
    'complexity' => 'Сложность',
    'caption' => 'Название',
    'description' => 'Описание',
    'remark' => 'Примечание',
    'complexity_at' => array('для новичков', 'для продвинутых', 'для экспертов'),
    'caption_tt' => 'Указать параметры для задания и поставить в очередь на счет',
    'description_tt' => 'Посмотреть методические указания по работе с этим типом задач',
    'jobs_new_note' => 'Используйте Название, как ссылку для формирования параметров и запуск задания, а Описание - как ссылку на методичку.<br>Другой способ создания нового задания - "Задания->Редактирование->Добавить новое".'
);

$job_params_form = array(
    'title' => 'Установить параметры задания',
    'note' => 'Необходимы все поля. Тип: 0-числовой(int, float, bool), 1-символьный, 2-дата (ГГГГ-ММ-ДД ЧЧ:ММ). Можете менять "Ваше значение".',
    'note_1' => 'Формат ввода даты: ГГГГ-ММ-ДД ЧЧ:ММ ',
    'note_2' => 'минимальная: ',
    'note_3' => 'Максимальное число разбиений гистограммы: ',
    'caption' => 'Название параметра',
    'name' => 'Обозначение',
    'type' => 'Тип',
    'def_val' => 'Ваше значение',
    'min_val' => 'Значение Min',
    'max_val' => 'Значение Max',
    'dtitle_templ' => 'По шаблону ( ',
    'dtitle_new' => 'Новое ( ',
    'use_station' => 'использовать станцию',
    'start_time' => 'Выбрать дату, время от',
    'end_time' => 'Выбрать дату, время до',
    'num_of_bins' => 'Число разбиений гистограммы',
    'rank' => 'Ранг (кратность) совпадений с другими станциями',
    'comments' => 'Краткие комментарии',
    'min_of_hist' => 'Минимум гистограммы',
    'max_of _hist' => 'Максимум гистограммы',
    'log_scale' => 'Логарифмическая шкала'
);

$reg_form = array(
    'title' => 'Новая учетная запись',
    'profile_title' => 'Учетная запись',
    'first_name_caption' => 'Имя',
    'last_name_caption' => 'Фамилия',
    'email_caption' => 'Email',
    'password_caption' => 'Пароль',
    'password2_caption' => 'Пароль повторно',
    'icq_caption' => 'ICQ UIN',
    'skype_caption' => 'Skype-имя',
    'education_caption' => 'Образование',
    'education_undefined' => 'ваше образование',
    'education_primary' => 'начальное',
    'education_secondary' => 'среднее',
    'education_high' => 'высшее',
    'occupation_caption' => 'Род занятий',
    'birth_year_caption' => 'Год рождения',
    'sex_caption' => 'Пол',
    'sex_undefined' => 'ваш пол',
    'sex_male' => 'муж.',
    'sex_female' => 'жен.',
    'country_caption' => 'Страна',
    'country_undefined' => 'ваша страна',
    'region_caption' => 'Край/Область',
    'city_caption' => 'Город',
    'language_caption' => 'Язык',
    'language_undefined' => 'ваш язык',
    'language_en' => 'Английский',
    'language_ru' => 'Русский',
    'news_subscr_caption' => 'Подписка на новости',
    'note' => 'Звездочкой * помечены обязательные поля.',
    'warn_length' => 'длина в символах',
    'warn_letters_only' => 'может состоять только из букв',
    'warn_digits_only' => 'может состоять только из цифр',
    'warn_not_selected' => 'не быбрано',
    'warn_illegal_syntax' => 'ошибка синтаксиса',
    'warn_symbols' => 'a-z A-Z 0-9',
    'warn_symbols_2' => 'может состоять только из a-z, 0-9, подчеркивания, начинаться с буквы',
    'warn_number' => 'неверное представление числа',
    'warn_age' => 'извините, возрастной диапазон',
    'warn_password' => 'несовпавдение пароля',
    'button_register' => 'уразумел и хочу зарегистрироваться',
    'button_profile' => 'изменить личные данные',
    'button_ok' => 'Зарегистрироваться',
    'button_ok_profile' => 'Сохранить',
    'button_cancel' => 'Передумал'
);

$jobs_table = array(
    //'begin' => ''
    'update'=>'Обновить',
    'default'=>'По_умолчанию',
    'period'=>'Период: ',
    'parameter'=>'Параметр',
    'value'=>'Значение',
    'pars_jobs'=>'Параметры задания',
    'links' => 'Ссылки для скачивания',
    'csv_link_pre' => 'Данные ',
    'csv_link_post' => ' для Excel (гистограммы)',
    'no_data'=>'нет ссылок',
    'actions'=>'Действия',
    'time_filter'=>'Фильтр по времени',
    'new_job'=>'Изменить параметры (новое задание)',
    'back'=>'Назад к списку заданий',
    'note'=>'Заметка',
    'note_l'=>'Вы можете использовать верхнюю панель для навигации',
    'user_filters'=>'Пользовательские фильтры',
    'back_main'=>'На главную страницу ЛАБ (в новом окне)',
    'job_info'=>'Информация о задании',
    'started'=>'Запущена: ',
    'finished'=>'Закочена: ',
    'user'=>'Пользователь: ',
    'status'=>'Статус задачи: ',
    'disabled'=>'Прервана',
    'pending'=>'Незакончена',
    'running'=>'Считается',
    'completed'=>'Счёт завершён',
    'failed'=>'Прервана с ошибкой',
    'gotojob' => 'Перейти на страницу задачи ',
    'add_descr'=>'добавить/изменить описание',
    'stdouttxt'=>'Показать/скрыть stdout.txt',
);
?>