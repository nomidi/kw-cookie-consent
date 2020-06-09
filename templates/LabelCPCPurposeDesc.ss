<% loop $Cookies %>
    <strong class="as-oil-cpc__purpose-text__cookie-title">$Title</strong>
<table>
    <tr>
        <td>Provider</td>
        <td>$Provider</td>
    </tr>
    <tr>
        <td>Purpose</td>
        <td>$Purpose</td>
    </tr>
    <tr>
        <td>Policy</td>
        <td><a href="$Policy">$Policy</a></td>
    </tr>
    <tr>
        <td>CookieName</td>
        <td>$CookieNamer</td>
    </tr>
    <tr>
        <td>Time</td>
        <td>$Time</td>
    </tr>

</table>
<% end_loop %>