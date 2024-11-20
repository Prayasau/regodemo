<?
	$getOrganizations = getOrganizations();

	$Mynewarray = array();
	foreach ($getOrganizations as $key => $value) {
		$Mynewarray[$value['company']][$value['locations']][$value['divisions']][$value['departments']][] = $value['teams'];	
	}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/orgchart.css">
<style type="text/css">
	select {
	    padding: 0px 2px !important;
	}

	#Showchart .orgchart {
	    box-sizing: border-box;
	    display: inline-block;
	    -webkit-touch-callout: none;
	    -webkit-user-select: none;
	    -khtml-user-select: none;
	    -moz-user-select: none;
	    -ms-user-select: none;
	    user-select: none;
	    background-image: none;
	    background-size: 0px;
	    border: none;
	    padding: 0px;
	}

	#Showchart #chart-container {
	  height: auto;
	  border-radius: 5px;
	  overflow: auto;
	  text-align: center;
	}

	
</style>
<h2 style="padding-right:60px">
	<i class="fa fa-cog fa-mr"></i> <?=$lng['Organization']?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
</h2>

<div class="main">

	<form id="organizeForm">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary btn-fr" id="submitBtn" type="submit"><i class="fa fa-save fa-mr"></i><?=$lng['Update']?></button>
				<button class="btn btn-info btn-fr" type="button" onclick="Showchartmdl();"><?=$lng['Show Chart']?></button>
			</div>
		</div>
		
		<table class="basicTable" id="organizeTable" border="0">
			<thead>
				<tr>
					<th style="min-width:20%"><?=$lng['Apply']?></th>
					<th style="min-width:20%"><?=$lng['Company']?></th>
					<? unset($parameters[5]);
					foreach($parameters as $key1 => $val1){
						if($val1['apply_param'] == 1){ ?>
							<th style="width:20%"><?=$val1[$lang]?></th>
					<? } } ?>

				</tr>
			</thead>
			<tbody>

				<? foreach($getOrganizations as $key => $row){
						if($row['apply'] == 1){ $check = 'checked';}else{ $check = '';} ?>

					<tr>
						<td>
							<input class="ml-3" type="checkbox" onclick="Applyorganization(this, <?=$row['id']?>)" id="org<?=$row['id']?>" value="<?=$row['apply']?>" <?=$check?>>
						</td>
						<td><span class="p-2"><?=$entities[$row['company']][$lang]?></span></td>
						<? if($parameters[1]['apply_param'] == 1){ ?>
							<td><span class="p-2"><?=$branches[$row['locations']][$lang]?></span></td>
						<? } ?>
						<? if($parameters[2]['apply_param'] == 1){ ?>
							<td><span class="p-2"><?=$divisions[$row['divisions']][$lang]?></span></td>
						<? } ?>
						<? if($parameters[3]['apply_param'] == 1){ ?>
							<td><span class="p-2"><?=$departments[$row['departments']][$lang]?></span></td>
						<? } ?>
						<? if($parameters[4]['apply_param'] == 1){ ?>
							<td><span class="p-2"><?=$teams[$row['teams']][$lang]?></span></td>
						<? } ?>
					</tr>

				<? } ?>
			
			</tbody>
		</table>

		<button class="btn btn-primary btn-sm mt-2" id="Addmorerows" type="button"><i class="fa fa-plus fa-mr"></i><?=$lng['Add row']?></button>
		
	</form>

	<?php
	
	$chartflow = "'name': 'Entity #1',
					    'title': 'Company',
					    'children': [ ";
	$chartData = array();
	foreach ($getOrganizations as $key => $value) {

		$chartflow .= " { 'name': '".$branches[$value['locations']][$lang]."', 'title': 'Location',
				         'children': [   
				            { 'name': '".$divisions[$value['divisions']][$lang]."', 'title': 'Division',
				             'children': [
				                { 'name': '".$departments[$value['departments']][$lang]."', 'title': 'Department',
				                	'children': [
						                { 'name': '".$teams[$value['teams']][$lang]."', 'title': 'Team' },
						            ]
				                }
				             ]
				            }
				          ]
				        },";
	}

	$chartflow .= " ]";



	$chartflow1 = '';
	$chartflow1Arr = array();
	foreach ($Mynewarray as $key => $value) {

		$chartflow1 .= "'name': '".$entities[$key][$lang]."',
					    'title': 'Company',
					    'children': [ ";
					    	foreach ($value as $k => $v) {

					    		$chartflow1 .= " { 'name': '".$branches[$k][$lang]."', 'title': 'Location', ";

					    		$chartflow1 .= " 'children': [ ";

					    			foreach ($v as $k1 => $v1) {
	           							$chartflow1 .= " { 'name': '".$divisions[$k1][$lang]."', 'title': 'Division', ";

	           								$chartflow1 .= " 'children': [ ";

								    			foreach ($v1 as $k2 => $v2) {
				           							$chartflow1 .= " { 'name': '".$departments[$k2][$lang]."', 'title': 'Department', ";

				           								$chartflow1 .= " 'children': [ ";

											    			foreach ($v2 as $k3 => $v3) {
							           							$chartflow1 .= " { 'name': '".$teams[$v3][$lang]."', 'title': 'Team', ";

							           							$chartflow1 .= " }, ";
							           						}

						           						$chartflow1 .= " ] ";
				           							

				           							$chartflow1 .= " }, ";
				           						}

			           						$chartflow1 .= " ] ";


	           							$chartflow1 .= " }, ";
	           						}

           						$chartflow1 .= " ] ";

					    		$chartflow1 .= " }, ";
					    	}
		$chartflow1 .=	" ], ";

		$chartflow1Arr[] = $chartflow1;
		
	}

?>

	
</div>

<div class="modal fade" id="Showchart" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog" role="document" style="min-width: 900px;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><img class="mr-2" src="../assets/images/icons8-flow-chart-50.png" style="display: inline-flex;
    width: 23px">&nbsp;<?=$lng['Chart view']?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
					
						<div id="chart-container"></div> 

					</div>
				</div>				
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" style="float:right" class="btn btn-primary" type="button"><?=$lng['Cancel']?></button>
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript">

function Showchartmdl(){

	$('#Showchart').modal('toggle');

}

function Applyorganization(that, rowid){

	if($(that).is(':checked')){
		var valchk = 1;
	}else{
		var valchk = 0;
	}

	$.ajax({
			url: "company/ajax/apply_organization.php",
			type: 'POST',
			data: {rowid: rowid, valchk: valchk},
			success: function(result){

				$("body").overhang({
					type: "success",
					message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
					duration: 2,
					callback: function(value){
						window.location.reload();
					}
				})

			}
		});
}



$("#Addmorerows").click(function(e){ 

	var row ='<tr>';
				row +='<td>';
					row +='<input class="ml-3" type="checkbox" name="apply" value="1" checked>';
					row +='</td>';
				row +='<td>';
					row +='<select name="company[]" style="width:100%">';
							<? foreach($entities as $k => $v){ ?>
								row += '<option value="<?=$v['ref']?>"><?=$v[$lang]?></option>';
							<? } ?>
						row += '</select>';
					row +='</td>';
					<? if($parameters[1]['apply_param'] == 1){ ?>
						row +='<td>';
							row +='<select name="location[]" style="width:100%">';
								<? foreach($branches as $k => $v){ ?>
									row +='<option value="<?=$v['ref']?>"><?=$v[$lang]?></option>';
								<? } ?>
							row +='</select>';
						row +='</td>';
					<? } ?>
					<? if($parameters[2]['apply_param'] == 1){ ?>
						row +='<td>';
							row +='<select name="divisions[]" style="width:100%">';
								<? foreach($divisions as $k => $v){ ?>
									row +='<option value="<?=$v['id']?>"><?=$v[$lang]?></option>';
								<? } ?>
							row +='</select>';
						row +='</td>';
					<? } ?>
					<? if($parameters[3]['apply_param'] == 1){ ?>
						row +='<td>';
							row +='<select name="departments[]" style="width:100%">';
								<? foreach($departments as $k => $v){ ?>
									row +='<option value="<?=$v['id']?>"><?=$v[$lang]?></option>';
								<? } ?>
							row +='</select>';
						row +='</td>';
					<? } ?>
					<? if($parameters[4]['apply_param'] == 1){ ?>
						row +='<td>';
							row +='<select name="teams[]" style="width:100%">';
								<? foreach($teams as $k => $v){ ?>
									row +='<option value="<?=$v['id']?>"><?=$v[$lang]?></option>';
								<? } ?>
							row +='</select>';
						row +='</td>';
					<? } ?>
				row +='</tr>';

		$('#organizeTable tbody').append(row);
});



$("#organizeForm").submit(function(e){ 
		e.preventDefault();
		$("#submitBtn i").removeClass('fa-save').addClass('fa-refresh fa-spin');
		var formData = $(this).serialize();
		$.ajax({
			url: "company/ajax/update_organization.php",
			type: 'POST',
			data: formData,
			success: function(result){
				//$('#dump').html(result); return false;
				$("#submitBtn").removeClass('flash');
				$("#sAlert").fadeOut(200);
				if(result == 'success'){
					$("body").overhang({
						type: "success",
						message: '<i class="fa fa-check"></i>&nbsp;&nbsp;<?=$lng['Data updated successfully']?>',
						duration: 2,
						callback: function(value){
							window.location.reload();
						}
					})

				}else{
					$("body").overhang({
						type: "error",
						message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Error']?> : '+result,
						duration: 4,
					})
				}
				setTimeout(function(){$("#submitBtn i").removeClass('fa-refresh fa-spin').addClass('fa-save');},500);
			},
			error:function (xhr, ajaxOptions, thrownError){
				$("body").overhang({
					type: "error",
					message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
					duration: 4,
				})
			}
		});
	});

	$("#submitBtn").attr('disabled', true);
	
	$('input').on('keyup', function (e) {
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});

	$('#Addmorerows').on('click', function (e) {
		$("#submitBtn").attr('disabled', false);
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});


	$('input[type="checkbox"]').on('click', function (e) {
		$("#submitBtn").addClass('flash');
		$("#sAlert").fadeIn(200);
	});
</script>

<script type="text/javascript" src="../assets/js/orgchart.js"></script>
<script type="text/javascript">
  
(function($) {
  $(function() {
   var ds = { 
   				//'name': 'Rego DEMO 1002','title': 'Company', 'children': '[ {',	
   				<? foreach ($chartflow1Arr as $key => $value) { echo $value; } ?> 
   				//'] }'
   			};

    var oc = $('#chart-container').orgchart({
      'data' : ds,
      'depth': 2,
      'nodeContent': 'title'
    });

  });
})(jQuery);

</script>
   
