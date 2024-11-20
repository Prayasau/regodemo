<div style="position:absolute; left:24px; top:57px; right:70%; bottom:0; background:#fff;">
	<div id="leftTable" style="left:10px; top:45px; right:10px; bottom:15px; background:#fff; overflow-Y:auto; padding:0; display:xnone; overflow-X:hidden">

		<table class="basicTable inputs" border="0">
			<thead>
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Login Screen
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th style="vertical-align:top">Select Type </th>
					<td> 
						<!-- <select id="select_login_type" name="login_screen[screen_type]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>		 -->								
					</td>
				</tr>
			</tbody>								
			<thead>
				<tr>
					<th colspan="2">
						<i class="fa fa-arrow-circle-down"></i>&nbsp; Select Box Settings 
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th style="vertical-align:top">Select Logo </th>
					<td> 
						<select id="select_admin_login_logo" name="login_screen_data[select_admin_login_logo]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>										
					</td>
				</tr>	

				<tr>
					<th style="vertical-align:top">Select Heading Color </th>
					<td> 
						<select id="select_admin_login_heading_color" name="login_screen_data[select_admin_login_heading_color]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>										
					</td>
				</tr>									
				<tr>
					<th style="vertical-align:top">Select Heading Font </th>
					<td> 
						<select id="select_admin_login_heading_font" name="login_screen_data[select_admin_login_heading_font]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>										
					</td>
				</tr>								
				<tr>
					<th style="vertical-align:top">Select Box Color </th>
					<td> 
						<select id="select_admin_login_box_color" name="login_screen_data[select_admin_login_box_color]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>										
					</td>
				</tr>				
				<tr>
					<th style="vertical-align:top">Select Background Picture</th>
					<td> 
						<select id="select_admin_backgroun_image" name="login_screen_data[select_admin_login_heading_color]" style="width:90%" >
							<?php foreach ($login_screen_type as $keyScreen => $valueScreen){ ?>
								<option  value="<?php echo $keyScreen;?>"><?php echo $valueScreen?></option><?php } ?>
						</select>										
					</td>
				</tr>
			</tbody>
		</table>
		
		<div style="height:15px"></div>

	</div>
</div>

<div style="position:absolute; left:30%; top:57px; right:0; bottom:0; background: #f6f6f6; border-left:1px solid #ddd">
	<div class="admin_login_screen_div" id="rightTable1" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: url('../../images/204503773-huge.jpg')no-repeat;background-position: bottom;background-size: cover;  overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">

		<div class="dash-left" style="width: 100%!important;">
			<div id="brand_logo">
				<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>

			<div style="padding-top:12vh; xborder:1px solid red">
				<div class="brand">
					<img style="margin-left: 146px" src="../images/pkf_people.png">
					<p></p>
				</div>
				
				
				<div class="logform">
					<h2 style="background:#007700; border-radius:3px 3px 0 0"><i class="fa fa-lock"></i> &nbsp;Login to our secure server</h2>
					<div class="logform-inner">
						<div id="logMsg" style="color:#b00; font-weight:600; font-size:14px; display:none"></div>
						<div id="login">
							<form id="logForm">
								<label>Username <i class="man"></i></label>
								<input name="username" type="text" autocomplete="username" value="" />
								<label>Password <i class="man"></i></label>
								<input name="password" type="password" autocomplete="current-password" value="" />
								<div style="height:15px"></div>
								<button type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
								<button id="togglediv" style="float:right;" type="button" class="btn btn-primary">Forgot password</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- dash left ends -->
		
	</div><!-- div right ends -->						

	<div class="system_login_screen_div" id="rightTable2" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: url('../../images/regohr_bg.png') no-repeat;background-position: bottom;background-size: cover; overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">

		<div class="dash-left" style="width: 100%!important;">
			<div id="brand_logo">
					<a style="margin:0px 0 0 0" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>

			<div style="padding-top:10vh; xborder:1px solid red;float: left;margin-left: 70px;">
				<div class="brand">
					<img src="../images/pkf_people.png">
					<p></p>
				</div>


				<div class="logform" style="xleft:1000px !important">
					<h2><i class="fa fa-lock"></i> &nbsp;Login to our secure server</h2>
					<div class="logform-inner">
						<div id="login">
							<form id="logForm">
								<label>Username <i class="man"></i></label>
								<input name="username" type="text" autocomplete="username" value="" />
								<label>Password <i class="man"></i></label>
								<input name="password" type="password" autocomplete="current-password" value="" />
								<div style="height:15px"></div>
								<button type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i>&nbsp; Log-in</button>
								<button id="togglediv" style="float:right;" type="button" class="btn btn-primary">Forgot password</button>
							</form>
							<div id="dump"></div>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- dash left ends -->
		
	</div><!-- div right ends -->						

	<div class="mob_login_screen_div" id="rightTable3" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: rgb(255, 255, 255); overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			
			<div class="appHeader1 bg-dark text-light">
			    <div class="pageTitle">Login to our secure server</div>
			</div>


			<div class="container-fluid" style="xborder:1px solid red">
				<div class="row" style="xborder:1px solid green; padding:25px">
					<div class="col-12">
						<img style="height:40px" src="../images/Regodemo.png">
						
						<div class="divider-icon">
							<div><i class="fa fa-lock fa-lg"></i></div>
						</div>
						
						<div id="logForm">	
							<form id="log_form">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control" type="text" name="username" value="sakdatest@test" id="username" style="width: 100%;" />
								</div>
								<div class="form-group">
									<label for="password">Password</label>
									<input class="form-control" type="password" name="password" value="sakdatest@test" id="password" style="width: 100%;"/>
								</div>
								<table border="0" style="margin-bottom:10px;">
									<tr>
										<td>
											<div class="custom-control custom-switch" style="">
													<input checked type="checkbox" class="custom-control-input" name="remember" id="remember" value="1" >
													<label style="background: #007bff!important" class="custom-control-label" for="remember"></label>
											</div>
										</td>
										<td style="padding-left:8px; font-weight:500">Remember me</td>
									</tr>
								</table>
								<button style="margin-bottom:6px" type="button" class="btn btn-default btn-block" style="background:#239965!important;">Log-in &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								<button type="button" class="btn btn-info btn-block" id="forgot" style="background: #007bff!important;">Forgot password</button>
								<div style="color:#a00; font-size:15px; display:none; margin-top:10px" id="logMsg"></div>
							</form>
						</div>
						
						<div id="forgotForm" style="display:none">
							<form id="forgotPassForm">
								<div class="form-group">
									<label for="username">Username</label>
									<input class="form-control"type="text" name="femail" id="femail"/>
								</div>
								<button style="margin-bottom:6px" type="button" class="btn btn-default btn-block">Request new password</button>
								<button id="backLogin" type="button" class="btn btn-info btn-block">Back to Login</button>
								<div style="color:#a00; line-height:140%; font-size:15px; display:none; margin-top:10px" id="forMsg"></div>
							</form>
						</div>
						
						<div style="height:250px"></div>
						
					</div>
				</div>
			</div>	



			<div class="fixBottomMenu" style="border:0">
				<a href="#" data-lng="th" class="langbutton "><img src="../images/flag_th.png"></a>
			</div>
		</div> <!-- dash left ends -->
		
	</div><!-- div right ends -->			

	<div class="scan_login_screen_div" id="rightTable4" style="position: absolute; left: 15px; top: 0px; right: 15px; bottom: 15px; background: url('../../images/204503773-huge.jpg')no-repeat;background-position: bottom;background-size: cover; overflow-y: auto; padding: 15px 15px 100px; padding-top: 0px!important;display: none;">
		<div class="dash-left" style="width: 100%!important;">
			
			<div class="header1" style="background: rgba(0,0,0,0.7); text-align:center">
				Rego Demo Time registration 
			</div>			

			<div class="log-wrapper">
				<div class="log-body">
					<div class="log-title" style="background: #0055a5 !important;">Login to our secure server</div>
					<div id="logForm">	
						<form id="log_form" style="padding:0 0 10px 0">
							<label>Username</label>
							<input id="username" name="username" type="text" value="" style="width: 100%">
							
							<label>Password</label>
							<input id="password" name="password" type="password" value="" style="width: 100%">
							
							<div id="logMsg"></div>
							
							<button id="logButton" type="submit" class="btn btn-success btn-lg btn-block tac" style="background: #61bc47;margin-top:10px; font-weight:400; letter-spacing:1px">Log-in &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
							
							<button id="reload" onClick="window.location.reload()" type="button" class="btn btn-info btn-lg btn-block tac" style="margin-top:10px; font-weight:400; letter-spacing:1px; display:none">Reload location &nbsp;<i class="fa fa-refresh xfa-lg"></i></button>
							
							<div id="twobtns" class="row col-md-12" style="display: none;">
								<div class="col-md-6">
										<button id="timeregister" type="submit" class="btn btn-success btn-lg btn-block tac" style="margin-top:10px; font-weight:400; letter-spacing:1px">Time registration &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								</div>
								<div class="col-md-6">
										<button id="generateloc" type="submit" class="btn btn-danger btn-lg btn-block tac" style="margin-top:10px; font-weight:400; letter-spacing:1px">Generate Location &nbsp;<i class="fa fa-sign-in fa-lg"></i></button>
								</div>
							</div>
						</form>
					</div>
					
					<div id="dump"></div>
				</div>

					<a data-lng="th" class="langbutton1 "><img height="50px" src="../images/flag_th.png"></a>
			</div>
		</div> <!-- dash left ends -->
		
	</div><!-- div right ends -->
</div>