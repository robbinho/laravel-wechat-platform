<?php

/*
 * This file is part of ibrand/laravel-wechat-platform.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Wechat\Platform\Http\Controllers;

use Exception;
use iBrand\Wechat\Platform\Services\PlatformService;

/**
 * 优惠券和除会员卡外其他卡券
 * Class CouponController.
 */
class CouponController extends Controller
{
    protected $platform;

    public function __construct(
        PlatformService $platformService
    ) {
        $this->platform = $platformService;
    }

    /**
     * 创建卡券.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function create()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $baseInfo = $data['base_info'];

        $especial = isset($data['especial']) ? $data['especial'] : [];

        $attributes = array_merge(['base_info' => $baseInfo], $especial);

        //调用接口
        $result = $server->card->create($data['type'], $attributes);

        //返回json
        return $result;
    }

    /**
     * 创建货架.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function createLandingPage()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->createLandingPage($data['banner'], $data['page_title'], $data['can_share'], $data['scene'], $data['card_list']);

        //返回json
        return $result;
    }

    /**
     * 获取卡券颜色.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getColors()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->colors();

        return $result;
    }

    /**
     * 设置测试白名单.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function setTestWhitelist()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->setTestWhitelist($data['openids']);

        return $result;
    }

    /**
     * 创建二维码
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function QRCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->createQrCode($data['cards']);

        return $result;
    }

    /**
     * ticket 换取二维码链接.
     *
     * @return string
     *
     * @throws Exception
     */
    public function getQrCodeUrl()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->getQrCodeUrl($data['ticket']);

        return $result;
    }

    /**
     * 查看卡券详情.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getInfo()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        //调用接口
        $result = $server->card->get($data['card_id']);

        return $result;
    }

    /**
     * 更改卡券信息.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function update()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        $baseInfo = $data['base_info'];

        $especial = isset($data['especial']) ? $data['especial'] : [];

        $attributes = array_merge(['base_info' => $baseInfo], $especial);

        //调用接口
        $result = $server->card->update($data['card_id'], strtolower($data['type']), $attributes);

        return $result;
    }

    /**
     * 更改卡券库存接口.
     *
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws Exception
     */
    public function updateQuantity()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        if ($data['amount'] >= 0) {
            // 增加库存
            $result = $server->card->increaseStock($data['card_id'], $data['amount']);
        }

        if ($data['amount'] < 0) {
            // // 减少库存
            $result = $server->card->reductStock($data['card_id'], $data['amount']);
        }

        // 返回json
        return $result;
    }

    /**
     * 设置卡券失效.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function disable()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->code->disable($data['code'], $data['card_id']);

        // 返回json
        return $result;
    }

    /**
     * 删除卡券.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function delete()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->delete($data['card_id']);

        // 返回json
        return $result;
    }

    /**
     * 查询code.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->code->get($data['code'], $data['card_id'], false);

        // 返回json
        return $result;
    }

    /**
     * 核销Code.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function consumeCode()
    {
        // 参数
        $appid = request('appid');

        $data = request()->json()->all();

        // 授权
        $server = $this->platform->authorizeAPI($appid);

        // 调用接口
        $result = $server->card->code->consume($data['code'], $data['card_id']);

        // 返回json
        return $result;
    }
}
