<?php

namespace Xaddax\OpenDocumentBundle\Spec\Model;

use Xaddax\OpenDocumentBundle\Model\OpenDocumentManager as OpenDocumentManager;
use \OpenDocument_Document_Text;
use \OpenDocument_Storage_Single;
use \OpenDocument_Storage_Zip;

class DescribeOpenDocumentManager extends \PHPSpec\Context
{
    protected $manager;

    public function before()
    {
        $this->manager = $this->spec(new OpenDocumentManager());
    }

    public function itShouldCreateTextDocument()
    {
        //$odt = new OpenDocument_Document_Text(new OpenDocument_Storage_Zip());
        $this->manager->create('text')->should->beAnInstanceOf('OpenDocument_Document_Text');
    }

    public function itShouldOpenAnOpenDocumentFileAndThrowAnExceptionBecauseItDoesNotExist()
    {
        $manager = $this->manager;
        $this->spec(function() use ($manager) {
            $manager->open('luis');
        })->should->throwException('OpenDocument_Exception');

    }

    public function itShouldOpenAnExistingDocumentFile()
    {
        $this->pending('open/retrieve from phpcr repository an odm file');
    }

    public function itShouldApplyChangesToOdt()
    {
        // bring up
        $manager = new OpenDocumentManager();
        $od = $manager->create('text');
        $paragraph = $od->createParagraph('My test paragraph');
        $paragraph->createTextElement('Iam persona');

        // define changes
        $changes = array(
            'position' => '8',
            'stringToInsert' => 'istent ',
        );

        // call method and speck it
        $newOpenDocument = $this->manager->applyChanges($od, $changes);
        $newDOMContent = $newOpenDocument->getDOM('content');
        var_dump($newDOMContent->saveXML()->getAcutalValue());exit;
        $newDOMContent->saveXML()->should->containText('test');
    }

}