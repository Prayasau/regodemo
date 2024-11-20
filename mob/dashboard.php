
	<div class="container-fluid" style="xborder:1px solid red; padding:0">
		
		<div class="profile-header">               
			<img src="../<?=$data['image']?>">
			<h3><?=$title[$data['title']].' '.$data[$lang.'_name']?></h3>
			<em><?=$positions[$data['position']][$lang]?></em>
		</div>
		
		<div class="dashboard">
		<ul>
<!-- 			<li class="timeScan <? if(!$scan || $data['time_reg'] == '0'){echo 'disabled';}?>">
				<a class="bg-teal-light" <? if($scan && $data['time_reg'] == '1'){echo 'href="index.php?mn=16"';}?>>
					<div class="inner">
						<i class="fa fa-clock-o"></i><?=$lng['Time registration']?>
					</div>
				</a>
			</li>    -->
			<li class="timeScan <? if(($timeCheck == '1') && ($data['time_reg'] == '1')){}else{echo ' disabled';}?>">
				<a class="bg-teal-light" <? if(($timeCheck == '1') && ($data['time_reg'] == '1')){echo 'href="index.php?mn=16"';}?>>
					<div class="inner">
						<i class="fa fa-clock-o"></i><?=$lng['Time registration']?>
					</div>
				</a>
			</li> 

			<li>
				<a class="bg-red-dark" href="index.php?mn=10">
					<i class="fa fa-user"></i>
					<em><?=$lng['Personal data']?></em>
				</a>
			</li>        
			<li>
				<a class="bg-green-dark" href="index.php?mn=11">
					<i class="fa fa-files-o"></i>
					<em><?=$lng['Payslips']?></em>
				</a>
			</li>        
			<li>
				<a class="bg-blue-dark" href="index.php?mn=12">
					<i class="fa fa-list"></i>
					<em><?=$lng['Year overview']?></em>
				</a>
			</li>        
			<li>
				<a class="bg-magenta-dark" href="index.php?mn=13">
					<i class="fa fa-calendar"></i>
					<em><?=$lng['Calendar']?></em>
				</a>
			</li>        
<!-- 			<li>
				<a class="bg-yellow-dark" href="index.php?mn=17">
					<i class="fa fa-plane"></i>
					<em><?=$lng['Leave']?></em>
				</a>
			</li>  -->       
			<li class="<?php if($leaveCheck == '1'){}else{ echo 'opacitycheck';} ?>">
				<a class="bg-yellow-dark" <?php if($leaveCheck == '1'){ 
					echo 'href="index.php?mn=17"';


				}else {

					echo 'href="#"';
				} ?>>
					<i class="fa fa-plane"></i>
					<em><?=$lng['Leave']?></em>
				</a>
			</li>         
			<li>
				<a class="bg-night-dark" href="index.php?mn=14">
					<i class="fa fa-comments-o"></i>
					<em><?=$lng['Contact']?></em>
				</a>
			</li>        
			<!--<li>
				<a class="bg-yellow-dark" href="index.php?mn=15">
					<i class="fa fa-unlock-alt"></i>
					<em><?=$lng['Password']?></em>
				</a>
			</li> -->       
		</ul>    
		<div style="height:60px; clear:both"></div>
		</div>

	</div>
