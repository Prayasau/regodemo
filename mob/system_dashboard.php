
	<div class="container-fluid" style="xborder:1px solid red; padding:0">
		
		<div class="profile-header">               
			<img src="../<?=$data['image']?>">
			<h3><?=$title[$data['title']].' '.$data[$lang.'_name']?></h3>
			<em><?=$positions[$data['position']][$lang]?></em>
		</div>
		
		<div class="dashboard">
		<ul>

			<li>
				<a style="background-color: #f39c12;" href="">
					<i class="fa fa-cogs"></i>
					<em>Manage Activities</em>
				</a>
			</li>        
		</ul>    
		<div style="height:60px; clear:both"></div>
		</div>

	</div>
