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
        add_shortcode('cp-stakes-pool_template', [$this, 'doTemplate']);
        add_shortcode('cp-stakes-pool_data', [$this, 'doData']);
    }

    public function doTemplate(array $attributes): string
    {
        $args = shortcode_atts([
            'name' => '',
            'variables' => [],
            'if' => '',
        ], $attributes);

        if (empty($args['name'])) {
            return '';
        }

        if (isset($attributes['variables'])) {
            parse_str(str_replace('&amp;', '&', $args['variables']), $args['variables']);
        }

        ob_start();
        $this->application->template($args['name'], $args['variables']);

        $html = ob_get_clean();

        if (empty($args['if'])) {
            return $html;
        }

        return '<template x-if="' . $args['if'] . '">' . $html . '</template>';
    }

    public function doData(array $attributes): string
    {
        $args = shortcode_atts([
            'key' => '',
            'id' => '',
        ], $attributes);

        if (empty($args['id'])) {
            $args['id'] = get_the_ID();
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
