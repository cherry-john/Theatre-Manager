<script type="text/javascript">
    var th_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
    jQuery(document).ready(function( $ ){
        $( '#add-row' ).on('click', function() {
            var row = $( '.empty-cast-row.screen-reader-text' ).clone(true).on('focus', function(){
                $('.th_person_search_class', this).suggest(th_ajax_url + '?action=th_person_lookup', {minchars:1});
                $('.th_role_search_class', this).suggest(th_ajax_url + '?action=th_role_lookup', {minchars:1});
            });
            row.removeClass( 'empty-cast-row screen-reader-text' );
            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
            return false;
        });

        $( '.remove-row' ).on('click', function() {
            $(this).parents('tr').remove();
            return false;
        });
        $('.th_person_search_class').on('focus', function(){
            $(this).suggest(th_ajax_url + '?action=th_person_lookup', {minchars:1});
            return false;
        });
        $('.th_role_search_class').on('focus', function(){
            $(this).suggest(th_ajax_url + '?action=th_role_lookup', {minchars:1});
            return false;
        });
    });
</script>
<style scoped>
    .th_show_person_info{
        width: 70%;
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
        margin: auto;
        text-align:center;
    }

    .th_show_person_info_row{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        text-align:center;
    }

    .th_show_person_info_field{
        flex-shrink: 2;
        margin:5px;
        text-align:center;
    }

    .th_show_person_info > .th_show_person_info_field {
        padding-bottom: 5px;
        border-bottom: 1px #ddd solid;
    }

    .th_show_person_info > .th_show_person_info_field > label{
        float: left;
        width: 150px;
        vertical-align: center;
    }

    select{
        float: left;
        width: 100%;
        vertical-align: center;
    }

    .th_show_person_info > .th_show_person_info_field > input {
        width: 280px;
    }

    .nomargin {
        margin:0 0 0 5px;
        font-weight: bold;
    }
</style>
<div class="th_show_person_info">
    <div class="th_show_person_info_field">
        <p style="font-weight: bold;">Members and Roles must be added first before adding them to a show!</p>
        <p>Member and Role names should be added to the boxes in the format <code>name (id)</code></p>
        <p>Enter the member's first name or role name, and then use the dropdown to ensure this format is correct</p>
        <table id="repeatable-fieldset-one" width="100%">
            <thead>
                <tr>
                    <th width="40%">Role</th>
                    <th width="40%">Member</th>
                    <th width="8%"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $repeatable_fields = get_post_meta($post->ID, 'th_committee_member_data', true);
                if ( $repeatable_fields ) {

                    foreach ( $repeatable_fields as $key => $value ) {
                        foreach ($value as $item){?>
                            <tr>
                                <td><input type="text" class="widefat th_role_search_class" name="postition[]" value="<?php echo esc_attr(get_the_title($item) . " (" . $item . ")" )?>" /></td>
                                <td><input type="text" class="widefat th_person_search_class" name="member[]" value="<?php echo esc_attr(get_the_title($key) . " (" . $key . ")" )?>" /></td>
                                <td><a class="button remove-row" href="#">Remove</a></td>
                            </tr>
                        <?php }
                    } 
                }?>

                <!-- empty hidden one for jQuery -->
                <tr class="empty-cast-row screen-reader-text">
                    <td><input type="text" class="widefat th_role_search_class" name="postition[]" /></td>
                    <td><input type="text" class="widefat th_person_search_class" name="member[]" value="" /></td>
                    <td><a class="button remove-row" href="#">Remove</a></td>
                </tr>
            </tbody>
        </table>

        <p><a id="add-row" class="button" href="#">Add Committee Member</a></p>
    </div>
</div>