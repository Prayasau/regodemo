			var div_data_id=['#personal_div_data','#country_div_data','#work_div_data','#time_div_data','#leave_div_data','#organization_div_data','#financial_div_data','#benefits_div_data'];

			function hide_div_data(g){
				div_data_id.forEach(function(idx){
					$(idx).css('display','none');
				});
				//console.log(g);
				if(g>0&&g<9)$(div_data_id[Number(g)-1]).css('display','');
			}