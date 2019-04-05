<h3><i class="fa fa-lock fa-fw" aria-hidden="true"></i><?= t('OAuth2Yandex Authentication') ?></h3>
<div class="panel">
    <?= $this->form->label(t('Callback URL'), 'oauth2yandex_callback_url') ?>
    <input type="text" class="auto-select" readonly="readonly" value="<?= $this->url->href('OAuthController', 'handler', array('plugin' => 'OAuth2Yandex'), false, '', true) ?>"/>

    <?= $this->form->label(t('Client ID'), 'oauth2yandex_client_id') ?>
    <?= $this->form->password('oauth2yandex_client_id', $values) ?>

    <?= $this->form->label(t('Client Secret'), 'oauth2yandex_client_secret') ?>
    <?= $this->form->password('oauth2yandex_client_secret', $values) ?>

    <?= $this->form->hidden('oauth2yandex_account_creation', array('oauth2yandex_account_creation' => 0)) ?>
    <?= $this->form->checkbox('oauth2yandex_account_creation', t('Allow Account Creation'), 1, isset($values['oauth2yandex_account_creation']) && $values['oauth2yandex_account_creation'] == 1) ?>

    <?= $this->form->label(t('Allow account creation only for those domains'), 'oauth2yandex_email_domains') ?>
    <?= $this->form->text('oauth2yandex_email_domains', $values) ?>
    <p class="form-help"><?= t('Use a comma to enter multiple domains: domain1.tld, domain2.tld') ?></p>

    <div class="form-actions">
        <input type="submit" value="<?= t('Save') ?>" class="btn btn-blue"/>
    </div>
</div>
