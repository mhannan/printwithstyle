<?php
function getPage_content_by_slug($slug) {
	/*$res = mysql_query("SELECT page_content FROM pages WHERE page_slug = '" . mysql_real_escape_string($slug) . "'");
	$rec = mysql_fetch_array($res);
	return $rec['page_content'];*/
	
				$content_arraySet = getPage_photo_by_slug($slug);
				
				$photoData = "";					// default initialization
				if($content_arraySet['photo-src'] != '')
				{
								if($content_arraySet['photo-position']=='left')
												$photoData = "<img src='uploads/page_banner/".$content_arraySet['photo-src']."' style='float:left'>";
								elseif($content_arraySet['photo-position']=='right')
												$photoData = "<img src='uploads/page_banner/".$content_arraySet['photo-src']."' style='float:right'>";
								elseif($content_arraySet['photo-position']=='top' || $content_arraySet['photo-position']=='')
												$photoData = "<img src='uploads/page_banner/".$content_arraySet['photo-src']."' >";
				}
				
				return ($photoData.$content_arraySet['content']);
}

function getPage_photo_by_slug($slug) {
	$res = mysql_query("SELECT * FROM pages WHERE page_slug = '" . mysql_real_escape_string($slug) . "'");
	$rec = mysql_fetch_array($res);
	$pageContent = array();
	$pageContent['photo-src'] = $rec["banner_image"];
	$pageContent['photo-position'] = $rec["banner_position"];
	$pageContent['content'] = $rec["page_content"];
	return $pageContent;
}