<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
    <link href="{{ asset('css/404.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="icon" href="http://www.thuthuatweb.net/wp-content/themes/HostingSite/favicon.ico" type="image/x-ico"/>
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    </head>
<body >

    <div class='underline'>
      <span>Sorry</span><span>, </span><span>this </span><span>page </span><span>not</span><span>'</span><span>t</span><span> found</span>
    </div>

    <h1><span>4</span><span>0</span><span>4</span></h1>
    
    <div class='button'><a title='put your link here' href="{{ URL::previous() }}"><span>Back To Previous Page</span></a></div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://www.tinybigideas.com/assets/demo/jquery-gravity/jGravity-min.js"></script>
<script>
$(function() {
$(document).ready(function() {
  var one =false;
  
   $('.button span').mouseover(function(){     
  	if(!one){
     			$('body').jGravity({
               target: 'span',
               ignoreClass: 'dontMove',
               weight: 25,
               depth: 100,
               drag: true
     		 });
      	one =true;
       };
   });
 
  			
});
});
</script>
</body>
</html>