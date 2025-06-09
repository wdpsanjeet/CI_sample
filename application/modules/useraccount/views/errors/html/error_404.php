<!doctype html>
<html>
 <head>
   <title>404 Page Not Found</title>
   <style>
   body{
     width: 99%;
     height: 100%;
     background-color: #FFFFFF;
     color: black;
     font-family: sans-serif;
   }
   div {
     position: absolute;
     width: 500px;
     height: 300px;
     z-index: 15;
     top: 20%;
     left: 50%;
     margin: -100px 0 0 -200px;
     text-align: center;
   }
   h1,h2{
     text-align: center;
   }
   h1{
     margin-bottom: 10px;
   }
   h1 img{
       width: 500px;
    height: 100%;
   }
   h2{
font-family: Prompt;
font-style: normal;
font-weight: 500;
font-size: 38px;
/* identical to box height */
color: #000000;
     margin-bottom: 40px;
   }
   
a {
    text-decoration: none !important;
    transition: 0.5s;
    -webkit-transition: 0.5s;
    -moz-transition: 0.5s;
    -ms-transition: 0.5s;
    -o-transition: 0.5s;
    color: #000;
}
   </style>
 </head>
 <body>
   <div>
       <h1><img src="<?php echo base_url().'themes/frontend/images/404image.png'?>"></h1>
     <h2>Oopsie! Something’s missing...</h2>
     <p>It seems like we couldn’t find what you searched. The page you were looking for doesn’t exist, isn’t available or was loading incorrectly.</p>
     <a class="bd_btn" href='<?php echo base_url(); ?>' ><img src="<?php echo base_url().'themes/frontend/images/back_to_home.png'?>"></a>
   </div>
 </body>
</html>