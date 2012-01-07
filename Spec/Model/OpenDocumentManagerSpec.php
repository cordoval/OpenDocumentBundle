<?php

namespace Xaddax\OpenDocumentBundle\Spec\Model;

use Xaddax\OpenDocumentBundle\Model\OpenDocumentManager as OpenDocumentManager;
use \OpenDocument_Document_Text;
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
        $this->manager->create('text')->should->be(1);
        $this->manager->text()->should->be(1);
    }

    public function itShouldOpenAnOpenDocumentFile()
    {
        $this->manager->open('luis')->should->beFalse();
    }


}