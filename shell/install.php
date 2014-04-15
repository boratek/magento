<?php

define('BASEDIR', realpath(dirname(__FILE__) . '/../') . '/');
require_once(BASEDIR.'lib/Varien/Simplexml/Config.php');
require_once(BASEDIR.'lib/Varien/Simplexml/Element.php');

/**
 * Extensions Installer
 * Options:
 *   --clear       // clear all symlinks
 *   --no-fetch    // no fetch sub-repository (build only symlinks and skeleton)
 */
class Hatimeria_Magento_Installer 
{
    const DEFAULT_SCOPE = 'app/code/community';
    const REALDIR = 'lib';
    const CONFIG_XML_FILE = "shell/configuration.xml";
    
    protected $options;
    protected $arguments;
    protected $xmlConfig;
    protected $ignores;

    public function __construct($argc, $argv)
    {
        $this->ignores = array();
        $this->options = array();
        $this->arguments = array();
        $this->parseParams($argv);
    }


    public function run()
    {
        if ($this->hasOption('clear')) {
            // Clear all symlinks:
            system(sprintf("cd %s && find . -type l | xargs rm", BASEDIR));
        }

        $this->prepareBasics();

        if (!is_file(BASEDIR.self::CONFIG_XML_FILE)) {
            $this->out(self::CONFIG_XML_FILE . ' not found!');
        }
        
        if (!$this->hasArguments()) {
            foreach ($this->getXmlConfig() as $name => $config) {
                try {
                    $this->installExtension($name, $config);
                } catch (Exception $e) {
                    $this->out($e->getMessage());
                }
            }
        }
        else
        {
            $config = $this->getXmlConfig();
            foreach ($this->getArguments() as $arg) {
                if (isset($config[$arg])) {
                    try {
                        $this->installExtension($arg, $config[$arg]);
                    } catch (Exception $e) {
                        $this->out($e->getMessage());
                    }
                }
            }
        }
        
        $this->updateIgnores();
    }
    
    /**
     * Basic directories, environment
     */
    protected function prepareBasics()
    {
        $this->createDir('media');
        $this->createDir('var');
        $this->createDir(self::DEFAULT_SCOPE . '/Hatimeria');
        $this->createDir(self::REALDIR . '/Hatimeria');

        if (!is_file(BASEDIR.'index.php')) {
            copy(BASEDIR.'resources/skel/index.php', BASEDIR.'index.php');
            $this->out('index.php created.');
        }
        
        if (!is_file(BASEDIR.'.htaccess')) {
            copy(BASEDIR.'resources/skel/htaccess', BASEDIR.'.htaccess');
            $this->out('.htaccess created.');
        }
        
        copy(BASEDIR.'resources/skel/gitignore', BASEDIR.'.gitignore');
        $this->out('gitignore overwriten.');
    }
    
    /**
     * Installing one extension
     * 
     * @param string $id
     * @param array $config 
     */
    protected function installExtension($id, $config)
    {
        $path = $config['path'];
        $name = $config['name'];
        $git = $config['git'];
        $version = $config['version'];

        $dest = sprintf("%s/%s", self::REALDIR, $path); // eg: lib/Hatimeria/Fixtures

        echo PHP_EOL;
        if (!is_dir(BASEDIR.$dest)) {
            $this->out(sprintf('Installing <%s> to: %s', $name, $dest));
            system(sprintf("git clone %s %s", escapeshellarg($git), escapeshellarg(BASEDIR.$dest)));
        } else {
            $this->out(sprintf('Updating <%s>', $name));
        }

        $this->addIgnore('/'.$dest);

        if (!$this->hasOption('no-fetch')) {
            $this->updateRepository($dest, $version);
        }

        $extConfig = $this->getExtensionConfig($id);
        $me = $this;
        
        if (isset($extConfig['dirs'])) {
            foreach ($extConfig['dirs'] as $link) {
                $this->addResource($path, $link, function($ext, $path) use ($me) {
                    $me->createDir($path);
                });
            }
        }
        
        if (isset($extConfig['symlinks'])) {
            foreach ($extConfig['symlinks'] as $link) {
                $this->addResource($path, $link, function($ext, $path) use ($me) {
                    $me->createSymlink($ext, $path);
                });
            }
        }
        
        if (isset($extConfig['copies'])) {
            foreach ($extConfig['copies'] as $link) {
                $this->addResource($path, $link, function($ext, $path) use ($me) {
                    $me->copyResource($ext, $path);
                });
            }        
        }
        
        if (isset($extConfig['ignores'])) {
            foreach ($extConfig['ignores'] as $link) {
                $me->addIgnore('/'.$link['value']);
            }        
        }
    }

    /**
     * Download and reset only if 'no-fetch':
     *
     * @param $dest
     * @param $version
     */
    protected function updateRepository($dest, $version)
    {
        if (!$this->checkLocalChanges($dest)) {
            $this->out('LOCAL CHANGES DETECTED IN: ' . $dest . ' RESETTING SKIPPED.');

            return false;
        }

        // Fetch origin:
        system(sprintf('cd %s && git fetch origin', escapeshellarg(BASEDIR.$dest)));

        // Checkout to branch that we want reset to.
        if (strpos($version, '/') !== false) {
            list ($origin, $branch) = explode('/', $version);
            system(sprintf('cd %s && git checkout %s', escapeshellarg(BASEDIR.$dest), escapeshellarg($branch)));
        }

        system(sprintf('cd %s && git reset --hard %s', escapeshellarg(BASEDIR.$dest), escapeshellarg($version)));
    }
    
    /**
     * Extension config 
     * 
     * @param string $id e.g: "fixtures"
     */
    protected function getExtensionConfig($id)
    {
        $packagesConfig = $this->getXmlConfig();
        
        if (!isset($packagesConfig[$id])) {
            throw new Exception("Package {$id} not found!");
        }
        
        $config = $packagesConfig[$id];
        $path = $config['path'];
        
        // eg: (/home/user/workspace/magento/) (lib) (Hatimeria/Fixtures) (install.xml)
        $packageConfig = sprintf("%s/%s/install.xml", BASEDIR.self::REALDIR, $path);
        
        if (is_file($packageConfig)) {
            $data = array();
            $dom = new DOMDocument();
            $dom->loadXML(file_get_contents($packageConfig));
            $xpath = new DOMXPath($dom);
            $sections = $xpath->query('/config/*');
            
            foreach ($sections as $section) {
                /* @var $section DOMElement */
                if (!($section instanceof DOMElement)) {
                    continue;
                }
                $newData = array();
                foreach($section->getElementsByTagName('item') as $item) {
                    /* @var $item DOMElement */
                    $ignore = ($item->hasAttribute('ignore')) ? $item->getAttribute('ignore') : 'true' ;
                    $newData[] = array('value' => $item->nodeValue, 'ignore' => $ignore);
                }
                
                $data[$section->nodeName] = $newData;
            }
            
            return $data;
        }
        else {
            return null;
        }
    }
    
    /**
     * XML packages configuration
     * 
     * @return array
     */
    protected function getXmlConfig()
    {
        if (!isset($this->xmlConfig)) {
            $configuration = new Varien_Simplexml_Config(BASEDIR.'shell/configuration.xml');
            $node = $configuration->getNode();
            $this->xmlConfig = $node->asArray();
        }
        
        return $this->xmlConfig;
    }
    
    /**
     * Creates structure of options and arguments
     * 
     * @param array $params 
     */
    protected function parseParams($params)
    {
        array_shift($params);
        foreach ($params as $param) {
            if (strpos($param, '--') !== false) {
                $this->options[] = preg_replace("/^--/", '', $param);
            }
            else {
                $this->arguments[] = $param;
            }
        }
    }
    
    /**
     * Check if there is an argument
     * 
     * @param string $arg
     * @return bool
     */
    public function hasArgument($arg)
    {
        return in_array($arg, $this->arguments);
    }
    
    /**
     * Are there any arguments?
     * 
     * @return bool
     */
    public function hasArguments()
    {
        return count($this->arguments) > 0 ;
    }
    
    /**
     * Are there any options?
     * 
     * @param string $option
     * @return bool
     */
    public function hasOption($option)
    {
        return in_array($option, $this->options);
    }
    
    /**
     * List of arguments
     * 
     * @return array
     */
    protected function getArguments()
    {
        return $this->arguments;
    }
    
    /**
     * Output
     * 
     * @param string $str 
     */
    protected function out($str)
    {
        echo " - " . $str . PHP_EOL;
    }
    
    /**
     * Add to ignores
     * 
     * @param string $path 
     */
    protected function addIgnore($path)
    {
        if (!in_array($path, $this->ignores)) {
            $this->ignores[] = $path;
        }
    }
    
    /**
     * Update ignores
     */
    protected function updateIgnores()
    {
        file_put_contents(BASEDIR.'.gitignore', '# --GENERATED--'.PHP_EOL, FILE_APPEND);
        foreach ($this->ignores as $ignore) {
            file_put_contents(BASEDIR.'.gitignore', $ignore.PHP_EOL, FILE_APPEND);
        }
    }
    
    /**
     * Adds resource from configuration file 
     * 
     * @param string $extension  e.g: Hatimeria/Fixtures
     * @param string $path       e.g: app/locale/pl_PL/...
     * @param function $todo
     * @return 
     */
    public function addResource($extension, $item, $todo)
    {
        $todo($extension, $item['value']);
        
        if (in_array(trim($item['ignore']), array('yes', 'true', '1', 'on'))) {
            $this->addIgnore('/'.$item['value']);
        }
    }
    
    /**
     * Creates symlink
     * 
     * @param string $extension    e.g: Hatimeria/Fixtures
     * @param string $path         e.g: app/design/frontend/default/default/template/somedir
     */
    public function createSymlink($extension, $path)
    {
        $src = sprintf("%s/%s/%s", BASEDIR.self::REALDIR, $extension, $path);
        $dst = BASEDIR . $path;
        
        if (file_exists($dst)) {
            @unlink($dst);
        }

        $spath = substr($dst, 0, strrpos($dst,DIRECTORY_SEPARATOR));
        system( sprintf("mkdir -p %s", escapeshellarg( $spath )) );
        //$this->out(sprintf('Catalog path: <%s> created', $spath));
        system(sprintf("ln -s %s %s", escapeshellarg($src), escapeshellarg($dst)));
        $this->out(sprintf('Symlink: <%s> connected', $path));
    }
    
    /**
     * Copies recursively resource
     * 
     * @param string $extension
     * @param string $path 
     */
    public function copyResource($extension, $path)
    {
        $src = sprintf("%s/%s/%s", BASEDIR.self::REALDIR, $extension, $path);
        $dst = sprintf(BASEDIR.$path);
        
        if (!file_exists($dst)) {
            system(sprintf("cp -r %s %s", escapeshellarg($src), escapeshellarg($dst)));
            $this->out(sprintf('Resource copied to: <%s>', $path));
        }
        else {
            $this->out(sprintf('Resource <%s> allready exists. Omited.', $path));
        }
    }
    
    /**
     * Creates dir if not exists yet 
     * 
     * @param string $path
     */
    public function createDir($path)
    {
        if (is_dir(BASEDIR.$path)) {
            $this->out(sprintf('/%s directory exists.', $path));
        }
        else {
            mkdir(BASEDIR.$path, 0777, true);
            $this->out(sprintf('/%s directory created.', $path));
        }
    }

    /**
     * Check directory local changes
     *
     * @param $dest
     * @return bool
     */
    protected function checkLocalChanges($dest)
    {
        exec(sprintf('cd %s && git status --short', escapeshellarg(BASEDIR.$dest)), $outputLines);

        return count($outputLines) === 0 ;
    }
}


$installer = new Hatimeria_Magento_Installer($argc, $argv);
$installer->run();
