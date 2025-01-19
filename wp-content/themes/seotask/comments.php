<?php
if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">
    <?php
    if (have_comments()) :
        ?>
        <h2 class="comments-title">
            <?php
            $comments_number = get_comments_number();
            if ('1' === $comments_number) {
                printf(esc_html__('One comment on “%s”', 'custom-theme'), get_the_title());
            } else {
                printf(
                    esc_html(_n('%1$s comment on “%2$s”', '%1$s comments on “%2$s”', $comments_number, 'custom-theme')),
                    number_format_i18n($comments_number),
                    get_the_title()
                );
            }
            ?>
        </h2>
        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style'      => 'ul',
                'short_ping' => true,
            ));
            ?>
        </ul>
        <?php
        the_comments_navigation();
    endif;

    if (!comments_open()) :
        ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'custom-theme'); ?></p>
        <?php
    endif;

    comment_form();
    ?>
</div>
