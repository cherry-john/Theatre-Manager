<script type="text/javascript">
    jQuery(document).ready(function( $ ){
        $( '#add-review-row' ).on('click', function() {
            var row = $( '.empty-review-row.screen-reader-text' ).clone(true);
            row.removeClass( 'empty-review-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-three tbody>tr:last' );
            return false;
        });

        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
    });
</script>
<style scoped>
    .th_person_info{
        width: 50%;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .th_person_info_row{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .th_person_info_field{
        flex-shrink: 2;
        margin:5px;
    }

    .th_person_info > .th_person_info_field {
        padding-bottom: 5px;
        border-bottom: 1px #ddd solid;
    }

    .th_person_info > .th_person_info_field > label{
        float: left;
        width: 150px;
        vertical-align: center;
    }

    .th_person_info > .th_person_info_field > input {
        width: 280px;
    }

    .nomargin {
        margin:0 0 0 5px;
        font-weight: bold;
    }
</style>
<div class="th_person_info_row">
    <div class="th_person_info">
        <div class="th_person_info_field">
            <table id="repeatable-fieldset-three" width="100%">
            <thead>
                <tr>
                    <th width="40%">Reviewer</th>
                    <th width="40%">Link to Review</th>
                    <th width="8%"></th>
                </tr>
            </thead>
            <tbody>
            <?php
            $repeatable_fields = get_post_meta($post->ID, 'th_show_review_data', true);
            if ( $repeatable_fields ) :

            foreach ( $repeatable_fields as $field ) {
                ?>
                <tr>
                    <td><input type="text" class="widefat" name="reviewer[]" value="<?php if($field['reviewer'] != '') echo esc_attr( $field['reviewer'] ); ?>" /></td>

                    <td><input type="url" class="widefat" name="link[]" value="<?php if ($field['link'] != '') echo esc_attr( $field['link'] ); ?>" /></td>

                    <td><a class="button remove-row" href="#">Remove</a></td>
                </tr>
                <?php
                } 
            endif; ?>

            <!-- empty hidden one for jQuery -->
            <tr class="empty-review-row screen-reader-text">
                <td><input type="text" class="widefat" name="reviewer[]" /></td>

                <td><input type="url" class="widefat" name="link[]" value="" /></td>

                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
            </tbody>
            </table>

            <p><a id="add-review-row" class="button" href="#">Add Review</a></p>
        </div>
    </div>
</div>