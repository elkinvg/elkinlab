<?php
//   ./lang/en/tasks_descr.inc.php
$tasks_descr_txt = array(
'page_title' => 'Task Types List and Descriptions',
'note' => 'This is the list of actual task types that you may use to create your own jobs'
);

$tasks_descr = array(
00=>  array('caption' =>'<b>List of terms</b>', 'descr' => '.....terms'),
29 => array('caption' =>'<b>Rate(time)</b>', 'descr' => 'Description for the task type (id=29 - Rate(time)).'),
30 => array('caption' =>'<b>dT in one station</b>', 'descr' => 'Description for the task type  (id=30 - dT in one station).'),
31 => array('caption' =>'<b>N_satellites(time)</b>', 'descr' => 'Description for the task type  (id=31 - N_satellites(time)).'),
32 => array('caption' =>'<b>Time resolution and offset for one station</b>', 'descr' => 'Description for the task type  (id=32 - Time resolution and offset for one station).'),
33 => array('caption' =>'<b>Consecutive time difference for one station</b>', 'descr' => 'Description for the task type  (id=33 - Consecutive time difference for one station).'),
34 => array('caption' =>'<b>Rate(time) for classes A and B</b>', 'descr' => 'Description for the task type  (id=34 -Rate(time) for classes A and B ).'),
35 => array('caption' =>'<b>N_satellites distribution</b>', 'descr' => 'Description for the task type (id=35 - N_satellites distribution).'),
36 => array('caption' =>'<b>Poisson distribution</b>', 'descr' => 'Description for the task type (id=36 -Poisson distribution ).'),
60 => array('caption' =>'<b>Looking for anomalies</b>', 
'descr' => 
'<p>Since events of secondary cosmic rays registration are independent, the rate of our detecting stations should satisfy well known statistical lows. The goal of the task is to test at a given time interval and given time scale the assumption about randomness of detected events. This program provides possibility to search for non-random component of the rate related to physical reasons (short growth of the rate due to a supernova explosion) or to peculiarities of detecting stations (non-random electronic noise). </p>
<p>The task has 8 input parameters:</p>
<p>1,2) The beginning and the end of time interval</p>
<p>3) Station number</p>
<p>4,5) Maximal and minimal absolute value of the time difference between the channels of the station. This option gives possibility to select events of type A and B in arbitrary limits. The values can be variated within the range from 0 to 1200 ns.</p>
<p>6) Number of bins for subdivision of chosen time interval</p>
<p>7) Time scale Tau where randomness of the selected sample will be tested. Tau can be selected from the interval 1 microsecond - 10 000 seconds.</p>
<p>8) Comments</p>
<p>For each event the program opens the time window of Tau duration and calculates the number  of events N within this window. Time dependence on N distribution is shown as 2D histogram on the first plot produced by the program.</p>
<p><img src="../skin/task_descr_60_1.png"  hspace=15 vspace=15 border=1></p>
<p>For the histogram presented on the plot the length of the time interval is 1 day and the bin size is 1 hour. Tau is 1 s. So from the plot we can say that the case, when the number of events in 1 s interval is zero, takes place ~600 times per hour, the case when exactly one event is detected in 1 s interval occurs 100-200 times per hour etc. But at 10 AM and 12 AM cases, when even 4 events were registered in 1 s, were detected.</p>
<p><img src="../skin/task_descr_60_2.png"  hspace=15 vspace=15 border=1></p>
<p>On the second plot you can see that for the each time bin of the first histogram the value  -Log P was introduced to describe probability to obtain observed N-distribution under assumption that detected events are statistically independent and the mean rate is stable in time. Magnitudes of -Log P on the level of <3-5 mean that there is no evidence of non-random component in the rate at time scale Tau. Otherwise values >10 inform us about serious anomaly in the rate. </p>
<p><img src="../skin/task_descr_60_3.png"  hspace=15 vspace=15 border=1></p>
<p>In the case of anomaly discovered an some time scale Tau, it\'s recommended to repeat studies for different values of Tau.  May be for them anomaly will be more evident.</p>
<p>The last plot produced by the program is the projection of the first 2D histogram to the N axis. Black marks correspond to experimental points as far as yellow bins correspond to expected distribution in the case of pure statistical nature of observed rate.  It\'s easy to see by eyes the agreement between distributions.</p>')
);

?>