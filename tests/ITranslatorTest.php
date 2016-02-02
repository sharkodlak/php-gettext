<?php

namespace Sharkodlak\Gettext;

class ITranslatorTest extends \PHPUnit_Framework_TestCase {
	private static $functionExists = [
		'dpgettext' => false,
		'pgettext' => false,
		'dnpgettext' => false,
		'npgettext' => false,
	];
	public static function setUpBeforeClass() {
		foreach (self::$functionExists as $functionName => $exists) {
			self::$functionExists[$functionName] = function_exists($functionName);
		}
		require_once __DIR__ . "/../src/ITranslator.php";
		$domains = ['default', 'client'];
		$localeDir = __DIR__ . '/locale';
		foreach ($domains as $domain) {
			bindtextdomain($domain, $localeDir);
			bind_textdomain_codeset($domain, 'UTF-8');
		}
	}

	private function setlocaleCs() {
		setlocale(LC_MESSAGES, 'cs_CZ.UTF-8');
	}

	private function setlocaleEn() {
		setlocale(LC_MESSAGES, 'en_US.UTF-8');
	}

	public function setUp() {
		$this->setlocaleEn();
		textdomain('default');
	}

	public function testGettext() {
		$translation = gettext('simple message');
		$this->assertEquals('simple message', $translation);
		$this->setlocaleCs();
		$translation = gettext('simple message');
		$this->assertEquals('jednoduchá zpráva', $translation);
	}

	public function testDpgettext() {
		if (self::$functionExists['dpgettext']) {
			$this->markTestSkipped('Function dpgettext already defined');
		} else {
			$domain = 'client';
			textdomain($domain);
			$translation = dpgettext($domain, 'firstContext', 'message with context');
			$this->assertEquals("client's message with context", $translation);
			$this->setlocaleCs();
			$translation = dpgettext($domain, 'firstContext', 'message with context');
			$this->assertEquals('klientská zpráva s kontextem', $translation);
		}
	}

	public function testPgettext() {
		if (self::$functionExists['pgettext']) {
			$this->markTestSkipped('Function pgettext already defined');
		} else {
			$translation = pgettext('firstContext', 'message with context');
			$this->assertEquals('message with context', $translation);
			$this->setlocaleCs();
			$translation = pgettext('firstContext', 'message with context');
			$this->assertEquals('zpráva s kontextem', $translation);
		}
	}

	public function testDnpgettext() {
		if (self::$functionExists['dnpgettext']) {
			$this->markTestSkipped('Function dnpgettext already defined');
		} else {
			$domain = 'client';
			textdomain($domain);
			$translation = dnpgettext($domain, 'firstContext', 'singular with context', '%d plurals with context', 1);
			$this->assertEquals("client's singular with context", $translation);
			$translation = dnpgettext($domain, 'firstContext', 'singular with context', '%d plurals with context', 2);
			$this->assertEquals("%d client's plurals with context", $translation);
			$this->setlocaleCs();
			$translation = dnpgettext($domain, 'firstContext', 'singular with context', '%d plurals with context', 1);
			$this->assertEquals('klientské jednotné číslo s kontextem', $translation);
			$translation = dnpgettext($domain, 'firstContext', 'singular with context', '%d plurals with context', 2);
			$this->assertEquals('%d klientská množná čísla s kontextem', $translation);
			$translation = dnpgettext($domain, 'firstContext', 'singular with context', '%d plurals with context', 5);
			$this->assertEquals('%d klientských množných čísel s kontextem', $translation);
		}
	}

	public function testNpgettext() {
		if (self::$functionExists['npgettext']) {
			$this->markTestSkipped('Function npgettext already defined');
		} else {
			$translation = npgettext('firstContext', 'singular with context', '%d plurals with context', 1);
			$this->assertEquals('singular with context', $translation);
			$translation = npgettext('firstContext', 'singular with context', '%d plurals with context', 2);
			$this->assertEquals('%d plurals with context', $translation);
			$this->setlocaleCs();
			$translation = npgettext('firstContext', 'singular with context', '%d plurals with context', 1);
			$this->assertEquals('jednotné číslo s kontextem', $translation);
			$translation = npgettext('firstContext', 'singular with context', '%d plurals with context', 2);
			$this->assertEquals('%d množná čísla s kontextem', $translation);
			$translation = npgettext('firstContext', 'singular with context', '%d plurals with context', 5);
			$this->assertEquals('%d množných čísel s kontextem', $translation);
		}
	}
}
