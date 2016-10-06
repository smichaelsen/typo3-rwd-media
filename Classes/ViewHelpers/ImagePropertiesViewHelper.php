<?php
namespace Smichaelsen\RwdMedia\ViewHelpers;

use FluidTYPO3\Vhs\Utility\ResourceUtility;
use TYPO3\CMS\Core\Resource\FileReference as CoreFileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

class ImagePropertiesViewHelper extends AbstractViewHelper
{

    /**
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        $this->registerArgument('as', 'string', 'variable name', TRUE);
    }

    /**
     *
     */
    public function render()
    {
        $image = $this->renderChildren();
        if ($this->templateVariableContainer->exists($this->arguments['as'])) {
            $this->templateVariableContainer->remove($this->arguments['as']);
        }
        if ($image instanceof ExtbaseFileReference) {
            $image = $image->getOriginalResource();
        } elseif (is_string($image) && strpos($image, ':') !== false) {
            $image = ResourceUtility::getFileArray(ResourceFactory::getInstance()->retrieveFileOrFolderObject($image));
        }
        if ($image instanceof CoreFileReference) {
            $file = $image->getOriginalFile();
            $fileReferenceProperties = $image->getProperties();
            $fileProperties = ResourceUtility::getFileArray($file);
            ArrayUtility::mergeRecursiveWithOverrule($fileProperties, $fileReferenceProperties, TRUE, false, false);
            $this->templateVariableContainer->add($this->arguments['as'], $fileProperties);
        } else {
            $this->templateVariableContainer->add($this->arguments['as'], $image);
        }
    }

}
