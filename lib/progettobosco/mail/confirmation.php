<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
	<META HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=utf-8">
	<TITLE></TITLE>
	<META NAME="GENERATOR" CONTENT="LibreOffice 3.5  (Linux)">
	<META NAME="AUTHOR" CONTENT="caiofior ">
	<META NAME="CREATED" CONTENT="20130118;11434800">
	<META NAME="CHANGEDBY" CONTENT="caiofior ">
	<META NAME="CHANGED" CONTENT="20130118;11514700">
	<STYLE TYPE="text/css">
	<!--
		@page { margin: 2cm }
		P { margin-bottom: 0.21cm }
		H1 { margin-bottom: 0.21cm }
		H1.western { font-family: "Arial", sans-serif; font-size: 16pt }
		H1.cjk { font-family: "Droid Sans Fallback"; font-size: 16pt }
		H1.ctl { font-family: "Lohit Hindi"; font-size: 16pt }
	-->
	</STYLE>
</HEAD>
<BODY LANG="it-IT" DIR="LTR">
<H1 CLASS="western">Benvenuto su <?php echo $SITE_NAME;?></H1>
<P STYLE="margin-bottom: 0cm">Conferma la tua iscrizione su 
<?php echo $SITE_NAME;?>.</P>
<P STYLE="margin-bottom: 0cm">Hai ricevuto questa mail a seguito
dell'iscrizione su <a href="<?php echo $BASE_URL; ?>?subscription_confirm=<?php echo $user->getData('confirmation_code');?>"><?php echo $SITE_NAME;?></a> per confermare la validità del tuo
indirizzo di posta elettronica.</P>
<P ALIGN=RIGHT STYLE="margin-bottom: 0cm">Lo staff di <?php echo $SITE_NAME;?>.</P>
</BODY>
</HTML>