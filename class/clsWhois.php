<?php
require_once __DIR__ . '/../../../mainfile.php';

$moduleDirName = basename(dirname(__DIR__));
xoops_loadLanguage('main', $moduleDirName);

class xWhois
{
    /*
     * Optional parameter for the server to be used for the lookup.
     * If this is not set, an appropriate whois server for the domain name
     * specified is automagically found by the Whois class.
     * @type string
     * @access public
     */
    public $whois_server;
    /*
     * The timeout, in seconds, for the lookup. Default is 30.
     * @type integer
     * @access public
     */
    public $timeout = 30;

    /*
     * Returns a string, with new-lines (\n) converted to non-breaking spaces (&lt;BR>),
     * with details for the domain specified by $domain.
     * @access public
     * @param  string $domain the domain to lookup, excluding http:// and www
     * @return string the results of the whois
     */
    public function lookup($domain)
    {
        $result = '';
        $parts  = [];
        $host   = '';

        // .tv don't allow access to their whois
        if (false !== strpos($domain, '.tv')) {
            //$result = "'.tv' domain names require you to have an account to do whois searches.";
            $result = "Please contact us regarding the $domain";
        // New domains fix (half work, half don't)
        } elseif (false !== strpos($domain, '.name') || false !== strpos($domain, '.pro') > 0) {
            //$result = ".name,.pro require you to have an account to do whois searches.";
            $result = "Please contact us regarding $domain";
        } else {
            if (empty($this->whois_server)) {
                $parts       = explode('.', $domain);
                $testhost    = $parts[count($parts) - 1];
                $whoisserver = $testhost . '.whois-servers.net';
                $this->host  = gethostbyname($whoisserver);
                $this->host  = gethostbyaddr($this->host);

                if ($this->host == $testhost) {
                    $this->host = 'www.internic.net';
                }
            }

            $whoisSocket = fsockopen($this->host, 43, $errno, $errstr, $this->timeout);

            if (!$whoisSocket) {
                $result = STATS_DNSLOOKUP_ERROR . '<br>' . $errno . '&nbsp;-&nbsp;' . $errstr . '<br>';
            } else {
                fwrite($whoisSocket, $domain . "\015\012");
                while (!feof($whoisSocket)) {
                    $result .= fgets($whoisSocket, 128) . '<br>';
                }
                fclose($whoisSocket);
            }
        }

        return $result;
    }

    public function reverselookup($ip)
    {
        // using the arin database cgi...have to keep an eye on things to make sure it works long term!
        $fullurl = "http://ws.arin.net/cgi-bin/whois.pl?queryinput=$ip";

        $url = parse_url($fullurl);

        if (!in_array($url['scheme'], ['', 'http'])) {
            return;
        }

        $fp = fsockopen($url['host'], ($url['port'] > 0 ? $url['port'] : 80), $errno, $errstr, $this->timeout);
        if (!$fp) {
            $d = STATS_REVERSELOOKUP_ERROR . '<br>' . $errno . '&nbsp;-&nbsp;' . $errstr . '<br>';
        } else {
            fwrite($fp, 'GET /' . $url['path'] . ($url['query'] ? '?' . $url['query'] : '') . " HTTP/1.0\r\nHost: " . $url['host'] . "\r\n\r\n");
            $d = '';
            while (!feof($fp)) {
                $d .= fgets($fp, 2048);
            }
            fclose($fp);

            $d = stristr($d, 'Search results for: ');
            $d = str_replace('cgi-bin/whois.pl?queryinput=N%20!%20', 'modules/statistics/admin/index.php?op=reverseip&iplookup=', $d);
            $d = str_replace('cgi-bin/whois.pl?queryinput=P%20!%20', 'modules/statistics/admin/index.php?op=reverseip&iplookup=', $d);
        }

        return $d;
    }
}
