﻿<?php header('Content-type: text/html; charset=utf-8'); ?>

<HTML>
<HEAD><TITLE>Práctica-Teatros</TITLE>
   <STYLE  TYPE="text/css">
   <!--
	input
	{
	  font-family : Arial, Helvetica;
	  font-size : 14;
	  color : #000033;
	  font-weight : normal;
	  border-color : #999999;
	  border-width : 1;
	  background-color : #FFFFFF;
	}
   -->
   </style>
</HEAD>

<BODY bgcolor="#C0C0C0" link="green" vlink="green" alink="green">
<BASEFONT face="arial, helvetica">

<TABLE border="0" align="center" cellspacing="3" cellpadding="3" width="1000">
<TR><TH colspan="2" width="100%" bgcolor="green"><FONT size="6" color="white">Teatros</FONT></TH>
</TR></TABLE><P>

	<div id="contenido">
	<?php
		echo "<h1>ERROR</h1>";
		echo "<p>Formato de caracteres no permitido</p>";
	?>
	<input type="button" value="Volver" onClick="location='indexx.php'"/>
	</div>

</BODY>
</HTML>