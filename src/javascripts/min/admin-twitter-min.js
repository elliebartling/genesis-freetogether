jQuery(document).ready(function($){$("#ft_org_button").text("Check for Twitter Account"),$("#ft_org_button").on("click",function(r){r.preventDefault();var e=$("#ft_org_twitter").val();$.ajax({url:"../wp-content/themes/genesis-freetogether/get_twitter_user.php",type:"POST",data:{user:e},success:function(r){if("undefined"==typeof r.errors||r.errors.length<1){var e=JSON.parse(r),t=$("#partner_org_social");t.append('<div id="partner-social-profile">'),$("#partner_org_social p:first").text("Success!"),$("#partner_org_social p:first").append(" We found "+e.name+" on Twitter, so you don't have to fill out as much data by hand.</p>"),$("#ft_org_desc").val(e.description),$("#ft_org_url").val(e.url);var o=e.profile_image_url.replace("_normal",""),a='<div class="image-preview" style="background: url('+o+'); background-size: cover; width: 200px; height: 200px; border-radius: 2px; margin: 2rem;"></div>';$("#ft_org_image").val(o),$("#ft_org_image_description").append('<div id="image-preview"></div>'),$("#image-preview").html(a);var i=e.location.split(","),n=i[1].substr(1,2);$("#ft_org_state").val(n);var s=e.profile_link_color;$("#ft_org_color").val("#"+s),$(".wp-color-result").attr("style","background-color: #"+s+";")}else $("#partner_org_social p:first").text("Response error")},error:function(r){$("#partner_org_social p:first").text("Request error")}})})});