<?php

namespace Sharkodlak\Gettext;

class TranslatorTest extends \PHPUnit_Framework_TestCase {
	private static $translator;

	public static function setUpBeforeClass() {
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

	public function testConstructor() {
		$domain = 'client';
		$translator = new Translator(__DIR__ . '/locale', $domain);
		$gotDomain = $translator->getDomain($domain);
		$this->assertEquals($domain, $gotDomain);
		$this->setlocaleCs();
		$translation = $translator->_('simple message');
		$this->assertEquals($domain, textdomain(null));
		$this->assertEquals('jednoduchá klientská zpráva', $translation);
	}

	public function testGetDomain() {
		$domain = 'default';
		$gotDomain = self::$translator->getDomain($domain);
		$this->assertEquals($domain, $gotDomain);
		$domain = 'undeclared domain remain same';
		$gotDomain = self::$translator->getDomain($domain);
		$this->assertEquals($domain, $gotDomain);
		$gotDomain = self::$translator->getDomain('countries');
		$this->assertEquals('iso_3166', $gotDomain);
		$gotDomain = self::$translator->getDomain('languages');
		$this->assertEquals('iso_639', $gotDomain);
		self::$translator->setDomainWithAlias('foo', '/missing/path', 'bar');
		$gotDomain = self::$translator->getDomain('foo');
		$this->assertEquals('bar', $gotDomain);
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
		$translation = self::$translator->d_('languages', 'Czech');
		$this->assertEquals('Czech', $translation);
		$translation = self::$translator->_('untranslated message');
		$this->assertEquals('untranslated message', $translation);
		$translation = self::$translator->d_('client', 'untranslated message');
		$this->assertEquals('untranslated message', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->d_('countries', 'Czech Republic');
		$this->assertEquals('Česká republika', $translation);
		$translation = self::$translator->d_('languages', 'Czech');
		$this->assertEquals('čeština', $translation);
		$translation = self::$translator->_('simple message');
		$this->assertEquals('jednoduchá zpráva', $translation);
		$translation = self::$translator->d_('client', 'simple message');
		$this->assertEquals('jednoduchá klientská zpráva', $translation);
	}

	public function testDn_() {
		$domain = 'client';
		$translation = self::$translator->dn_($domain, 'untranslated singular', 'untranslated plural', 1);
		$this->assertEquals('untranslated singular', $translation);
		$translation = self::$translator->dn_($domain, 'untranslated singular', 'untranslated plural', 2);
		$this->assertEquals('untranslated plural', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dn_($domain, 'singular', '%d plurals', 1);
		$this->assertEquals('klientské jednotné číslo', $translation);
		$translation = self::$translator->dn_($domain, 'singular', '%d plurals', 2);
		$this->assertEquals('%d klientská množná čísla', $translation);
		$translation = self::$translator->dn_($domain, 'singular', '%d plurals', 5);
		$this->assertEquals('%d klientských množných čísel', $translation);
	}

	public function testDnp_() {
		$domain = 'client';
		$translation = self::$translator->dnp_($domain, 'firstContext', 'untranslated singular with context', 'untranslated plural with context', 1);
		$this->assertEquals('untranslated singular with context', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', 'untranslated singular with context', 'untranslated plural with context', 2);
		$this->assertEquals('untranslated plural with context', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dnp_($domain, 'firstContext', 'singular with context', '%d plurals with context', 1);
		$this->assertEquals('klientské jednotné číslo s kontextem', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', 'singular with context', '%d plurals with context', 2);
		$this->assertEquals('%d klientská množná čísla s kontextem', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', 'singular with context', '%d plurals with context', 5);
		$this->assertEquals('%d klientských množných čísel s kontextem', $translation);
	}

	public function testDp_() {
		$domain = 'client';
		$translation = self::$translator->dp_($domain, 'firstContext', 'untranslated message');
		$this->assertEquals('untranslated message', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dp_($domain, 'firstContext', 'message with context');
		$this->assertEquals('klientská zpráva s kontextem', $translation);
	}

	public function testN_() {
		$translation = self::$translator->n_('untranslated singular', 'untranslated plural', 1);
		$this->assertEquals('untranslated singular', $translation);
		$translation = self::$translator->n_('untranslated singular', 'untranslated plural', 2);
		$this->assertEquals('untranslated plural', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->n_('singular', '%d plurals', 1);
		$this->assertEquals('jednotné číslo', $translation);
		$translation = self::$translator->n_('singular', '%d plurals', 2);
		$this->assertEquals('%d množná čísla', $translation);
		$translation = self::$translator->n_('singular', '%d plurals', 5);
		$this->assertEquals('%d množných čísel', $translation);
	}

	public function testNp_() {
		$translation = self::$translator->np_('firstContext', 'singular with context', '%d plurals with context', 1);
		$this->assertEquals('singular with context', $translation);
		$translation = self::$translator->np_('firstContext', 'singular with context', '%d plurals with context', 2);
		$this->assertEquals('%d plurals with context', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->np_('firstContext', 'singular with context', '%d plurals with context', 1);
		$this->assertEquals('jednotné číslo s kontextem', $translation);
		$translation = self::$translator->np_('firstContext', 'singular with context', '%d plurals with context', 2);
		$this->assertEquals('%d množná čísla s kontextem', $translation);
		$translation = self::$translator->np_('firstContext', 'singular with context', '%d plurals with context', 5);
		$this->assertEquals('%d množných čísel s kontextem', $translation);
	}

	public function testP_() {
		$translation = self::$translator->p_('firstContext', 'untranslated message with context');
		$this->assertEquals('untranslated message with context', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->p_('firstContext', 'message with context');
		$this->assertEquals('zpráva s kontextem', $translation);
	}
}
