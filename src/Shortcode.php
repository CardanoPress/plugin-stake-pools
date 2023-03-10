<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use CardanoPress\Interfaces\HookInterface;

class Shortcode implements HookInterface
{
    protected Application $application;

    public function __construct()
    {
        $this->application = Application::getInstance();
    }

    public function setupHooks(): void
    {
        add_shortcode('cp-stakes-pool', [$this, 'doData']);
    }

    public function doData(array $attributes): string
    {
        $args = shortcode_atts([
            'id' => '',
            'key' => '',
        ], $attributes);

        if (empty($args['id'])) {
            return '';
        }

        $pool = $this->application->getPoolData($args['id']);
        $value = $pool->toArray();

        return $this->printOutput($value, $args['key']);
    }

    private function printOutput($value, string $sub = '')
    {
        if (is_array($value)) {
            $value = empty($sub) ? $value : $value[$sub] ?? '';

            return $this->getString($value);
        }

        return $value;
    }

    private function getString($value): string
    {
        return is_array($value) ? json_encode($value) : $value;
    }
}
