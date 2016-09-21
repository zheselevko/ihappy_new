function changeCartCounters(){
    $(".mini-cart .total").css({
    	"margin-left": -$(".mini-cart .total").width()/2
    });
    $(".mini-cart .count").css({
    	"margin-left": -$(".mini-cart .count").width()/2
    });
}
function scroll(pos)
{
var scroll=0;	
while ( pos.offsetParent!=null)
{
	scroll=scroll+pos.offsetTop;
	pos=pos.offsetParent;
}
$('html, body').animate({scrollTop:scroll},{duration: 800});
}
$(document).ready(function(){

	$(".custom-check").tiCheckbox({margin: "14"});

	$(".cat-menu .top").click(function(){
		if ($(this).find("ul").length>0) {
			$(this).siblings(".top").removeClass("active");
			$(this).addClass("active");
			/*return false;*/
		}
	});

	if ($(".promo.sl1").get(0)) {
	    $(".promo.sl1 .items").carouFredSel({
	        items:{
	            visible:1
	        },
	        pagination: ".promo.sl1 .paginate",
	        auto:{
	            easing: "swing",
	            duration: 700,
	            timeoutDuration: 7000,
	            pauseOnHover: false
	        }
	    });
	}

	if ($(".promo.sl0").get(0)) {

	    $(".promo.sl0 .items").carouFredSel({
	        items:{
	            visible:1
	        },
	        pagination: ".promo.sl0 .paginate",
	        auto:{
	            easing: "swing",
	            duration: 700,
	            timeoutDuration: 7000,
	            pauseOnHover: false
	        }
	    });
	}

    $("#main-menu .menu").carouFredSel({
        items:{
            visible: 5
        },
        prev: "#main-menu .prev",
        next: "#main-menu .next",
        scroll: 1,
        auto:{
        	play: false,
            easing: "swing",
            duration: 300
        }
    });

    $("#brand-menu .menu").carouFredSel({
        items:{
            visible: 5
        },
        prev: "#brand-menu .prev",
        next: "#brand-menu .next",
        scroll: 1,
        auto:{
        	play: false,
            easing: "swing",
            duration: 300
        }
    });

    if (document.getElementById("similar-slider")) {
        $("#similar-slider .slider").carouFredSel({
            items:{
                visible: 4
            },
            prev: "#similar-slider .prev",
            next: "#similar-slider .next",
            scroll: 1,
            auto:{
                play: false,
                easing: "swing",
                duration: 300
            }
        });
    }

    if (document.getElementById("auction-slider")) {
        $("#auction-slider .slider").carouFredSel({
            items:{
                visible: 4
            },
            prev: "#auction-slider .prev",
            next: "#auction-slider .next",
            scroll: 1,
            auto:{
                play: false,
                easing: "swing",
                duration: 300
            }
        });
    }

    var submenu;
    $(".menu a").hover(function(){
        submenu = $(this).attr("href");
        $(submenu).show();
        $(submenu).find(".connect").css({
            'left':  $(this).offset().left - $(submenu).offset().left + ($(this).width() - $(submenu).find(".connect").width())/2
        });
        var h = 0;
        $(submenu).find("ul").each(function(){
            if ($(this).height()>h) h = $(this).height();
        });
        $(submenu).find("ul").height(h);
    }, function(){
        $(submenu).hide();
        $(submenu).removeClass("open");
    });

   
    $(".main-submenu").hover(function(){
        $(this).show();
        $('.menu a[href="#'+$(this).attr("id")+'"]').addClass("active");
    }, function(){
        $(this).hide();
        $('.menu a[href="#'+$(this).attr("id")+'"]').removeClass("active");
    });

    if (document.getElementById("tabs")){
	/* console.log(      $("#tabs").tabs({
            activate: function( event, ui ) {
                imgH();
            }
        }));*/
		$("#tabs >div").css("display","none");
		$("#description").css("display","block");
		$(".tabs-wrap >ul>li>a").click(function(){
		var href=$(this).attr("href");
		var pl=this;
		$(".tabs-wrap >ul>li").removeClass("ui-state-active");
		$(pl.parentNode).addClass("ui-state-active");
setTimeout(function(){imgH();},40);

		$("#tabs >div").css("display","none");
		$(href).css("display","block");
		return false;
		});
    }

    $(".currency").sb();

    $(".filter-container select").sb();

    var fb_pop = function(self) {
        self.anchor.click(function(event) {
            event.preventDefault();
            var href = $(this).attr("href");
            var title = $(this).attr("title");
            $.fancybox.open({'href':href, 'title':title}, {'type':'image'});




 });
};

    if (document.getElementById("pikame")){
        $("#pikame").PikaChoose({
            buildFinished: fb_pop,
            autoPlay: false,
            showCaption: false,
            thumbOpacity: 0.7,
            animationSpeed: 400,
            transition: [1],
            text: {previous: "", next: "" },
            carousel: true
        });
    }

    $(".fancy-link").fancybox({
        prevEffect : 'none',
        nextEffect : 'none'
    });

    $(".sorting .sort-toggle").click(function(){
        $(this).toggleClass("open");
        if ($(this).hasClass("open")){
            $(this).parent().siblings(".sort-list").slideDown(200);
        } else {
            $(this).parent().siblings(".sort-list").slideUp(200);
        }
        return false;
    });

    $(".sorting .sort-list a").click(function(){
        $(".sorting .sort-list a").not($(this)).removeClass("current");
        $(this).addClass("current");
        $(".sorting .sort-toggle").removeClass("open");
        $(this).parents(".sort-list").slideUp(200);
        $(".sorting .sort-toggle").text($(this).text());
        return false;
    });

    $("body").click(function(e){
        var clicked = $(e.target),
            clickedClass = clicked.prop("class");
        if(clicked.parents("ul").hasClass("sort-list") || clicked.hasClass("sort-list")){}else{
            $(".sorting .sort-toggle").removeClass("open");
            $(".sort-list").slideUp(400);
        }
    })

    changeCartCounters();

    $(".mini-cart .count, .mini-cart .total").bind("change", function(){
    	changeCartCounters();
    });


    /* рейтинг */
    $(".raiting").hover (
        function(){ /* при наведении мыши на блок с рейтингом, динамически добавляем блок с подсветкой выбранной оценки */
            if (!$(this).hasClass("disable")) $(this).append("<span></span>");
        },
        function()
        { /* при уходе с рейтинга, удаляем блок с подсветкой */
            $(this).find("span").remove();
    });


    var rating;

    $(".raiting").mousemove (
        /*
         устанавливаем ширину блока с подсветкой таким образом, чтобы была выделена оценка, находящаяся под курсором мыши
         */
        function(e){
            if (!$(this).hasClass("disable")){
                if (!e) e = window.event;
                if (e.pageX){
                    x = e.pageX;
                } else if (e.clientX){
                    x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;

                }
                var posLeft = 0;
                var obj = this;
                while (obj.offsetParent)
                {
                    posLeft += obj.offsetLeft;
                    obj = obj.offsetParent;
                }
                var offsetX = x-posLeft,
                    modOffsetX = 5*offsetX%this.offsetWidth; /* 5 - число возможных оценок */
                rating = parseInt(5*offsetX/this.offsetWidth);

                if(modOffsetX > 0) rating+=1;

                $(this).find("span").eq(0).css("width",rating*15+"px"); /* ширина одной оценки, в данном случае одной звезды */
                }
        });

    $(".raiting").click ( 
        function()
        {
		if(!$(this).hasClass("disable")){
		var zv=$(".raiting").not($(".raiting.disable"));
		
			$("#feedbacks .new-feedback .raiting input[name=\'rating\']").val(rating);
			$(zv).find("div").remove();
			$(zv).append("<div style='width: " + (rating ) *100/5 + "%'></div>");
		}
           
            return false;
        });

		$("#fedb_call_head").click(function(){
		$("#back_call").fadeIn();
		return false;
		});
		$("#close_back_call").click(function(){
		$("#back_call").fadeOut();
		});
		$("#fedb_call_b").click(function(){
		var valid=0;
		$("#divForm .req").each(function(){
		if($(this).val()==""){
		$(this).css("border","1px solid red");
		valid+=1;
		}else{
		$(this).css("border","");
		}
		});
		
		if(valid!=0){
		alert("Пожалуйста заполните все обязательные поля.");
		}
		else{
		    $.post('/index.php?route=product/fedbcall', { 'cont_name' : $("#tbName").val(), 'cont_tel' : $("#tbPhone").val(), 'cont_comment' : $("#tbMessage").val(), 'cont_city' : $("#tbCity").val(), 'cont_time_t' : $("#tbTo").val(), 'cont_time_f' : $("#tbFrom").val()}, function( result,status,xhr ) {
var rez = JSON && JSON.parse(result) || $.parseJSON(result);
    if(rez.result==1){
	
	$("#back_call input").val("");
	$("#back_call textarea").val("");
	alert(rez.alert);
	$("#back_call").fadeOut();
	}
	else{
	alert(rez.alert);
	}
    },"html");//end post  
		}
		
		
		
		});
		
});

function imgH(){
    if (document.getElementById("tabs")){
        $(".photos-list a").each(function(){
            $(this).find("img").css("margin-top",($(this).height()-$(this).find("img").height())/2);
        });
    }
}

window.onload = function(){
    imgH();
}