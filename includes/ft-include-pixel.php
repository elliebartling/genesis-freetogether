<?php 

add_action( 'genesis_before', 'ft_tracking_pixels' );
function ft_tracking_pixels() { ?>

	<!-- Quantcast Tag -->
	<script type="text/javascript">
	var _qevents = _qevents || [];

	(function() {
	var elem = document.createElement('script');
	elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
	elem.async = true;
	elem.type = "text/javascript";
	var scpt = document.getElementsByTagName('script')[0];
	scpt.parentNode.insertBefore(elem, scpt);
	})();

	_qevents.push({
	qacct:"p-RnsPTynnL8wJ-"
	});
	</script>

	<noscript>
	<div style="display:none;">
	<img src="//pixel.quantserve.com/pixel/p-RnsPTynnL8wJ-.gif" border="0" height="1" width="1" alt="Quantcast"/>
	</div>
	</noscript>
	<!-- End Quantcast tag -->

	<!-- Tag for Activity Group: Free Together Retargeting, Activity Name: FreeTogether Retargeting, Activity ID: 3134442 -->

	<!-- Expected URL: http://freetogether.org/ -->



	<!--

	Activity ID: 3134442

	Activity Name: FreeTogether Retargeting

	Activity Group Name: Free Together Retargeting

	-->



	<!--

	Start of DoubleClick Floodlight Tag: Please do not remove

	Activity name of this tag: FreeTogether Retargeting

	URL of the webpage where the tag is expected to be placed: http://freetogether.org/

	This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.

	Creation Date: 02/14/2016

	-->

	<script type="text/javascript">

	var axel = Math.random() + "";

	var a = axel * 10000000000000;

	document.write('<iframe src="https://5391242.fls.doubleclick.net/activityi;src=5391242;type=freert;cat=freet0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=1;num=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');

	</script>

	<noscript>

	<iframe src="https://5391242.fls.doubleclick.net/activityi;src=5391242;type=freert;cat=freet0;dc_lat=;dc_rdid=;tag_for_child_directed_treatment=;ord=1;num=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>

	</noscript>

	<!-- End of DoubleClick Floodlight Tag: Please do not remove -->

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-73725652-1', 'auto');
	  ga('send', 'pageview');

	</script>

	<!-- Facebook Pixel Code -->
	<script>
	!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
	n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
	n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
	t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
	document,'script','//connect.facebook.net/en_US/fbevents.js');

	fbq('init', '1275377385822357');
	fbq('track', "PageView");</script>
	<noscript><img height="1" width="1" style="display:none"
	src="https://www.facebook.com/tr?id=1275377385822357&ev=PageView&noscript=1"
	/></noscript>
	<!-- End Facebook Pixel Code -->


<?php
}