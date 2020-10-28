<?php
use MediaWiki\MediaWikiServices;

use Wikibase\Repo\WikibaseRepo;
use Wikibase\Lib\Store\LanguageFallbackLabelDescriptionLookup;
//use Wikibase\Repo\Specials\SpecialMyLanguageFallbackChain;
use Wikibase\Repo\FederatedProperties\SpecialListFederatedProperties;


//use Wikibase\Repo\Specials;

class MISpecialFullP extends SpecialPage {    
    function __construct() {
		parent::__construct('MoreInfoFullP');
    }
    
    

    function execute( $par ) {        
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();

		# Get request data from, e.g.
		$param = $request->getText('param');

        # Do stuff
        //$mark = self::questionMark();
		//$mark = $this->questionMark;

		$wikibaseRepo = WikibaseRepo::getDefaultInstance();

       		$prefetchingTermLookup = $wikibaseRepo->getPrefetchingTermLookup();
		$labelDescriptionLookup = new LanguageFallbackLabelDescriptionLookup(
			$prefetchingTermLookup,
			$wikibaseRepo->getLanguageFallbackChainFactory()
				->newFromLanguage( $wikibaseRepo->getUserLanguage() )
		);
		$entityIdFormatter = $wikibaseRepo->getEntityIdHtmlLinkFormatterFactory()
			->getEntityIdFormatter( $wikibaseRepo->getUserLanguage() );
		$mark = new Wikibase\Repo\Specials\SpecialListProperties(
			$wikibaseRepo->getDataTypeFactory(),
			$wikibaseRepo->getStore()->getPropertyInfoLookup(),
			$labelDescriptionLookup,
			$entityIdFormatter,
			$wikibaseRepo->getEntityTitleLookup(),
			$prefetchingTermLookup,
			$wikibaseRepo->getLanguageFallbackChainFactory()
		);





		
		$mark->execute('');
		$output->addWikiTextAsInterface(get_class($this));
		$output->addWikiTextAsInterface(get_class($mark));
		$output->addWikiTextAsInterface(print_r (get_class_methods(new Wikibase\Repo\Specials\SpecialListProperties($wikibaseRepo->getDataTypeFactory(),
		$wikibaseRepo->getStore()->getPropertyInfoLookup(),
		$labelDescriptionLookup,
		$entityIdFormatter,
		$wikibaseRepo->getEntityTitleLookup(),
		$prefetchingTermLookup,
		$wikibaseRepo->getLanguageFallbackChainFactory()))));


        
        $wikitext = 'Hello world!';
		$output->addWikiTextAsInterface($wikitext);
    }

    function questionMark() {
		$wikibaseRepo = WikibaseRepo::getDefaultInstance();

        /*
		if ( $wikibaseRepo->getSettings()->getSetting( 'federatedPropertiesEnabled' ) ) {
			return new SpecialListFederatedProperties(
				$wikibaseRepo->getSettings()->getSetting( 'federatedPropertiesSourceScriptUrl' )
			);
        }
        */

		$prefetchingTermLookup = $wikibaseRepo->getPrefetchingTermLookup();
		$labelDescriptionLookup = new LanguageFallbackLabelDescriptionLookup(
			$prefetchingTermLookup,
			$wikibaseRepo->getLanguageFallbackChainFactory()
				->newFromLanguage( $wikibaseRepo->getUserLanguage() )
		);
		$entityIdFormatter = $wikibaseRepo->getEntityIdHtmlLinkFormatterFactory()
			->getEntityIdFormatter( $wikibaseRepo->getUserLanguage() );
		return new Wikibase\Repo\Specials\SpecialListProperties(
			$wikibaseRepo->getDataTypeFactory(),
			$wikibaseRepo->getStore()->getPropertyInfoLookup(),
			$labelDescriptionLookup,
			$entityIdFormatter,
			$wikibaseRepo->getEntityTitleLookup(),
			$prefetchingTermLookup,
			$wikibaseRepo->getLanguageFallbackChainFactory()
		);
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