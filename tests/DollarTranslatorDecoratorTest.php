<?php

namespace Sharkodlak\Gettext;

class DollarTranslatorDecoratorTest extends \PHPUnit_Framework_TestCase {
	private static $translator;

	public static function setUpBeforeClass() {
		$translator = new BasicTranslator(__DIR__ . '/locale', 'default');
		$translator->setDomain(__DIR__ . '/locale', 'client');
		self::$translator = new DollarTranslatorDecorator($translator);
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

	public function dollarReplaceTest() {
		$replaced = self::$translator->dollarReplace('Test %3$d placeholders %1 with %%%2 signs but ignore %%4.');
		$this->assertEquals('Test %3$d placeholders %1$s with %%%2$s signs but ignore %%4.', $replaced);
	}

	public function test_() {
		$translation = self::$translator->_('untranslated message %2 being downloaded from source %1');
		$this->assertEquals('untranslated message %2$s being downloaded from source %1$s', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->_('message %2 being downloaded from source %1');
		$this->assertEquals('zpráva %2$s se stahuje ze zdroje %1$s', $translation);
	}

	public function testDoubleDecoration() {
		$translator = new DollarTranslatorDecorator(self::$translator);
		$translation = $translator->_('untranslated message %2 being downloaded from source %1');
		$this->assertEquals('untranslated message %2$s being downloaded from source %1$s', $translation);
		$this->setlocaleCs();
		$translation = $translator->_('message %2 being downloaded from source %1');
		$this->assertEquals('zpráva %2$s se stahuje ze zdroje %1$s', $translation);
	}

	public function testD_() {
		$domain = 'client';
		$translation = self::$translator->d_($domain, 'untranslated message %2 being downloaded from source %1');
		$this->assertEquals('untranslated message %2$s being downloaded from source %1$s', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->d_($domain, 'message %2 being downloaded from source %1');
		$this->assertEquals('ze zdroje %1$s se stahuje klientská zpráva %2$s', $translation);
	}

	public function testDn_() {
		$domain = 'client';
		$translation = self::$translator->dn_($domain, '%1 untranslated singular', '%1 untranslated plurals', 1);
		$this->assertEquals('%1$s untranslated singular', $translation);
		$translation = self::$translator->dn_($domain, '%1 untranslated singular', '%1 untranslated plurals', 2);
		$this->assertEquals('%1$s untranslated plurals', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dn_($domain, '%1 singular', '%1 plurals', 1);
		$this->assertEquals('%1$s klientské jednotné číslo', $translation);
		$translation = self::$translator->dn_($domain, '%1 singular', '%1 plurals', 2);
		$this->assertEquals('%1$s klientská množná čísla', $translation);
		$translation = self::$translator->dn_($domain, '%1 singular', '%1 plurals', 5);
		$this->assertEquals('%1$s klientských množných čísel', $translation);
	}

	public function testDnp_() {
		$domain = 'client';
		$translation = self::$translator->dnp_($domain, 'firstContext', '%1 untranslated singular', '%1 untranslated plurals', 1);
		$this->assertEquals('%1$s untranslated singular', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', '%1 untranslated singular', '%1 untranslated plurals', 2);
		$this->assertEquals('%1$s untranslated plurals', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dnp_($domain, 'firstContext', '%1 singular', '%1 plurals', 1);
		$this->assertEquals('%1$s klientské jednotné číslo s kontextem', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', '%1 singular', '%1 plurals', 2);
		$this->assertEquals('%1$s klientská množná čísla s kontextem', $translation);
		$translation = self::$translator->dnp_($domain, 'firstContext', '%1 singular', '%1 plurals', 5);
		$this->assertEquals('%1$s klientských množných čísel s kontextem', $translation);
	}

	public function testDp_() {
		$domain = 'client';
		$translation = self::$translator->dp_($domain, 'firstContext', 'untranslated message %2 being downloaded from source %1');
		$this->assertEquals('untranslated message %2$s being downloaded from source %1$s', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->dp_($domain, 'firstContext', 'message %2 being downloaded from source %1');
		$this->assertEquals('ze zdroje %1$s se stahuje klientská zpráva %2$s s kontextem', $translation);
	}

	public function testN_() {
		$translation = self::$translator->n_('%1 untranslated singular', '%1 untranslated plurals', 1);
		$this->assertEquals('%1$s untranslated singular', $translation);
		$translation = self::$translator->n_('%1 untranslated singular', '%1 untranslated plurals', 2);
		$this->assertEquals('%1$s untranslated plurals', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->n_('%1 singular', '%1 plurals', 1);
		$this->assertEquals('%1$s jednotné číslo', $translation);
		$translation = self::$translator->n_('%1 singular', '%1 plurals', 2);
		$this->assertEquals('%1$s množná čísla', $translation);
		$translation = self::$translator->n_('%1 singular', '%1 plurals', 5);
		$this->assertEquals('%1$s množných čísel', $translation);
	}

	public function testNp_() {
		$translation = self::$translator->np_('firstContext', '%1 untranslated singular', '%1 untranslated plurals', 1);
		$this->assertEquals('%1$s untranslated singular', $translation);
		$translation = self::$translator->np_('firstContext', '%1 untranslated singular', '%1 untranslated plurals', 2);
		$this->assertEquals('%1$s untranslated plurals', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->np_('firstContext', '%1 singular', '%1 plurals', 1);
		$this->assertEquals('%1$s jednotné číslo s kontextem', $translation);
		$translation = self::$translator->np_('firstContext', '%1 singular', '%1 plurals', 2);
		$this->assertEquals('%1$s množná čísla s kontextem', $translation);
		$translation = self::$translator->np_('firstContext', '%1 singular', '%1 plurals', 5);
		$this->assertEquals('%1$s množných čísel s kontextem', $translation);
	}

	public function testP_() {
		$translation = self::$translator->p_('firstContext', 'untranslated message %2 being downloaded from source %1');
		$this->assertEquals('untranslated message %2$s being downloaded from source %1$s', $translation);
		$this->setlocaleCs();
		$translation = self::$translator->p_('firstContext', 'message %2 being downloaded from source %1');
		$this->assertEquals('zpráva %2$s s kontextem se stahuje ze zdroje %1$s', $translation);
	}
}
