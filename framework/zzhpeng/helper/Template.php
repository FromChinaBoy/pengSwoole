<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2019/2/11
 * Time: 3:20 PM
 */
namespace zzhpeng\helper;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use zzhpeng\core\Config;
use zzhpeng\core\Singleton;

class Template
{
    use Singleton;
    public $template;
    public function __construct()
    {
        $templateConfig = Config::get('template');
        $loader = new FilesystemLoader($templateConfig['path']);
        $this->template = new Environment($loader, array(
            'cache' => $templateConfig['cache'],
            'auto_reload' => true
        ));
    }

    public function clear()
    {
        if ($this->template) {
            $this->template->clearTemplateCache();
        }
    }
}