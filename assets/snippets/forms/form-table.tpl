<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="input-test-name">Shop name</label>
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span>Name of one-page shop</span>
                    </legend>
                    <p>
                        <label title="Same as whole WordPress site" data-value="inherited">
                            <input type="radio" name="input-test-name" value="inherited" checked="checked">
                            Same as whole WordPress site
                            <span class="description">(Same as is inserted <a href="#">here</a>&hellip;)</span>
                        </label>
                    </p>
                    <p>
                        <label title="Custom: " data-value="custom">
                            <input type="radio" name="input-test-name" value="custom">
                            Custom:
                            <span class="screen-reader-text">insert name of shop</span>
                            <label class="screen-reader-text" for="input-test-name_custom">Name of one-page shop</label>
                            <input type="text" name="input-test-name_custom" id="input-test-name_custom" value=""
                                   class="regular-text" disabled="disabled" placeholder="Enter name for your shop&hellip;">
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="test-input-02">Description</label>
            </th>
            <td>
                <fieldset>
                    <p>
                        <label for="test-input-02">Shop's description should be simple and easily to remember.</label>
                        <input type="text" name="test-input-02" id="test-input-02" class="regular-text">
                    </p>
                    <p class="description">Enter text with at the most 255 characters.</p>
                </fieldset>
            </td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
jQuery( document ).ready( function () {
    jQuery( 'input[name="input-test-name"]' ).parent().click( function() {
        if ( jQuery( this ).data( 'value' ) == 'custom' ) {
            jQuery( '#input-test-name_custom' ).prop( 'disabled', false ).removeProp( 'disabled' ).focus();
        } else {
            jQuery( '#input-test-name_custom' ).prop( 'disabled", true );
        }
    } );
} );
</script>