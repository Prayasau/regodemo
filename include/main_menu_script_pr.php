<script type="text/javascript">
		
	$(document).ready(function() {
		
		if(lang == 'en'){	
			var locale =  ['OK', 'Cancel', 'Select All'];
		}else{
			var locale =  ['ตกลง', 'ยกเลิก', 'เลือกทั้งหมด'];
		}

		function updateAccess(access, values){
			$.ajax({
				//url: ROOT+"ajax/update_session_access_pr.php",
				url: ROOT+"ajax/update_session_access.php",
				data: {access: access, values: values},
				success: function(result){
					//$('#dump').html(result); return false;
					window.location.reload()
				}
			});
		}
			
		window.sb = $('#selBox-entities').mnSumoSelect({ 
			placeholder: '<?=$lng['Company']?>',
			captionFormat:'<?=$lng['Company']?> ({0})', 
			captionFormatAllSelected:'<?=$lng['All Company']?>',
			csvDispCount: 1, 
			search: true, 
			searchText:'<?=$lng['Search']?> ...', 
			selectAll:true,
			okCancelInMulti:true,
			showTitle: false,
			triggerChangeCombined:true
		})
		$('#selBox-entities').on('change',function(e){
			//alert($(this).val());
			updateAccess('entities', $(this).val()); 
		});
		
		window.sb = $('#selBox-divisions').mnSumoSelect({ 
			placeholder: '<?=$lng['Divisions']?>',
			captionFormat:'<?=$lng['Divisions']?> ({0})', 
			captionFormatAllSelected:'<?=$lng['All Divisions']?>',
			csvDispCount: 1, 
			search: true, 
			searchText:'<?=$lng['Search']?> ...',
			locale: locale,  
			selectAll:true,
			okCancelInMulti:true,
			showTitle: false,
			triggerChangeCombined:true
		})
		$('#selBox-divisions').on('change',function(e){
			//alert($(this).val());
			updateAccess('divisions', $(this).val()); 
		});
		
		window.sb = $('#selBox-branches').mnSumoSelect({ 
			placeholder: '<?=$lng['Location']?>',
			captionFormat:'<?=$lng['Location']?> ({0})', 
			captionFormatAllSelected:'<?=$lng['All Locations']?>',
			csvDispCount: 1, 
			search: true, 
			searchText:'<?=$lng['Search']?> ...',
			locale: locale, 
			selectAll:true,
			okCancelInMulti:true,
			showTitle: false,
			triggerChangeCombined:true
		})
		$('#selBox-branches').on('change',function(e){
			//alert($(this).val()); 
			updateAccess('branches', $(this).val());
		});
		
		window.sb = $('#selBox-departments').mnSumoSelect({ 
			placeholder: '<?=$lng['Departments']?>',
			captionFormat:'<?=$lng['Departments']?> ({0})', 
			captionFormatAllSelected:'<?=$lng['All Departments']?>',
			csvDispCount: 1, 
			search: true, 
			searchText:'<?=$lng['Search']?> ...',
			locale: locale,  
			selectAll:true,
			okCancelInMulti:true,
			showTitle: false,
			triggerChangeCombined:true
		})
		$('#selBox-departments').on('change',function(e){
			//alert($(this).val()); 
			updateAccess('departments', $(this).val());
		});
		
		window.sb = $('#selBox-teams').mnSumoSelect({ 
			placeholder: '<?=$lng['Teams']?>',
			captionFormat:'<?=$lng['Teams']?> ({0})', 
			captionFormatAllSelected:'<?=$lng['All Teams']?>',
			csvDispCount: 1, 
			search: true, 
			searchText:'<?=$lng['Search']?> ...',
			locale: locale,  
			selectAll:true,
			okCancelInMulti:true,
			showTitle: false,
			triggerChangeCombined:true
		})
		$('#selBox-teams').on('change',function(e){
			//alert($(this).val());
			updateAccess('teams', $(this).val());
		});
		
		


	});

	</script>
