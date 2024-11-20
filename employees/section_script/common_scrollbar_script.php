$(document).ready(function(){


	$("div#datatables11_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables13_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables15_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables17_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables19_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables21_wrapper div.row:nth-last-child(1)").css('display','none');
	$("div#datatables23_wrapper div.row:nth-last-child(1)").css('display','none');

	// =================================== FOR PERSONAL SECTION  ================================= //
    var oldRst = 0;
	$('div#datatables11_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l = $('div#datatables12_wrapper .dataTables_scrollBody');
	  var lst = l.scrollTop();
	  var rst = $(this).scrollTop();
	  
	  l.scrollTop(lst+(rst-oldRst));
	  
	  oldRst = rst;
	});
    
    var oldRst1 = 0;
	$('div#datatables12_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l1 = $('div#datatables11_wrapper .dataTables_scrollBody');
	  var lst1 = l1.scrollTop();
	  var rst1 = $(this).scrollTop();
	  
	  l1.scrollTop(lst1+(rst1-oldRst1));
	  
	  oldRst1 = rst1;
	});    



	$('#datatables12_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables11_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables12_wrapper ul li a:contains("+propty+")").click();
	})	


	/*var oldRst2 = 0;
	$('div#datatables11_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l2 = $('div#datatables12_wrapper .dataTables_scrollBody');
	  var lst2 = l2.scrollLeft();
	  var rst2 = $(this).scrollLeft();
	  
	  l2.scrollLeft(lst2+(rst2-oldRst2));
	  
	  oldRst2 = rst2;
	});*/
    

    var oldRst13 = 0;
	$('div#datatables12_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l13 = $('div#datatables11_wrapper .dataTables_scrollBody');
	  var lst13 = l13.scrollLeft();
	  var rst13 = $(this).scrollLeft();
	  
	  l13.scrollLeft(lst13+(rst13-oldRst13));
	  
	  oldRst13 = rst13;
	});        

	var oldRst14 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l14 = $('div#datatables12_wrapper .dataTables_scrollBody');
	  var lst14 = l14.scrollLeft();
	  var rst14 = $(this).scrollLeft();
	  l14.scrollLeft(lst14+(rst14-oldRst14));
	  
	  oldRst14 = rst14;
	});  

	// =================================== FOR PERSONAL SECTION  ================================= //

	// =================================== FOR CONTACTS SECTION  ================================= //
	var oldRst15 = 0;
	$('div#datatables13_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l15 = $('div#datatables14_wrapper .dataTables_scrollBody');
	  var lst15 = l15.scrollTop();
	  var rst15 = $(this).scrollTop();
	  
	  l15.scrollTop(lst15+(rst15-oldRst15));
	  
	  oldRst15 = rst15;
	});
    
    var oldRst16 = 0;
	$('div#datatables14_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l16 = $('div#datatables13_wrapper .dataTables_scrollBody');
	  var lst16 = l16.scrollTop();
	  var rst16 = $(this).scrollTop();
	  
	  l16.scrollTop(lst16+(rst16-oldRst16));
	  
	  oldRst16 = rst16;
	}); 



	$('#datatables14_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables13_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables14_wrapper ul li a:contains("+propty+")").click();
	})	


	/*var oldRst17 = 0;
	$('div#datatables13_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l17 = $('div#datatables14_wrapper .dataTables_scrollBody');
	  var lst17 = l17.scrollLeft();
	  var rst17 = $(this).scrollLeft();
	  
	  l17.scrollLeft(lst17+(rst17-oldRst17));
	  
	  oldRst17 = rst17;
	});*/
    

    var oldRst18 = 0;
	$('div#datatables14_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l18 = $('div#datatables13_wrapper .dataTables_scrollBody');
	  var lst18 = l18.scrollLeft();
	  var rst18 = $(this).scrollLeft();
	  
	  l18.scrollLeft(lst18+(rst18-oldRst18));
	  
	  oldRst18 = rst18;
	});        

	var oldRst19 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l19 = $('div#datatables14_wrapper .dataTables_scrollBody');
	  var lst19 = l19.scrollLeft();
	  var rst19 = $(this).scrollLeft();
	  l19.scrollLeft(lst19+(rst19-oldRst19));
	  
	  oldRst19 = rst19;
	}); 


	// =================================== FOR CONTACTS SECTION  ================================= //	


	// =================================== FOR WORK DATA SECTION  ================================= //
	var oldRst20 = 0;
	$('div#datatables15_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l20 = $('div#datatables16_wrapper .dataTables_scrollBody');
	  var lst20 = l20.scrollTop();
	  var rst20 = $(this).scrollTop();
	  
	  l20.scrollTop(lst20+(rst20-oldRst20));
	  
	  oldRst20 = rst20;
	});
    
    var oldRst21 = 0;
	$('div#datatables16_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l21 = $('div#datatables15_wrapper .dataTables_scrollBody');
	  var lst21 = l21.scrollTop();
	  var rst21 = $(this).scrollTop();
	  
	  l21.scrollTop(lst21+(rst21-oldRst21));
	  
	  oldRst21 = rst21;
	}); 



	$('#datatables16_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables15_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables16_wrapper ul li a:contains("+propty+")").click();
	})	


	var oldRst22 = 0;
	$('div#datatables15_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l22 = $('div#datatables16_wrapper .dataTables_scrollBody');
	  var lst22 = l22.scrollLeft();
	  var rst22 = $(this).scrollLeft();
	  
	  l22.scrollLeft(lst22+(rst22-oldRst22));
	  
	  oldRst22 = rst22;
	});
    

    var oldRst23 = 0;
	$('div#datatables16_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l23 = $('div#datatables15_wrapper .dataTables_scrollBody');
	  var lst23 = l23.scrollLeft();
	  var rst23 = $(this).scrollLeft();
	  
	  l23.scrollLeft(lst23+(rst23-oldRst23));
	  
	  oldRst23 = rst23;
	});        

	var oldRst24 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l24 = $('div#datatables16_wrapper .dataTables_scrollBody');
	  var lst24 = l24.scrollLeft();
	  var rst24 = $(this).scrollLeft();
	  l24.scrollLeft(lst24+(rst24-oldRst24));
	  
	  oldRst24 = rst24;
	}); 


	// =================================== FOR WORK DATA SECTION  ================================= //	

	// =================================== FOR TIME  SECTION  ================================= //
	var oldRst25 = 0;
	$('div#datatables17_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l25 = $('div#datatables18_wrapper .dataTables_scrollBody');
	  var lst25 = l25.scrollTop();
	  var rst25 = $(this).scrollTop();
	  
	  l25.scrollTop(lst25+(rst25-oldRst25));
	  
	  oldRst25 = rst25;
	});
    
    var oldRst26 = 0;
	$('div#datatables18_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l26 = $('div#datatables17_wrapper .dataTables_scrollBody');
	  var lst26 = l26.scrollTop();
	  var rst26 = $(this).scrollTop();
	  
	  l26.scrollTop(lst26+(rst26-oldRst26));
	  
	  oldRst26 = rst26;
	}); 



	$('#datatables18_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables17_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables18_wrapper ul li a:contains("+propty+")").click();
	})	


	var oldRst27 = 0;
	$('div#datatables17_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l27 = $('div#datatables18_wrapper .dataTables_scrollBody');
	  var lst27 = l27.scrollLeft();
	  var rst27 = $(this).scrollLeft();
	  
	  l27.scrollLeft(lst27+(rst27-oldRst27));
	  
	  oldRst27 = rst27;
	});
    

    var oldRst28 = 0;
	$('div#datatables18_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l28 = $('div#datatables17_wrapper .dataTables_scrollBody');
	  var lst28 = l28.scrollLeft();
	  var rst28 = $(this).scrollLeft();
	  
	  l28.scrollLeft(lst28+(rst28-oldRst28));
	  
	  oldRst28 = rst28;
	});        

	var oldRst29 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l29 = $('div#datatables18_wrapper .dataTables_scrollBody');
	  var lst29 = l29.scrollLeft();
	  var rst29 = $(this).scrollLeft();
	  l29.scrollLeft(lst29+(rst29-oldRst29));
	  
	  oldRst29 = rst29;
	}); 


	// =================================== FOR TIME SECTION  ================================= //

	// =================================== FOR LEAVE  SECTION  ================================= //
	var oldRst30 = 0;
	$('div#datatables19_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l30 = $('div#datatables20_wrapper .dataTables_scrollBody');
	  var lst30 = l30.scrollTop();
	  var rst30 = $(this).scrollTop();
	  
	  l30.scrollTop(lst30+(rst30-oldRst30));
	  
	  oldRst30 = rst30;
	});
    
    var oldRst31 = 0;
	$('div#datatables20_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l31 = $('div#datatables19_wrapper .dataTables_scrollBody');
	  var lst31 = l31.scrollTop();
	  var rst31 = $(this).scrollTop();
	  
	  l31.scrollTop(lst31+(rst31-oldRst31));
	  
	  oldRst31 = rst31;
	}); 



	$('#datatables20_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables19_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables20_wrapper ul li a:contains("+propty+")").click();
	})	


	var oldRst32 = 0;
	$('div#datatables19_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l32 = $('div#datatables20_wrapper .dataTables_scrollBody');
	  var lst32 = l32.scrollLeft();
	  var rst32 = $(this).scrollLeft();
	  
	  l32.scrollLeft(lst32+(rst32-oldRst32));
	  
	  oldRst32 = rst32;
	});
    

    var oldRst33 = 0;
	$('div#datatables20_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l33 = $('div#datatables19_wrapper .dataTables_scrollBody');
	  var lst33 = l33.scrollLeft();
	  var rst33 = $(this).scrollLeft();
	  
	  l33.scrollLeft(lst33+(rst33-oldRst33));
	  
	  oldRst33 = rst33;
	});        

	var oldRst34 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l34 = $('div#datatables20_wrapper .dataTables_scrollBody');
	  var lst34 = l34.scrollLeft();
	  var rst34 = $(this).scrollLeft();
	  l34.scrollLeft(lst34+(rst34-oldRst34));
	  
	  oldRst34 = rst34;
	}); 


	// =================================== FOR LEAVE SECTION  ================================= //




	// =================================== FOR ORGANIZATION  SECTION  ================================= //
	var oldRst35 = 0;
	$('div#datatables21_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l35 = $('div#datatables22_wrapper .dataTables_scrollBody');
	  var lst35 = l35.scrollTop();
	  var rst35 = $(this).scrollTop();
	  
	  l35.scrollTop(lst35+(rst35-oldRst35));
	  
	  oldRst35 = rst35;
	});
    
    var oldRst36 = 0;
	$('div#datatables22_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l36 = $('div#datatables21_wrapper .dataTables_scrollBody');
	  var lst36 = l36.scrollTop();
	  var rst36 = $(this).scrollTop();
	  
	  l36.scrollTop(lst36+(rst36-oldRst36));
	  
	  oldRst36 = rst36;
	}); 



	$('#datatables22_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables21_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables22_wrapper ul li a:contains("+propty+")").click();
	})	


	var oldRst37 = 0;
	$('div#datatables21_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l37 = $('div#datatables22_wrapper .dataTables_scrollBody');
	  var lst37 = l37.scrollLeft();
	  var rst37 = $(this).scrollLeft();
	  
	  l37.scrollLeft(lst37+(rst37-oldRst37));
	  
	  oldRst37 = rst37;
	});
    

    var oldRst38 = 0;
	$('div#datatables22_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l38 = $('div#datatables21_wrapper .dataTables_scrollBody');
	  var lst38 = l38.scrollLeft();
	  var rst38 = $(this).scrollLeft();
	  
	  l38.scrollLeft(lst38+(rst38-oldRst38));
	  
	  oldRst38 = rst38;
	});        

	var oldRst39 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l39 = $('div#datatables22_wrapper .dataTables_scrollBody');
	  var lst39 = l39.scrollLeft();
	  var rst39 = $(this).scrollLeft();
	  l39.scrollLeft(lst39+(rst39-oldRst39));
	  
	  oldRst39 = rst39;
	}); 





	// =================================== FOR BENEFITS  SECTION  ================================= //
	var oldRst40 = 0;
	$('div#datatables23_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l40 = $('div#datatables24_wrapper .dataTables_scrollBody');
	  var lst40 = l40.scrollTop();
	  var rst40 = $(this).scrollTop();
	  
	  l40.scrollTop(lst40+(rst40-oldRst40));
	  
	  oldRst40 = rst40;
	});
    
    var oldRst41 = 0;
	$('div#datatables24_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l41 = $('div#datatables23_wrapper .dataTables_scrollBody');
	  var lst41 = l41.scrollTop();
	  var rst41 = $(this).scrollTop();
	  
	  l41.scrollTop(lst41+(rst41-oldRst41));
	  
	  oldRst41 = rst41;
	}); 



	$('#datatables24_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables23_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables24_wrapper ul li a:contains("+propty+")").click();
	})	


	/*var oldRst42 = 0;
	$('div#datatables23_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l42 = $('div#datatables24_wrapper .dataTables_scrollBody');
	  var lst42 = l42.scrollLeft();
	  var rst42 = $(this).scrollLeft();
	  
	  l42.scrollLeft(lst42+(rst42-oldRst42));
	  
	  oldRst42 = rst42;
	});*/
    

    var oldRst43 = 0;
	$('div#datatables24_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l43 = $('div#datatables23_wrapper .dataTables_scrollBody');
	  var lst43 = l43.scrollLeft();
	  var rst43 = $(this).scrollLeft();
	  
	  l43.scrollLeft(lst43+(rst43-oldRst43));
	  
	  oldRst43 = rst43;
	});        

	var oldRst44 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l44 = $('div#datatables24_wrapper .dataTables_scrollBody');
	  var lst44 = l44.scrollLeft();
	  var rst44 = $(this).scrollLeft();
	  l44.scrollLeft(lst44+(rst44-oldRst44));
	  
	  oldRst44 = rst44;
	}); 


	// =================================== FOR BENEFITS SECTION  ================================= //



	// =================================== FOR FINANCIAL SECTION  ================================= //	

	var oldRst45 = 0;
	$('div#datatables25_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l45 = $('div#datatables26_wrapper .dataTables_scrollBody');
	  var lst45 = l45.scrollTop();
	  var rst45 = $(this).scrollTop();
	  
	  l45.scrollTop(lst45+(rst45-oldRst45));
	  
	  oldRst45 = rst45;
	});
    
    var oldRst46 = 0;
	$('div#datatables26_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l46 = $('div#datatables25_wrapper .dataTables_scrollBody');
	  var lst46 = l46.scrollTop();
	  var rst46 = $(this).scrollTop();
	  
	  l46.scrollTop(lst46+(rst46-oldRst46));
	  
	  oldRst46 = rst46;
	}); 



	$('#datatables26_wrapper').on('mousedown', '.paginate_button', function() {

		var propty= $(this).text();
		var firstTableClick = $("#datatables25_paginate ul li a:contains("+propty+")").click();
		var SecondTableClick = $("#datatables26_wrapper ul li a:contains("+propty+")").click();
	})	


	/*var oldRst47 = 0;
	$('div#datatables25_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l47 = $('div#datatables26_wrapper .dataTables_scrollBody');
	  var lst47 = l47.scrollLeft();
	  var rst47 = $(this).scrollLeft();
	  
	  l47.scrollLeft(lst47+(rst47-oldRst47));
	  
	  oldRst47 = rst47;
	});*/
    

    var oldRst48 = 0;
	$('div#datatables26_wrapper .dataTables_scrollBody').on('scroll', function () {
	  l48 = $('div#datatables25_wrapper .dataTables_scrollBody');
	  var lst48 = l48.scrollLeft();
	  var rst48 = $(this).scrollLeft();
	  
	  l48.scrollLeft(lst48+(rst48-oldRst48));
	  
	  oldRst48 = rst48;
	});        

	var oldRst49 = 0;
	$('div#hidediv2 table#scrolltable').on('scroll', function () {

	  l49 = $('div#datatables26_wrapper .dataTables_scrollBody');
	  var lst49 = l49.scrollLeft();
	  var rst49 = $(this).scrollLeft();
	  l49.scrollLeft(lst49+(rst49-oldRst49));
	  
	  oldRst49 = rst49;
	}); 



	// =================================== FOR FINANCIAL SECTION  ================================= //	


});