<?php
/**
 * Created by: zhlhuang (364626853@qq.com)
 * Time: 2022/2/25 16:59
 * Blog: https://www.yuque.com/huangzhenlian
 */

declare(strict_types=1);

namespace App\Application\Geo\Service;

use App\Service\AbstractSettingService;

class GeoSettingService extends AbstractSettingService
{
    function getGeoSetting(string $key = '', $default = '')
    {
        return $this->getSettings('geo', $key, $default);
    }

    function setGeoSetting(array $setting): bool
    {
        return $this->saveSetting($setting, 'geo');
    }
}