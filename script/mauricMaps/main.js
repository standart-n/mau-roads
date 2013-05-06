
$(document).ready(function(){
		$("#var_window").val("map");
		$("#var_last").val("0");
		$("div#content-table").empty();
		/*$("div#map").show().css({'height':($(window).height()-190)+'px'});*/
		$("div#map").show().css({'height':($(window).height()-100)+'px'});
		$("a#view-list").show();
		$("div#tr-table, div#results, div#content-table, div#more, a#view-map").hide();
		$('html, body').animate({scrollTop:'70px'},"slow");
		make_ajax("select",0,"");


	$("a#view-map").on("click",function(){
		$("#var_window").val("map");
		$("#var_last").val("0");
		$("div#content-table").empty();
		/*$("div#map").show().css({'height':($(window).height()-190)+'px'});*/
		$("div#map").show().css({'height':($(window).height()-100)+'px'});
		$("a#view-list").show();
		$("div#tr-table, div#results, div#content-table, div#more, a#view-map").hide();
		$('html, body').animate({scrollTop:'70px'},"slow");
		make_ajax("select",this.id,"");
	});
	$("a#view-list").on("click",function(){
		$("#var_window").val("list");
		$("#var_last").val("0");
		$("div#map, div#script").empty;
		$("div#map, a#view-list").hide();
		$("div#tr-table, div#results, div#content-table, div#more, a#view-map").show();
		make_ajax("select",this.id,"");
		myMap.destroy();
	});
});

function showCommentInfo(uuid) {
	$(document).ready(function(){
		$("#comment-info-"+uuid).removeClass("comment-info-disable").toggleClass("comment-info-active");
		$("#comment-counters-"+uuid).removeClass("comment-counters-active").toggleClass("comment-counters-disable");
		$("#comment-line-info-"+uuid).show();
		$("#comment-line-counters-"+uuid).hide();
	});
}

function showCommentCounters(uuid) {
	$(document).ready(function(){
		$("#comment-info-"+uuid).toggleClass("comment-info-disable").removeClass("comment-info-active");
		$("#comment-counters-"+uuid).toggleClass("comment-counters-active").removeClass("comment-counters-disable");
		$("#comment-line-info-"+uuid).hide();
		$("#comment-line-counters-"+uuid).show();
	});
}

function on_line(id){
	$(document).ready(function(){
			ln_status=$("[link-id="+id+"]").attr("open-status");
			if (ln_status=="close") {
				$("[comment-id="+id+"]").show();
				$("[link-id="+id+"]").attr('open-status','open');
			} else {
				$("[comment-id="+id+"]").hide();
				$("[link-id="+id+"]").attr('open-status','close');
			}
	});
	return true;
}

function before_send(){
	$(document).ready(function(){
		$("div#results").html("<h4>Загрузка данных...</h4>");	
	});
	return true;
}

function on_success(s){
	$(document).ready(function(){
		$("div#results").html(""); 
		$("div#map").html(""); 
		if (s.alert!="") { alert(s.alert); }
		$("div#total").html(s.total); 
		if (s.count>0) { 
			if ($("#var_window").val()=="list") {
				$("#content-table").html($("#content-table").html()+s.html); 
				$("a#view-map").show();
				$("div#script").empty(); 
			} else {
				$("div#content-table").empty();
				$("div#script").html(s.script); 
				//alert(s.script);
				map_init();
			}
		}
		if (s.count==1) { $("div.comment-wrap").show().attr("open-status","open");  }
		if (s.count==0) { $("div#results").html("<h4>Ничего не найдено...</h4>"); }
		$("#var_last").val(s.last);
		if ((s.more==true) && ($("#var_window").val()=="list")) { $("#more").show(); } else { $("#more").hide(); }
		if (s_id=="sector-select") {
			$("#home").hide();
			$("#street").html(s.street);
		}
		if (s_id=="street-select") {
			$("#home").show().html(s.home);
		}	
	});
	return true;
}

function on_error(error){
	$(document).ready(function(){
		$("div#results").html("<h4>Произошла ошибка при загрузке данных...</h4>");
	});
	return true;
}

function on_select(id){
	$(document).ready(function(){
		$("#var_last").val("0");
		$("#content-table").html("");
		make_ajax("select",id,"");
	});
	return true;
}

function on_more(){
	$(document).ready(function(){
		make_ajax("select",this.id,"down");
	});
	return true;
}

function getInd(id) {
return document.getElementById(id+"-select").selectedIndex;
}

function getOpt(id) {
return document.getElementById(id+"-select").options;
}

function make_ajax(act,id,type){
	$(document).ready(function(){
		$("#var-coords").empty();
		s_id=id;
		// s_ctp_opt=getOpt("ctp");
		// s_direction_opt=getOpt("direction");
		// s_sector_opt=getOpt("sector");
		// s_street_opt=getOpt("street");
		// s_home_opt=getOpt("home");
		s_ctp_opt=0;
		s_direction_opt=0;
		s_sector_opt=0;
		s_street_opt=0;
		s_home_opt=0;
		s_last=$("#var_last").val();
		$.ajax({
			url:"index.php",
			cache:false,
			type:"GET",
			data:{
				ajax:true,
				click:s_id,
				last:0,
				category:'map'
			},
			dataType:"jsonp",
			timeout:1000000,
			beforeSend:function(){ before_send(); },			
			success:function(s){
				console.log(s); 
				on_success(s);
				if (type=="down") {
					height=$(document).height();
					$('html, body').animate({scrollTop:height+'px'},"slow");
				}
			},
			error:function(XMLHttpRequest,textStatus,error){ console.log('!ajax', textStatus, error); }
		});
	});
	return true;
}
	
