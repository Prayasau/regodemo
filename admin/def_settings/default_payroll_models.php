<?
	$payrollmdl = array();
	$sqlv = "SELECT * FROM rego_payroll_models WHERE apply = '1'";
	if($resv = $dba->query($sqlv)){
		while($rowv = $resv->fetch_assoc()){
			$payrollmdl[] = $rowv;
		}
	}

?>
<h2><i class="fa fa-cogs"></i>&nbsp;&nbsp;<?=$lng['Default'].' '.$lng['Payroll Models']?> <span style="float:right; display:none; font-style:italic; color:#b00" id="sAlert"><?=$lng['Data is not updated to last changes made']?></span></h2>

<div class="main">
	<div style="padding:0 0 0 20px" id="dump"></div>

	<form id="payrollMdlForm" style="height:100%">

		<ul class="nav nav-tabs" id="myTab">
			<li class="nav-item"><a class="nav-link active" data-target="#payrollmdls" data-toggle="tab"><?=$lng['Payroll Models']?></a></li>
		</ul>

		<!-- <button disabled class="btn btn-primary" style="margin:0; position:absolute; top:15px; right:16px;" id="submitbtn" type="submit"><i class="fa fa-save"></i>&nbsp;&nbsp;<?=$lng['Update']?></button> -->

		<div class="tab-content" style="height:calc(100% - 40px)">
				
			<div class="tab-pane active" id="payrollmdls">
				<table class="basicTable" border="0">
					<thead>
						<tr>
							<th width="20px;"><?=$lng['Apply']?></th>
							<td class="tac"><i class="fa fa-edit fa-lg"></i></td>
							<th><?=$lng['ID']?>#</th>
							<th><?=$lng['Name']?></th>
							<th><?=$lng['Description']?></th>
						</tr>
					</thead>
					<tbody>
						<? if(isset($payrollmdl[0])){ 
							foreach($payrollmdl as $value){ ?>
								<tr>
									<td class="tac">
										<input type="hidden" name="apply" value="0">
										<input type="checkbox" name="apply" value="<?=$value['apply'];?>" <?if($value['apply'] == 1){echo 'checked="checked"';}?> >
									</td>
									<th>
										<a title="Edit" href="index.php?mn=102&mid=<?=$value['id'];?>" class="editItem">
											<i class="fa fa-edit fa-lg"></i>
										</a>
									</th>
									<td class="ml-1"><?=$value['code'];?></td>
									<td class="ml-1"><?=$value['name'];?></td>
									<td class="ml-1"><?=$value['description'];?></td>
									
								</tr>
						<? } } ?>
					</tbody>
				</table>
			</div>
		</div>

	</form>
</div>
<script type="text/javascript">
	
	$(document).ready(function() {



		var activeTab = localStorage.getItem('activeTab10');
		$('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
			localStorage.setItem('activeTab10', $(e.target).data('target'));
		});
		if(activeTab){
			$('#myTab a[data-target="' + activeTab + '"]').tab('show');
		}else{
			$('#myTab a[data-target="#payrollmdls"]').tab('show');
		}

	});
</script>