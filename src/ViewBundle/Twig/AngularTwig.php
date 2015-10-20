<?php
namespace ViewBundle\Twig;

class AngularTwig extends \Twig_Extension
{

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('ng', [$this, 'getNgVariable']),
        ];
    }

    public function getNgVariable($variable)
    {
        return '{{ ' . $variable . ' }}';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'angular-twig';
    }
}
