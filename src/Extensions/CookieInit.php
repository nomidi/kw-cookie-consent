<?php
    namespace  kw\cookieconsent;

    use Debug;
    use Extension;
    use Requirements;
    use SiteConfig;

    class CookieInit extends Extension
    {
        public function onBeforeInit()
        {
            $siteConfig = SiteConfig::current_site_config();
            if ($siteConfig->CookieIsActive) {
                $this->CookieConsentKlaro($siteConfig);
                return;
            }
        }



        private function CookieConsentKlaro($siteConfig)
        {


            $config = file_get_contents(__DIR__.'/../../templates/KlaroConfig_write.ss');
            $klarocss = file_get_contents(__DIR__.'/../../client/js/libs/klaro/dist/klaro.min.css');
            $defcss = file_get_contents(__DIR__.'/../../client/css/kw-klaro.css');
            Requirements::insertHeadTags($config);
            Requirements::javascript('kw-cookie-consent/client/js/libs/klaro-ie.js');
            Requirements::insertHeadTags('<style>'.$defcss.' '.$klarocss.'.cn-ok button{margin:10px 0;}.klaro .cookie-modal .cm-btn.cm-btn-success, .klaro .cookie-notice .cm-btn.cm-btn-success{background:'.$siteConfig->CookieColorCPCActivateAll.'}.klaro .cookie-notice{z-index:9999;}.klaro .cookie-modal a, .klaro .cookie-notice a{color:#fff;text-decoration: underline}.cn-ok button, .cn-ok a {display:block; width:100%}  </style>');
        }


    }
