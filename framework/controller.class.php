<?php
declare(strict_types=1);

class JLController
{
    private string $appName;

    public function __construct(string $appNameNew)
    {
        $this->appName = $appNameNew;
    }

    public function setAppName(string $appNameNew): void
    {
        $this->appName = $appNameNew;
    }

    /**
     * Load an element (model, view, etc.)
     *
     * @param string $elementType model|view
     * @param string $elementName Example: "Toto" → loads "modelToto.php"
     * @param string $elementCustomName Optional alias name for this element
     * @param bool   $admin True = backend app, False = frontend app
     * @param string $appLoad Optional app name to load element from
     */
    public function addElement(
        string $elementType,
        string $elementName = '',
        string $elementCustomName = '',
        bool $admin = false,
        string $appLoad = ''
    ): void {
        $path = $admin ? SITE_PATH_ADMIN : SITE_PATH;

        // fallback to this controller’s app
        $appLoad = $appLoad ?: $this->appName;

        $file = sprintf(
            '%s/app/app_%s/%s%s.php',
            rtrim($path, '/'),
            $appLoad,
            $elementType,
            ucfirst($elementName)
        );

        if (!is_file($file)) {
            throw new RuntimeException("Element file not found: {$file}");
        }

        include_once $file;

        // fallback alias name
        $elementCustomName = $elementCustomName ?: ($elementName ?: $elementType);

        // Example: MyAppViewHome, MyAppModelUser
        $elementClassName = $appLoad . ucfirst($elementType) . ucfirst($elementName);

        if (!class_exists($elementClassName)) {
            throw new RuntimeException("Class {$elementClassName} not found in {$file}");
        }

        $this->{$elementCustomName} = new $elementClassName();
    }

    public function addView(
        string $viewName = '',
        string $viewCustomName = '',
        bool $admin = false,
        string $appLoad = ''
    ): void {
        $this->addElement('view', $viewName, $viewCustomName, $admin, $appLoad);
    }

    public function addModel(
        string $modelName = '',
        string $modelCustomName = '',
        bool $admin = false,
        string $appLoad = ''
    ): void {
        $this->addElement('model', $modelName, $modelCustomName, $admin, $appLoad);
    }
}
