<?php

    namespace kw\cookieconsent;

    use CheckboxField;
    use Config;
    use DataObject;
    use DB;
    use FieldList;
    use GridField;
    use GridFieldConfig_RecordEditor;
    use Tab;
    use TabSet;
    use TextareaField;
    use TextField;

    class CookieCategory extends DataObject
    {
        private static $singular_name = 'GCookieCategory';
        private static $table_name = 'CookieCategory';

        private static $db = array(
            'Title'=>'Varchar',
            'Content'=>'HTMLText',
            'Required'=>'Boolean'
        );

        private static $has_many = array(
            'CookieEntries'=>'kw\cookieconsent\CookieEntry'
        );

        public function getCMSFields()
        {
            $fields = FieldList::create(TabSet::create('Root', $mainTab = Tab::create('Main')));
            $fields->addFieldsToTab('Root.Main', array(

                TextField::create('Title'),
                TextareaField::create('Content'),
                CheckboxField::create('Required'),
                GridField::create('CookieEntries',  _t('CookieCategory.COOKIEENTRIES', "Cookies"), $this->CookieEntries(),
                    GridFieldConfig_RecordEditor::create())
            ));


            $this->extend('updateCMSFields', $fields);
            return $fields;
        }

        public function requireDefaultRecords()
        {
            parent::requireDefaultRecords();


            $entry = CookieCategory::get()->first();
            if (!$entry) {
                $GenerateConfig = Config::inst()->get('kw\cookieconsent\CookieCategory', 'OnInit');

                foreach($GenerateConfig as $key => $entry){
                    if(is_array($entry) && array_key_exists('Title',$entry)){
                        $title = $entry['Title'];
                    } else {
                        $title = $key;
                    }
                    if(is_array($entry) && array_key_exists('Required', $entry)){
                        $required = true;
                    } else {
                        $required = false;
                    }
                    if(is_array($entry) && array_key_exists('CookieEntries',$entry)){
                        $cookies = $entry['CookieEntries'];
                    } else {
                        $cookies = false;
                    }
                    if(is_array($entry) && array_key_exists('Content',$entry)){
                        $content = $entry['Content'];
                    } else {
                        $content = false;
                    }
                    self::make_entry(
                        $title,$content, $required,$cookies
                    );
                }

                DB::alteration_message("Added default CookieCategory", "created");
            }
        }
        public static function make_entry($title,$content, $required = false,$cookies)
        {
            $CookieCategory = CookieCategory::create();
            $CookieCategory->Title = $title;
            $CookieCategory->Content = $content;
            $CookieCategory->Required = $required;
            $CookieCategoryID = $CookieCategory->write();

            if(is_array($cookies)){
                CookieEntry::make_entry(
                    $cookies, $CookieCategoryID
                );
            }


            return $CookieCategory;
        }
    }
