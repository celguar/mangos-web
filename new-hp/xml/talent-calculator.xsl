<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:import href="/new-hp/xml/includes.xsl"/>
<xsl:import href="/new-hp/xml/talent-page.xsl"/>
<xsl:output method="html" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Transitional//EN"/>

<xsl:template match="talents"><link rel="stylesheet" type="text/css" href="/new-hp/css/armory/talent-calc.css"/>

	
	<div id="dataElement">
        <div class="parchment-top">
            <div class="parchment-content">				
                <div class="list">				
				<xsl:call-template name="newTalentTabs"/>
                    <div class="full-list">
                        <div class="info-pane">						
							<xsl:call-template name="talentCalc">
								<xsl:with-param name="pageMode" select="'calc'"/>
								<xsl:with-param name="whichClassId" select="@classId"/>
								<xsl:with-param name="talStr" select="@tal"/>
							</xsl:call-template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</xsl:template>


<xsl:template name="newTalentTabs">

	<xsl:variable name="tabData" select="document(concat('/strings/', $lang,'/tabs/tools.xml'))"/>
	<xsl:variable name="currTab" select="'talentCalc'"/>	
	<xsl:variable name="currSubTab" select="@classId"/>


	<div class="tabs"> 
		<!-- print top-level tabs -->
		<xsl:for-each select="$tabData/tabs/tab">
			<div class="tab">
				<xsl:if test="@id = $currTab">
					<xsl:attribute name="class">selected-tab</xsl:attribute>
				</xsl:if>
				<a href="{@href}"><xsl:value-of select="text()"/></a>
			</div>
		</xsl:for-each>
		<div class="clear"/>
	</div>
	
	<!-- only print subtabs if we need it -->
	<xsl:if test="$tabData/tabs/tab[@id=$currTab]/subTab">
		<div class="subTabs">
			<div class="upperLeftCorner"/>
			<div class="upperRightCorner"/>
			<xsl:for-each select="/page/talentTabs/talentTab">
				<xsl:sort select="@name"/>		
				<a href="/talent-calc.xml?{@url}">
					<xsl:attribute name="class">
						<xsl:if test="@classId = $currSubTab">selected-subTab</xsl:if>
					</xsl:attribute>					
					<span><xsl:if test="@login = 'true'">key </xsl:if><xsl:value-of select="@name"/> </span>
				</a>
			</xsl:for-each>
		</div>
	</xsl:if>

</xsl:template>



</xsl:stylesheet>