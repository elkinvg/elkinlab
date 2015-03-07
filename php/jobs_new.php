<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <?php
        $pp = "..";

        echo "<link href='$pp/css/common.css' rel='stylesheet' type='text/css' />";
        require "$pp/php/config.inc.php";


//lang-dependent:
        require "$pp/lang/$context[lang]/msg.inc.php";
////echo "<script language='JavaScript' src='$pp/lang/$context[lang]/menu.js' type='text/javascript'></script>";
//// jquery:
////echo "<link type='text/css' href='$pp/css/jquery/themes/smoothness/jquery-ui-1.7.2.custom.css' rel='stylesheet' />";
//echo "<link type='text/css' href='$pp/js/jquery/jquery-ui-1.10.4/themes/base/jquery-ui.css' rel='stylesheet' />\n"; // elkin
//echo "<script type='text/javascript' src='$pp/js/jquery/jquery-2.1.3.min.js'></script> \n"; // elkin
//////echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.2/jquery-ui.min.js'></script>";
////echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.10.4/ui/jquery-ui.js'></script>\n"; // elkin
//echo "<script type='text/javascript' src='$pp/js/jquery/ui/jquery-ui-1.7.2.custom.js'></script>"; // elkin
////echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.10.4/jquery-1.10.2.js'"; // elkin
////echo "<link type='text/css' href='$pp/css/jquery/themes/smoothness/jquery-ui-1.7.2.custom.css' rel='stylesheet' />";
////echo "<script type='text/javascript' src='$pp/js/jquery/jquery-1.3.2.min.js'></script>";
////echo "<script type='text/javascript' src='$pp/js/jquery/ui/jquery-ui-1.7.2.custom.min.js'></script>";
//echo "<link type='text/css' href='$pp/js/jquery/jquery-ui-1.11.3/jquery-ui.css' rel='stylesheet' />\n";
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-2.1.3.min.js'></script> \n"; // elkin
        echo "<link type='text/css' href='$pp/js/jquery/jquery-ui-1.11.3/themes/sunny/jquery-ui.css' rel='stylesheet' />\n"; // elkin
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/external/jquery/jquery.js'></script>\n"; // elkin
        echo "<script type='text/javascript' src='$pp/js/jquery/jquery-ui-1.11.3/jquery-ui.js'></script>\n"; // elkin
        ?>

        <script type="text/javascript">
            $(document).ready(function () {
                var caption = $("#caption"),
                        par_numb = $("#par_numb"),
                        job_id = $("#job_id"),
                        task_id = $("#task_id"),
                        params_task_id = $("#params_task_id"),
                        oper = $("#oper"),
                        params_oper = $("#params_oper"),
                        uuid = $("#uuid"),
                        newrec = $("#newrec"),
                        allFields = $([]).add(caption).add(par_numb).add(job_id).add(task_id).add(oper).add(uuid).add(newrec).add(params_task_id).add(params_oper),
                        tips = $("#validateTips"),
                        tipsparams = $("#validateTipsParams");

                $('.job-add').click(function ()
                {
                    var task_id = $(this).attr("task_id");
                    var task_par_numb = $(this).attr("par_number");
                    var task_caption = $(this).find('a').html();

<?php echo "var langt='{$job_params_form['dtitle_new']}'; "; ?>
                    var t = langt + task_caption + ")";


                    alert(" task_caption = " + task_caption
                            + "\n task_par_numb = " + task_par_numb
                            + "\n task_id = " + task_id
                            + "\n par_numb = " + par_numb
                            + "\n job_id = " + job_id);


                    $('#params').dialog('option', 'title', t);
                    $('#params').dialog("open");
                })
                        .hover(function () {
                            $(this).addClass("ui-state-hover");
                        }, function () {
                            $(this).removeClass("ui-state-hover");
                        })
                        .mousedown(function () {
                            $(this).addClass("ui-state-active");
                        })
                        .mouseup(function () {
                            $(this).removeClass("ui-state-active");
                        });


                $("#params").dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    buttons: [
                        {
                            text: "Ok",
                            click: function () {
                                $(this).dialog("close");
                            }
                        },
                        {
                            text: "Cancel",
                            click: function () {
                                $(this).dialog("close");
                            }
                        }
                    ]
                });
            });

        </script>


    </head>
    <body vlink=black link=black>
        <!--<button id="opener-2">Open Dialog</button>-->

        <div <?php echo " id='params' name='params' title='$job_params_form[title]'"; ?> >
<?php
//echo "<div id='params' name='params' title='$job_params_form[title]'>";
echo "<p id='validateTipsParams'>$job_params_form[note_1]($job_params_form[note_2]" . date('Y-m-d', $date_from) . ")<br>$job_params_form[note_3]$max_bins</p>";
?>

            <form>
                <fieldset>
                    <input type="hidden" name="params_oper" id="params_oper">
                    <input type="hidden" name="uuid" id="uuid">
                    <input type="hidden" name="job_id" id="job_id">	
                    <input type="hidden" name="newrec" id="newrec" value=1>	
                    <input type="hidden" name="params_task_id" id="params_task_id">
                    <input type="hidden" name="par_numb" id="par_numb" value=0>	
                    <table name="params_form" id="params_form">
                        <thead>
                            <tr><td><?php echo "$job_params_form[caption]"; ?></td><td><?php echo "$job_params_form[def_val]"; ?></td><td colspan=4>&nbsp;</td></tr>	
                        </thead>
                        <tbody></tbody>
                    </table>
                </fieldset>
            </form>
        </div>

        <?php
        $oper = 'list';
        $ret = array();
        $cols = 4;
        require "./tasks.php";

//global $context;
        $brief_descr = file_get_contents("$pp/lang/$context[lang]/newjob_brief_descr.html");
        $icon = "<img src='../skin/rating_on.png'>";
        ?>
        <table height=100%>
            <TR height=100%><TD class=showcase>

                    <table name='jobs_new_sel' id='jobs_new_sel' cellpadding=2>

<!--//$icon="<img src='../skin/star_gray4_16x16.png'>";-->

                        <thead>
                            <tr><td <?php echo "colspan=$cols"; ?> class=page_title><?php echo "$jobs_new[jobs_new_title]"; ?> </td>
                            <tr><td <?php echo "colspan=$cols"; ?> class=page_note> <?php echo "$brief_descr"; ?> </td>
                            <tr><td <?php echo "colspan=$cols"; ?> ><hr></td></tr>
                            <tr class=page_table_header>
                                <td title= <?php echo "$jobs_new[complexity]"; ?> ><a href='#'><?php echo "$icon"; ?> </a></td>
                                <td><?php echo "$jobs_new[caption]" ?> </td>
                                <td> <?php echo "$jobs_new[description]"; ?> </td>
                                <td><?php echo "$jobs_new[remark]"; ?> </td>
                            </tr>
                            <tr><td colspan=<?php echo "$cols"; ?> ><hr></td></tr>
                        </thead>
                        <tbody>

                            <?php
                            $fill = false;
                            foreach ($ret as $value) {
                                if (!$debug) {
                                    $descr = ($context['lang'] == 'ru') ? $value['description_ru'] : $value['description_en'];
                                    $rem = ($context['lang'] == 'ru') ? $value['remark_ru'] : $value['remark_en'];
                                } else {
                                    $descr = $value['description_ru'];
                                    $rem = $value['remark_ru'];
                                }

                                $task_id = $value['task_id'];
                                $pars = $value['par_number'];

                                $descr_link = "" . $proj_home . "php/container.php?url=lang/" . $context['lang'] . "/task_descr/task" . $task_id . ".htm";
                                //$descr_link="http://livni.jinr.ru/php/container.php?url=lang/$context[lang]/task_descr/task$task_id.htm";
                                $complexity = $value['complexity'];
                                if ($complexity > 2)
                                    $complexity = 2; //we have only 3 titles
                                $complexity_tt = $jobs_new['complexity_at'][$complexity];
                                $icons = "";
                                for ($n = 0; $n <= $complexity; $n++) {
                                    $icons.=$icon;
                                }
                                //ELKIN-B
                                $task_visibly_for_flag;
                                if ($complexity < 2)
                                    $task_visibly_for_flag = 1;
                                else {
                                    if ($complexity == 2 && ($context['utype'] == "admin" || $context['utype'] == "expert"))
                                        $task_visibly_for_flag = 1;
                                    else
                                        $task_visibly_for_flag = 0;
                                }

                                if ($task_visibly_for_flag) {
                                    //ELKIN-E
                                    $fill = !$fill;
                                    $tr = $fill ? "class=interlace" : "";
                                    echo "<tr $tr>";
                                    echo "<td class=\"col_complexity\" width=4%><a href='#' title='$complexity_tt'>$icons</a></td>";
                                    echo "<td width=10% class='job-add' task_id=$task_id par_number=$pars><a href='#' title='$jobs_new[caption_tt]'>$value[caption]</a></td>";
                                    echo "<td width=43% class='job-descr hover_on_white' task_id=$task_id><a href='$descr_link' target=_new title='$jobs_new[description_tt]'>$descr</a></td>";
                                    echo "<td width=43%>$rem</td>";
                                    echo "</tr>";
                                    //ELKIN-B
                                }
                                //ELKIN-E
                            }
                            ?>
                        </tbody>
                        <tr><td <?php echo "colspan=$cols"; ?> ><hr></td></tr>
                        <tr><td <?php echo "colspan=$cols"; ?> class=hover_on_white><a href='#'> <?php echo "$jobs_new[jobs_new_note]"; ?> </a></td></tr>
                    </table>

                </TD></TR>
        </table>


    </body>
</html>