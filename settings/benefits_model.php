<?
	include('standard_model_array.php');

	$dataRP = getActiveRewardPenalties();
	$getBenefitModels = getBenefitModels();
	$getPayrollModels = getPayrollModels();

	// echo '<pre>';
	// print_r($getBenefitModels);
	// print_r($standard_model_array);
	// echo '</pre>';
	// exit;

?>
<style type="text/css">
	
	table#Standardtbl tbody td {
    	padding: 4px 10px !important;
    }

    table.basicTable tbody th {
    	border-right: 0px !important;
    }

    #tab_Standard table tbody tr td{
    	vertical-align: top;
    }

	::-webkit-scrollbar {
	    width: 6px;
	    height: 15px !important;
	}
</style>
<h2 style="padding-right:60px">
	<i class="fa fa-cog"></i>&nbsp; <?=$lng['Benefits Models']?>
	<span style="display:none; font-style:italic; color:#b00; padding-left:30px" id="sAlert"><i class="fa fa-exclamation-triangle fa-mr"></i><?=$lng['Data is not updated to last changes made']?></span>
</h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<ul class="nav nav-tabs" id="myTab">
		<li class="nav-item"><a class="nav-link active" href="#tab_payroll" data-toggle="tab"><?=$lng['Payroll Models']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_emp_groups" data-toggle="tab"><?=$lng['Employee groups']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_JobQueues" data-toggle="tab"><?=$lng['Job Queues']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_compensations" data-toggle="tab"><?=$lng['Compensations']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_Incentives" data-toggle="tab"><?=$lng['Incentives']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_sal_incre" data-toggle="tab"><?=$lng['Salary Increase']?></a></li>
		<li class="nav-item"><a class="nav-link" href="#tab_Standard" data-toggle="tab"><?=$lng['Standard Models']?></a></li>
	</ul>


	<div class="tab-content" style="height:100%">

		<!------ payroll model start ---------->
		<div class="tab-pane active" id="tab_payroll">
			<div style="float:right;" class="mb-1">
				<button class="btn btn-primary" onclick="AddPayrollMdl();" type="button"><i class="fa fa-plus"></i>&nbsp;<?=$lng['Add Model']?></button>
			</div>
			<table class="basicTable inputs" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th width="20px;"><?=$lng['Apply']?></th>
						<td class="tac"><i class="fa fa-edit fa-lg"></i></td>
						<th><?=$lng['ID']?> #</th>
						<th><?=$lng['Name']?></th>
						
						<th><?=$lng['Description']?></th>
					</tr>
				</thead>

				<tbody>
					<? 
					if(isset($getPayrollModels['PayrollModel'])){
					foreach ($getPayrollModels['PayrollModel'] as $key => $value) { ?>
				
						<tr>
							<td>
								<input type="hidden" name="apply" value="0">
								<input type="checkbox" name="apply" value="<?=$value['apply'];?>" <?if($value['apply'] == 1){echo 'checked="checked"';}?> >
							</td>
							<th>
								<a title="Edit" href="index.php?mn=704&mid=<?=$value['id'];?>" class="editItem" >
									<i class="fa fa-edit fa-lg"></i>
								</a>
							</th>
							<td><?=$value['code'];?></td>
							<td><?=$value['name'];?></td>
							
							<td><?=$value['description'];?></td>
							
						</tr>

					<? } } ?>
				</tbody>
			</table>
		</div>
		<!------ payroll model end ---------->

		<!------ Employee groups start ---------->
		<div class="tab-pane" id="tab_emp_groups">
			Employee groups
		</div>
		<!------ Employee groups end ---------->


		<!------ Job Queues start ---------->
		<div class="tab-pane" id="tab_JobQueues">

			<div style="float:right;" class="mb-1">
				<button class="btn btn-secondary" type="button"><i class="fa fa-plus"></i> <?=$lng['Add Model']?></button>
			</div>
			
			<table class="basicTable inputs" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th width="20px;"><?=$lng['Apply']?></th>
						<td class="tac"><i class="fa fa-edit fa-lg"></i></td>
						<th><?=$lng['ID']?> #</th>
						<th><?=$lng['Name']?></th>
						<th><?=$lng['Type']?></th>
						<th><?=$lng['Description']?></th>
						
						
					</tr>
				</thead>

				<tbody>
					
				</tbody>
			</table>

		</div>
		<!------ Job Queues end ---------->


		<!------ compensations model start ---------->
		<div class="tab-pane" id="tab_compensations">

			<div style="float:right;" class="mb-1">

				<button class="btn btn-primary" onclick="AddrewPenlMdl();"  type="button"><i class="fa fa-plus"></i>&nbsp;<?=$lng['Add Model']?></button>
			</div>
			<table class="basicTable inputs" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th width="20px;"><?=$lng['Apply']?></th>
						<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
							<i class="fa fa-edit fa-lg"></i>
						</td>
						<th><?=$lng['ID']?> #</th>
						<th><?=$lng['Name']?></th>
						<th><?=$lng['Type']?></th>
						<th><?=$lng['Description']?></th>
						
						
					</tr>
				</thead>

				<tbody>
					<? 
					if(isset($getBenefitModels['Compensations'])){
					foreach ($getBenefitModels['Compensations'] as $key => $value) { ?>
				
						<tr>
							<td>
								<input type="hidden" name="apply" value="0">
								<input type="checkbox" name="apply" value="<?=$value['apply'];?>" <?if($value['apply'] == 1){echo 'checked="checked"';}?> >
							</td>
							<th>
								<!-- <a title="Edit" onclick="ShowAllmodeltbl('<?=$value['name'];?>','<?=$value['code'];?>');" class="editItem" >
									<i class="fa fa-edit fa-lg"></i>
								</a> -->
								<a title="Edit" href="index.php?mn=703&mid=<?=$value['id'];?>" class="editItem" >
									<i class="fa fa-edit fa-lg"></i>
								</a>
							</th>
							<td><?=$value['code'];?></td>
							<td><?=$value['name'];?></td>
							<td><?=$value['type'];?></td>
							<td><?=$value['description'];?></td>
							
						</tr>

					<? } } ?>
				</tbody>
			</table>
		</div>
		<!------ compensations end ---------->

		<!------ Incentives start ---------->
		<div class="tab-pane" id="tab_Incentives">

			<div style="float:right;" class="mb-1">
				<button class="btn btn-secondary" type="button"><i class="fa fa-plus"></i> <?=$lng['Add Model']?></button>
			</div>
			
			<table class="basicTable inputs" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th width="20px;"><?=$lng['Apply']?></th>
						<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
							<i class="fa fa-edit fa-lg"></i>
						</td>
						<th><?=$lng['ID']?> #</th>
						<th><?=$lng['Name']?></th>
						<th><?=$lng['Type']?></th>
						<th><?=$lng['Description']?></th>
						
					</tr>
				</thead>

				<tbody>
					
				</tbody>
			</table>

		</div>
		<!------ Incentives end ---------->

		<!------ sal_incre start ---------->
		<div class="tab-pane" id="tab_sal_incre">

			<div style="float:right;" class="mb-1">
				<button class="btn btn-secondary" type="button"><i class="fa fa-plus"></i> <?=$lng['Add Model']?></button>
			</div>
			
			<table class="basicTable inputs" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th width="20px;"><?=$lng['Apply']?></th>
						<td class="tac sorting_disabled" style="width: 18px;" rowspan="1" colspan="1">
							<i class="fa fa-edit fa-lg"></i>
						</td>
						<th><?=$lng['ID']?> #</th>
						<th><?=$lng['Name']?></th>
						<th><?=$lng['Type']?></th>
						<th><?=$lng['Description']?></th>
						
						
					</tr>
				</thead>

				<tbody>
					
				</tbody>
			</table>

		</div>
		<!------ sal_incre end ---------->


		<!------ standard model start ---------->
		<div class="tab-pane" id="tab_Standard">
			<table class="basicTable inputs table-responsive" id="Standardtbl" border="0">
				<thead>
					<tr>
						<th style="width: 10%;"><?=$lng['Name']?></th>
						<th><?=$lng['Description']?></th>
						<th style="width: 5%;"><?=$lng['Type']?></th>
						<th style="width: 5%;"><?=$lng['Related to']?></th>
						<th><?=$lng['Remarks']?></th>
						<!-- <th><?=$lng['View model']?></th> -->
					</tr>
				</thead>
				<tbody>
					<? foreach ($standard_model_array as $key => $value) { ?>
				
						<tr>
							<td><?=$value['name'];?></td>
							<td>
								<?=$value['description'];?>
								<!-- <textarea rows="3"><?=$value['description'];?></textarea> -->
							</td>
							<td><?=$value['type'];?></td>
							<td><?=$value['related_to'];?></td>
							<td>
								<?=$value['remarks'];?>
								<!-- <textarea rows="3"><?=$value['remarks'];?></textarea> -->
							</td>
							<!-- <td>
								<a href="javascript:;" onclick="ShowAllmodeltbl('<?=$value['name'];?>','<?=$value['code'];?>');"><?=ucwords($value['view']);?></a>
							</td> -->
						</tr>

					<? } ?>
				</tbody>
			</table>
		</div>
		<!------ standard model end ---------->

	</div>

</div>
<?
	//include('all_calculation_model.php');
	include('comps_model/model_view.php');
	include('payroll_model/model_list.php');
?>
<script type="text/javascript">

	

	function AddrewPenlMdl(){

		$('#RewPenlModel').modal('toggle');
	}


	function ShowAllmodeltbl(Mname,Mcode){

		$('#myModal table th#mName small').remove();
		$('#myModal table th#mName').html('<small style="font-weight: 600;"> <?=$lng['Code']?>: '+Mcode+'</small><br><small style="font-weight: 600;"> <?=$lng['Modal Name']?>: '+Mname+'</small>');

		$('#myModal table input#mdlName').val(Mname);
		$('#myModal').modal('toggle');
	}

	function AddPayrollMdl(){

		$('#Payroll_modellist').modal('toggle');
	}

	$(document).ready(function() {

		var activeTabPay = localStorage.getItem('activeTabPay');
		if(activeTabPay){
			$('.nav-link[href="' + activeTabPay + '"]').tab('show');
		}else{
			$('.nav-link[href="#tab_payroll"]').tab('show');
		}
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTabPay', $(e.target).attr('href'));
		});

	});

	// $('ul#myTab li a').on('click', function(e){
	// 	var Tname = $(this).text();
	// 	$('#PrevNextScr form#UpdatePopupForm input#myTabname').val(Tname);
	// });

	
</script>