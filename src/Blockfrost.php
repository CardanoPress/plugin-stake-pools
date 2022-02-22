<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace PBWebDev\CardanoPress\StakePools;

use PBWebDev\CardanoPress\Blockfrost as BaseBlockfrost;

class Blockfrost extends BaseBlockfrost
{
    public function getPoolInfo(string $id): array
    {
        $response = $this->client->request('pools/' . $id);

        return 200 === $response['status_code'] ? $response['data'] : [];
    }
}
