<div id="slideshow">
   <div>
     <img src="backend/attachfiles/5854749.png">
   </div>
   <div>
     <img src="backend/attachfiles/8991275.jpg">
   </div>
   <div>
     <img src="backend/attachfiles/6036261.jpg">
   </div>
</div>

<style>
    #slideshow { 
        margin: 50px auto; 
        position: relative; 
        width: 240px; 
        height: 240px; 
        padding: 10px; 
        box-shadow: 0 0 20px rgba(0,0,0,0.4); 
    }

    #slideshow > div { 
        position: absolute; 
        top: 10px; 
        left: 10px; 
        right: 10px; 
        bottom: 10px; 
    }
</style>

<script>
    $("#slideshow > div:gt(0)").hide();

    setInterval(function() { 
      $('#slideshow > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#slideshow');
    },  3000);
</script>