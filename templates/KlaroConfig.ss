<script>
    var klaroConfig = {
        'privacyPolicy': '$siteConfig.CookieLinkPrivacy().AbsoluteLink()',
        'acceptAll': true,
        'hideDeclineAll': false,
        'translations': {
            de:{
                'consentNotice': {
                    'description': '$siteConfig.CookieLabelIntro',
                },
                'acceptAll': '$siteConfig.CookieLabelCPCActivateAll',
                'decline': '$siteConfig.CookieLabelCPCDeactivateAll',
                'acceptSelected': 'Speichern',
                <% if $CookieEntries %>
                    <% loop $CookieEntries %>
                        '$CookieID':{
                            'description': '$Purpose'
                        },
                    <% end_loop %>
                    'purposes': {
                        <% loop $CookieCategories %>'$CookieCategoryID': '$Title'<% if Last %><% else %>,<% end_if %><% end_loop %>
                    }
                <% end_if %>

            }
        },
        <% if $CookieCategories %>
        'apps': [

        <% loop $CookieCategories %>
            <% loop $CookieEntries %>
            {
                'name': '$CookieID',
                'required': <% if $CookieCategory.Required %>true<% else %>false<% end_if %>,
                'default': <% if $CookieCategory.Required %>true<% else %>false<% end_if %>,
                'purposes': ['$CookieCategory.CookieCategoryID'],
                'title': '$Title',
                'cookies': '$CookieName'<% if $HTMLCallback %>,
                'callback': function(consent, app) {{$HTMLCallback}(consent,app);}<% end_if %>
            }<% if $Last %><% else %>,<% end_if %>
            <% end_loop %>
            <% if $Last %><% else %>,<% end_if %>
        <% end_loop %>
        ]
        <% end_if %>
    };



</script>
<% loop $CookieEntries %><% if $HTMLCode %>$HTMLCode<% end_if %><% end_loop %>