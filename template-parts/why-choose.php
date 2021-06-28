<?php
/**
 * Template part for displaying why choose Farm to Plate
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farm_to_Plate
 */

?>

<?php
    echo "<section class = 'why-choose'>";
        if( have_rows('why_choose') ):
            while( have_rows('why_choose') ) : the_row();
                $sub_value_heading = get_sub_field('heading');
                $sub_value_description = get_sub_field('description');
                echo "<div class = 'why-choose-item'>";
                    echo "<h2>$sub_value_heading</h2>";
                    echo "<p>$sub_value_description</p>";
                echo "</div>";
            endwhile;
        endif;
    echo "</section>";

?>