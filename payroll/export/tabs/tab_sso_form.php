<style type="text/css">
	.dashbox-sm .inner {
    	padding: 7px 5px 7px 10px !important;
    }

    .main.gov-forms {
	    padding-top: 0px;
	    top: 30px;
	    overflow-x: auto;
	    position: inherit;
	}
</style>
<div class="main gov-forms">

	<div class="hide-800" style="width:300px;position: absolute;">
		<div class="dashbox-sm orange">
			<div class="inner <? if($_GET['sm']==44){ echo 'active';}?>" onclick="window.location.href='index.php?mn=422&sm=44';">
				<i class="fa fa-paperclip"></i>
				<p><?=$lng['SSO Attachment']?></p>
				<i class="fa fa-caret-right"></i>
			</div>
		</div>
		<div class="dashbox-sm orange">
			<div class="inner <? if($_GET['sm']==43){ echo 'active';}?>" onclick="window.location.href='index.php?mn=422&sm=43';">
				<i class="fa fa-file-pdf-o"></i>
				<p><?=$lng['SSO Form']?></p>
				<i class="fa fa-caret-right"></i>
			</div>
		</div>

		<div class="dashbox-sm dblue">
			<div class="inner <? if($_GET['sm']==45){ echo 'active';}?>" onclick="window.location.href='index.php?mn=422&sm=45';">
				<i class="fa fa-file-text-o"></i>
				<p><?=$lng['SSO text file']?></p>
				<i class="fa fa-caret-right"></i>
			</div>
		</div>
		<div class="dashbox-sm dblue">
			<div class="inner <? if($_GET['sm']==46){ echo 'active';}?>" onclick="window.location.href='index.php?mn=422&sm=46';">
				<i class="fa fa-file-excel-o"></i>
				<p><?=$lng['SSO Excel file']?></p>
				<i class="fa fa-caret-right"></i>
			</div>
		</div>

	</div>
	<div class="government-forms" style="margin-left: 300px;">

		<?	$helpfile = getHelpfile(430);
			switch($_GET['sm']){
				/*case 40: include('show_pnd1_monthly_'.$lang.'.php'); break;
				case 41: include('show_pnd1_monthly_attach_'.$lang.'.php'); break;
				case 50: include('show_pnd3_'.$lang.'.php'); break;
				case 51: include('show_pnd3_attach_'.$lang.'.php'); break;*/
				case 43: include('forms/show_sso_form_'.$lang.'.php'); break;
				case 44: include('forms/show_sso_attach_'.$lang.'.php'); break;

				case 45: include('txtfiles/sso_textfile.php'); break;
				case 46: include('txtfiles/sso_attach_excel.php'); break;
				/*case 46: include('show_pvf_form_'.$lang.'.php'); break;
				case 45: include('show_pvf_attach_'.$lang.'.php'); break;
				case 47: include('show_wht_certificate.php'); break;
				case 48: include('show_pnd1_attach_kor_'.$lang.'.php'); break;
				case 49: include('show_pnd1kor_'.$lang.'.php'); break;*/
			}
		?>	

	</div>

</div>