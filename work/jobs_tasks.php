 <html>
 <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
$context['level']=1; $pp="..";
$url="$pp/{$_GET['url']}";
require "$pp/php/common.php";
echo "<script language='JavaScript' type='text/javascript'>sweet_home='$sweet_home';  level='$context[level]';</script>";	//fwd var to js
echo "<script language='JavaScript' src='$pp/js/common.js' type='text/javascript'></script>";
echo "<script language='JavaScript' src='$pp/js/countries.js' type='text/javascript'></script>";
echo "<link rel='shortcut icon' href='$pp/skin/favicon.ico'>";
echo "<link href='$pp/css/common.css' rel='stylesheet' type='text/css' />";
//lang-dependent:
require "$pp/lang/$context[lang]/msg.inc.php";
echo "<script language='JavaScript' src='$pp/lang/$context[lang]/menu.js' type='text/javascript'></script>";
//jquery:
echo "<link type='text/css' href='$pp/css/jquery/themes/smoothness/jquery-ui-1.7.2.custom.css' rel='stylesheet' />";
echo "<script type='text/javascript' src='$pp/js/jquery/jquery-1.3.2.min.js'></script>";
echo "<script type='text/javascript' src='$pp/js/jquery/ui/jquery-ui-1.7.2.custom.min.js'></script>";
?>

<script type="text/javascript">

<?php
echo "warn_length='$reg_form[warn_length]';"; 
echo "warn_digits_only='$reg_form[warn_digits_only]';"; 
echo "warn_symbols = '$reg_form[warn_symbols]';";
echo "warn_no_sel= '$tasks_form[no_sel_warning]';";
echo "warn_number='$reg_form[warn_number]';";
echo "warn_date_fromat='$tasks_form[warn_date_fromat]';";
?>

var rexName=new RegExp("^[^\\<|\\>|\\\"|\\'|\\%|\\;|\\&|\\-|\\.|\\@|\\,|\\!|\\?|\\#|\\*|\\~|\\=|\\^|\\:|\\`]+$", "i");
var rexApp=new RegExp("^([0-9a-zA-Z_\.])+$","i");
var rexDigits=new RegExp("\\d","i");
var rexNumber=new RegExp("^[-+]?[0-9]*\.?[0-9]+([eE][-+]?[0-9]+)?$","i");
var rexDate=new RegExp("^([0-9\-])+$","i");

$(document).ready(function() {
//     $(function(){
       
var app_name = $("#app_name"),
    caption = $("#caption"), 
    par_numb = $("#par_numb"), 
    task_status = $("#task_status"),
    popularity = $("#popularity"),
    complexity = $("#complexity"),
    sequence = $("#sequence"),
    description_en = $("#description_en"),
    remark_en = $("#remark_en"),
    description_ru = $("#description_ru"),
    remark_ru = $("#remark_ru"),
    task_id = $("#task_id"),
    oper=$("#oper"),
    newrec=$("#newrec"),
    params_oper=$("#params_oper"),
    params_task_id=$("#params_task_id"),
    params_newrec=$("#params_newrec"),
    uuid = $("#uuid"),              
    allFields = $([]).add(app_name).add(caption).add(par_numb).add(task_status).add(popularity).add(complexity).add(sequence).add(description_en).add(remark_en).add(description_ru).add(remark_ru).add(task_id).add(oper).add(newrec).add(uuid),
    someFields = $([]).add(task_id).add(oper).add(uuid),
    paramsFields=$([]).add(params_task_id).add(params_oper).add(params_newrec).add(uuid),
    tips = $("#validateTips"),
    tipsparams= $("#validateTipsParams");
            
function warnUser(t) {alert(t);}
function updateTips(t) {tips.text(t).effect("highlight",{},1500);}
function updateTipsNew(t,o) {o.text(t).effect("highlight",{},1500);}

function checkLength(o, n, min, max) //TO DO: replace with new version
{
	 if ( o.val().length >= min && o.val().length <= max )  {return true;}
	 o.addClass('ui-state-error');
	 if (min==max) t=warn_length + " : "+min;
	 else t=warn_length + " : "+min+" - "+max;
	 updateTips(n +" -> "+t);
	 return false;
}
function checkRegexp(o, regexp, n, t)  //TO DO: replace with new version
{
	if (regexp.test( o.val())) {return true;}
	o.addClass('ui-state-error');
	updateTips(n +" -> "+t);
	return false;
}
function checkRegexpNew(o, regexp, n, t,otips) 
{
	if (regexp.test( o.val())) {return true;}
	o.addClass('ui-state-error');
	updateTipsNew(n +" -> "+t,otips);
	return false;
}
function checkLengthNew(o, n, min, max,otips) 
{
	 if (o.val().length >= min && o.val().length <= max )  {return true;}
	 o.addClass('ui-state-error');
	 if (min==max) t=warn_length + " : "+min;
	 else t=warn_length + " : "+min+" - "+max;
	 updateTipsNew(n +" -> "+t,otips);
	 return false;
}
function checkNums(odef, omin, omax, otips)
{       	    
    var s;
    s=odef.val();   var vdef = parseFloat(s);	//odef.val());	//isNaN(x)
    s=omin.val();   var vmin = parseFloat(s);	//omin.val());
    s=omax.val(); var vmax = parseFloat(s);	//omax.val());       	    
    if (vmin > vmax) {omin.addClass('ui-state-error'); omax.addClass('ui-state-error'); updateTipsNew("Min > Max",otips); return false;}
    if ((vdef > vmax) || (vdef < vmin)) {odef.addClass('ui-state-error'); updateTipsNew("Def vs [Min-Max]",otips); return false;}
    return true;
}
function checkDate(omin,otips)
{
  var s=omin.val(); 
  var a=s.split("-",3);
  if (a.length!=3) {omin.addClass('ui-state-error'); omin.addClass('ui-state-error'); updateTipsNew("Format: YYYY-MM-DD",otips); return false;}
  today = new Date();
  project=new Date(2008,8,1);
  param=new Date(a[0],parseInt(a[1],10)-1,parseInt(a[2],10));	//js months => 0...11!!!
  if (param < project) {omin.addClass('ui-state-error'); omin.addClass('ui-state-error'); updateTipsNew("Min < 2008-08-01",otips); return false;}
  if (param > today)  {omin.addClass('ui-state-error'); omin.addClass('ui-state-error'); updateTipsNew("Min > today",otips); return false;}
  return true;    		
}

			
$('#modify').dialog({
  autoOpen: false,
  width: 350,
  position: 'center',
  modal:true,
  buttons:  
  {    
    <?php echo "$tasks_form[button_ok]";?> : function() 
    {
      var bValid = true;
      allFields.removeClass('ui-state-error');

      sField=$('#caption_caption').html();
      bValid = bValid && checkLength(caption,sField,3,64);
      bValid = bValid && checkRegexp(caption,rexName,sField,warn_symbols);

      sField=$('#app_name_caption').html();
      bValid = bValid && checkLength(app_name,sField,3,64);
      bValid = bValid && checkRegexp(app_name,rexApp,sField,warn_symbols);

      sField=$('#par_number_caption').html();
      bValid = bValid && checkLength(par_numb,sField,1,2);	
      bValid = bValid && checkRegexp(par_numb,rexDigits,sField,warn_digits_only);

      sField=$('#status_caption').html();
      bValid = bValid && checkLength(task_status,sField,1,2);
      bValid = bValid && checkRegexp(task_status,rexDigits,sField,warn_digits_only);

      sField=$('#popularity_caption').html();
      bValid = bValid && checkLength(popularity,sField,1,3);
      bValid = bValid && checkRegexp(popularity,rexDigits,sField,warn_digits_only);

      sField=$('#complexity_caption').html();
      bValid = bValid && checkLength(complexity,sField,1,2);
      bValid = bValid && checkRegexp(complexity,rexDigits,sField,warn_digits_only);

      sField=$('#sequence_caption').html();
      bValid = bValid && checkLength(sequence,sField,1,4);
      bValid = bValid && checkRegexp(sequence,rexDigits,sField,warn_digits_only);

      sField=$('#description_en_caption').html();
      bValid = bValid && checkLength(description_en,sField,10,1024);
      sField=$('#description_ru_caption').html();
      bValid = bValid && checkLength(description_ru,sField,10,1024);
      /*
      sField=$('#remark_en_caption').html();
      bValid = bValid && checkLength(remark_en,sField,10,1024);
      sField=$('#remark_ru_caption').html();
      bValid = bValid && checkLength(remark_ru,sField,10,1024);
      */

      bNew= newrec.val();
      if (bNew==0)
			{
        var r=$('input:radio[name=task_sel]:checked');
        m = r.val();
			  if (isNaN(m)) bValid=false;
        else 
        {
        	task_id.val(m);
          var dr=description_en.val(); r.attr('description_en',dr);
              dr=description_ru.val(); r.attr('description_ru',dr);
              dr=remark_en.val();      r.attr('remark_en',dr);
              dr=remark_ru.val();      r.attr('remark_ru',dr);
        }
			}
              
			if (bValid) 
			{
				oper.val("modify");

				var u=my_getcookie("uuid");
				uuid.val(u);                  

        cap_new=caption.val();
        app_new=app_name.val();
        par_new =par_numb.val()
        task_new=task_status.val();
        pop_new=popularity.val();
        com_new=complexity.val();
        seq_new=sequence.val();

        $.post("tasks.php", allFields, function(data) 
        {
          $('#task_id').val(data);
          if ((bNew==1) && (data > 0))	//if new record added successfully
          {
						 var selTag=$('#tasks_listall tbody:last').prev();
						 selTag.append('<tr>' +
						 '<td><input type=radio name=\'task_sel\' id=\'task_sel\' value='+data+'></td>' + 
						 '<td>' + cap_new + '</td>' + 
						 '<td>' + data + '</td>' +
						 '<td>' + app_new + '</td>' + 
						 '<td>' + par_new + '</td>' + 
						 '<td>' + task_new + '</td>' + 
						 '<td>' + pop_new + '</td>' + 
						 '<td>' + com_new + '</td>' + 
						 '<td>' + seq_new + '</td>' + 
						 '</tr>');
							$('input:radio').removeAttr('checked');
							$('#tasks_listall').change();
					}
          else if (data > 0)	//if modified successfully
          {
           		var selTag=$("input:radio[name=task_sel]:checked").parent();
							selTag = selTag.next('td'); selTag.html(cap_new);
							selTag = selTag.next('td'); selTag.html(data);
							selTag = selTag.next('td'); selTag.html(app_new);
							selTag = selTag.next('td'); selTag.html(par_new);
							selTag = selTag.next('td'); selTag.html(task_new);
							selTag = selTag.next('td'); selTag.html(pop_new);
							selTag = selTag.next('td'); selTag.html(com_new);
							selTag = selTag.next('td'); selTag.html(seq_new);
          }
				},
				"text");
				$(this).dialog('close');
			}
		},
		<?php echo "$tasks_form[button_cancel]";?>: function() {$(this).dialog('close');}
	}, //buttons
	close: function() 
	{
	  //allFields.val('').removeClass('ui-state-error');  //13.02.2012 15:19:39
	  allFields.removeClass('ui-state-error');
	}
});

      $("#delete").dialog({
			  autoOpen: false,
			  resizable: false,
			  width: 350,
			  height:200,
			  modal: true,
			  overlay: {
			   backgroundColor: '#000',
			   opacity: 0.5
			  },
			  buttons: 
			  {
				<?php echo "'{$tasks_form[button_del]}'"; ?>: function() 
				{
				  oper.val("delete");
				  var u=my_getcookie("uuid");
				  uuid.val(u);                  
				  m = $('input:radio[name=task_sel]:checked').val();
				  if (!isNaN(m))
				  {
				     task_id.val(m);
				     $.post("tasks.php", someFields, function(data) 
					 {
				       if (data > 0)	//if deleted successfully
				       {
					     var selTag=$("input:radio[name=task_sel]:checked").parent().parent();
					     selTag.remove();
				       }
					 },"text");
				  };
				  $(this).dialog('close');
				},
			    <?php echo "$tasks_form[button_cancel]";?>: function() {$(this).dialog('close');}
			  }
		  });

		$('#params').dialog({
				autoOpen: false,
				width: 650,
				position: 'center',
				modal:true,
				buttons:  {
				    
				   <?php echo "$tasks_form[button_ok]";?> : function() {
				   var bValid = true;

                <?php echo "scap='$params_form[caption]';";?>
                <?php echo "sname='$params_form[name]';";?>
                <?php echo "stype='$params_form[type]';";?>
                <?php echo "sdef='$params_form[def_val]';";?>
                <?php echo "smin='$params_form[min_val]';";?>
                <?php echo "smax='$params_form[max_val]';";?>
				   
				   var i, ptype,n=par_numb.val();
					var selTag=$('#params_form :input');
					selTag.removeClass('ui-state-error');

				   for (i=0; i<n; i++)
				   {
				     	sField=scap;  sel=$("#params_caption_"+i);
				       bValid = bValid && checkLengthNew(sel,sField,3,32,tipsparams);
				       bValid = bValid && checkRegexpNew(sel,rexName,sField,warn_symbols,tipsparams);						
						if (!bValid) break;

						sField=sname;  sel=$("#params_name_"+i);
				       bValid = bValid && checkLengthNew(sel,sField,3,16,tipsparams);
				      bValid = bValid && checkRegexpNew(sel,rexApp,sField,warn_symbols,tipsparams);
						if (!bValid) break;
						
						sField=stype;  sel=$("#params_type_"+i);			ptype=sel.val();
				        bValid = bValid && checkLengthNew(sel,sField,1,3,tipsparams);
				        bValid = bValid && checkRegexpNew(sel,rexDigits,sField,warn_digits_only,tipsparams);
						if (!bValid) break;
				       						
						sField=sdef;  sel=$("#params_def_"+i);
				       if (ptype==1) 
				       {
				           bValid = bValid && checkLengthNew(sel,sField,1,32,tipsparams);
				           bValid = bValid && checkRegexpNew(sel,rexName,sField,warn_symbols,tipsparams);
				       }
				       else  if (ptype==0) 
				       	{
				          bValid = bValid && checkLengthNew(sel,sField,1,32,tipsparams);
				      	   bValid = bValid && checkRegexpNew(sel,rexNumber,sField,warn_number,tipsparams);
				      	 }
				        else {sel.empty(); sel.val("");}
						 if (!bValid) break;
						
						 sField=smin;  sel=$("#params_min_"+i);
						 if (ptype==0) //numeric
						 {
				           bValid = bValid && checkLengthNew(sel,sField,1,32,tipsparams);
				           bValid = bValid && checkRegexpNew(sel,rexNumber,sField,warn_number,tipsparams);
				        }
						 else if (ptype==2) //from date (time=0)
						 {
				           bValid = bValid && checkLengthNew(sel,sField,10,10,tipsparams);
				           bValid = bValid && checkRegexpNew(sel,rexDate,sField,warn_date_fromat,tipsparams);
    				    	 bValid = bValid && checkDate(sel,tipsparams);
				        }
				        else {sel.empty(); sel.val("");}
						if (!bValid) break;
						
						sField=smax;  sel=$("#params_max_"+i);
						 if (ptype==0) 
						 {
				           bValid = bValid && checkLengthNew(sel,sField,1,32,tipsparams);
				           bValid = bValid && checkRegexpNew(sel,rexNumber,sField,warn_number,tipsparams);
				        }
				        else {sel.empty(); sel.val("");}
						if (!bValid) break;

    				    if (ptype==0) 
    				    {
    				    	sel_def=$("#params_def_"+i);
    				    	sel_min=$("#params_min_"+i);
    				    	sel_max=$("#params_max_"+i);
    				    	bValid = bValid && checkNums(sel_def,sel_min,sel_max,tipsparams);
    				    }
						if (!bValid) break;    				    
				   }
				   if (bValid) 
				   {
					   m = $('input:radio[name=task_sel]:checked').val();
					   if (isNaN(m)) bValid=false;
					   else params_task_id.val(m);
			          params_oper.val("modify");

				  var u=my_getcookie("uuid");
				  uuid.val(u);                  

					   n_taskpars=0;
                     var fields = $("#params :input").serializeArray();
					   $.post("taskpars.php", fields, function(data)
					   {
						   aret=eval(data);
						   if (aret[0].par_number>0) alert("Saved OK"); 	//TO DO better: ==params_number
					   },"text");
				       $(this).dialog('close');
				   };
				},
				<?php echo "$tasks_form[button_cancel]";?>: function() {$(this).dialog('close');}
				}
			});

     //event (button click) handlers ----------------------------------------------------------------------

$('#task-modify').click(function() 
{
  m = $('input:radio[name=task_sel]:checked').val();
  if (isNaN(m)) alert(warn_no_sel);
  else
  {
    $('#newrec').val(0);
    $('#modify').dialog('open');

    //now init the dialogue fields with the values of the table:
    var r=$("input:radio[name=task_sel]:checked");
    var selTag=r.parent();
    selTag = selTag.next('td'); c=selTag.html(); $('#caption').val(c);
    selTag = selTag.next('td'); v=selTag.html(); $('#task_id').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#app_name').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#par_numb').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#task_status').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#popularity').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#complexity').val(v);
    selTag = selTag.next('td'); v=selTag.html(); $('#sequence').val(v);
           
    var dr=r.attr("description_en"); $('#description_en').val(dr);
        dr=r.attr("description_ru"); $('#description_ru').val(dr);
        dr=r.attr("remark_en");      $('#remark_en').val(dr);
        dr=r.attr("remark_ru");      $('#remark_ru').val(dr);
           
     $('#modify').dialog('option', 'title', c);
	}
})
.hover(function(){ $(this).addClass("ui-state-hover");},function(){ $(this).removeClass("ui-state-hover"); })
.mousedown(function(){$(this).addClass("ui-state-active");})
.mouseup(function(){$(this).removeClass("ui-state-active");});

$('#task-add').click(function() 
{
  //clear all and init the dialogue fields with some default values
	allFields.val('').removeClass('ui-state-error');  //13.02.2012 15:19:39  
	$('#par_numb').val(10);
  $('#task_status').val(0);
  $('#popularity').val(0);
  $('#complexity').val(0);
  $('#complexity').val(1000);

  $('#newrec').val(1);
  $('#modify').dialog('open');
})
.hover(function(){ $(this).addClass("ui-state-hover");},function(){ $(this).removeClass("ui-state-hover"); })
.mousedown(function(){$(this).addClass("ui-state-active");})
.mouseup(function(){$(this).removeClass("ui-state-active");});				
     
	  $('#task-delete')
	    .click(function() {
		  m = $('input:radio[name=task_sel]:checked').val();
		  if (isNaN(m)) alert(warn_no_sel); 
		  else
		  	{
           var selTag=$("input:radio[name=task_sel]:checked").parent();
           selTag = selTag.next('td'); c=selTag.html(); $('#caption').val(c);
           $('#delete').dialog('option', 'title', c);	  		
	    	$('#delete').dialog('open');
	       }
	    })
		.hover(function(){ $(this).addClass("ui-state-hover");},function(){ $(this).removeClass("ui-state-hover"); })
		.mousedown(function(){$(this).addClass("ui-state-active");})
		.mouseup(function(){$(this).removeClass("ui-state-active");});				

	  $('#task-params')
	    .click(function() {
		    m = $('input:radio[name=task_sel]:checked').val();
		    if (isNaN(m)) alert(warn_no_sel); 
		    else
		    {
           	 var selTag=$("input:radio[name=task_sel]:checked").parent();
				selTag = selTag.next('td'); c = selTag.html();	//caption
				selTag = selTag.next('td'); //selTag.html(data);
				selTag = selTag.next('td'); //selTag.html(app_new);
				selTag = selTag.next('td'); p= selTag.html();	//parameters

               if (p>0 && p<100)
               {
				  var n_taskpars=0;
				  var aret= new Array();
                  caption.val(c);
                  par_numb.val(p);
		    	  params_task_id.val(m);
                  params_oper.val("load");
				  
				  $.post("taskpars.php", paramsFields, function(data, textStatus)
		          {
					  //alert (textStatus); // , textStatus
					  aret = eval(data);	 //if doesn't work - make it this way:eval('(' + data + ')');
					  n_taskpars=aret.length;
					  p=par_numb.val();
					  if (n_taskpars==0) option=0;	//create new
					  else if (n_taskpars==p) option=1;	//edit existing list
					  else if (p>n_taskpars) {option=2; alert("You are going to append the parameters list");}
					  else if (p<n_taskpars) {option=3; alert("You are going to truncate the parameters list");}
					  else option=0;

					  var selTag=$('#params_form tbody');
					  selTag.empty(); 
					  for (i=0; i<p; i++)
					  {
						  if (option==1 || (option==2 && i<n_taskpars))
						  {
							  pcap='"' + aret[i].caption + '"';
							  pname='"' + aret[i].name + '"';
							  ptype='"' + aret[i].type + '"';
							  pdef='"' + aret[i].def_val + '"';
							  pmin='"' + aret[i].min_val + '"';
							  pmax='"' + aret[i].max_val + '"';
						  }
						  else {pcap = ""; pname = ""; ptype = ""; pdef=""; pmin=""; pmax="";}
						  selTag.append('<tr>' +
							'<td><input type="text" name="params_caption_'+i+'" id="params_caption_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=32 size=64 value='+pcap+'></td>'+
							'<td><input type="text" name="params_name_'+i+'"   id="params_name_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=16 size=32 value='+pname+'></td>'+
							'<td><input type="text" name="params_type_'+i+'"     id="params_type_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=3 size=6 value='+ptype+'></td>'+
							'<td><input type="text" name="params_def_'+i+'"       id="params_def_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=32 size=24 value='+pdef+'></td>'+
							'<td><input type="text" name="params_min_'+i+'"      id="params_min_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=32 size=24 value='+pmin+'></td>'+
							'<td><input type="text" name="params_max_'+i+'"     id="params_max_'+i+'" class="text ui-widget-content ui-corner-all" maxlength=32 size=24 value='+pmax+'></td>'+
							'</tr>');
					  }
		          },"text");	//returns array
 
                 $('#params').dialog('option', 'title', c);
	    	     $('#params').dialog('open');
	    	   }
	       }
	    })
		.hover(function(){ $(this).addClass("ui-state-hover");},function(){ $(this).removeClass("ui-state-hover"); })
		.mousedown(function(){$(this).addClass("ui-state-active");})
		.mouseup(function(){$(this).removeClass("ui-state-active");});				
     });

   </script>


<style type="text/css">
 label, input { display:block; }
 select, input {padding: .4em; }
 select, input { width:95%;}
  fieldset { padding:0; border:0; margin-top:15px; }
  h1 { font-size: 1.2em; margin: .6em 0; }
  div#modify, div#delete, div#params {margin: 15px 0; }
  .ui-button { outline: 0; margin:0; padding: .4em 1em .5em; text-decoration:none;  !important; cursor:pointer; position: relative; text-align: center; }
  .ui-dialog .ui-state-highlight, .ui-dialog .ui-state-error { padding: .3em;  }
</style>	   

 </head>

 <body vlink=black link=black>

<!-- ui-dialogs -->

<?php
echo "<div id='delete' title='{$tasks_form[del_caption]}'>";
echo "<p><span class='ui-icon ui-icon-alert' style='float:left; margin:0 7px 20px 0;'></span>$tasks_form[del_warning]</p>";
echo "</div>";

echo "<div id='modify' title='$tasks_form[title]'>";
echo "<p id='validateTips'>$tasks_form[note]</p>";
?>
<form>
<fieldset>
<input type="hidden" name="oper" id="oper">
<input type="hidden" name="task_id" id="task_id">	
<input type="hidden" name="newrec" id="newrec">	
<table>
<tr><td><label for="caption" id="caption_caption"><?php echo "$tasks_form[caption_caption]";?></label></td><td><input type="text" name="caption" id="caption" class="text ui-widget-content ui-corner-all" maxlength=64 /></td></tr>	
<tr><td><label for="app_name" id="app_name_caption"><?php echo "$tasks_form[app_name_caption]";?></label></td><td><input type="text" name="app_name" id="app_name" class="text ui-widget-content ui-corner-all" maxlength=64 /></td></tr>	
<tr><td><label for="par_numb" id="par_number_caption"><?php echo "$tasks_form[par_number_caption]";?></label></td><td><input type="text" name="par_numb" id="par_numb" class="text ui-widget-content ui-corner-all"  maxlength=2 /></td></tr>  
<tr><td><label for="task_status" id="status_caption"><?php echo "$tasks_form[status_caption]";?></label></td><td><input type="text" name="task_status" id="task_status" class="text ui-widget-content ui-corner-all"  maxlength=2 /></td></tr>
<tr><td><nobr><label for="popularity" id="popularity_caption"><?php echo "$tasks_form[popularity_caption]";?></label></nobr></td><td><input type="text" name="popularity" id="popularity"  class="text ui-widget-content ui-corner-all"  maxlength=6 /></td></tr>
<tr><td><nobr><label for="complexity" id="complexity_caption"><?php echo "$tasks_form[complexity_caption]";?></label></nobr></td><td><input type="text" name="complexity" id="complexity"  class="text ui-widget-content ui-corner-all"  maxlength=6 /></td></tr>
<tr><td><nobr><label for="sequence" id="sequence_caption"><?php echo "$tasks_form[sequence_caption]";?></label></nobr></td><td><input type="text" name="sequence" id="sequence"  class="text ui-widget-content ui-corner-all"  maxlength=6 /></td></tr>

<tr><td><nobr><label for="description_en" id="description_en_caption"><?php echo "$tasks_form[description_en_caption]";?></label></nobr></td><td><input type="text" name="description_en" id="description_en"  class="text ui-widget-content ui-corner-all" /></td></tr>
<tr><td><nobr><label for="remark_en" id="remark_en_caption"><?php echo "$tasks_form[remark_en_caption]";?></label></nobr></td><td><input type="text" name="remark_en" id="remark_en"  class="text ui-widget-content ui-corner-all" /></td></tr>
<tr><td><nobr><label for="description_ru" id="description_ru_caption"><?php echo "$tasks_form[description_ru_caption]";?></label></nobr></td><td><input type="text" name="description_ru" id="description_ru"  class="text ui-widget-content ui-corner-all" /></td></tr>
<tr><td><nobr><label for="remark_ru" id="remark_ru_caption"><?php echo "$tasks_form[remark_ru_caption]";?></label></nobr></td><td><input type="text" name="remark_ru" id="remark_ru"  class="text ui-widget-content ui-corner-all" /></td></tr>
</table>
</fieldset>
</form>
</div>

<?php
echo "<div id='params' title='$params_form[title]'>";
echo "<p id='validateTipsParams'>$params_form[note]</p>";
?>
<form>
<fieldset>
<input type="hidden" name="params_oper" id="params_oper">
<input type="hidden" name="uuid" id="uuid">
<input type="hidden" name="params_task_id" id="params_task_id">	
<input type="hidden" name="params_newrec" id="params_newrec">	
<table name="params_form" id="params_form">
<thead>
<tr>
<td><?php echo "$params_form[caption]";?></td>
<td><?php echo "$params_form[name]";?></td>
<td><?php echo "$params_form[type]";?></td>
<td><?php echo "$params_form[def_val]";?></td>
<td><?php echo "$params_form[min_val]";?></td>
<td><?php echo "$params_form[max_val]";?></td>
</tr>	
</thead>
<tbody>
</tbody>    
</table>
</fieldset>
</form>
</div>


<?php

echo "<table height=100%>";
trHeader();


echo "<TR height=100%><TD class=showcase>";
//container begin
?>

		
<!-- trShowcase -->

<?php
$oper='listall';
$ret=array();
$cols=9;
require "tasks.php";
echo "<table name='tasks_listall' id='tasks_listall'>";
echo "<thead>";
echo "<tr><td colspan=$cols class=page_title>$tasks_form[tasks_editor_title]</td></tr>";
echo "<tr><td colspan=$cols><hr></td></tr>";
echo "<tr class=page_table_header><td>*</td><td>$tasks_txt[caption]</td><td>$tasks_txt[task_id]</td><td>$tasks_txt[app_name]</td><td>$tasks_txt[par_number]</td><td>$tasks_txt[status]</td><td>$tasks_txt[popularity]</td><td>$tasks_txt[complexity]</td><td>$tasks_txt[sequence]</td></tr>";
echo "<tr><td colspan=$cols><hr></td></tr>";
echo "</thead>";
echo "<tbody>";
echo "<form name='tasks_sel' id='tasks_sel'>";
foreach ($ret as $value)
{
  echo "<tr><td><input type=radio name=task_sel id=task_sel value='$value[task_id]' description_en='$value[description_en]' description_ru='$value[description_ru]' remark_en='$value[remark_en]' remark_ru='$value[remark_ru]'></td><td>{$value['caption']}</td><td>{$value['task_id']}</td><td>{$value['app_name']}</td><td>{$value['par_number']}</td><td>{$value['status']}</td><td>{$value['popularity']}</td><td>{$value['complexity']}</td><td>{$value['sequence']}</td></tr>";
}
echo "</form>";
echo "</tbody>";
echo "<tr><td colspan=$cols><hr></td></tr>";
echo "</table>";
?>

<table width=100% cellpadding=25px><tr><td><nobr><div>
<button id="task-add" class="ui-button ui-state-default ui-corner-all"><?php echo "$tasks_form[button_add]"; ?></button>
<button id="task-modify" class="ui-button ui-state-default ui-corner-all"><?php echo "$tasks_form[button_modify]"; ?></button>
<button id="task-delete" class="ui-button ui-state-default ui-corner-all"><?php echo "$tasks_form[button_delete]"; ?></button>
<button id="task-params" class="ui-button ui-state-default ui-corner-all"><?php echo "$tasks_form[button_params]"; ?></button>
 </div></nobr></td></tr></table>

<?php
//container end
echo "</TD></TR>";

trFooter();
echo "</table>";
?>

<!-- TO DO: create lang/dependent page title -->
 <script language="JavaScript" type="text/javascript">
    var t = document.createElement("title");
    t.innerHTML="Livni: tasks: edit";
    document.getElementsByTagName("head")[0].appendChild(t);
</script>

 </body>
 </html>
