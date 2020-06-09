<?php
    namespace kw\cookieconsent;

    use CheckboxField;
    use DataExtension;
    use FieldList;
    use GridField;
    use GridFieldConfig_RecordEditor;
    use SiteConfig;
    use TextareaField;
    use TextField;
    use TreeDropdownField;

    class CookieSiteConfig extends DataExtension
    {
        private static $db = array(
            'CookieIsActive' => 'Boolean',
            'CookieLabelIntroHeading'=>'Text',
            'CookieLabelIntro'=>'Text',
            'CookieLabelButtonAdvancedSettings' => 'Text',
            'CookieLabelButtonBack' => 'Text',
            'CookieLabelCPCHeading'=> 'Text',
            'CookieLabelCPCText'=> 'HTMLText',
            'CookieLabelCPCActivateAll'=> 'Text',
            'CookieLabelCPCDeactivateAll'=> 'Text',
            'CookieLabelCPCPurposeDesc'=> 'Text',
            'CookieColorCPCActivateAll'=>'Text'
        );

        private static $has_one = array(
            'CookieLinkPrivacy' => 'SiteTree',
            'CookieLinkImprint' => 'SiteTree'
        );

        private static $has_many = array(
            'CookieCategories' => 'CookieCategory'
        );


        public function updateCMSFields(FieldList $fields)
        {
            $fields->removeByName(array(
                'CookieLabelIntroHeading'
            ));


            $fields->addFieldToTab('Root.CookieConsent', new CheckboxField('CookieIsActive', _t('CookieSiteConfig.COOKIEISACTIVE', "Cookie Consent aktiv?")));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelIntroField = new TextareaField('CookieLabelIntro', _t('CookieSiteConfig.CookieLabelIntro', "Infobox ")));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCActivateAllField = new TextField('CookieLabelCPCActivateAll', _t('CookieSiteConfig.CookieLabelCPCActivateAll')));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCDeactivateAllField = new TextField('CookieLabelCPCDeactivateAll', _t('CookieSiteConfig.CookieLabelCPCDeactivateAll')));
            $fields->addFieldToTab('Root.CookieConsent', $CookieColorCPCActivateAllField = new TextField('CookieColorCPCActivateAll', _t('CookieSiteConfig.CookieColorCPCActivateAll')));




            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelButtonAdvancedSettingsField = new TextField('CookieLabelButtonAdvancedSettings'));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelButtonBackField = new TextField('CookieLabelButtonBack'));

            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCHeadingField = new TextField('CookieLabelCPCHeading'));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCTextField = new TextareaField('CookieLabelCPCText'));


            $fields->addFieldToTab('Root.CookieConsent', $treedropdownfield = new TreeDropdownField("CookieLinkPrivacyID", _t('CookieConsent.CookieLinkPrivacyID', "Link zur Datenschutzseite "), "SiteTree"));
            $fields->addFieldToTab('Root.CookieConsent', $treedropdownfield = new TreeDropdownField("CookieLinkImprintID", _t('CookieConsent.CookieLinkImprint', "Link zum Impressum "), "SiteTree"));


            $CookieLabelIntroField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelIntroVAL'));
            $CookieLabelButtonAdvancedSettingsField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelButtonAdvancedSettingsVAL'));
            $CookieLabelButtonBackField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelButtonBackVAL'));
            $CookieColorCPCActivateAllField->setAttribute('placeholder', '#3f7edf');
            $CookieLabelCPCActivateAllField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelCPCActivateAllVAL'));
            $CookieLabelCPCDeactivateAllField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelCPCDeactivateAllVAL'));



            $fields->addFieldToTab(
                'Root.CookieConsent',
                GridField::create('CookieCategory', 'Cookies', CookieCategory::get(), GridFieldConfig_RecordEditor::create())
            );
        }

        public function onBeforeWrite()
        {
            parent::onBeforeWrite(); // TODO: Change the autogenerated stub
            #if($this->owner->CookieLabelIntroHeading == ''){
            #   $this->owner->CookieLabelIntroHeading = _t('CookieSiteConfig.CookieLabelIntroHeadingVAL');
            #}
            if ($this->owner->CookieLabelIntro == '') {
                $this->owner->CookieLabelIntro = _t('CookieSiteConfig.CookieLabelIntroVAL');
            }
            if ($this->owner->CookieLabelButtonAdvancedSettings == '') {
                $this->owner->CookieLabelButtonAdvancedSettings = _t('CookieSiteConfig.CookieLabelButtonAdvancedSettingsVAL');
            }
            if ($this->owner->CookieLabelButtonBack == '') {
                $this->owner->CookieLabelButtonBack = _t('CookieSiteConfig.CookieLabelButtonBackVAL');
            }
            if ($this->owner->CookieColorCPCActivateAll == '') {
                $this->owner->CookieColorCPCActivateAll = _t('CookieSiteConfig.CookieColorCPCActivateAllVAL');
            }
            if ($this->owner->CookieLabelCPCActivateAll == '') {
                $this->owner->CookieLabelCPCActivateAll = _t('CookieSiteConfig.CookieLabelCPCActivateAllVAL');
            }
            if ($this->owner->CookieLabelCPCDeactivateAll == '') {
                $this->owner->CookieLabelCPCDeactivateAll = _t('CookieSiteConfig.CookieLabelCPCDeactivateAllVAL');
            }
        }
        public function onAfterWrite()
        {
            parent::onAfterWrite(); // TODO: Change the autogenerated stub
            self::writeConfig();

        }

        public static function writeConfig()
        {
            $siteConfig = SiteConfig::current_site_config();

            $KlaroConfig = $siteConfig->customise(
                array(
                    'siteConfig'=>$siteConfig,
                    'CookieEntries'=>\kw\cookieconsent\CookieEntry::get())
            )->renderWith('KlaroConfig');

            $fp = fopen(__DIR__ . '/../../templates/KlaroConfig_write.ss', 'w+');
            fwrite($fp, self::compressTemplate($KlaroConfig->Value));
            fclose($fp);
        }
        /**
         * compressTemplate compresses the template data and minimize them
         * @param  string $template uncompressed Meta Information
         * @return string $template compressed Meta Information
         */
        private static function compressTemplate($template)
        {
            return trim(str_replace(array("\r\n", "\r", "\n","  "), "", $template));
        }
    }