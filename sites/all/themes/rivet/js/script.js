(function ($, Drupal) {

	var $doc = $( document ),
		$html = $( document.documentElement ),
		$body = $( document.body ),
		$htmlBody = $.fn.add.call($html,$body),
		$header = $("header"),
		$topBar = $header.find(".top-bar"),
		$logoLink = $topBar.find(".title-area").find("a"),
		//$titleArea = $header.find(".title-area"),
		$menuIcon = $(".menu-icon"),
		$topBarSection = $(".top-bar-section"),
		$sections = $("main").children("article"),
		$nav = $("nav"),
		$navLinks = $nav.find(".main-menu").find('a'),
		$navLinksFooter = $("footer").find(".menu-footer").find('a'),
		$contactForm = $(".block-webform-client-block-39"),
		getCookie = function(cname) {
		    var name = cname + "=", ca = document.cookie.split(';');
		    for(var i=0; i<ca.length; i++) {
		        var c = ca[i];
		        while (c.charAt(0)==' ') c = c.substring(1);
		        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
		    }
			
			return "";
		},
		dataStore = window.localStorage,
		emailRE = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		//$contactForm = $('.webform-client-form'),
		//$scrollCircleButton = $( document.getElementById('scroll-circle-button') ),
		$alert = $( '<div />' ).addClass( 'alert-box success radius' )
							   .html( 'Thank you for your submission. <a href="#" class="close">&times;</a>' ),
		scrolling = false,
		/*transitionEndSupport = function () { 
			var prefixes = [
					"",
					"webkit",
					"o"
				],
			i = -1,
			l = prefixes.length,
			ret = false,
			vendor;

			while ((i += 1) < l) {
				vendor = prefixes[i];
				if (("on" + vendor + "transitionend") in window) {
					ret = new window.Boolean(true);
					ret.event = ((vendor) ? vendor + "T" : "t") + "ransitionEnd";
					break;
				}
			}
			
			return ret.event;
		},
		transitionEnd = transitionEndSupport(), */		
		pageInit = function() {
			if ( $body.hasClass("front") ) { 
				window.addEventListener('popstate', function(event) {
					event.preventDefault();
					scrolling = true;
					var $dest = ( event.state ) ? $( document.getElementById(event.state.element) ) : $sections.first();
					smoothScroll( $dest );								
					return false;
				});
			}
		},
		smoothScroll = function($dest, clbk) {
			
			if ( typeof $dest !== "number" && !$dest.length ) return false;

			var to = typeof $dest !== "number" ? ( typeof $dest.offset === "function" && typeof $dest.offset().top === "number" ? $dest.offset().top - $topBar.outerHeight() : 0 ) : $dest;

			if ( !$header.hasClass("fixed") ) {
				to += 24;
			}
			
			if ( to > -1 ) {
				if ( to > 0 )  { to += 1; }
				$htmlBody.animate({ scrollTop: to }, 400, function() { 
					scrolling = false; 
					if ( typeof clbk === "function" ) { clbk.call(); }
				});
				
				updateNav();
			} else if ( typeof clbk === "function" ) {
				clbk.call();
			}
		},
		updateNav = function() {
			$navLinks.removeClass('active');
			getNavFromPage( window.location.hash.replace('#', '') ).addClass('active');
		},
		getNavFromPage = function( lookup ) {
			return $navLinks.filter(function() {
				return this.getAttribute( 'data-menuanchor' ) === lookup;
			}).slice(0,1);
		},
		getPageFromNav = function(lookup) {
			return $('[data-shortname="' + lookup + '"]').slice(0,1);
			/*return $sections.filter(function() {
				return this.getAttribute( 'data-shortname' ) === lookup;
			}).slice(0,1);*/
		},
		debounce = function(func, wait, immediate) {
			var timeout;
			return function() {
				var context = this, args = arguments,
					later = function() {
						timeout = null;
						if (!immediate) func.apply(context, args);
					},
					callNow = immediate && !timeout;
	
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow) func.apply(context, args);
			};
		},
		navWatchScroll = debounce(function() {
		//navWatchScroll = (function() {			
			if ( (typeof window.scrollY === "number" && window.scrollY > 20) || 
				( typeof window.pageYOffset === "number" && window.pageYOffset > 20) ) {
				$header.addClass("fixed");
			} else {
				$header.removeClass("fixed")
			}
		}, 4),
		$platformCTAs = $('.view-cta-platform').find('.secondary'),
		closeCTA = function(evt) {
			if ( evt ) { evt.preventDefault(); }
			$body.removeClass("fixed-active");
			$platformCTAs.removeClass("active");
		},
		$contactLi = $("header").find(".menu-340"),
		contactFormAni = false,
		toggleContactForm = function() { console.log("00")

			if ( $contactForm.hasClass("active") ) {
				$body.removeClass("fixed-active");
				$contactForm.removeClass("active");
				$contactLi.removeClass("shown")
			} else {
				$html.removeClass("touch-nav-enabled");
				$body.addClass("fixed-active");
				$header.addClass("fixed");
				$contactForm.addClass("active");
				$contactLi.addClass("shown")
			}
			
			contactFormAni = true;
			setTimeout(function() { contactFormAni = false; }, 2000);
		},
		$articleLinks = $(".view-articles-infographics").find('a[data-access-link]'),
		refreshArticlesLinks = function() {
			$articleLinks.each(function() {
				this.href = this.getAttribute('data-access-link');
			});
		},
		navLinkAction = function(evt) {
			var dest = this.getAttribute( 'data-menuanchor' );
			if ( dest === "contact" && contactFormAni === false) {
				evt.preventDefault();
				//toggleContactForm();
				$html.removeClass("touch-nav-enabled");
				$body.addClass("fixed-active")
				$header.addClass("fixed");
				$contactForm.addClass("active");
				$contactLi.addClass("shown")
			} else if ( dest ) {
				$html.removeClass("touch-nav-enabled");
				var $dest = getPageFromNav( dest );
				if ( $dest.length ) {
					evt.preventDefault();
					smoothScroll( $dest );
				}
			}
		},
	    $formWrapper = $("#node-6"),
		$mainMenu = $("#main-menu"),
		contactFormAni = false;		


		if ( window.location.hash ) {
			var $dest = getPageFromNav( window.location.hash.replace('#', '') );
			setTimeout( function() { smoothScroll( $dest ); }, 350);
		} else {
			updateNav();
			pageInit.call();
		}	


	//Drupal.behaviors.rivet = {
    //	attach: function(context, settings) {
						
			$doc.foundation();
			
			var htmlClasses = new Array();

			//htmlClasses.push( transitionEnd ? 'transitionend' : 'no-transitionend' );
			htmlClasses.push( 'placeholder' in document.createElement('input') ? 'placeholder' : 'no-placeholder' );
			htmlClasses.push( 'ontouchstart' in document.documentElement ? 'touch-support' : 'no-touch-support' );

			if (Function('/*@cc_on return document.documentMode===10@*/')()){
				htmlClasses.push('lte-ie10');
			}

			$html.addClass( htmlClasses.join(" ") );
					
			$(".view-customers .view-content").slick({
				//autoplay: true,
				autoplaySpeed: 5000,
				dots: true,
				infinite: true,
				speed: 500,
				//fade: true,
				slide: '.slide',
				cssEase: 'linear'
			});


			if ( $body.hasClass("front") ) {	
				
				if ( !('ontouchstart' in document.documentElement) ) {
					var BV = new $.BigVideo({ container: $body.children('.page') });
					
					BV.init();
					
					BV.show(
						[{
							src : "http://media.rivet.works/Rivet_Background_Grey0.mp4", 
							type: "video/mp4"
						},{
							src : "http://media.rivet.works/Rivet_Background_Grey0.webm", 
							type: "video/webm"
						}],
						{
							ambient:!0, 
							loop:true,
							autoplay:true,
							preload:'auto'
						}
					);
				}

				$(window).on("scroll", navWatchScroll).trigger("scroll");

			

				$logoLink.on("click", "img", function(evt) {
					evt.preventDefault();
					smoothScroll(0);
				});

				/* CTA CLICKS */
				$(".view-cta-platform").on("click", ".primary", function(evt) {
					evt.preventDefault();
					var $this = $(this);
					$this.siblings('.secondary').addClass("active");
					$body.addClass("fixed-active");
				});			
				
				$('[data-close="platform"]').on("click", closeCTA);
				
				$('[data-cta="platform"]').on("click", function(evt) {
					evt.preventDefault();
					var thisIndex = $(this).parent().children().index( $(this) );
					
					$platformCTAs
						.removeClass("active")
						.eq( thisIndex ).addClass( "active" );
				});

			} // front page
			
			
	//	}
    //};
    
    
	/*$sections.on("waybetter.outview", function() {
		var $that = $(this);
		
		if ( scrolling === false ) {
			var current = $that.next('[data-waybetter]').length ? $that.next('[data-waybetter]') : $that.prev('[data-waybetter]'),
				title = current.attr("data-title");
			if ( current.length && typeof history.pushState !== "undefined" ) {
				history.pushState({ element: current.attr('id') }, title.replace("-", " "), '#' + title);
			}
			
			updateNav();
		}
	}).waybetter({ threshold: 200 });*/
	
	if ( !window.matchMedia || window.matchMedia("(min-width: 641px)").matches ) {
		$(".node-what-we-do").find(".video").waybetter({ threshold: 50 });
		$(".view-cta-platform").add(".view-cta-resources").waybetter({ threshold: 50 });
	}
	
	
	$mainMenu.after( $formWrapper.addClass("for-modal") );
	
	$navLinks.add( $navLinksFooter ).on("click", navLinkAction);
	
	
	$(document).on("click", '[data-trigger="contact-form"]', toggleContactForm);
	
	$menuIcon.on("click", "a", function(evt) {
		evt.preventDefault();
		$html.toggleClass("touch-nav-enabled");
	});


	$(document).on("click", "[data-scroll-to]", function(evt) { 
		evt.preventDefault();
		smoothScroll( $( $(this).attr("data-scroll-to") ) );
	})
	.on("click", ".scroll-to-top", function(evt) {
		evt.preventDefault();
		smoothScroll( 0 );
	})
	.on("click", 'a[href^="http"], a[href^="//"]', function(evt) {
		if(this.className.indexOf('wistia-popover') < 0 ) {
			if ( ( window.location.host !== this.href.replace('http://', '').replace('https://', '').split("/")[0]) && ( this.getAttribute("target") === null) ) {
				evt.preventDefault();
				window.open(this.href);
			}
		}
	});
	
	// CLEAN UP
	var $webforms = $(".webform-client-form"),
		invalidEmailWarning = function() {
			//console.log("bad");	
		},
		submitWebform = function() {
			var $this = $(this),
				$submitButton = $this.find('button.form-submit').not('[value="Upload"]'),
				dataArray = $this.serializeArray(),
				data = $this.serialize(),
				message,
				$messageCont = $this.find('.submission-message'),
				gated =  $this.hasClass("webform-client-form-40");

			$.post(window.location.href, data)
			 .done(function( response, result, xhr ) {
			 	var $response = $(response).find(".messages").children().children();
				message = $response.length ? $response.html() : 'Thank You.';
				$messageCont.html( message ).addClass("active");
				setTimeout(function() { $messageCont.fadeOut(300); }, 3000);
				
				if ( gated ) {
					if (dataStore) { 
						dataStore.setItem("accessarticles", true); 
						var userInfoArray = dataArray.slice(0,5),
						userInfo = {};
						for(var i in userInfoArray) {
							userInfo[userInfoArray[i]["name"]] = userInfoArray[i]["value"];
						}
						
						dataStore.setItem("rivetHubSpotData", JSON.stringify(userInfo));
					}
				
					setTimeout( function() {
						$this.closest('section').removeClass("active");
					}, 2000);
					
					refreshArticlesLinks();
				} else if ($this.attr("id") === "webform-client-form-39" ) {
					setTimeout( function() { 
						$body.removeClass("fixed-active");
						$("#contact-form-close").trigger("click");
						$messageCont.removeClass("active").empty();
						$this.get(0).reset();
					}, 1500);
				}
			});
		};
	
	
	
	$webforms.on("submit", function(evt) {
		//if ( $(this).attr("id") === "webform-client-form-38" ) return;
		
		evt.preventDefault();

		var $this = $(this),
			emailValue = $(this).find('[type="email"]').val(),
			requiredsPopulated = function() {
				var error = null;
				$this.find(".required").each(function() { 
					if ( this.value === '' && !error ) { 
						error = this; 
					}
				});
				return error;
			};
			
		requiredsPopulated = requiredsPopulated();
		
		if ( requiredsPopulated ) {
			var //$messageCont = $this.find('.submission-message')
				$messageCont = $('<div />').addClass("error-message").on("click", function() { $(this).fadeOut(200, function() { $(this).remove(); }) }),
				name = requiredsPopulated.getAttribute('placeholder');

				/*$( requiredsPopulated ).addClass("user-required").on("click focus", function() {
					$(this).removeClass("user-required");
				});*/
				
				if ( name === null ) {
					name = $(requiredsPopulated).parent().parent().children('label').text().replace(' *', '');
				}
					
				$messageCont.text( name + ' is required.' );
				$( requiredsPopulated.parentNode ).append( $messageCont )
		}
		else if ( !emailRE.test(emailValue) ) {
			invalidEmailWarning();
		} else {
			if ( $(this).attr("id") === "webform-client-form-38" ) {
				$this.get(0).submit();
			} else {
				submitWebform.call(this);
			}
				
		}
	}).each(function() {
		var	$submitButton = $(this).find('button.form-submit').not('[value="Upload"]'),
			$message = $('<div />').addClass("submission-message");
			
		$message.insertAfter( $submitButton );
	});
	
	
	
	// articles gate
	if ( $body.hasClass("page-articles-infographics") ) {
		var $articleLinks = $('.view-articles-infographics').find('a'),
			$gateForm = $('#page-hidden').children('.block-webform-client-block-40'),
			handleArticleAccess = function() {
				//if ( !getCookie("accessarticles") ) {
				if ( !dataStore || (!dataStore.getItem("accessarticles") === true) ) {
					this.setAttribute("data-access-link", this.href);
					this.href = "#";
					$(this).on("click", function(evt) {
						if ( this.href.slice(-1) === "#" ) { 
							evt.preventDefault();
							
							$gateForm.addClass( "active" );
							
							var sel = 'data-sfdcCampaignId',
								sfdcCampaignId = $(this).closest('.views-row').attr(sel);
							$gateForm.find('[name="submitted[sfdccampaignid]"]').val( sfdcCampaignId );
						}
					});
				}
			};
		$articleLinks.each(handleArticleAccess);
	}
	
	
	if ( dataStore !== null ) {
		$(window).on("storage", function(evt) {
			if ( evt.key === "accessarticles" && evt.newValue === true ) {
				refreshArticlesLinks();
			}
		});

		if ( $body.hasClass("node-type-article") ) {
			var data = dataStore.getItem("rivetHubSpotData");
			if ( data ) {
				var data = JSON.parse( data ),
					$form = $( "#webform-client-form-40" ),
					sel = 'data-sfdcCampaignId',
					sfdcCampaignId = document.querySelector('[' + sel + ']').getAttribute(sel),
					/*$sfdcCampaignId = $('<input />').attr({ 
						"type": "hidden",
						"name": "sfdcCampaignId",
						"value": sfdcCampaignId,
					});*/
					$sfdccampaignid = $('[name="submitted[sfdccampaignid]"]');
					
					
					
				for( var d in data ) {
					$form.find('[name="' + d + '"]').val( data[d] );
				}
				
				
				$sfdccampaignid.val(sfdcCampaignId);
				//$form.append( $sfdcCampaignId );
								
				var newData = $form.serialize();
				
				$.post(window.location.href, newData);
			} else {
				window.location.replace('/articles-infographics');
				
			}			
		}		
		
		
		
	}
	// CLEAN UP
		

		
	
		
	$(document).on("click", "#webform-client-form-40 .webform-component--close", function(evt) {
		evt.preventDefault();
		$gateForm.removeClass("active").find("form").get(0).reset();
		$gateForm.find('.error-message').remove();
	})
	.on("click", "#contact-form-close", function() {
		$body.removeClass("fixed-active");
		$contactForm.removeClass("active");
		$contactLi.removeClass("shown")
	});
	
	
	
	
	// TEAM PAGE
	$(".view-Team").on("click", ".button", function() { 
		var $this = $(this),
			$extra = $this.closest(".person").find(".extra");
			
		if ( $this.hasClass("open") ) {
			if ( $extra.hasClass("active") ) {
				$this.removeAttr("data-active");
				$extra.removeClass("active");
			} else {
				$extra.addClass("active");	
				$this.attr("data-active", "");
			}
		} else if ( $this.hasClass("close") ) {
			$this.closest(".person").find(".extra").removeClass("active");
		}
	});				
    
    $( 'input[type="file"]' ).on("change", function() {
	    var $cont = $(this).siblings(".file-name").length ? $(this).siblings(".file-name") : $('<div />').addClass("file-name").insertAfter( this.parentNode ),
	    	fileName = this.files[0].name;

			$cont.html( fileName );
    });
	// TEAM PAGE 	

	
	$(".grid").mixItUp({
		animation: {
	        enable: true,
	        effects: 'fade',
	        duration: 600,
	        easing: 'ease',
	        perspectiveDistance: '3000',
	        perspectiveOrigin: '50% 50%',
	        /*queue: true,
	        queueLimit: 1,
	        animateChangeLayout: false,
	        animateResizeContainer: true,
	        animateResizeTargets: false,
	        staggerSequence: false,
	        reverseOut: false*/
    	},
		selectors: {
    	    target: '.views-row',
			//filter: '.filter',
		}
    });
	
	$(".grid-filters").on("click", ".toggle, label", function() {
		$(this).parent().toggleClass("active");
	});
	
	
	/* stream social */
	$(".view-stream").on("click", ".social-share", function(evt) {
	    var $cont = $( this );
	
	    if ( !$cont.hasClass("active") ) {
	      evt.preventDefault();
	      evt.stopPropagation();
	      $cont.addClass("active");
	      return false;
	    }
    
  	}).on("click", ".overlay", function() {
	  	window.location.href = this.querySelector(".link").childNodes[0].href
  	});
  	
  	$(".view-stream .social-share").on("mouseout", function(evt) {
    	var $this = $(this), landed = evt.relatedTarget;
    	console.log( landed );
		if ( landed !== this && !$this.find( landed ).length ) {
			$this.removeClass("active");
		}

  	});
	
	$("table").each( function() {
		$(this).wrap( $('<div />').addClass("responsive-table") );
		$(this).wrap( $('<div />') );
	})
	
	
	$(".responsive-video").each( function() {
		var height = this.childNodes[0].getAttribute("height"),
			width = this.childNodes[0].getAttribute("width");
		$( this ).css("padding-top", ((height*100)/width) + "%");
	});
	
	
    $(".sidebar-tab").on("click", function(evt) {
	    evt.preventDefault();
	   $(this) .parent("aside").toggleClass("active");
    });	
	
	
	$("#scroll-arrow").on("click", function() { smoothScroll( $sections.slice(1,2) ); });
	

})(jQuery, Drupal);