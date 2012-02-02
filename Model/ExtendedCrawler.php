<?php
namespace Xaddax\OpenDocumentBundle\Model;

use Symfony\Component\DomCrawler\Crawler;

class ExtendedCrawler extends Crawler
{
    /**
     * @param $xpath
     * @param $namespace
     * @return Crawler
     */
    public function filterNSXPath($xpath, $namespace)
    {
        $document = new \DOMDocument('1.0', 'UTF-8');
        $root = $document->appendChild($document->createElement('_root'));
        foreach ($this as $node) {
            $root->appendChild($document->importNode($node, true));
        }

        $this->uri = 'dummy';
        $domxpath = new \DOMXPath($document);
        $domxpath->registerNameSpace('text', $namespace);
        return new static($domxpath->query($xpath), $this->uri);
    }
}
