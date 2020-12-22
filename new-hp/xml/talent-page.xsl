<?xml version="1.0"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template name="talentCalc">

	<xsl:param name="pageMode" />
	<xsl:param name="whichClassId" />
	<xsl:param name="talStr" />

	<!-- hide id 0 for now -->
	<xsl:variable name="tempClassId">
		<xsl:choose>
			<xsl:when test="$whichClassId = 0">6</xsl:when>
			<xsl:otherwise><xsl:value-of select="$whichClassId" /></xsl:otherwise>
		</xsl:choose>
	</xsl:variable>

	<script type="text/javascript" src="/js/tools/talent-calc.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function(){		
			initTalentCalc("<xsl:value-of select="$tempClassId" />", 
							"<xsl:value-of select="$talStr" />", 
							"<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalents.single']" />",
							"<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalents.plural']" />",
							"<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.rankStrOrder']" />",
							"<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.nextRank']" />",
							"<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqTalentTree']" />",
							"<xsl:value-of select="$pageMode" />");
			});	
	</script>

	<xsl:variable name="talentList" select="document(concat('/talent-tree.xml?cid=', $tempClassId,'&amp;loc=',$lang))" />	


	<xsl:choose>		
		<xsl:when test="$pageMode = 'calc'">
			<div class="calcInfo">
				<a id="linkToBuild" href="/talent-calc.xml"><span><div class="export"><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.linkToBuild']" /></div></span></a>
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsSpent']" /></b>&#160;<span class="ptsHolder" id="pointsSpent">0</span>
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsLeft']" /></b>&#160;<span class="ptsHolder" id="pointsLeft">0</span> 
				<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqLevel']" /></b>&#160;<span class="ptsHolder" id="requiredLevel">10</span>
			</div>			
		</xsl:when>
		<xsl:otherwise>
			<div class="calcInfo" style="display: none; margin: 0;">					
				<!-- hide so js doesn't error -->
				<div style="display: none;">
					<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsSpent']" /></b>&#160;<span class="ptsHolder" id="pointsSpent">0</span>
					<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.pointsLeft']" /></b>&#160;<span class="ptsHolder" id="pointsLeft">0</span> 
					<b><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reqLevel']" /></b>&#160;<span class="ptsHolder" id="requiredLevel">10</span>
				</div>
			</div>
		</xsl:otherwise>
	</xsl:choose>
	<div id="talContainer">
		
		<!-- loop through trees -->
		<div class="talentFrame">			
			<xsl:for-each select="$talentList/page/talentTrees/tree">
				<xsl:sort select="@order" />

				<div id="{@bgImage}_tree" class="talentTree" style="margin-right: 5px; background-image: url('/images/talents/bg/{@bgImage}.jpg')">
					<xsl:if test="position() = last()">
						<xsl:attribute name="style">background-image: url('/images/talents/bg/<xsl:value-of select="@bgImage" />.jpg');</xsl:attribute>
					</xsl:if>
					<xsl:call-template name="oneTier">
						<xsl:with-param name="currTier" select="'0'" />
						<xsl:with-param name="maxTier" select="'10'" />
						<xsl:with-param name="currTree" select="current()" />
					</xsl:call-template>
					
					<!-- only show on calculator page -->		
					<xsl:if test="$pageMode = 'calc'">
						<a class="subtleResetButton" href="javascript:void(0)" onclick="resetTalents('{@bgImage}_tree', true);">
							<span><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.reset']" /></span>
						</a>
					</xsl:if>
					<div class="talentTreeInfo" style="background: url(/wow-icons/_images/21x21/{@icon}.png) 0 0 no-repeat;">
						<span id="treeName_{@bgImage}_tree" style="font-weight: bold;"><xsl:value-of select="current()/@name" /></span> &#160;<span id="treespent_{@bgImage}_tree">0</span>
					</div>					
				</div>	
			</xsl:for-each>
					
			<xsl:choose>
				<xsl:when test="$pageMode = 'calc'">
					<a class="resetTalents" href="javascript:resetAllTalents()">				
						<span><div class="reload"><xsl:value-of select="$loc/strs/unsorted/str[@id='talents.resetAll']" /></div></span>
					</a>
				</xsl:when>
				<xsl:otherwise>
					<!-- export build link and glyphs title -->
					<a id="linkToBuild" class="exportBuildLink" href="/talent-calc.xml"><span><div class="export staticTip" onmouseover="setTipText('{$loc/strs/unsorted/str[@id='armory.talents.export.click']}')">						
						<xsl:value-of select="$loc/strs/unsorted/str[@id='armory.talents.export.exportbuild']" />					
					</div></span></a>
					<div id="glyphsLabel" class="filterTitle"><xsl:value-of select="$loc/strs/items/types/str[@id='armory.item-search.glyphs']" /></div>
				</xsl:otherwise>
			</xsl:choose>
		</div>	
	</div>	
</xsl:template>

<!-- print out one talent tree tier -->
<xsl:template name="oneTier">

	<xsl:param name="currTier" />
	<xsl:param name="maxTier" />
	<xsl:param name="currTree" />
	
	<div id="{$currTree/@bgImage}_tier{$currTier}" class="tier">	
		<xsl:for-each select="$currTree/talent[@tier = $currTier]">			
			<div id="{@key}_iconHolder" class="talent staticTip col{@column}" style="background-image:url('/wow-icons/_images/_talents43x43/{@icon}.gif');">
				<xsl:if test="not($currTier = 0)">
					<xsl:attribute name="style">background-image:url('/wow-icons/_images/_talents43x43/grey/<xsl:value-of select="@icon"/>.gif');</xsl:attribute>
				</xsl:if>
				<div id="{@key}" class="talentHolder tier{$currTier+1}" onmousedown="addTalent(event, '{@key}');" onmouseover="makeTalentTooltip('{@key}');">
					<xsl:attribute name="class">talentHolder tier<xsl:value-of select="$currTier+1" />
						<xsl:if test="@requires"> requires t_<xsl:value-of select="@requires" /></xsl:if>
						<xsl:if test="not($currTier = 0)"> disabled</xsl:if>
					</xsl:attribute>
					<xsl:for-each select="rank">
						<span id="rank{position()}_{../@key}" style="display: none"><xsl:value-of select="@description" /></span>					
					</xsl:for-each>
					
					<xsl:if test="spell">
						<span id="spellInfo_{@key}" style="display: none;">					
							<!-- range -->							
							<xsl:if test="spell/@maxRange">
								<span style="float: right;">
									<xsl:if test="not(spell/power)">
										<xsl:attribute name="style">float: left;</xsl:attribute>
									</xsl:if>
									<!-- yes i know, it doesn't make any sense to me either -->
									<xsl:if test="spell/@minRange"><xsl:value-of select="spell/@minRange" />&#160;-</xsl:if>
									<xsl:choose>
										<!-- melee -->
										<xsl:when test="spell/@maxRange = '5'">
											<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.meleeRange']" />
										</xsl:when>
										<xsl:otherwise>
											<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.rangedSpell']">
												<xsl:with-param name="param1" select="spell/@maxRange" />
											</xsl:apply-templates>
										</xsl:otherwise>										
									</xsl:choose>
								</span>
								<xsl:if test="not(spell/power)"><br /></xsl:if>			
							</xsl:if>
							
							<!-- cost -->
							<xsl:if test="spell/power">
								<span style="float: left;">
									<xsl:for-each select="spell/power">
										<xsl:if test="position() &gt; 1">,</xsl:if>
										<xsl:choose>
											<xsl:when test="@type = 'mana'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.mana-percent']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'rage'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.rage']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'energy'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.energy']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'runic'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.runic']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'unholy'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.unholy']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'frost'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.frost']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'blood'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.blood']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
											<xsl:when test="@type = 'unknown'">
												<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.spelltype.mana']">
													<xsl:with-param name="param1" select="@cost" />
												</xsl:apply-templates>
											</xsl:when>
										</xsl:choose>
					
									</xsl:for-each>								

								</span><br />
							</xsl:if>

							<!-- cooldown -->
							<xsl:if test="spell/@cooldown">
								<span style="float: right;">									
								<xsl:choose>
									<xsl:when test="spell/@cooldown &lt; '60000'">
										<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.cooldown.sec']">
											<xsl:with-param name="param1" select="spell/@cooldown div 1000" />
										</xsl:apply-templates>
						
									</xsl:when>
									<xsl:otherwise>
										<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.cooldown.min']">
											<xsl:with-param name="param1" select="spell/@cooldown div 60000" />
										</xsl:apply-templates>
									</xsl:otherwise>
								</xsl:choose>
								</span>														
							</xsl:if>
							
							<!-- cast time -->		
							<xsl:if test="spell/@castTime">
								<span style="float: left;">			
									<xsl:choose>
										<xsl:when test="spell/@castTime = '0'">
											<xsl:choose>
												<xsl:when test="spell/@channeled = '1'">
													<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.channeled']" />
												</xsl:when>
												<xsl:otherwise>
													<xsl:choose>
														<xsl:when test="spell/power/@type ='mana'">
															<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.instant-cast']" />
														</xsl:when>
														<xsl:otherwise>
															<xsl:value-of select="$loc/strs/unsorted/str[@id='talents.casttime.instant']" />
														</xsl:otherwise>
													</xsl:choose>									
												</xsl:otherwise>
											</xsl:choose>
										</xsl:when>
										<xsl:otherwise>
											<xsl:apply-templates mode="printf" select="$loc/strs/unsorted/str[@id='talents.casttime.non-instant']">
												<xsl:with-param name="param1" select="spell/@castTime div 1000" />
											</xsl:apply-templates>
										</xsl:otherwise>
									</xsl:choose>
								</span>
							</xsl:if>
							
						</span>
					</xsl:if>

					<div class="iconhighlight"></div>
					<span id="{@key}_name" style="display: none;"><xsl:value-of select="@name" /></span>
					<span id="{@key}_icon" style="display: none;"><xsl:value-of select="@icon" /></span>
					
					<div class="rankCtr">
						<span id="count_{@key}">0</span>
						<span>/</span>
						<span id="total_{@key}"><xsl:value-of select="count(rank)" /></span>
					</div>
				</div>
			</div>
		</xsl:for-each>
	</div>
	
	<!-- print next tier -->
	<xsl:if test="$currTier &lt; $maxTier">
		<xsl:call-template name="oneTier">
			<xsl:with-param name="currTier" select="$currTier + 1" />
			<xsl:with-param name="maxTier" select="$maxTier" />
			<xsl:with-param name="currTree" select="current()" />
		</xsl:call-template>
	</xsl:if>
</xsl:template>
</xsl:stylesheet>