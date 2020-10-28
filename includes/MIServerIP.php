<?php


class MIServerIP extends SpecialPage {    
    function __construct() {
		parent::__construct('MoreInfoserverIP');
    }
    
    
    function execute( $par ) {        
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();

		# Get request data from, e.g.
		$param = $request->getText('param');

        # Do stuff
        $output->addWikiTextAsInterface('<code>gethostname()</code>: ' . gethostname());
        $output->addWikiTextAsInterface('<br />');
        $output->addWikiTextAsInterface('<code>gethostbyname(gethostname())</code>: ' . gethostbyname(gethostname()));
        //$output->addWikiTextAsInterface('<br />');
        //$output->addWikiTextAsInterface('<code>gethostbynamel(gethostname())</code>: ' . print_r(gethostbynamel(gethostname())));
        $output->addWikiTextAsInterface('<br />');
        $output->addWikiTextAsInterface('<code>gethostbyname(wikitrek.tk)</code>: ' . gethostbyname('wikitrek.tk'));
        $output->addWikiTextAsInterface('<br />');
        $output->addWikiTextAsInterface('<code>gethostbyname($wgServer)</code>: ' . $wgServer . gethostbyname($wgServer));
        $output->addWikiTextAsInterface('<br />');
        $output->addWikiTextAsInterface('<code>getIPs()</code>: ' . self::getIPs());
        $output->addWikiTextAsInterface('<br />');
        //$output->addWikiTextAsInterface('<code>gethostbynamel(gethostname())</code>: ' . gethostbynamel(gethostname()));
        $output->addWikiTextAsInterface('<code>gethostbynamel(gethostname())</code>: ');
        foreach (gethostbynamel(gethostname()) as $IPAddress) {
          $output->addWikiTextAsInterface('* ' . $IPAddress);
        }

        $output->addWikiTextAsInterface('<code>Client IP Address</code>: ' . self::client_ip_address());

        $wikitext = 'Hello world!';
		$output->addWikiTextAsInterface($wikitext);
    }

  function getIPs() {
    $addresses = gethostbynamel(gethostname());

    if (count($addresses) == 1) {
      return $addresses[0];
      } else {
        foreach ($addresses as $address) {
          $list = "* " . $address . PHP_EOL;
        }
        return $list;
      }
  }

  function client_ip_address() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $ip){
                $ip = trim($ip); // just to be safe

                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
}

    /**
     * Override the parent to set where the special page appears on Special:SpecialPages
     * 'other' is the default. If that's what you want, you do not need to override.
     * Specify 'media' to use the <code>specialpages-group-media</code> system interface message, which translates to 'Media reports and uploads' in English;
     * 
     * @return string
     */
    function getGroupName() {
        return 'moreinfo';
    }
}