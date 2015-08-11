<?php

namespace Sharkodlak\Libs\Gettext;


class Translator extends ATranslator {
    private $domains = array();


    public function __construct($defaultDir, array $domains = array('default'), $codeset = 'UTF-8') {
        foreach ($domains as $domain) {
            $dir = $defaultDir;

            if (!is_string($domain)) {
                if (isset($domain['dir'])) {
                    $dir = $domain['dir'];
                }

                $domain = $domain['domain'];
            }

            $this->setDomain($dir, $domain, $codeset);
        }

        textdomain($domain);
    }


    public function dgettext($domain, $message) {
        $text = dgettext($domain, $message);
        return $text;
    }

    public function dngettext($domain, $singular, $plural, $count) {
        return dngettext($domain, $singular, $plural, $count);
    }

    public function dnpgettext($domain, $context, $singular, $plural, $count) {
        return dnpgettext($domain, $context, $singular, $plural, $count);
    }

    public function dpgettext($domain, $context, $message) {
        return dpgettext($domain, $context, $message);
    }

    public function gettext($message) {
        $callback = function($translator, $domain) use ($message) {
            return $translator->dgettext($domain, $message);
        };
        return $this->searchForTranslationInAllDomains($message, $callback);
    }

    public function ngettext($singular, $plural, $count) {
        $callback = function($translator, $domain) use ($singular, $plural, $count) {
            return $translator->dngettext($domain, $singular, $plural, $count);
        };
        $message = $count == 1 ? $singular : $plural;
        return $this->searchForTranslationInAllDomains($message, $callback);
    }

    public function npgettext($context, $singular, $plural, $count) {
        $callback = function($translator, $domain) use ($context, $singular, $plural, $count) {
            return $translator->dnpgettext($domain, $context, $singular, $plural, $count);
        };
        $message = $count == 1 ? $singular : $plural;
        return $this->searchForTranslationInAllDomains($message, $callback);
    }

    public function pgettext($context, $message) {
        $callback = function($translator, $domain) use ($context, $message) {
            return $translator->dpgettext($domain, $context, $message);
        };
        return $this->searchForTranslationInAllDomains($message, $callback);
    }

    private function searchForTranslationInAllDomains($message, \Closure $callback) {
        foreach ($this->domains as $domain) {
            $translation = $callback($this, $domain);
            if ($translation !== $message) {
                return $translation;
            }
        }

        return $message;
    }

    /** Translates the given string.
     *
     * @deprecated
     **/
    public function translate($message, $count = NULL) {
        $callback = $this->translateGetCallback($message, $count);
        $translation = $this->searchForTranslationInAllDomains($message, $callback);
        $translation = $this->translationTrimContext($message, $translation);
        return $translation;
    }

    private function translateGetCallback($message, $count = NULL) {
        if (isset($count)) {
            $callback = function($translator, $domain) use ($message, $count) {
                $singular = $plural = $message;
                return $translator->dngettext($domain, $singular, $plural, $count);
            };
        } else {
            $callback = function($translator, $domain) use ($message) {
                return $translator->dgettext($domain, $message);
            };
        }

        return $callback;
    }

    private function translationTrimContext($message, $translation) {
        if ($message === $translation) {
            $matches = array();
            $eot = preg_match('~\x04|\\\\[x0]04~', $message, $matches, PREG_OFFSET_CAPTURE);

            if ($eot) {
                $translation = substr($message, strlen($matches[0][0]) + $matches[0][1]);
            }
        }

        return $translation;
    }

    final public function setDomain($dir, $domain, $codeset = 'UTF-8') {
        bindtextdomain($domain, $dir);
        bind_textdomain_codeset($domain, $codeset);
        $this->domains[] = $domain;
        return $this;
    }
}
