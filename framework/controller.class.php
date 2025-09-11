<?php

class JLController
{
    private string $appName;

    public function __construct(string $appNameNew)
    {
        $this->setAppName($appNameNew);
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
        // Path based on admin or frontend
        $path = $admin ? SITE_PATH_ADMIN : SITE_PATH;

        // If no custom app given, use this controller’s app
        if (empty($appLoad)) {
            $appLoad = $this->appName;
        }

        $file = $path . '/app/app_' . $appLoad . '/' . $elementType . ucwords($elementName) . '.php';

        if (!file_exists($file)) {
            throw new RuntimeException("Element file not found: " . $file);
        }

        include_once $file;

        // If no custom name, fallback to element type/name
        if (empty($elementCustomName)) {
            $elementCustomName = $elementName ?: $elementType;
        }

        // Example: MyAppViewHome, MyAppModelUser
        $elementClassName = $appLoad . ucwords($elementType) . ucwords($elementName);

        if (!class_exists($elementClassName)) {
            throw new RuntimeException("Class $elementClassName not found in $file");
        }

        $this->{$elementCustomName} = new $elementClassName();
    }

    public function addView(string $viewName = '', string $viewCustomName = '', bool $admin = false, string $appLoad = ''): void
    {
        $this->addElement('view', $viewName, $viewCustomName, $admin, $appLoad);
    }

    public function addModel(string $modelName = '', string $modelCustomName = '', bool $admin = false, string $appLoad = ''): void
    {
        $this->addElement('model', $modelName, $modelCustomName, $admin, $appLoad);
    }
}
