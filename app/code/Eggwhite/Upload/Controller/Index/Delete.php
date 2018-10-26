<?php
/**
 * Eggwhite_Upload extension
 *
 *
 * @category Eggwhite Cartupload
 * @package  Eggwhite_Upload
 * @author   D.V <Eggwhite Dev>
 */

namespace Eggwhite\Upload\Controller\Index;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_objectManager;
    protected $_filesystem;
    protected $file;
    
    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager,\Magento\Framework\Filesystem $filesystem,\Magento\Framework\Filesystem\Driver\File $file) 
    {
	$this->_file = $file;
        $this->_objectManager = $objectManager;
        $this->_filesystem = $filesystem;
        parent::__construct($context);    
    }

    public function execute()
    {
	$mediaDirectory = $this->_filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
	$mediaRootDir = $mediaDirectory->getAbsolutePath();
        $post = $this->getRequest()->getParam("id");
	$question = $this->_objectManager->create('Eggwhite\Upload\Model\Upload');
	$question->load($post);
	$this->_file->deleteFile($mediaRootDir.'upload/' . $question->getFilename());
	$question->delete();
	$this->messageManager->addSuccess(__('Selected file(s) have been deleted successfully.'));    
	$this->_redirect('checkout/cart');
    }
}
