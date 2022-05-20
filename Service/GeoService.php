<?php
/**
 * Created by: zhlhuang (364626853@qq.com)
 * Time: 2022/5/18 16:15
 * Blog: https://www.yuque.com/huangzhenlian
 */

declare(strict_types=1);

namespace App\Application\Geo\Service;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Guzzle\ClientFactory;
use Hyperf\Utils\Codec\Json;

class GeoService
{
    /**
     * @Inject()
     */
    private ClientFactory $client_factory;

    /**
     * @Inject()
     */
    private GeoSettingService $service;

    /**
     * 根据经纬度返回地理位置信息
     *
     * @param float $longitude
     * @param float $latitude
     * @return array|mixed
     */
    function getInfoByLocation(float $longitude, float $latitude)
    {
        try {
            $key = $this->service->getGeoSetting('geo_qq_key', '');
            $url = "https://apis.map.qq.com/ws/geocoder/v1/?location={$latitude},{$longitude}&key={$key}";
            $client = $this->client_factory->create();
            $response = $client->get($url);

            $res = Json::decode($response->getBody()
                ->getContents(), true);

            return $res['result'] ?? [];
        } catch (\Throwable $exception) {
            return [];
        }
    }
}