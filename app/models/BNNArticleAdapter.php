<?php

namespace app\models;
use \DOMDocument;
use \DOMXPath;
use \Exception;

class BNNArticleAdapter
{

	public $portalURL = '';

	public function __construct() {
		libxml_use_internal_errors(true); //Suppress libXML Warnings
	}

	public function get($url = null) {

		if (!$this->validate($url)) {throw new Exception("URL to Scrape has Invalid format", );}

		$data = $this->curl($url);

		$html = $data['data'];

		$doc = new DOMDocument();
		$doc->loadHTML($html);
		$xpath = new DOMXPath($doc);

		$selector = 'article--full';
		$xmlNodes = $xpath->query("//*[contains(@class, '$selector')]");
		$content = $xmlNodes->item(0);

		if (empty($content)) {
			$selector = 'longread--full';
			$xmlNodes = $xpath->query("//*[contains(@class, '$selector')]");
			$content = $xmlNodes->item(0);
		}
		
		if (empty($content)) {return null;}

		// Remove Teaser Elements
		foreach ($xpath->query("//*[contains(@class, 'section-teaser')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Immersive Header Meta
		foreach ($xpath->query("//*[contains(@class, 'immersive-header__meta')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Immersive Header Meta
		foreach ($xpath->query("//*[contains(@class, 'immersive-header__mobile-meta')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Immersive Header Sticky
		foreach ($xpath->query("//*[contains(@class, 'immersive-header__sticky-content-container')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Breadcrumb
		foreach ($xpath->query("//*[contains(@class, 'immersive-header__breadcrumb')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Artikel Lead
		foreach ($xpath->query("//*[contains(@class, 'article__lead-media')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Meta Data
		foreach ($xpath->query("//*[contains(@class, 'page-meta')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Meta Data
		foreach ($xpath->query("//*[contains(@class, 'embed-consent')]", $xmlNodes->item(0)) as $node) {
			$node->parentNode->removeChild($node);
		}

		// Remove Images
		foreach ($xpath->query("//figure", $xmlNodes->item(0)) as $footer) {
			$footer->parentNode->removeChild($footer);
		}

		// Remove Footer
		foreach ($xpath->query("//footer", $xmlNodes->item(0)) as $footer) {
			$footer->parentNode->removeChild($footer);
		}

		return $doc->saveHTML($content);

	}

	private function validate($url) {
		return filter_var($url, FILTER_VALIDATE_URL);
	}

	private function curl($url) {

		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt ($ch, CURLOPT_HTTPHEADER, [BNNLOGINCOOKIE]);

		$recievedData = curl_exec($ch);
		if ($recievedData === false) {
			dd(curl_error($ch));
		}

		$lastUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
		$responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

		curl_close ($ch);

		if ($responseCode == 404) {
			throw new \Exception("Artikel nicht gefunden oder kann nicht importiert werden", 404);
		}

		return ['data' => $recievedData, 'url' => $lastUrl];

	}



}
