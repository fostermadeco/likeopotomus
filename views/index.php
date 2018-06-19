<div class="box">
    <div class="form-standard">

        <?=form_open(ee('CP/URL')->make('addons/settings/likeopotomus/save'))?>
            <div class="form-btns form-btns-top">
                <h1>Settings</h1>
                <?=form_submit('', 'Save Settings', 'class="btn" data-submit-text="Save Settings" data-work-text="Saving..."')?>
            </div>

            <fieldset>
                <div class="field-instruct">
                    <label>
                        Authentication Token
                    </label>
                    <em>
                        Set this to "Yes" if you are using an authentication token for users, rather than ExpressionEngine's built in authentication.
                    </em>
                </div>

                <div class="field-control">
                    <?=form_yes_no_toggle('auth_token', $settings['auth_token'], 'class="toggle-btn"')?>
                </div>

            </fieldset>
        <?=form_close()?>

    </div>
</div>