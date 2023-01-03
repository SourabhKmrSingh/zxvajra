/*  ---------------------------------------------------
    Template Name: Fashi
    Description: Fashi eCommerce HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com/
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").hide();
        $("#preloder").hide();
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*------------------
        Hero Slider
    --------------------*/
    $(".hero-items").owlCarousel({
        loop: true,
        margin: 0,
        nav: true,
        items: 1,
        dots: false,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
		autoplayHoverPause: true
    });

    /*------------------
        Product Slider
    --------------------*/
   $(".product-slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        items: 4,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1700,
        autoHeight: false,
        autoplay: true,
		autoplayHoverPause: true,
        responsive: {
            0: {
                items: 2,
            },
            576: {
                items: 3,
            },
            992: {
                items: 5,
            },
            1200: {
                items: 5,
            }
        }
    });
	
	/*------------------
        Gainers Slider
    --------------------*/
   $(".gainers-slider").owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        items: 5,
        dots: true,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1700,
        autoHeight: false,
        autoplay: false,
        responsive: {
            0: {
                items: 2,
            },
            576: {
                items: 3,
            },
            992: {
                items: 5,
            },
            1200: {
                items: 5,
            }
        }
    });

    /*------------------
       logo Carousel
    --------------------*/
    $(".logo-carousel").owlCarousel({
        loop: false,
        margin: 30,
        nav: false,
        items: 5,
        dots: false,
        navText: ['<i class="ti-angle-left"></i>', '<i class="ti-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        mouseDrag: false,
        autoplay: true,
        responsive: {
            0: {
                items: 3,
            },
            768: {
                items: 5,
            }
        }
    });

    /*-----------------------
       Product Single Slider
    -------------------------*/
    $(".ps-slider").owlCarousel({
        loop: false,
        margin: 10,
        nav: true,
        items: 4,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
    });
    
    /*------------------
        CountDown
    --------------------*/
    // For demo preview
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    if(mm == 12) {
        mm = '01';
        yyyy = yyyy + 1;
    } else {
        mm = parseInt(mm) + 1;
        mm = String(mm).padStart(2, '0');
    }
    var timerdate = mm + '/' + dd + '/' + yyyy;
    // For demo preview end

    console.log(timerdate);
    

    // Use this for real timer date
    /* var timerdate = "2020/01/01"; */

	$("#countdown").countdown(timerdate, function(event) {
        $(this).html(event.strftime("<div class='cd-item'><span>02</span> <p>Days</p> </div>" + "<div class='cd-item'><span>06</span> <p>Hrs</p> </div>" + "<div class='cd-item'><span>40</span> <p>Mins</p> </div>" + "<div class='cd-item'><span>52</span> <p>Secs</p> </div>"));
        //$(this).html(event.strftime("<div class='cd-item'><span>%D</span> <p>Days</p> </div>" + "<div class='cd-item'><span>%H</span> <p>Hrs</p> </div>" + "<div class='cd-item'><span>%M</span> <p>Mins</p> </div>" + "<div class='cd-item'><span>%S</span> <p>Secs</p> </div>"));
    });
	
    /*----------------------------------------------------
     Language Flag js 
    ----------------------------------------------------*/
    $(document).ready(function(e) {
    //no use
    try {
        var pages = $("#pages").msDropdown({on:{change:function(data, ui) {
            var val = data.value;
            if(val!="")
                window.location = val;
        }}}).data("dd");

        var pagename = document.location.pathname.toString();
        pagename = pagename.split("/");
        pages.setIndexByValue(pagename[pagename.length-1]);
        $("#ver").html(msBeautify.version.msDropdown);
    } catch(e) {
        // console.log(e);
    }
    $("#ver").html(msBeautify.version.msDropdown);

    //convert
    $(".language_drop").msDropdown({roundedBorder:false});
        $("#tech").data("dd");
    });
    /*-------------------
		Range Slider
	--------------------- */
	// var rangeSlider = $(".price-range"),
		// minamount = $("#minamount"),
		// maxamount = $("#maxamount"),
		// minPrice = rangeSlider.data('min'),
		// maxPrice = rangeSlider.data('max');
	    // rangeSlider.slider({
		// range: true,
		// min: minPrice,
        // max: maxPrice,
		// values: [minPrice, maxPrice],
		// slide: function (event, ui) {
			// minamount.val('₹' + ui.values[0]);
			// maxamount.val('₹' + ui.values[1]);
		// }
	// });
	// minamount.val('₹' + rangeSlider.slider("values", 0));
    // maxamount.val('₹' + rangeSlider.slider("values", 1));

    /*-------------------
		Radio Btn
	--------------------- */
    $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").on('click', function () {
        $(".fw-size-choose .sc-item label, .pd-size-choose .sc-item label").removeClass('active');
        $(this).addClass('active');
    });
    
    /*-------------------
		Nice Select
    --------------------- */
    $('.sorting, .p-show').niceSelect();

    /*------------------
		Single Product
	--------------------*/
	$('.product-thumbs-track .pt').on('click', function(){
		$('.product-thumbs-track .pt').removeClass('active');
		$(this).addClass('active');
		var imgurl = $(this).data('imgbigurl');
		var bigImg = $('.product-big-img').attr('src');
		if(imgurl != bigImg) {
			$('.product-big-img').attr({src: imgurl});
			$('.zoomImg').attr({src: imgurl});
		}
	});

    $('.product-pic-zoom').zoom();
    
    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
	proQty.prepend('<span class="dec qtybtn">-</span>');
	proQty.append('<span class="inc qtybtn">+</span>');
	proQty.on('click', '.qtybtn', function () {
		var $button = $(this);
		var oldValue = $button.parent().find('input').val();
		if ($button.hasClass('inc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			// Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}
		$button.parent().find('input').val(newVal);
	});

})(jQuery);

function gotoURL(site)
{
	if (site !="")
	{
		self.location = site;
	}
}

function shipping_details()
{
	if($('input[name="shipping_box"]:checked').length > 0)
	{
		$(".shipping_row").fadeIn();
	}
	else
	{
		$(".shipping_row").hide();
	}
}

function shipping_check()
{
	if($('input[name="shipping_box"]:checked').length > 0)
	{
		if($("#shipping_first_name").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_first_name").focus();
			return false;
		}
		else if($("#shipping_mobile").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_mobile").focus();
			return false;
		}
		else if($("#shipping_address").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_address").focus();
			return false;
		}
		else if($("#shipping_city").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_city").focus();
			return false;
		}
		else if($("#shipping_state").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_state").focus();
			return false;
		}
		else if($("#shipping_country").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_country").focus();
			return false;
		}
		else if($("#shipping_pin_code").val() == "")
		{
			alert("Please fill out this field!");
			$("#shipping_pin_code").focus();
			return false;
		}
		else
		{
			return true;
		}
	}
}

function cart_add(slr)
{
	$("#product-list-cart"+slr).submit();
}

function number_format(user_input)
{
	var filtered_number = user_input.replace(/[^0-9]/gi, '');
	var length = filtered_number.length;
	var breakpoint = 1;
	var formated_number = '';
	
	for(i = 1; i <= length; i++)
	{
		if(breakpoint > 3)
		{
			breakpoint = 1;
			formated_number = ',' + formated_number;
		}
		var next_letter = i + 1;
		formated_number = filtered_number.substring(length - i, length - (i - 1)) + formated_number; 
		breakpoint++;
	}
	return formated_number;
}

function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
	return false;

	return true;
}