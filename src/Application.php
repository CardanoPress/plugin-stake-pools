<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Foundation\AbstractApplication;
use CardanoPress\Traits\Configurable;
use CardanoPress\Traits\Enqueueable;
use CardanoPress\Traits\Instantiable;
use CardanoPress\Traits\Templatable;
use ThemePlate\Cache\CacheManager;
use ThemePlate\Process\Tasks;

class Application extends AbstractApplication
{
    use Configurable;
    use Enqueueable;
    use Instantiable;
    use Templatable;

    protected Tasks $tasks;
    protected CacheManager $cache;

    protected function initialize(): void
    {
        $this->setInstance($this);

        $path = plugin_dir_path($this->getPluginFile());
        $this->admin = new Admin($this->logger('admin'));
        $this->manifest = new Manifest($path . 'assets/dist', $this->getData('Version'));
        $this->templates = new Templates($path . 'templates');
        $tasks = new Tasks(Admin::OPTION_KEY);
        $this->cache = new CacheManager($tasks);

        $tasks->report([$this->logger('poolData'), 'info']);
    }

    public function setupHooks(): void
    {
        $this->admin->setupHooks();
        $this->manifest->setupHooks();
        $this->templates->setupHooks();

        add_action('cardanopress_loaded', [$this, 'init']);
    }

    public function init(): void
    {
    }

    public function isReady(): bool
    {
        $function = function_exists('cardanoPress');
        $namespace = 'PBWebDev\\CardanoPress\\';
        $blockfrost = class_exists($namespace . 'Blockfrost');

        return $function && $blockfrost;
    }

    public function getPoolData(int $postId): PoolData
    {
        return new PoolData($postId);
    }

    public function cacheManager(): CacheManager
    {
        return $this->cache;
    }
}
