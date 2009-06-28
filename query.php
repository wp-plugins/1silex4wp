<?php
/*  Copyright 2009  Alexandre Hoyau  (email : lex [at] silex-ria . org)

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
 $my_query1 = new WP_Query('cat=6&showposts=4&orderby=rand');
 
 
 $my_query1 = new WP_Query('post_type=page&posts_per_page=-1');
 
 
 while ($my_query1->have_posts()) : $my_query1->the_post(); 
 
 
 
 ?>
 
 
 
 <?php query_posts('category_name=special_cat&showposts=10'); ?>

  <?php while (have_posts()) : the_post(); ?>
    <!-- Do special_cat stuff... -->
  <?php endwhile;?>

 

