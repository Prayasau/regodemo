
		<? if(count($entities) > 1){ ?>
		<? if(!empty($_SESSION['rego']['mn_entities'])){ ?>
		<div class="btn-group permissions" style="display:none">	
		    <select multiple="multiple" id="selBox-entities" style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_header_font'] ?>;">
					<? foreach($entities as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_entities']))){ ?>
					<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_entities']))){echo 'selected';} ?> value="<?=$k?>"><?=$v['code']?> - <?=$v[$lang]?></option>
					<? }} ?>
		    </select>
		</div>	
		<? } } ?>
		
		<? if(count($branches) > 1 && $parameters[1]['apply_param'] == 1){ ?>
		<? if(!empty($_SESSION['rego']['mn_branches'])){ ?>	
		<div class="btn-group permissions" style="display:none">
		    <select multiple="multiple" id="selBox-branches" style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_header_font'] ?>;">
					<? foreach($branches as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_branches']))){ ?>
					<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_branches']))){echo 'selected';} ?> value="<?=$k?>"><?=$v['code']?> - <?=$v[$lang]?></option>
					<? }} ?>
		    </select>
		</div>
		<? } } ?>
		
		<? if(count($divisions) > 1 && $parameters[2]['apply_param'] == 1){
			if(!empty($_SESSION['rego']['mn_divisions'])){ ?>
			<div class="btn-group permissions" style="display:none">
			<select multiple="multiple" id="selBox-divisions" style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_header_font'] ?>;">
				<? foreach($divisions as $k=>$v){if(in_array($k, explode(',', $_SESSION['rego']['mn_divisions']))){ ?>
				<option <? if(in_array($k, explode(',', $_SESSION['rego']['sel_divisions']))){echo 'selected';} ?> value="<?=$k?>"><?=$v['code']?> - <?=$v[$lang]?></option>
				<? }} ?>
			</select>
			</div>
		<? }} ?>
		
		<? if(count($departments) > 1 && $parameters[3]['apply_param'] == 1){
			if(!empty($_SESSION['rego']['mn_departments'])){ ?>
			<div class="btn-group permissions" style="display:none">
			<select multiple="multiple" id="selBox-departments" style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_header_font'] ?>;">
				<? foreach($departments as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['mn_departments']))){ ?>
				<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_departments']))){echo 'selected';} ?> value="<?=$k?>"><?=$v['code']?> - <?=$v[$lang]?></option>
				<? }} ?>
			</select>
			</div>
		<? }} ?>
    	
    	<? if(count($teams) > 1 && $parameters[4]['apply_param'] == 1){ ?>
		<? if(!empty($_SESSION['rego']['mn_teams'])){ ?>
		<div class="btn-group permissions" style="display:none">
			<select multiple="multiple" id="selBox-teams" style="font-family:<?php echo $savedMainDashboardlayout['main_dashboard_header_font'] ?>;">
				<? foreach($teams as $k=>$v){if(in_array($k, explode(',',$_SESSION['rego']['mn_teams']))){ ?>
				<option <? if(in_array($k, explode(',',$_SESSION['rego']['sel_teams']))){echo 'selected';} ?> value="<?=$k?>"><?=$v['code']?> - <?=$v[$lang]?></option>
				<? }} ?>
		    </select>
		</div>
		<? } } ?>

