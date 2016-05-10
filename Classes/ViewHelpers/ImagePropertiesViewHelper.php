<?php
namespace Smichaelsen\RwdMedia\ViewHelpers;

use FluidTYPO3\Vhs\Utility\ResourceUtility;
use TYPO3\CMS\Core\Resource\FileReference as CoreFileReference;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ExtbaseFileReference;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;

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
     * @return array
     */
    public function render()
    {
        return static::renderStatic(
            $this->arguments,
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    static public function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $image = $renderChildrenClosure();
        $variables = $renderingContext->getTemplateVariableContainer();
        if ($variables->exists($arguments['as'])) {
            $variables->remove($arguments['as']);
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
            $variables->add($arguments['as'], $fileProperties);
        } else {
            $variables->add($arguments['as'], $image);
        }
    }

}
