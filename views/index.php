<div class="box">
    <h1>Settings</h1>
    <?=form_open('', array('class' => 'settings'))?>
        <?=$alert?>
        <fieldset class="col-group">
            <div class="setting-txt col w-8">
                <label>
                    Authentication Token
                </label>
                <em>
                    Set this to "Yes" if you are using an authentication token for users, rather than ExpressionEngine's built in authentication.
                </em>
            </div>

            <div class="setting-field col w-8">
                <label for="auth_token_yes" class="choice mr yes <?php if($settings['auth_token']) { ?>chosen<?php } ?>">
                    <?=form_radio('auth_token', 'y', $settings['auth_token'], 'id="auth_token_yes"')?>
                    Yes
                </label>

                <label for="auth_token_no" class="choice no <?php if(!$settings['auth_token']) { ?>chosen<?php } ?>">
                    <?=form_radio('auth_token', 'n', !$settings['auth_token'], 'id="auth_token_no"')?>
                    No
                </label>
            </div>
        </fieldset>

        <fieldset class="col-group">
            <div class="setting-txt col w-8">
                <label>
                    Authentication Token Name
                </label>
                <em>
                    If you are using an authentication token stored in a global variable enter the name of that variable here
                </em>
            </div>

            <div class="setting-field col w-8">
                <?=form_input('auth_token_name', $settings['auth_token_name'])?>
            </div>
        </fieldset>

        <fieldset class="form-ctrls">
            <?=form_submit('', 'Save Settings', 'class="btn" data-submit-text="Save Settings" data-work-text="Saving..."')?>
        </fieldset>

    <?=form_close()?>
</div>