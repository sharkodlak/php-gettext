<?php

namespace Sharkodlak\Libs\Gettext;


/** Adds sprintf dollar notation if it's missing.
 **/
class DollarTranslatorDecorator extends ATranslator {
    private $translator;


    static private function dollarReplace($message) {
        // Replace %1 with %1$s, which is acceptable by sprintf. Skip %%, and do not translate %0 (used in %0.2f)
        return \preg_replace("~(?<!%)((?:%{2})*)(%(?!0)\d+)(?!\\$)~", "$1$2\$s", $message);
    }


    public function __construct(ITranslator $translator) {
        $this->translator = $translator;
    }


    public function dgettext($domain, $message) {
        $message = $this->translator->dgettext($domain, $message);
        return self::dollarReplace($message);
    }

    public function dngettext($domain, $singular, $plural, $count) {
        $message = $this->translator->dngettext($domain, $singular, $plural, $count);
        return self::dollarReplace($message);
    }

    public function dnpgettext($domain, $context, $singular, $plural, $count) {
        $message = $this->translator->dnpgettext($domain, $context, $singular, $plural, $count);
        return self::dollarReplace($message);
    }

    public function dpgettext($domain, $context, $message) {
        $message = $this->translator->dpgettext($domain, $context, $message);
        return self::dollarReplace($message);
    }

    public function gettext($message) {
        $message = $this->translator->gettext($message);
        return self::dollarReplace($message);
    }

    public function ngettext($singular, $plural, $count) {
        $message = $this->translator->ngettext($singular, $plural, $count);
        return self::dollarReplace($message);
    }

    public function npgettext($context, $singular, $plural, $count) {
        $message = $this->translator->npgettext($context, $singular, $plural, $count);
        return self::dollarReplace($message);
    }

    public function pgettext($context, $message) {
        $message = $this->translator->pgettext($context, $message);
        return self::dollarReplace($message);
    }

    public function translate($message, $count = NULL) {
        $message = $this->translator->translate($message, $count);
        return self::dollarReplace($message);
    }
}
