<!DOCTYPE html>
<html class="no-js">

<!-- Mirrored from www.ivanjevremovic.in.rs/live/estimation/boxed/blue/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 May 2016 23:38:24 GMT -->
@include('includes.sitehead')

<body class="pattern-4">

<!-- Preloader -->
	<div id="preloader">
	    <div id="status"></div>
	</div>

<!--  START STYLE SWITCHER (preview only)  -->

	

	<!--  END STYLE SWITCHER (preview only)  -->


	<div class="wrapper">


		@include('includes.siteheader')

		<!--Revolution Slider begin-->
		
		<br/><br/>

		<!--end Revolution Slider-->

		@yield('content')

		<footer id="footer" class="content">
			

			<div class="footer-bottom container-center cf">					
					
				<div class="bottom-left">									
					<p class="copyright">Copyright &copy; {{date('Y')}} Lixnet Technologies. All rights reserved</p>				
				</div><!-- end bottom-left -->		
				
				<div class="bottom-right">
					<nav>
						<ul id="footer-nav">
							<li><a href="{{URL::to('/')}}">Home</a></li>
							<li><a href="{{URL::to('about')}}">About</a></li>
							<li><a href="{{URL::to('industries')}}">Industries</a></li>
							<li><a href="{{URL::to('download')}}">Download</a></li>
							<li><a href="{{URL::to('faq')}}">FAQ</a></li>
							<li><a href="{{URL::to('support')}}">Support</a></li>
							<li><a href="{{URL::to('contact')}}">Contact</a></li>
						</ul>
					</nav>
				</div><!-- end bottom-right -->				
					
			</div><!-- end footer-bottom -->
		</footer>

	</div><!-- end wrapper -->	


	

	<div class="scroll-top"><a href="#"><i class="fa fa-angle-up"></i></a></div>

<!--*************************
*							*
*      JAVASCRIPT FILES	 	*
*							*
************************* -->

<!--imports jquery-->

{{ HTML::script('js/jquery-1.10.2.min.js') }}


{{ HTML::script('js/jquery-migrate-1.1.0.min.js') }}
<!-- used for the contact form -->

{{ HTML::script('js/jquery.form.js') }}
<!-- used for the the fun facts counter -->

{{ HTML::script('js/jquery.countTo.js') }}
<!-- for displaying flickr images -->

{{ HTML::script('js/jflickrfeed.min.js') }}
<!-- used to trigger the animations on elements -->

{{ HTML::script('js/waypoints.min.js') }}
<!-- used to stick the navigation menu to top of the screen on smaller displays -->

{{ HTML::script('js/waypoints-sticky.min.js') }}
<!-- used for rotating through tweets -->

{{ HTML::script('js/vTicker.js') }}
<!-- imports jQuery UI, used for toggles, accordions, tabs and tooltips -->

{{ HTML::script('js/jquery-ui-1.10.3.custom.min.js') }}
<!-- used for smooth scrolling on local links -->

{{ HTML::script('js/jquery.scrollTo-1.4.3.1-min.js') }}
<!-- used for opening images in a Lightbox gallery -->

{{ HTML::script('js/nivo-lightbox.min.js') }}
<!-- used for displaying tweets -->

{{ HTML::script('js/jquery.tweet.js') }}
<!-- flexslider plugin, used for image galleries (blog post preview, portfolio single page) and carousels -->

{{ HTML::script('js/jquery.flexslider-min.js') }}
<!-- used for sorting portfolio items -->

{{ HTML::script('js/jquery.isotope.js') }}
<!-- for dropdown menus -->

{{ HTML::script('js/superfish.js') }}
<!-- for detecting Retina displays and loading images accordingly -->

{{ HTML::script('js/retina-1.1.0.min.js') }}


{{ HTML::script('js/jquery.sharrre.min.js') }}
<!-- easing plugin for easing animation effects -->

{{ HTML::script('js/jquery-easing-1.3.js') }}
<!-- Slider Revolution plugin -->

{{ HTML::script('plugins/rs-plugin/js/jquery.themepunch.plugins.min.js') }}			

{{ HTML::script('plugins/rs-plugin/js/jquery.themepunch.revolution.min.js') }}		

<!--imports custom javascript code-->

{{ HTML::script('js/custom.js') }}

{{ HTML::script('js/options.js') }}

</body>


<!-- Mirrored from www.ivanjevremovic.in.rs/live/estimation/boxed/blue/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 May 2016 23:38:24 GMT -->
</html>