<?php
namespace Smichaelsen\RwdMedia\ViewHelpers;

use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class FileStringToObjectViewHelper extends AbstractViewHelper implements CompilableInterface
{

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
     * @return FileInterface
     */
    static public function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $fileString = $renderChildrenClosure();
        if ($fileString instanceof FileInterface) {
            return $fileString;
        }
        return ResourceFactory::getInstance()->retrieveFileOrFolderObject($fileString);
    }

}
