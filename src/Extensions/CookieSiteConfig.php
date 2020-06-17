<?php
    namespace kw\cookieconsent;



    use SilverStripe\CMS\Model\SiteTree;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\Forms\TextareaField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\Forms\TreeDropdownField;
    use SilverStripe\i18n\i18n;
    use SilverStripe\ORM\DataExtension;
    use SilverStripe\SiteConfig\SiteConfig;



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
            'CookieLabelSaveButton'=>'Text',
            'CookiePureConfig'=>'HTMLText'
        );

        private static $has_one = array(
            'CookieLinkPrivacy' => SiteTree::class,
            'CookieLinkImprint' => SiteTree::class
        );




        public function updateCMSFields(FieldList $fields)
        {
            $fields->removeByName(array(
                'CookieLabelIntroHeading'
            ));


            $fields->addFieldToTab('Root.CookieConsent', new CheckboxField('CookieIsActive', _t('CookieSiteConfig.COOKIEISACTIVE', "Cookie Consent aktiv?")));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelIntroField = new TextareaField('CookieLabelIntro', _t('CookieSiteConfig.CookieLabelIntro', "Infobox ")));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCActivateAllField = new TextField('CookieLabelCPCActivateAll', _t('CookieSiteConfig.CookieLabelCPCActivateAll','Button alle Cookies akzeptieren')));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCDeactivateAllField = new TextField('CookieLabelCPCDeactivateAll', _t('CookieSiteConfig.CookieLabelCPCDeactivateAll','Button nur technisch notwendige Cookies zulassen')));
            $fields->addFieldToTab('Root.CookieConsent', $CookieColorCPCActivateAllField = new TextField('CookieColorCPCActivateAll', _t('CookieSiteConfig.CookieColorCPCActivateAll','Button Farbe alle Cookies akzeptieren')));
            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelSaveButtonField = new TextField('CookieLabelSaveButton', _t('CookieSiteConfig.CookieLabelSaveButton','CookieLabelSaveButton')));




            $fields->addFieldToTab('Root.CookieConsent', $CookieLabelButtonAdvancedSettingsField = new TextField('CookieLabelButtonAdvancedSettings'));
          #  $fields->addFieldToTab('Root.CookieConsent', $CookieLabelButtonBackField = new TextField('CookieLabelButtonBack'));

          #  $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCHeadingField = new TextField('CookieLabelCPCHeading'));
          #  $fields->addFieldToTab('Root.CookieConsent', $CookieLabelCPCTextField = new TextareaField('CookieLabelCPCText'));


            $fields->addFieldToTab('Root.CookieConsent', $treedropdownfield = new TreeDropdownField("CookieLinkPrivacyID", _t('CookieConsent.CookieLinkPrivacyID', "Link zur Datenschutzseite "), 'SilverStripe\CMS\Model\SiteTree'));
       #     $fields->addFieldToTab('Root.CookieConsent', $treedropdownfield = new TreeDropdownField("CookieLinkImprintID", _t('CookieConsent.CookieLinkImprint', "Link zum Impressum "),  'SilverStripe\CMS\Model\SiteTree'));


            $CookieLabelIntroField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelIntroVAL','Auf unserer Webseite kommen verschiedene Cookies zum Einsatz. Einige von ihnen sind notwendig, während andere uns helfen, diese Website zu verbessern. Ihnen steht jederzeit ein Widerrufsrecht zu.'));
            $CookieLabelButtonAdvancedSettingsField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelButtonAdvancedSettingsVAL','Individuelle Cookie Einstellungen'));
           # $CookieLabelButtonBackField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelButtonBackVAL'));
            $CookieColorCPCActivateAllField->setAttribute('placeholder', '#3f7edf');
            $CookieLabelCPCActivateAllField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelCPCActivateAllVAL','Alle akzeptieren'));
            $CookieLabelCPCDeactivateAllField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelCPCDeactivateAllVAL','Nur technisch notwendige'));
            $CookieLabelSaveButtonField->setAttribute('placeholder', _t('CookieSiteConfig.CookieLabelSaveButtonVAL','Speichern'));



            $fields->addFieldToTab(
                'Root.CookieConsent',
                GridField::create('CookieCategory', 'Cookie Kategorien', CookieCategory::get(), GridFieldConfig_RecordEditor::create())
            );

            $fields->addFieldToTab(
                'Root.CookieConsent',
                GridField::create('CookieEntry', 'Cookies', CookieEntry::get(), GridFieldConfig_RecordEditor::create())
            );



            $fields->addFieldToTab('Root.CookieConsent', new TextareaField('CookiePureConfig', _t('CookieSiteConfig.CookiePureConfig','Klaro Config (alternative)')));
        }

        public function onBeforeWrite()
        {
            parent::onBeforeWrite(); // TODO: Change the autogenerated stub
            #if($this->owner->CookieLabelIntroHeading == ''){
            #   $this->owner->CookieLabelIntroHeading = _t('CookieSiteConfig.CookieLabelIntroHeadingVAL');
            #}
            if ($this->owner->CookieLabelIntro == '') {
                $this->owner->CookieLabelIntro = _t('CookieSiteConfig.CookieLabelIntroVAL','Auf unserer Webseite kommen verschiedene Cookies zum Einsatz. Einige von ihnen sind notwendig, während andere uns helfen, diese Website zu verbessern. Ihnen steht jederzeit ein Widerrufsrecht zu.');
            }
            if ($this->owner->CookieLabelButtonAdvancedSettings == '') {
                $this->owner->CookieLabelButtonAdvancedSettings = _t('CookieSiteConfig.CookieLabelButtonAdvancedSettingsVAL','Individuelle Cookie Einstellungen');
            }
            #if ($this->owner->CookieLabelButtonBack == '') {
             #   $this->owner->CookieLabelButtonBack = _t('CookieSiteConfig.CookieLabelButtonBackVAL','');
            #}
            if ($this->owner->CookieColorCPCActivateAll == '') {
                $this->owner->CookieColorCPCActivateAll = _t('CookieSiteConfig.CookieColorCPCActivateAllVAL','#3f7edf');
            }
            if ($this->owner->CookieLabelCPCActivateAll == '') {
                $this->owner->CookieLabelCPCActivateAll = _t('CookieSiteConfig.CookieLabelCPCActivateAllVAL','Alle akzeptieren');
            }
            if ($this->owner->CookieLabelCPCDeactivateAll == '') {
                $this->owner->CookieLabelCPCDeactivateAll = _t('CookieSiteConfig.CookieLabelCPCDeactivateAllVAL','Nur technisch notwendige');
            }
            if($this->owner->CookieLabelSaveButton == ''){
                $this->owner->CookieLabelSaveButton = _t('CookieSiteConfig.CookieLabelSaveButtonVAL','Speichern');
            }
        }
        public function onAfterWrite()
        {
            parent::onAfterWrite(); // TODO: Change the autogenerated stub
            self::writeConfig();
        }

        public function getCookieCategoriesByLang($Locale)
        {
           return CookieCategory::get();
        }

        public function getCookieEntriesByLang($Locale)
        {
            CookieEntry::get();
        }

        public static function writeConfig()
        {
            $SiteConfig = SiteConfig::current_site_config();
            if($SiteConfig->CookiePureConfig != ''){
                $fp = fopen(__DIR__ . '/../../templates/KlaroConfig_write.ss', 'w+');
                fwrite($fp, '<script>'.$SiteConfig->CookiePureConfig.'</script>');
                fclose($fp);
            } else {
                $KlaroConfig = $SiteConfig->customise(
                    array(

                        'SiteConfigDefault'=>$SiteConfig,
                        'DefaultLocale'=>i18n::getData()->langFromLocale(i18n::get_locale()),
                        'CookieEntries'=>CookieEntry::get(),
                        'CookieCategories'=> CookieCategory::get(),
                    ))->renderWith('KlaroConfig');

                $fp = fopen(__DIR__ . '/../../templates/KlaroConfig_write.ss', 'w+');
                fwrite($fp, $KlaroConfig->Value);
                fclose($fp);
            }



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
            $locale = i18n::get_locale();
            return i18n::getData()->langFromLocale($locale);
        }
    }
