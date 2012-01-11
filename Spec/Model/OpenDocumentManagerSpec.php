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

    public function xitShouldCreateTextDocument()
    {
        //$odt = new OpenDocument_Document_Text(new OpenDocument_Storage_Zip());
        $this->manager->create('text')->should->be(1);
        $this->manager->text()->should->be(1);
    }

    public function xitShouldOpenAnOpenDocumentFile()
    {
        $this->manager->open('luis')->should->beFalse();
    }

    public function itShouldApplyChangesToODT()
    {
        // bring up
        $storage = new OpenDocument_Storage_Single();
        $storage->create('text');
        $od = new OpenDocument_Document_Text($storage);
        $p1 = $od->createParagraph('My test paragraph');
        $p1->createTextElement('Iam persona');

        // define changes
        $changes = array(
            'position' => '8',
            'stringToInsert' => 'istent ',
        );

        // call method and speck it
        $newOpenDocument = $this->manager->applyChanges($od, $changes);
        $newDOMContent = $newOpenDocument->getDOM('content');
        var_export($newDOMContent);
    }

}