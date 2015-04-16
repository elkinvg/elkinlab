//menu.js
//For interpreters: please translate the following array elements from English to your native language :
//<name> => your native language translation
//<tooltip>=> your native language translation
//Leave all the rest intact, please. Send all the files translated to basil.gromov@gmail.com
//menu element structure: <parent_id>;<item_id>;<name>;<tooltip>;<link>;<option>
var main_menu = [
"main;project;Project;;;0x80",
"main;detectors;Detector;;;0x80",
"main;jobs;Jobs;;;0x8F",
"main;physics;Research;;;0x8F",
"main;manuals;Manuals;;;0x80",
"main;personal;Personal;;;0x80",
"project;hello;Greeting;A few words to newcomers;php/container.php?url=lang/en/project.inc.htm;0x10",
"project;about;About;About the project;php/container.php?url=lang/en/intro.inc.htm;0x10",
"project;science;Science;Scientific aspect, idea;php/container.php?url=lang/en/sci_aspect.inc.htm;0x10",
"project;education;Education;Educational aspect, idea;php/container.php?url=lang/en/edu_aspect.inc.htm;0x10",
"project;modelling;Modelling;Computer modelling results;php/container.php?url=lang/en/mod_results.inc.htm;0x10",
"project;analogs;Analogs;Other analogue projects;php/container.php?url=lang/en/analogs.inc.htm;0x10",
"project;rules;Participation;Participation and rules;php/container.php?url=lang/en/participation.inc.htm;0x10",
"project;video;Video;Video tours on the topic;php/container.php?url=lang/en/videos.inc.htm;0x10",
"project;timeline;Timeline;Bits of History;php/container.php?url=lang/en/timeline.inc.htm;0x1F",
"project;forum;Forum;Forum on EAS and other educational and scientific aspects;forum;0x1F",
"detectors;intro;Introduction;Of the task and it\'s solution approaches;php/container.php?url=lang/en/detectors_intro.inc.htm;0x10",
"detectors;descr;Description;Brief installation description;php/container.php?url=lang/en/detectors_descr.inc.htm;0x10",
"detectors;detecting;Detectors;Particles Detection;php/container.php?url=lang/en/detectors_particles.inc.htm;0x10",
"detectors;electronics;Electronics;Particles Detection Electronics;php/container.php?url=lang/en/detectors_electronics.inc.htm;0x10",
"detectors;data;Data;Data registered;php/container.php?url=lang/en/detectors_data.inc.htm;0x10",
//"detectors;stats;Statistics;Collected data statistics;php/container2.php?url=php/dfc_list.php;0x10",
"detectors;stats;Statistics;Collected data statistics;php/dfc_list2.php;0x10",
"detectors;meteo;Weather Station;Collected weather data statistics;http://meteo.jinr.ru;0x10",
"detectors;journal;Journal;RUSALKA working journal;php/journal_list.php;0x1F",
"jobs;list;Job List;View the list, results...;php/jobs_list.php;0x1F",
"jobs;edit;Create,Modify;Create,modify,delete,queue;;0x0F",
"jobs;new;Create New;Learn,create,queue;;0x0F",
"jobs;tasks_descr;Task List;Task Types List and Descriptions;;0x0F",
"jobs;tasks;Task Editor;Create, modify, delete a task type;;0x0E",
"physics;methodology;Steps;Physical tasks sequence;php/research_descr.php;0x1F",
"physics;reports;Reports;View reports list, upload;php/jobs_reports.php;0x1F",
"manuals;faq;QA;Questions and Answers;php/faq.php;0x10",
"manuals;jinr;Links;Useful links and bibliography;php/container.php?url=lang/en/links.inc.htm;0x10",
"manuals;articles;Articles;Entry level descriptions for compex notions;php/container.php?url=lang/en/articles.inc.htm;0x10",
"manuals;site;Site;Smth about the site;php/container.php?url=lang/en/site.inc.htm;0x1F",
"manuals;expert;For Pros;Links for specialists;php/container.php?url=lang/en/roadmap_expert.inc.htm;0x10",
"personal;login;Login;Registered user login;;0x40",
"personal;logout;Logout;Registered user logout;php/porter.php?oper=logout;0x1F",
"personal;register;Register;Register here and join;;0x40",
"personal;profile;Profile;View, edit, destroy;;0x0F",
"personal;stats;Activity;User statistics for experts;php/container2.php?url=php/personal_stats.php;0x1A",
"personal;news;News;RSS-feed message publishing;php/container2.php?url=php/personal_news.php;0x1A"
];
//EOF menu.js