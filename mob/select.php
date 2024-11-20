<?php

// GET EMPLOYEE ACCES AND STATUS 
$EMP_ACCESS 		= $_SESSION['rego']['emp_access'];

// CREATE ARRAY OF EMPLOYEE ACCESS VALUES 
$EMP_ACCESS_ARRAY = explode(',' , $EMP_ACCESS );



$EMP_ACCESS_STATUS  = $_SESSION['rego']['emp_status'];
$EMP_USERNAME	    = $_SESSION['rego']['username'];

// GET COMPANY ACCES AND STATUS 
$COMP_ACCESS 		= $_SESSION['rego']['com_access'];

// CREATE ARRAY OF COMPANY ACCESS VALUES 
$COM_ACCESS_ARRAY = explode(',' , $COMP_ACCESS );  

// GET SYSTEM ACCES AND STATUS 

$SYS_ACCESS 		= $_SESSION['rego']['sys_access'];
$SYS_ACCESS_STATUS  = $_SESSION['rego']['sys_status'];

// CREATE ARRAY OF SYSTEM ACCESS VALUES 

$SYS_ACCESS_ARRAY = explode(',', $SYS_ACCESS);



// GET COMPANY STATUS OF EACH ACCESS VALUE FROM REGO USERS TABLE 


foreach ($COM_ACCESS_ARRAY as $key_company => $value_company) 
{
	$getDataForCompany[$value_company] = getCOMPDataFromAllDatabase($value_company,$EMP_USERNAME);
}

// GET SYSTEM STATUS OF EACH ACCESS VALUE FROM REGO USERS TABLE 

foreach ($SYS_ACCESS_ARRAY as $key_system => $value_system) 
{
	$getDataForSystem[$value_system] = getSYSDataFromAllDatabase($value_system,$EMP_USERNAME);
}


// GET EMPLOYEE STATUS OF EACH ACCESS VALUE FROM REGO USERS TABLE 

foreach ($EMP_ACCESS_ARRAY as $key_system => $value_employee) 
{
	$getDataForEmployee[$value_employee] = getSYSDataFromAllDatabase($value_employee,$EMP_USERNAME);
}




// echo '<pre>';
// print_r($getDataForEmployee);
// echo '</pre>';

// die();


?>

<!--- ADD HTML CODE HERE ---> 
	<div class="container-fluid" style="xborder:1px solid red; padding:0">
		
		<div class="profile-header">               
			<img src="../<?=$data['image']?>">
			<h3><?=$title[$data['title']].' '.$data[$lang.'_name']?></h3>
			<em><?=$positions[$data['position']][$lang]?></em>
		</div>
		
		<div class="dashboard dashboardwidth">
		<ul>

			<li class="widthclass " id="user_type_li">
				<select  id= "user_select" class="form-control" onchange="swipeTab();" style="text-align-last:center;">
					<option value="">Select User Type</option>
					<option value="emp">Employee User</option>
					<option value="comp">Company User</option>
					<option value="sys">System User</option>
				</select>
			</li> 

     
			<!--CHECK IF COMPANY USER EXISTS , IF YES THEN SHOW IN COMPANY SELECT BOX -->

			<li class="widthclass" id="company_type_li" style="display:none;" >
				<select id="companyGetSelected" class="form-control" style="text-align-last:center;" onchange="loginintopage('comp');">
					<option>Select Company </option>
					<?php if(isset($getDataForCompany)) { 
							foreach($getDataForCompany as $key => $valueCompany){?>

						<option value="<?php echo $key;?>" ><?php echo $key;?></option>

					<?php } } ?>
				</select>
				<div style="text-align: center;">
					<div style="margin:auto;">
						<button onclick="swipeTab();"class="btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <span>Back</span> </button>
					</div>	
				</div>
			</li>  		

			<!--CHECK IF COMPANY SYSTEM EXISTS , IF YES THEN SHOW IN SYSTEM SELECT BOX -->

			<li class="widthclass" id="system_type_li" style="display: none;" >
				<select id="systemGetSelected" class="form-control" style="text-align-last:center;" onchange="loginintopage('sys');">
					<option>Select System User</option>
					<?php if(isset($getDataForSystem)) { 
							foreach($getDataForSystem as $key_system => $valueSystem){?>

						<option value="<?php echo $key_system;?>" ><?php echo $key_system;?></option>

					<?php } } ?>
				</select>
				<div style="text-align: center;">
					<div style="margin:auto;">
						<button onclick="swipeTab();"class="btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <span>Back</span> </button>
					</div>	
				</div>
			</li>  			


			<!--CHECK IF Employee  EXISTS , IF YES THEN SHOW IN SYSTEM SELECT BOX -->

			<li class="widthclass" id="emp_type_li" style="display: none;" >
				<select id="empGetSelected" class="form-control" style="text-align-last:center;" onchange="loginintopage('emp');">
					<option>Select Employee Company</option>
					<?php if(isset($getDataForEmployee)) { 
							foreach($getDataForEmployee as $key_system => $valueSystem){?>

								<option value="<?php echo $key_system;?>" ><?php echo $key_system;?></option>

					<?php } } ?>
				</select>
				<div style="text-align: center;">
					<div style="margin:auto;">
						<button onclick="swipeTab();"class="btn"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> <span>Back</span> </button>
					</div>	
				</div>
			</li>        
		</ul>    
		<div style="height:60px; clear:both"></div>
		</div>

	</div>

<script type="text/javascript">

	function swipeTab()
	{	
		var swipeType = $('#user_select').val();

		if(swipeType == 'comp')
		{
			// slide company dropdown
			$('#user_type_li' ).css('display','none');
			$('#company_type_li').css('display','block');
			$('#company_type_li' ).addClass( 'animate__animated animate__fadeInRight' );
			$('#user_select').val('');
		}
		else if(swipeType == 'sys')
		{
			// slide system dropdown
			$('#user_type_li' ).css('display','none');
			$('#system_type_li').css('display','block');
			$('#system_type_li' ).addClass( 'animate__animated animate__fadeInRight' );
			$('#user_select').val('');

		}
		else  if(swipeType == 'emp')
		{
			// login to employee dashboard 

			// slide system dropdown
			$('#user_type_li' ).css('display','none');
			$('#emp_type_li').css('display','block');
			$('#emp_type_li' ).addClass( 'animate__animated animate__fadeInRight' );
			$('#user_select').val('');


		}
		else
		{
			$('#user_type_li' ).css('display','');
			$('#company_type_li').css('display','none');
			$('#system_type_li').css('display','none');
			$('#emp_type_li').css('display','none');
			$('#user_type_li' ).addClass( 'animate__animated animate__fadeInRight' );
			$('#user_select').val('');
		}
	

	}


	function loginintopage(type)
	{
		if(type == 'comp')
		{
			// login into company dashboard
			// get company name and load data of that company
			var selectedCompany = $('#companyGetSelected').val();


			if(selectedCompany)
			{

				// redirect
				// set company in session

				$.ajax({
					url: "ajax/change_company.php",
					data: {'selectedCompany': selectedCompany},
					success:function(result){

						// redirect to company dashboard 
						location.href = 'index.php?mn=19';

					},
					error:function (xhr, ajaxOptions, thrownError){
						alert('<?=$lng['Error']?> ' + thrownError);
					}
				});


				// location.href = 'index.php?mn=2';

			}
			else
			{
				// blank field error 
			}

		}
		else if(type == 'sys')
		{
			var systemGetSelected = $('#systemGetSelected').val();

			if(systemGetSelected)
			{
				$.ajax({
					url: "ajax/change_company.php",
					data: {'selectedCompany': selectedCompany},
					success:function(result){

						// redirect to system dashboard 
						location.href = 'index.php?mn=20';

					},
					error:function (xhr, ajaxOptions, thrownError){
						alert('<?=$lng['Error']?> ' + thrownError);
					}
				});
			}
			else
			{
				// blank field error 
			}
		}
		else if(type == 'emp')
		{
				$.ajax({
					url: "ajax/change_company.php",
					data: {'selectedCompany': selectedCompany},
					success:function(result){

						// redirect to system dashboard 
						location.href = 'index.php?mn=21';

					},
					error:function (xhr, ajaxOptions, thrownError){
						alert('<?=$lng['Error']?> ' + thrownError);
					}
				});

		}

	}
</script>