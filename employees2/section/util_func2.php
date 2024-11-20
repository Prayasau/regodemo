			/////////////////////////////////utility functions2/////////////////////////////////////////
			var datatables=[dtable,dtable2,dtable3,dtable4,dtable5,dtable6,dtable7,dtable8,dtable9,dtable10,dtable11,dtable12,dtable15,dtable16,dtable13,dtable14];
			function adjust_columns(){
				datatables.forEach(function(v1,idx){

					$('#datatables'+(idx*2+11)).show(function(){setTimeout(function(){
						//console.log((idx*2));
						datatables[idx*2].columns.adjust();datatables[idx*2+1].columns.adjust();
					}, 1000); });
				});
			}

			

			var sections=['personal','contacts','work_data','time','leave','organization','financial','benefits'];
			
			function show_div_data(g){
			//console.log('g'+g);
			if(g==1||g==2){
				$('#showHideclm2').prop("disabled",false);
			$('#showHideClmss2').removeClass('displayNone');
			if(g==1){
					var hideAllcolumn = [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
					$.each(hideAllcolumn, function(key,val) {    
						datatables[0].column(val).visible(true);
						datatables[1].column(val).visible(true);
					});
				}
			}
			sections.forEach(function(element){
				if(element=='benefits')$('#div_benfits').css("display","none");
				$('#div_'+element).css("display","none");
				$('#'+element+'_old_data').css("display","none");
			});
			//console.log(sections[Number(g)-1]);
			
			if(g==8)$('#div_benfits').css("display","");
			$('#div_'+sections[Number(g)-1]).css("display","");
			$('#'+sections[Number(g)-1]+'_old_data').css("display","");

			for(let i=2;i<=9;i++)
				$("#showHideclm"+(i)).closest("div").css('display','none');
			
			if(g!=7&&g!=8)
			$('#showHideclm'+(Number(g)+1)).closest("div").css('display','');
			
			if(g==7)
			$('#showHideclm9').closest("div").css('display','');
			
			if(g==8)
			$('#showHideclm8').closest("div").css('display','');
			
			if(g==8||g==6)
			$(".commonhidebutton").css('display','none');
			else $(".commonhidebutton").css('display','');
			
			//datatables[(g-1)*2].columns.adjust();
			datatables[(g-1)*2].columns.adjust();
			datatables[(g-1)*2+1].columns.adjust();
			}

			
			var tableCols=[tableCols2,tableCols3,tableCols4,tableCols5,tableCols6,tableCols7,tableCols9,tableCols8];
			function getDataDivClass(g){

			sections.forEach(function(element){
			if(element=='benefits')$('#div_benfits').css("display","none");
			$('#div_'+element).css("display","none");
			$('#'+element+'_old_data').css("display","none");
			});
			//console.log(sections[Number(g)-1]);
			if(g==8)$('#div_benfits').css("display","");
			$('#div_'+sections[Number(g)-1]).css("display","");
			$('#'+sections[Number(g)-1]+'_old_data').css("display","");

			if(g==1){
					var hideAllcolumn = [3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
					$.each(hideAllcolumn, function(key,val) {    
						datatables[0].column(val).visible(true);
						datatables[1].column(val).visible(true);
					});
				}

			var columns =[];
			if(g!=7&&g!=8)
			{
				$('#showHideclm'+(Number(g)+1))[0].sumo.selectAll();
				$('#showHideclm'+(Number(g)+1)+' option:selected').each(function(i) {
			    	 columns.push($(this).val());
			    });
			}
			if(g==7)
			{
				$('#showHideclm9')[0].sumo.selectAll();
				$('#showHideclm9 option:selected').each(function(i) {
			    	 columns.push($(this).val());
			    });
			}
			if(g==8){
				$('#showHideclm8')[0].sumo.selectAll();
				$('#showHideclm8 option:selected').each(function(i) {
			    	 columns.push($(this).val());
			    });
			}
				//$("select#showHideclm"+(Number(g)))[0].sumo.selectAll();	//2

				

		    	var att_cols = [];
				$.each(columns, function(index, item) {
					att_cols.push({id:item, db:tableCols[g-1][item][0], name:tableCols[g-1][item][1]})
				})

		    	$.ajax({
					url: "ajax/update_show_hide_clm2.php",
					data: {cols: att_cols},
					success: function(result){
					},
					error:function (xhr, ajaxOptions, thrownError){
						$("body").overhang({
							type: "error",
							message: '<i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?=$lng['Sorry but someting went wrong']?> <b><?=$lng['Error']?></b> : '+thrownError,
							duration: 4,
						})
					}
				});
					datatables[(g-1)*2].columns.adjust();
					datatables[(g-1)*2+1].columns.adjust();				
			}

			function getDataDivUtilfun(g){
				hideAllDataDivs();
				showDataDiv(g);

			}

			function hideAllDataDivs(){
				sections.forEach(function(element){
				if(element=='benefits')$('#div_benfits').css("display","none");
				$('#div_'+element).css("display","none");
				$('#'+element+'_old_data').css("display","none");
				});
			}
			function showDataDiv(g){
				if(g==8)$('#div_benfits').css("display","");
					$('#div_'+sections[Number(g)-1]).css("display","");
				$('#'+sections[Number(g)-1]+'_old_data').css("display","");

				for(let i=2;i<=9;i++)
					$("#showHideclm"+(i+1))[0].sumo.unSelectAll();
			}
			
			function getDataDiv(){
				
			}
			/////////////////////////////////utility functions2/////////////////////////////////////////
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			