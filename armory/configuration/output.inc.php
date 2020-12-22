<?php
class Output
{
	// Settings //
	var $sourcefolder = 'source'; // The folder that contains most of the files //
	// Output-related //
	var $output;
	var $stringcallcount;
	var $ob_varcount = 0;
	// Remember to add to this list till I find another solution //
	var $OB_CURRENT_CHARACTER = "";
	// Initialisation Class //
	function init()
	{
	// Empty until further notice //
	}
	// String output adder-er //
	// The most important function ever devised by Supalosa //
	function string($string)
	{
		$this->output .= $string;
		$this->stringcallcount ++;
	}
	// Sets an output buffer variable //
	function setobvar($var, $val)
	{
		$obvariable = 'OB_'.$var;
		$this->$obvariable = $val;
		$this->ob_varcount ++;
	}
	// Return the value of an output buffer variable //
	function getobvar($var)
	{
		$obvariable = 'OB_'.$var;
		return $this->$obvariable;
	}
	// Outputs the page //
	function outputPage()
	{
		$obstrings = array(
		"AFTER_BODYTAG",
		"CURRENT_CHARACTER",
		"CSEARCH_RESULT_LIMIT",
		"ADVCSEARCH_GUILD",
		"ADVCSEARCH_RPP",
		"GLIST_TERM",
		"GLIST_LIMIT",
		"GUILD_NAME",
		"GUILD_FACTION",
		);
		foreach($obstrings AS $key)
		{
			$obvartouse = "OB_".$key;
			if(isset($this->$obvartouse))
				$thisval = $this->$obvartouse;
			else
				$thisval = NULL;
			$this->output = str_replace("OB_".$key, $thisval, $this->output);
		}
		// Output the page //
		print $this->output;
	}
	// HTML Outputter starts here //
	function pageHeader($string, $classprefix = "header")
	{
		$this->string("<span class=\"".$classprefix."-shadow\">".$string."</span><br>");
		$this->string("<span class=\"".$classprefix."-text\">".$string."</span><br>");
	}
	// The Holy Error Function! //
	function showerror($errTitle, $errMessage)
	{
		$this->startcontenttable();
		$this->string("Error - ".$errTitle."<br>");
		$this->string($errMessage);
		$this->endcontenttable();
	}
	function startcontenttable($stylename = 'content', $headerclass = 'none', $headertext = 'none')
	{
		$this->string("<table class=\"content-table\" cellspacing=\"0\" cellpadding=\"0\">");
		if($headerclass == 'none')
		{
			$this->string("<tr>");
			$this->string("<td class=\"content-border-tl content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
			$this->string("<td class=\"content-border-top content-top\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
			$this->string("<td class=\"content-border-tr content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
			$this->string("</tr>");
		}
		else
		{
			$this->string("<tr>");
			$this->string("<td colspan=\"3\">");
			$this->string("<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">");
			$this->string("<tr>");
			$this->string("<td class=\"".$headerclass."\" width=\"50%\" valign=\"top\">".$headertext."</td>");
			$this->string("<td class=\"content-header-right\" width=\"50%\"><img src=\"images/spacer.gif\"</td>");
			$this->string("</tr>");
			$this->string("</table>");
			$this->string("</td>");
			$this->string("</tr>");
		}
		$this->string("<tr>");
		$this->string("<td class=\"content-border-left content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
		$this->string("<td class=\"".$stylename."\">");
	}
	function endcontenttable()
	{
		$this->string("</td>");
		$this->string("<td class=\"content-border-right content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
		$this->string("</tr>");
		$this->string("<tr>");
		$this->string("<td class=\"content-border-bl content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
		$this->string("<td class=\"content-border-bottom content-top\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
		$this->string("<td class=\"content-border-br content-corner\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\"></td>");
		$this->string("</tr>");
		$this->string("</table>");
	}
}
$o = new Output;
?>