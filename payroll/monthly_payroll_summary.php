<?
	$getAllColumn = getAllowandDeductColumns();
	$Activecolumns = getColumnforPayroll();


  	$emptyCols = array();
  	$emptyColsG = array();

  	/*if(isset($Activecolumns) && is_array($Activecolumns)){
		foreach($getAllColumn as $k1=>$v1){
			foreach($v1 as $k=>$v){
				if(!in_array($v['id'], $Activecolumns)){
					$emptyColsG[$k1][] = $v['id'];
					$emptyCols[] = $v['id'];
				}
			}
		}

		$getAllowandDeductColumns = $emptyColsG;
	}else{*/

		$getAllowandDeductColumns = $getAllColumn;
	//}


	// echo '<pre>';
	// print_r($getAllowandDeductColumns);
	// print_r($Activecolumns);
	// echo '</pre>';
	// exit();

	// echo json_encode($emptyCols);

?>
<style type="text/css">
	::-webkit-scrollbar {
	    width: 6px;
	    height: 15px !important;
	}
</style>
<h2 style="padding-right:60px">
	<i class="fa fa-cog"></i>&nbsp; <?=$lng['Monthly Payroll Summary']?>
	<!-- <span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span> -->
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>
		
			<div class="row">
				<div class="col-md-2">
					<!-- <select multiple="multiple" id="showCols" style="height:18px !important">
					<? 
					/*$attCols = array();
					foreach($getAllowandDeductColumns as $k1=>$v1){
					 	foreach($v1 as $k=>$v){
					 		$attCols[$v['id']] = $v[$lang];
							echo '<option class="optCol" value="'.$v['id'].'" ';
							if(in_array($v['id'], $Activecolumns)){echo 'selected ';}
							echo '>'.$v[$lang].'</option>';
					} } */?>
					</select> -->
				</div>
				<div class="col-md-8"></div>
				<div class="col-md-2">
					<button type="button" onclick="window.history.go(-1); return false;" class="btn btn-primary btn-fr">
						<?=$lng['Go back']?>
					</button>
				</div>
			</div>
					
			<table id="datatable" class="dataTable hoverable selectable attendance nowrap">
				<thead>
					<tr class="xlhnormal">
						<th></th>
						<th class="tac" colspan="4"><?=$lng['Employee']?></th>	

						<?if(is_array($getAllowandDeductColumns['inc_sal'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['inc_sal'])?>"><?=$lng['Salary']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['inc_ot'])){ ?>			
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['inc_ot'])?>"><?=$lng['Overtime']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['inc_fix'])){ ?>	
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['inc_fix'])?>"><?=$lng['Fixed income']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['inc_var'])){ ?>	
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['inc_var'])?>"><?=$lng['Variable income']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['inc_oth'])){ ?>	
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['inc_oth'])?>"><?=$lng['Other income']?></th>
						<? } ?>

						
						<th class="tac" colspan="1" style="background: #a9d08e"><?=$lng['Total']?></th>

						

						<?if(is_array($getAllowandDeductColumns['ded_abs'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_abs'])?>"><?=$lng['Absence']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['ded_fix'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_fix'])?>"><?=$lng['Fixed deductions']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['ded_var'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_var'])?>"><?=$lng['Variable deductions']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['ded_leg'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_leg'])?>"><?=$lng['Legal deductions']?></th>
						<? } ?>

						<?if(is_array($getAllowandDeductColumns['ded_pay'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_pay'])?>"><?=$lng['Advance payment']?></th>
						<? } ?>
						
						<?if(is_array($getAllowandDeductColumns['ded_oth'])){ ?>
							<th class="tac" colspan="<?=count($getAllowandDeductColumns['ded_oth'])?>"><?=$lng['Other deductions']?></th>
						<? } ?>

						<th class="tac" colspan="1" style="background: #f8cbad"><?=$lng['Total']?></th>

						<th class="tac" colspan="1" style="background: #bdd7ee"><?=$lng['Net']?></th>

					</tr>
					<tr>
						<th class="par30"><?=$lng['ID']?></th>
						<th class="tal par30"><?=$lng['Employee name']?></th>
						<th class="tac" data-searchable="false" data-sortable="false">
							<i data-toggle="tooltip" title="Calculator" class="fa fa-calculator fa-lg"></i>
						</th>
						<th class="tac" data-searchable="false" data-sortable="false">
							<i data-toggle="tooltip" title="Payslip" class="fa fa-product-hunt fa-lg"></i>
						</th>
						<th class="tal" data-searchable="false" data-sortable="false"><?=$lng['Days']?></th>
						<!-- <th class="tal"><?=$lng['Salary']?></th> -->

						<?foreach($getAllowandDeductColumns['inc_sal'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['inc_ot'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>
						
						<?foreach($getAllowandDeductColumns['inc_fix'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['inc_var'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['inc_oth'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						
						<th data-searchable="false" data-sortable="false" style="background: #a9d08e"><?=$lng['Earnings']?></th>

						

						<?foreach($getAllowandDeductColumns['ded_abs'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['ded_fix'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['ded_var'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['ded_leg'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['ded_pay'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<?foreach($getAllowandDeductColumns['ded_oth'] as $k => $v){ ?>
							<th data-searchable="false" id="<?=$v['id']?>" data-sortable="false"><?=$v[$lang]?></th>
						<? } ?>

						<th data-searchable="false" data-sortable="false" style="background: #f8cbad;"><?=$lng['Deductions']?></th>
						<th data-searchable="false" data-sortable="false" style="background: #bdd7ee;"><?=$lng['Pay']?></th>
						
						
					</tr>
				</thead>
				<tbody>

					<?php
						// echo '<pre>';
						// print_r($getAllowandDeductColumns);
						// echo '</pre>';
					?>
				
				</tbody>
			</table>


</div>

<script type="text/javascript">

	$(document).ready(function() {

		var tableCols = <?=json_encode($attCols)?>;
		//var eCols = <?=json_encode($Activecolumns)?>;
		var eCols = <?=json_encode($emptyCols)?>;

		//var HideCols = $('#showCols').val();
		
		var dtable = $('#datatable').DataTable({

			scrollX:  true,
			lengthChange:  false,
			searching: true,
			<?=$dtable_lang?>
			columnDefs: [
				{"targets": eCols, "visible": false, "searchable": false}
			]

		});


		var mySelect = $('#showCols').SumoSelect({
			csvDispCount:1,
			outputAsCSV : true,
			showTitle : false,
			placeholder: '<?=$lng['Show Hide Columns']?>',
			captionFormat: '<?=$lng['Show Hide Columns']?>',
			captionFormatAllSelected: '<?=$lng['Show Hide Columns']?>',
		});

		$(".SumoSelect li").bind('click.check', function(event) {
			var nr = $(this).index()+8;
			
			if($(this).hasClass('selected') == true){
				dtable.column(nr).visible(true);
			}else{
				dtable.column(nr).visible(false);
			}
    	})

    	$('select#showCols').on('sumo:closing', function(o) {
			var columns = $(this).val();
			var att_cols = [];
			$.each(columns, function(index, item) {
				//alert(tableCols[item][0])
				att_cols.push({id:item, db:tableCols[item][0], name:tableCols[item][1]})
			})
			$.ajax({
				url: "ajax/save_att_columns.php",
				data: {cols: att_cols},
				success: function(result){
					//$('#dump').html('save_att_columns : '+result);
					
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


	});
</script>