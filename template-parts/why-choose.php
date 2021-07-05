<?php
/**
 * Template part for displaying why choose Farm to Plate
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farm_to_Plate
 */

?>

<section class = 'why-choose'>
<?php
        if( have_rows('why_choose') ):
            ?>
            <h2>Why Choose</h2>
            <div class="why-choose-reasons">
            <?php
            while( have_rows('why_choose') ) : the_row();
                $sub_value_heading = get_sub_field('heading');
                $sub_value_description = get_sub_field('description');
                ?>
                <article class = 'why-choose-item'>
                    <h3> <?php echo $sub_value_heading; ?> </h3>
                    <?php
                    echo $sub_value_description;
                    ?>
                </article>
            
                <?php
            endwhile;
        endif;
        ?>
        </div>
    </section>