<?php
    namespace kw\cookieconsent;

    use ArrayData;
    use CheckboxField;
    use DataExtension;
    use Debug;
    use FieldList;
    use GridField;
    use GridFieldConfig_RecordEditor;
    use i18n;
    use SiteConfig;
    use TextareaField;
    use TextField;
    use Translatable;
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
            'CookieColorCPCActivateAll'=>'Text',
            'CookieLanguage'=>'Varchar',
            'CookieLabelSaveButton'=>'Text'
        );

        private static $has_one = array(
            'CookieLinkPrivacy' => 'SiteTree',
            'CookieLinkImprint' => 'SiteTree'
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
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelSaveButtonField = new TextField('CookieLabelSaveButton', _t('CookieSiteConfig.CookieLabelSaveButton')));




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
            $CookieLabelSaveButtonField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelSaveButtonVAL'));



            $fields->addFieldToTab(
                'Root.CookieConsent',
                GridField::create('CookieCategory', 'Cookie Kategorien', CookieCategory::get(), GridFieldConfig_RecordEditor::create())
            );

            $fields->addFieldToTab(
                'Root.CookieConsent',
                GridField::create('CookieEntry', 'Cookies', CookieEntry::get(), GridFieldConfig_RecordEditor::create())
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
            if($this->owner->CookieLabelSaveButton == ''){
                $this->owner->CookieLabelSaveButton = _t('CookieSiteConfig.CookieLabelSaveButtonVAL');
            }
        }
        public function onAfterWrite()
        {
            parent::onAfterWrite(); // TODO: Change the autogenerated stub
            self::writeConfig();
        }

        public function getCookieCategoriesByLang($Locale)
        {
            if($this->owner->hasExtension('Translatable')){
                return Translatable::get_by_locale('\kw\cookieconsent\CookieCategory', $Locale);
            } else {
                return CookieCategory::get();
            }

        }

        public function getCookieEntriesByLang($Locale)
        {
            if($this->owner->hasExtension('Translatable')){
                return Translatable::get_by_locale('\kw\cookieconsent\CookieEntry', $Locale);
            } else {
                return CookieEntry::get();
            }


        }

        public static function writeConfig()
        {
            $siteConfig = SiteConfig::current_site_config();

            if($siteConfig->hasExtension('Translatable')){
                $SiteConfigDefault = Translatable::get_one_by_locale('SiteConfig', Translatable::default_locale());
            } else {
                $SiteConfigDefault = $siteConfig;
            }




            $KlaroConfig = $siteConfig->customise(
                array(

                    'SiteConfigDefault'=>$SiteConfigDefault,
                    'CookieEntries'=>CookieEntry::get(),
                    'CookieCategories'=> CookieCategory::get(),
                ))->renderWith('KlaroConfig');

            $fp = fopen(__DIR__ . '/../../templates/KlaroConfig_write.ss', 'w+');
            #fwrite($fp, self::compressTemplate($KlaroConfig->Value));
            fwrite($fp, $KlaroConfig->Value);
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

        public function getJSLocale()
        {
            if ($this->owner->hasExtension('Translatable')) {
                $locale = $this->owner->Locale;
            } else {
                $locale = i18n::get_locale();
            }
            return i18n::get_lang_from_locale($locale);
        }
    }
