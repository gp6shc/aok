function thumbs_rating_vote(t,a){var r="thumbsrating"+t,e="#thumbs-rating-"+t;if(localStorage.getItem(r))jQuery("#thumbs-rating-"+t+" .thumbs-rating-already-voted").fadeIn().css("display","block");else{console.log(this.innerHTML),localStorage.setItem(r,!0);var s="thumbsrating"+t+"-"+a;localStorage.setItem(s,!0);var n={action:"thumbs_rating_add_vote",postid:t,type:a,nonce:thumbs_rating_ajax.nonce};jQuery.post(thumbs_rating_ajax.ajax_url,n,function(r){var s=jQuery(e);jQuery(e).html(""),jQuery(e).append(r),jQuery(s).removeClass("thumbs-rating-container"),jQuery(s).attr("id","");var n="#thumbs-rating-"+t;thumbs_rating_class=1==a?".thumbs-rating-up":".thumbs-rating-down",jQuery(n+thumbs_rating_class).addClass("thumbs-rating-voted")})}}