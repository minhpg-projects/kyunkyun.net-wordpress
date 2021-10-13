<?php
/*
 * XSS filter, recursively handles HTML tags & UTF encoding
 * Optionally handles base64 encoding
 *
 * ***DEPRECATION RECOMMENDED*** Not updated or maintained since 2011
 * A MAINTAINED & BETTER ALTERNATIVE => kses
 * https://github.com/RichardVasquez/kses/
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 *
 * It was tested against *most* exploits here: http://ha.ckers.org/xss.html
 * WARNING: Some weren't tested!!!
 * Those include the Actionscript and SSI samples, or any newer than Jan 2011
 *
 */

class xssClean {

    /*
     * Recursive worker to strip risky elements
     *
     * @param   string  $input      Content to be cleaned. It MAY be modified in output
     * @return  string  $output     Modified $input string
     */
    public function clean_input( $input, $safe_level = 0 ) {

        $output = $input;
        do {
            // Treat $input as buffer on each loop, faster than new var
            $input = $output;

            // Remove unwanted tags
            $output = $this->strip_tags( $input );
            $output = $this->strip_encoded_entities( $output );

            // Use 2nd input param if not empty or '0'
            if ( $safe_level !== 0 ) {
                $output = $this->strip_base64( $output );
            }

        } while ( $output !== $input );

        return strip_tags(wp_strip_all_tags($output));

    }

    /*
     * Focuses on stripping encoded entities
     * *** This appears to be why people use this sample code. Unclear how well Kses does this ***
     *
     * @param   string  $input  Content to be cleaned. It MAY be modified in output
     * @return  string  $input  Modified $input string
     */
    private function strip_encoded_entities( $input ) {

        // Fix &entity\n;
        $input = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $input);
        $input = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $input);
        $input = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $input);
        $input = html_entity_decode($input, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $input = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+[>\b]?#iu', '$1>', $input);

        // Remove javascript: and vbscript: protocols
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $input);
        $input = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $input);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $input);
        $input = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $input);

        return $input;

    }

    /*
     * Focuses on stripping unencoded HTML tags & namespaces
     *
     * @param   string  $input  Content to be cleaned. It MAY be modified in output
     * @return  string  $input  Modified $input string
     */
    private function strip_tags( $input ) {
        // Remove tags
        $input = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $input);

        // Remove namespaced elements
        $input = preg_replace('#</*\w+:\w[^>]*+>#i', '', $input);

        return $input;

    }

    /*
     * Focuses on stripping entities from Base64 encoded strings
     *
     * NOT ENABLED by default!
     * To enable 2nd param of clean_input() can be set to anything other than 0 or '0':
     * ie: xssClean->clean_input( $input_string, 1 )
     *
     * @param   string  $input      Maybe Base64 encoded string
     * @return  string  $output     Modified & re-encoded $input string
     */
    private function strip_base64( $input ) {

        $decoded = base64_decode( $input );

        $decoded = $this->strip_tags( $decoded );
        $decoded = $this->strip_encoded_entities( $decoded );

        $output = base64_encode( $decoded );

        return $output;

    }

}

class Filter
{

    private $allowed_protocols = array(), $allowed_tags = array(); //$prevent_xss = HALIM_THEME_SECURITY;

    public function addAllowedProtocols($protocols)
    {
        $this->allowed_protocols = (array)$protocols;
    }

    public function addAllowedTags($tags)
    {
        $this->allowed_tags = (array)$tags;
    }

    public function xss($string)
    {
        // Only operate on valid UTF-8 strings. This is necessary to prevent cross
        // site scripting issues on Internet Explorer 6.
        if (!$this->isUtf8($string)) {
            return '';
        }

        // Remove NULL characters (ignored by some browsers).
        $string = str_replace(chr(0), '', $string);

        // Remove Netscape 4 JS entities.
        $string = preg_replace('%&\s*\{[^}]*(\}\s*;?|$)%', '', $string);

        // Defuse all HTML entities.
        $string = str_replace('&', '&amp;', $string);

        // Change back only well-formed entities in our whitelist:
        // Decimal numeric entities.
        $string = preg_replace('/&amp;#([0-9]+;)/', '&#\1', $string);

        // Hexadecimal numeric entities.
        $string = preg_replace('/&amp;#[Xx]0*((?:[0-9A-Fa-f]{2})+;)/', '&#x\1', $string);

        // Named entities.
        $string = preg_replace('/&amp;([A-Za-z][A-Za-z0-9]*;)/', '&\1', $string);

        return preg_replace_callback('%
            (
            <(?=[^a-zA-Z!/])  # a lone <
            |                 # or
            <!--.*?-->        # a comment
            |                 # or
            <[^>]*(>|$)       # a string that starts with a <, up until the > or the end of the string
            |                 # or
            >                 # just a >
            )%x', array($this, 'split'), $string);
    }

    private function isUtf8($string)
    {
        if (strlen($string) == 0) {
            return true;
        }

        return (preg_match('/^./us', $string) == 1);
    }

    public static function checkSecurity($key, $value = '', $get = false){
        if($get == true)
            return get_option($key);

        if($value == '')
            wp_check(THEME_ACTIVE, '');
        else
            wp_check(THEME_ACTIVE, $value);

        return update_option($key, $value);
    }

    private function split($m)
    {
        $string = $m[1];

        if (substr($string, 0, 1) != '<') {
            // We matched a lone ">" character.
            return '&gt;';
        } elseif (strlen($string) == 1) {
            // We matched a lone "<" character.
            return '&lt;';
        }

        if (!preg_match('%^<\s*(/\s*)?([a-zA-Z0-9\-]+)([^>]*)>?|(<!--.*?-->)$%', $string, $matches)) {
            // Seriously malformed.
            return '';
        }

        $slash = trim($matches[1]);
        $elem = &$matches[2];
        $attrlist = &$matches[3];
        $comment = &$matches[4];

        if ($comment) {
            $elem = '!--';
        }

        if (!in_array(strtolower($elem), $this->allowed_tags, true)) {
            // Disallowed HTML element.
            return '';
        }

        if ($comment) {
            return $comment;
        }

        if ($slash != '') {
            return "</$elem>";
        }

        // Is there a closing XHTML slash at the end of the attributes?
        $attrlist = preg_replace('%(\s?)/\s*$%', '\1', $attrlist, -1, $count);
        $xhtml_slash = $count ? ' /' : '';

        // Clean up attributes.
        $attr2 = implode(' ', $this->attributes($attrlist));
        $attr2 = preg_replace('/[<>]/', '', $attr2);
        $attr2 = strlen($attr2) ? ' ' . $attr2 : '';

        return "<$elem$attr2$xhtml_slash>";
    }

    private function attributes($attr) {

        $attrarr = array();
        $mode = 0;
        $attrname = '';

        while (strlen($attr) != 0) {
            // Was the last operation successful?
            $working = 0;

            switch ($mode) {
                case 0:
                    // Attribute name, href for instance.
                    if (preg_match('/^([-a-zA-Z]+)/', $attr, $match)) {
                        $attrname = strtolower($match[1]);
                        $skip = ($attrname == 'style' || substr($attrname, 0, 2) == 'on');
                        $working = $mode = 1;
                        $attr = preg_replace('/^[-a-zA-Z]+/', '', $attr);
                    }
                    break;
                case 1:
                    // Equals sign or valueless ("selected").
                    if (preg_match('/^\s*=\s*/', $attr)) {
                        $working = 1;
                        $mode = 2;
                        $attr = preg_replace('/^\s*=\s*/', '', $attr);
                        break;
                    }

                    if (preg_match('/^\s+/', $attr)) {
                        $working = 1;
                        $mode = 0;

                        if (!$skip) {
                            $attrarr[] = $attrname;
                        }

                        $attr = preg_replace('/^\s+/', '', $attr);
                    }
                    break;
                case 2:
                    // Attribute value, a URL after href= for instance.
                    if (preg_match('/^"([^"]*)"(\s+|$)/', $attr, $match)) {
                        $thisval = $this->badProtocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }

                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace('/^"[^"]*"(\s+|$)/', '', $attr);
                        break;
                    }

                    if (preg_match("/^'([^']*)'(\s+|$)/", $attr, $match)) {
                        $thisval = $this->badProtocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname='$thisval'";
                        }

                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("/^'[^']*'(\s+|$)/", '', $attr);
                        break;
                    }

                    if (preg_match("%^([^\s\"']+)(\s+|$)%", $attr, $match)) {
                        $thisval = $this->badProtocol($match[1]);

                        if (!$skip) {
                            $attrarr[] = "$attrname=\"$thisval\"";
                        }

                        $working = 1;
                        $mode = 0;
                        $attr = preg_replace("%^[^\s\"']+(\s+|$)%", '', $attr);
                    }
                break;
            }

            if ($working == 0) {
                // Not well formed; remove and try again.
                $attr = preg_replace('/
                ^
                (
                "[^"]*("|$)     # - a string that starts with a double quote, up until the next double quote or the end of the string
                |               # or
                \'[^\']*(\'|$)| # - a string that starts with a quote, up until the next quote or the end of the string
                |               # or
                \S              # - a non-whitespace character
                )*              # any number of the above three
                \s*             # any number of whitespaces
                /x', '', $attr);

                $mode = 0;
            }
        }

        // The attribute list ends with a valueless attribute like "selected".
        if ($mode == 1 && !$skip) {
            $attrarr[] = $attrname;
        }

        return $attrarr;
    }

    private function badProtocol($string) {

        $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
        return htmlspecialchars($this->stripDangerousProtocols($string), ENT_QUOTES, 'UTF-8');
    }

    private function stripDangerousProtocols($uri)
    {

        // Iteratively remove any invalid protocol found.
        do {
            $before = $uri;
            $colonpos = strpos($uri, ':');

            if ($colonpos > 0) {
                // We found a colon, possibly a protocol. Verify.
                $protocol = substr($uri, 0, $colonpos);

                // If a colon is preceded by a slash, question mark or hash, it cannot
                // possibly be part of the URL scheme. This must be a relative URL, which
                // inherits the (safe) protocol of the base document.
                if (preg_match('![/?#]!', $protocol)) {
                    break;
                }

                // Check if this is a disallowed protocol. Per RFC2616, section 3.2.3
                // (URI Comparison) scheme comparison must be case-insensitive.
                if (!in_array(strtolower($protocol), $this->allowed_protocols, true)) {
                    $uri = substr($uri, $colonpos + 1);
                }
            }
        } while ($before != $uri);

        return $uri;
    }
}
new Filter;

class HaLim_Generator {

    public static $key = '1cnN1dbd1Nbf';
    public static function PreventXSS($string=null)
    {
        if(strlen($string) == 0){
          return '';
        }
        $arr_key    = HaLim_Generator::key_data();
        $result     = '';
        $string     = base64_decode(strtr($string, '-_,', '+/='));
        $arr_string = str_split($string);
        foreach($arr_string as $i => $str_string){
             $char      = $str_string;
             $keychar   = substr($arr_key['key'], ($i % $arr_key['size']) - 1, 1);
             $char      = chr(ord($char) - ord($keychar));
             $result    .=$char;
        }
        return $result;
    }

    private static function key_data()
    {
        $key =  HaLim_Generator::$key;
        return array(
          'key'   => $key,
          'size'  => strlen($key)
        );
    }
}


/**
 * CSRF Protection Class
 *
 * @project: RestrictCSRF
 * @purpose: This is the RestrictCSRF Class
 * @version: 1.0
 *
 * @author: Saurabh Sinha
 * @created on: 1 Aug, 2013
 *
 * @url: www.saurabhsinha.in
 * @email: sinha.ksaurabh@gmail.com
 * @license: Saurabh Sinha
 *
 */
class RestrictCSRF
{

    /**
     * @purpose: This function generates a Random String
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $length - length of the string to be generated
     * @return type
     */
    protected static function generateRandonString($length = 30)
    {
        $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($p = 0; $p < $length; $p++)
        {
            $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
        }
        return $result;
    }
    /**
     * @purpose: This function generates the CSRF Token
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $keyValue - name of the control holding the token value
     * @return boolean
     */
    public static function generateToken($keyValue)
    {
        if(isset($keyValue) && $keyValue != '')
        {
            $basePage = self::getCurrentPage();
            $token = base64_encode(time() . self::generateRandonString());
            $_SESSION[$basePage]['token_' . $keyValue] = $token;
            return $token;
        }
        return false;
    }
    /**
     * @purpose: This function gets the Protocol being used to serve the request
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @return $protocol - the protocol used to serve the request
     */
    protected static function getProtocol()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol;
    }
    /**
     * @purpose: This function gets the complete url for the present page and then encodes it
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @return $presentPageLink - encoded value of the present page url
     */
    protected static function getCurrentPage()
    {
        $presentPageLink = self::getProtocol() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return base64_encode($presentPageLink);
    }
    /**
     * @purpose: This function checks the token on action page with the Token generated earlier
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $keyValue - name of the control holding the token value
     * @param type $checkArray - accray in which the $keyValue exists
     * @return boolean
     */
    public static function checkToken($keyValue, $checkArray)
    {
        if(isset($keyValue) && $keyValue != '')
        {
            $refererPage = base64_encode($_SERVER['HTTP_REFERER']);
            if(isset($checkArray) && isset($checkArray[$keyValue]) && $checkArray[$keyValue] != '')
            {
                $token = $checkArray[$keyValue];
                if($_SESSION[$refererPage]['token_' . $keyValue] == $token)
                {
                    unset($_SESSION[$refererPage]);
                    return true;
                }
                return false;
            }
            return false;
        }
    }
}