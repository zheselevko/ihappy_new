	<?php
	header("Content-type: text/css");
if ($this->config->get('boxcolor')) { 
			$boxcolor = $this->config->get('boxcolor');
		} else {
      		$boxcolor = 'ffffff';
    	}

if ($this->config->get('textcolor')) { 
			$textcolor = $this->config->get('textcolor');
		} else {
      		$textcolor = '000000';
    	}

if ($this->config->get('boxcolor2')) { 
			$boxcolor2 = $this->config->get('boxcolor2');
		} else {
      		$boxcolor2 = 'ffffff';
    	}


if ($this->config->get('textcolor2')) { 
			$textcolor2 = $this->config->get('textcolor2');
		} else {
      		$textcolor2 = '000000';
    	}

if ($this->config->get('boxcolor3')) { 
			$boxcolor3 = $this->config->get('boxcolor3');
		} else {
      		$boxcolor3 = 'ffffff';
    	}


if ($this->config->get('textcolor3')) { 
			$textcolor3 = $this->config->get('textcolor3');
		} else {
      		$textcolor3 = '000000';
    	}


if ($this->config->get('boxcolor4')) { 
			$boxcolor4 = $this->config->get('boxcolor4');
		} else {
      		$boxcolor4 = 'ffffff';
    	}


if ($this->config->get('textcolor4')) { 
			$textcolor4 = $this->config->get('textcolor4');
		} else {
      		$textcolor4 = '000000';
    	}

if ($this->config->get('sizem')) { 
			$sizem = $this->config->get('sizem');
		} else {
      		$sizem = '180';
    	}

if ($this->config->get('sizem2')) { 
			$sizem2 = $this->config->get('sizem2');
		} else {
      		$sizem2 = '10';
    	}

if ($this->config->get('sizem3')) { 
			$sizem3 = $this->config->get('sizem3');
		} else {
      		$sizem3 = '13';
    	}
?>
<style type="text/css">	
.urbangreymenu{width: <?php echo $sizem; ?>px; }
h3 {margin: 2px 0px 10px;}
.urbangreymenu .headerbar{
font: bold <?php echo $sizem3; ?>px Verdana;
color: #D7251C;
background: #<?php echo $boxcolor; ?>;
margin-bottom: 2px; 
padding: 5px 0 5px 31px; 
border: 2px solid #<?php echo $boxcolor; ?>;
border-radius: <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px;
}
.urbangreymenu .subs{
background:#<?php echo $boxcolor; ?>; 
border: 2px solid #<?php echo $boxcolor; ?>;
 border-radius: <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px;
}
.urbangreymenu .headerbar a{
text-decoration: none;
font-size: <?php echo $sizem3; ?>px;
color: #<?php echo $textcolor; ?>;
display: block;
}
.urbangreymenu .headerbar a:hover{ 
text-decoration: none;
color: #<?php echo $textcolor2; ?>;
text-shadow: 0 0 10px #<?php echo $textcolor2; ?>, 0 0 20px #<?php echo $textcolor2; ?>, 0 0 30px #<?php echo $textcolor2; ?>, 0 0 40px #<?php echo $textcolor2; ?>;
transform:translate(0px, 0px) rotate(0deg) scale(1.1);
-webkit-transform:translate(0px, 0px) rotate(0deg) scale(1.1); 
-moz-transform:translate(0px, 0px) rotate(0deg) scale(1.1);
-o-transform:translate(0px, 0px) rotate(0deg) scale(1.1);
}
.urbangreymenu ul{
list-style-type: none;
margin: 0;
padding: 0;
margin-bottom: 0;
}
.urbangreymenu ul li{padding-bottom: 2px; }
.urbangreymenu ul li a{
font-size: <?php echo $sizem3; ?>px;
color: #<?php echo $textcolor3; ?>;
background: #<?php echo $boxcolor3; ?>;
display: block;
padding: 5px 0;
line-height: 17px;
padding-left: 8px; /*link text is indented 8px*/
text-decoration: none;
}
.urbangreymenu ul li a:visited{color: #6D589D;}
.urbangreymenu ul li a:hover{ 
text-decoration: none;
text-align: center;
background: #<?php echo $boxcolor4; ?>; 
color: #<?php echo $textcolor4; ?>;
width: 80%;
text-shadow: 0 0 10px #<?php echo $textcolor4; ?>, 0 0 20px #<?php echo $textcolor4; ?>, 0 0 30px #<?php echo $textcolor4; ?>, 0 0 40px #<?php echo $textcolor4; ?>;
transform:translate(10px, 0px) rotate(0deg) scale(1.1);
-webkit-transform:translate(10px, 0px) rotate(0deg) scale(1.1); 
-moz-transform:translate(10px, 0px) rotate(0deg) scale(1.1); 
-o-transform:translate(10px, 0px) rotate(0deg) scale(1.1);
}
.submenu li a { 
width: 90%;
background: #<?php echo $boxcolor4; ?>; 
border: 2px solid #<?php echo $boxcolor4; ?>;
border-radius: <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px <?php echo $sizem2; ?>px;
text-align: center;
}
</style>

