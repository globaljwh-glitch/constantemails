<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:fo="http://www.w3.org/1999/XSL/Format">
<xsl:output method="html" indent="no"/>
<xsl:strip-space elements="*"/>
	<!--MENU-->
	<xsl:template match="MENU" mode="top">
		<xsl:apply-templates select="MENU-ITEM"  mode="top"/>
	</xsl:template>
 
	<xsl:template match="MENU" mode="sub">
		<xsl:apply-templates select="MENU-ITEM"  mode="sub"/>
	</xsl:template> 


	<!--MENU-ITEM-->
	<xsl:template match="MENU-ITEM"  mode="top">
			<xsl:choose>
            <!-- when vizited inside-->
            	<xsl:when test="MENU-ITEM[@ID=/LAYOUT/@ID] or @ID=/LAYOUT/@ID">
            		<td>
	        			<img src="images/bullet.gif" style="margin-right: 3px;" align="absmiddle"/>
        			</td>
            		<td>
        				<a href="{@HREF}" class="amenu"><xsl:value-of select="@TITLE" disable-output-escaping="yes"/></a>
        			</td>
            		<td>
	        			<span style="width:42px; height:0px;"><spacer type="block" width="42" height="0" /></span>
        			</td>
                </xsl:when>
                <!-- when active-->
                
                <xsl:otherwise>
                	<td>
	        			<img src="images/bullet.gif" style="margin-right: 3px;" align="absmiddle"/>
        			</td>
                	<td>
        				<a href="{@HREF}" class="menu"><xsl:value-of select="@TITLE" disable-output-escaping="yes"/></a>
        			</td>
            		<td>
	        			<span style="width:42px; height:0px;"><spacer type="block" width="42" height="0" /></span>
        			</td>
                </xsl:otherwise>
            </xsl:choose>
	</xsl:template>


	<xsl:template match="MENU-ITEM" mode="sub">
		<xsl:variable name="position"><xsl:value-of select="position()" /></xsl:variable>
        <xsl:choose>
            <xsl:when test="@ID=/LAYOUT/@ID" >
            	<xsl:if test="position()!=1">
	  				<tr><td colspan="2" height="10"></td></tr>
            	</xsl:if>
  				<tr class="asubmenu">
  					<td width="19" align="right"><img src="images/submenu_abullet.gif" border="0"/></td>
  					<td width="141" style="padding-left: 5px;"><xsl:value-of select="@TITLE" disable-output-escaping="yes"/></td>
  				</tr>
  				<tr><td colspan="2" height="10"></td></tr>
            </xsl:when>
            <xsl:otherwise>
				<xsl:if test="../MENU-ITEM[@ID=/LAYOUT/@ID] or ../../MENU-ITEM[@ID=/LAYOUT/@ID]">
                	<xsl:if test="position()=1">
    	  				<tr><td colspan="2" height="10"></td></tr>
                	</xsl:if>
    				<tr>
    					<td width="19"><span style="width:13px; height:1px;"><spacer type="block" width="13" height="1"/></span><a href="{@HREF}"><img src="images/submenu_bullet.gif" border="0"/></a></td>
    					<td width="141" style="padding-left: 5px;"><a href="{@HREF}" class="menu"><xsl:value-of select="@TITLE" disable-output-escaping="yes"/></a></td>
    				</tr>
     				<xsl:if test="not(../MENU-ITEM[$position+1]/MENU-ITEM[@ID=/LAYOUT/@ID] or ../MENU-ITEM[$position+1][@ID=/LAYOUT/@ID]) and $position != last()">
		  				 <tr><td colspan="2"><img src="images/submenu_hr.gif" height="26" width="100%"/></td></tr>
     				</xsl:if>
				</xsl:if>
            </xsl:otherwise>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>
