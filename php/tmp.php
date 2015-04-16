        <table height=100%>

            <TR height=100%><TD class=showcase>
    <?php            echo pHeader(); ?>
                    <table name='jobs_new_sel' id='jobs_new_sel' cellpadding=2>
                        <div id="errordiv"></div>

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
<?php            echo pFooter(); ?>
                </TD></TR>
        </table>