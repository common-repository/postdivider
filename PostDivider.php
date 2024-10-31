<?php
/* 
	Plugin Name: Post Divider
	Plugin URI: http://www.wallofscribbles.com/PostDevider
	Description: Allows the user to get the content before and after the <!--MORE--> tag. Please refer to Read Me or plugin website for use examples.
	Version: 1.2
	Author: Corey Dutson
	Author URI: http://www.wallofscribbles.com
*/

/*  Copyright 2008  Corey Dutson  (email : cdutson@wallofscribbles.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* 	USE: Use within 'The Loop'. Pass the function the $post->post_content.

	Example: GETTING THE TEXT BEFORE THE MORE TAG
	<?php the_pre_more_text(); ?>
	<?php $content = get_the_pre_more_text(); ?>

	Example: GETTING THE TEXT AFTER THE MORE TAG
	<?php the_post_more_text(); ?>
	<?php $content = get_the_post_more_text(); ?> */

/* for internal use with this plugin */
function privateConditionContent($body)
{ return  str_replace(']]>', ']]&gt;', apply_filters('the_content', $body)); }

/* Echos the text before the <!--MORE--> tag */
function the_pre_more_text ()
{
   $returnVal = get_the_pre_more_text ($post->post_content);
   if ($returnVal !== FALSE)
      echo $returnVal;
   else
      the_excerpt();
}

/* Returns the text before the <!--MORE--> tag */
function get_the_pre_more_text ()
{
	global $post; 
	$moreTag = '<!--more';
	$content = FALSE;

	 $morePos = stripos($post->post_content, $moreTag);
   if ($morePos !== FALSE || $morePos > -1)
      $content = substr($post->post_content, 0, $morePos);
   else
      return FALSE;

   return privateConditionContent($content);
}

/* Echos the text after the <!--MORE--> tag */
function the_post_more_text ()
{ echo get_the_post_more_text (); }

/* Returns the text after the <!--MORE--> tag */
function get_the_post_more_text ()
{
	global $post; 
   $moreTag = '<!--more';
   $content = FALSE;

   $morePos = stripos($post->post_content, $moreTag);

   if ($morePos !== FALSE || $morePos > -1)
   {
      $content = substr($post->post_content, $morePos + strlen($moreTag));
      $morePos = stripos($content, '-->');
      if ($morePos !== FALSE || $morePos > -1)
         $content = substr($content, $morePos + 3); // little rough
   }
   else
      $content = $post->post_content;

   return privateConditionContent($content);
}

/* Echos all of the text both before and after the More tag */
function all_post_text()
{ echo get_all_post_text(); }

/* Returns all of the text both before and after the More tag */
function get_all_post_text()
{
	global $post;
	return privateConditionContent($post->post_content);
}

?>