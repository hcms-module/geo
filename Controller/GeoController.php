<?php

declare(strict_types=1);

namespace App\Application\Geo\Controller;

use App\Annotation\Api;
use App\Annotation\View;
use App\Application\Admin\Controller\AdminAbstractController;
use App\Application\Admin\Middleware\AdminMiddleware;
use App\Application\Geo\Model\GeoRegion;
use App\Application\Geo\Service\GeoSettingService;
use Hyperf\Database\Model\Relations\Relation;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Middleware(AdminMiddleware::class)]
#[Controller(prefix: "/geo/geo")]
class GeoController extends AdminAbstractController
{

    #[Inject]
    protected GeoSettingService $setting;

    /**
     * 组件获取省市信息
     */
    #[Api]
    #[GetMapping("/component/geo/region/city")]
    public function regionCity()
    {
        $lists = GeoRegion::where('p_code', 0)
            ->with([
                'children'
            ])
            ->orderBy('code', 'ASC')
            ->get();

        return compact('lists');
    }

    /**
     * 组件获取省市区信息
     */
    #[Api]
    #[GetMapping("/component/geo/region")]
    public function region()
    {
        $lists = GeoRegion::where('p_code', 0)
            ->with([
                'children' => function (Relation $relation) {
                    $relation->with(['children']);
                }
            ])
            ->orderBy('code', 'ASC')
            ->get();

        return compact('lists');
    }

    #[Api]
    #[GetMapping("setting")]
    public function settingInfo()
    {
        $setting = $this->setting->getGeoSetting();

        return compact('setting');
    }

    #[Api]
    #[PostMapping("setting")]
    public function settingSave()
    {
        $setting = $this->request->post('setting');
        $res = $this->setting->setGeoSetting($setting);

        return $res ? $this->returnSuccessJson() : $this->returnErrorJson();
    }

    #[View]
    #[GetMapping("")]
    public function index()
    {
    }
}
