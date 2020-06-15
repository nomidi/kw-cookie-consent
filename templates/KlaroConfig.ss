<script>


    var klaroConfig = {
        'privacyPolicy': <% with $SiteConfig %>'$CookieLinkPrivacy().AbsoluteLink()<% end_with %>',
        'acceptAll': true,
        'hideDeclineAll': false,
        'translations': {
        <% with $SiteConfigDefault %>
            $getJSLocale:{
            'consentNotice': {
                'description': '$CookieLabelIntro',
            },
            'acceptAll': '$CookieLabelCPCActivateAll',
                    'decline': '$CookieLabelCPCDeactivateAll',
                    'acceptSelected': '$CookieLabelSaveButton',

            <% if $getCookieCategoriesByLang($Locale) %>
            'purposes': {
                <% loop $getCookieCategoriesByLang($Locale) %>'$Key': '$Title',<% end_loop %>
            },
            <% end_if %>

            <% if $getCookieEntriesByLang($Locale) %>
                <% loop $getCookieEntriesByLang($Locale) %>
                    '$CookieKey':{
                    'description': '$Purpose'
                },
                <% end_loop %>
            <% end_if %>

        },

        },
        <% end_with %>


        <% if $CookieCategories %>
        'apps': [

            <% loop $CookieCategories %>
                <% if $CookieEntries %>
                    <% loop $CookieEntries %>
                        <% if $CookieKey %>
                            {
                                'name': '$CookieKey',
                            'required': <% if $CookieCategory.Required %>true<% else %>false<% end_if %>,
                            'default': <% if $CookieCategory.Required %>true<% else %>false<% end_if %>,
                                'purposes': ['$CookieCategory.Key'],
                                'title': '$Title',
                                'cookies': '$CookieName'<% if $HTMLCallback %>,
                                'callback': function(consent, app) {{$HTMLCallback}(consent,app);}<% end_if %>
                            }<% if $Last %><% else %>,<% end_if %>
                        <% end_if %>
                    <% end_loop %>
                    <% if $Last %><% else %>,<% end_if %>
                <% end_if %>

            <% end_loop %>
        ]
        <% end_if %>
    };



</script>
<% loop $CookieEntries %><% if $HTMLCode %>$HTMLCode<% end_if %><% end_loop %>