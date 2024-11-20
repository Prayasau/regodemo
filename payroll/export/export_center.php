<h2 style="padding-right:60px">
	<i class="fa fa-cog"></i>&nbsp; Export Center	
</h2>
<div style="padding:0 0 0 20px" id="dump"></div>
	
	<div class="dash-left">
		
		<div class="dashbox reds<? //if($myaccess['rego']['payroll_result']['view']){echo 'purple';}else{echo 'disabled';} ?>">
			<div class="inner" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect1']]['code']."";?>>
				<i class="fa fa-file-pdf-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Employee Pay Slips']?></p>
					</div>
				</div>						
			</div>
		</div>	

		<div class="dashbox purple<? //if($myaccess['rego']['payroll_result']['view']){echo 'purple';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=431';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect2']]['code'].""; ?>>
				<i class="fa fa-list-ul"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Revenue Department']?></p>
					</div>
				</div>						
				
			</div>
		</div>		
		
		<div class="dashbox green<?// if($myaccess['rego']['payroll_attendance']['view']){echo 'green';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=421';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect3']]['code'].""; ?>>
				<i class="fa fa-history"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Social Security Funds']?></p>
					</div>
				</div>						
			</div>
		</div>

	

		<div class="dashbox teal<? //if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo 'teal';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=603';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect4']]['code'].""; ?>>
				<i class="fa fa-cogs"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Provident Funds']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox reds<? //if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo 'teal';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=603';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect5']]['code'].""; ?>>
				<i class="fa fa-cogs"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Payments']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox brown<? //if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo 'teal';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=603';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect6']]['code'].""; ?>>
				<i class="fa fa-cogs"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Accounting entries']?></p>
					</div>
				</div>						
				
			</div>
		</div>

		<div class="dashbox teal<? //if($myaccess['rego']['payroll_benefits']['view'] && $myaccess['rego']['standard'][$standard]['pr_benefits']){echo 'teal';}else{echo 'disabled';} ?>">
			<div class="inner" onclick="window.location.href='index.php?mn=603';" <?php echo "style=background:".$savedAdminColors[$savedMainDashboardlayout['maincolorSelect7']]['code'].""; ?>>
				<i class="fa fa-file-text-o"></i>
				<div class="parent">
					<div class="child">
						<p <?php echo "style=font-family:".$savedDefaultFonts[$savedMainDashboardlayout['main_font_settings']]."!important;color:".$savedAdminColors[$savedMainDashboardlayout['mainfontColor']]['code']."!important"; ?>><?=$lng['Annual WHT certificates']?></p>
					</div>
				</div>						
				
			</div>
		</div>

	</div>
