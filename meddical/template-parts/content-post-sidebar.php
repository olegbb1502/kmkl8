<ul class="category-list hide">
    <?php 
        $category_ids = get_terms();
        $args = array(
            'orderby' => 'count',
            'parent' => 0,
        );
        $current_category = get_the_category()[0]->term_id;
        $categories = get_categories( $args );
        foreach ( $categories as $category ):?>
        <li class="category <?php if ($category->term_id == $current_category) echo 'active'; ?>">
            <a href="<?php echo get_category_link( $category->term_id ); ?>">
                <span><?php echo $category->name; ?></span>
                <span class="counter"><?php echo $category->category_count; ?></span>
            </a>
        </li>
            
    <?php endforeach;?>
</ul>