<?php

namespace Sharkodlak\Gettext;

class TranslatorTest extends \PHPUnit_Framework_TestCase {
	static private $translator;

	static public function setUpBeforeClass() {
		self::$translator = new Translator(__DIR__ . '/locale', 'default');
		self::$translator->setDomainWithAlias('countries', '/usr/share/locale', 'iso_3166');
		self::$translator->setDomainWithAlias('languages', '/usr/share/locale', 'iso_639');
	}

	private function setlocaleCs() {
		setlocale(LC_MESSAGES, 'cs_CZ.UTF-8', 'cs_CZ', 'cs');
	}

	private function setlocaleEn() {
		setlocale(LC_MESSAGES, 'en_US.UTF-8', 'en_US', 'en');
	}

	public function setUp() {
		$this->setlocaleEn();
	}

	public function testGetDomain() {
		$domain = 'default';
		$gotDomain = self::$translator->getDomain($domain);
		$this->assertEquals($domain, $gotDomain);
		$gotDomain = self::$translator->getDomain('countries');
		$this->assertEquals('iso_3166', $gotDomain);
		$gotDomain = self::$translator->getDomain('languages');
		$this->assertEquals('iso_639', $gotDomain);
	}

	public function test_() {
		$translation = self::$translator->_('untranslated message');
		$this->assertEquals('untranslated message', $translation);
		$translation = self::$translator->_('simple message');
		$this->assertEquals('a simple message', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->_('simple message');
		$this->assertEquals('jednoduchá zpráva', $translation);
	}

	public function testD_() {
		$translation = self::$translator->d_('countries', 'Czech Republic');
		$this->assertEquals('Czech Republic', $translation);
		$translation = self::$translator->d_('languages', 'czech');
		$this->assertEquals('czech', $translation);
		$translation = self::$translator->_('untranslated message');
		$this->assertEquals('untranslated message', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->d_('countries', 'Czech Republic');
		$this->assertEquals('Česká republika', $translation);
		$translation = self::$translator->d_('languages', 'Czech');
		$this->assertEquals('čeština', $translation);
		$translation = self::$translator->_('simple message');
		$this->assertEquals('jednoduchá zpráva', $translation);
	}
}
