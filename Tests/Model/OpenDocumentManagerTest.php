<?php

namespace Xaddax\OpenDocumentBundle\Tests\Model;

use Xaddax\OpenDocumentBundle\Model\OpenDocumentManager;
use \OpenDocument_Document_Text;
use \OpenDocument_Storage_Single;
use \OpenDocument_Storage_Zip;
use \OpenDocument_Exception;

class OpenDocumentManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $manager;

    public function setUp()
    {
        $this->manager = new OpenDocumentManager();
    }

    public function testCreateTextDocument()
    {
        //$odt = new OpenDocument_Document_Text(new OpenDocument_Storage_Zip());
        $od = $this->manager->create('text');
        $this->assertInstanceOf('OpenDocument_Document_Text', $od);
    }

    /**
     * @expectedException OpenDocument_Exception
     */
    public function testOpenAnOpenDocumentFileAndThrowAnExceptionBecauseItDoesNotExist()
    {
        $this->manager->open('luis');
    }

    public function testOpenAnExistingDocumentFile()
    {
        $odtCreated = $this->manager->create('text', 'luis.odt');

        $storage = $odtCreated->getStorage();
        $fileName = $storage->getFile();

        $odtOpened = $this->manager->open($fileName);
        $this->assertInstanceOf($odtOpened, $odtCreated);
    }

    public function testApplyChangesToOdt()
    {
        $this->markTestIncomplete('here incomplete');
        /*
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
        */
    }
}