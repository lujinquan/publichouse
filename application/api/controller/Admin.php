<?php

namespace app\api\controller;

use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
use think\Db;
use think\Debug;

/**
 * @title 房管员版的
 * @author Mr.Lu
 * @description
 */
class Admin extends Controller
{

    /**
     * 小程序主页接口【公告、应缴金额、已缴金额】
     */
    public function index()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }

            $notices = Db::name('notice')->field('id, Title,UpdateTime')->order('UpdateTime desc')->limit(10)->select();

            foreach ($notices as &$v) {
                $v['UpdateTime'] = date('Y/m/d', strtotime($v['UpdateTime']));
            }

            $result['notices'] = $notices;
            $result['rents'] = Db::name('rent_order')->where(['OrderDate' => date('Ym', time()), 'InstitutionID' => $findOne['InstitutionID']])->field('sum(ReceiveRent) as ReceiveRents, sum(PaidRent) as PaidRents')->find();
            return jsons('2000', '获取成功', $result);

        }
    }

    /**
     * 小程序获取单条公告详情的接口
     */
    public function noticeInfo()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }

            $notice = Db::name('notice')->where('id', $data['id'])->field('id, Title, UpdateTime, Content, Name')->find();

            if ($notice) {
                return jsons('2000', '获取成功', $notice);
            } else {
                return jsons('4005', '获取失败');
            }
        }
    }

    /**
     * 获取订单列表
     */
    public function orderList()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'OrderDate' => date('Ym', time()),
                'InstitutionID' => $findOne['InstitutionID'],
                'Type' => 1, //订单生成状态
            ];
            if (isset($data['TenantName']) && $data['TenantName']) {
                $where['TenantName'] = array('like','%'.$data['TenantName'].'%');
            }
            $rentList = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, OrderDate, ReceiveRent ,TenantName')
                ->paginate(config('paginate.list_rows'))
                ->toArray();

            foreach ($rentList['data'] as &$v) {
                $v['OrderDate'] = substr($v['OrderDate'], 0, 4) . '年' . substr($v['OrderDate'], 4, 2) . '月';
            }

            $rentList['total_page'] = ceil($rentList['total'] / $rentList['per_page']);
            return jsons('2000', '获取成功', $rentList);

        }
    }

    /**
     * 小程序支付页面生成二维码
     */
    public function nativeapi()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'InstitutionID' => $findOne['InstitutionID'],
                'RentOrderID' => $data['RentOrderID'],
                'Type' => 1,
            ];

            $orderInfo = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, TenantName, OrderDate, ReceiveRent')
                ->find();

            if (!$orderInfo) {
                return jsons('4005', '未知错误');
            }
            //halt($orderInfo);
            Loader::import('wxpay.WxPayNativePay', EXTEND_PATH);
            Loader::import('wxpay.log', EXTEND_PATH);

            $notify = new \NativePay();

            //模式二
            /**
             * 流程：
             * 1、调用统一下单，取得code_url，生成二维码
             * 2、用户扫描二维码，进行支付
             * 3、支付完成之后，微信服务器会通知支付成功
             * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
             */
            $wxPayConfig = new \WxPayConfig();
            $out_trade_no = $wxPayConfig::MCHID . date("YmdHis");
            $input = new \WxPayUnifiedOrder();
            $input->SetBody($orderInfo['TenantName']);
            $input->SetAttach($orderInfo['RentOrderID']); //自定义订单号参数
            $input->SetOut_trade_no($out_trade_no);
            $input->SetTotal_fee($orderInfo['ReceiveRent'] * 100); //以1分钱为单位
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600)); //设置二维码过期时间10分钟
            $input->SetGoods_tag("goods_tag"); //设置商品标识
            $input->SetNotify_url("https://ph.ctnmit.com/api/Admin/orderQuery"); //设置回调地址
            $input->SetTrade_type("NATIVE");
            $input->SetProduct_id("123456789");

            $result = $notify->GetPayUrl($input);

            if (isset($result["code_url"])) {
                jsons('2000', '获取成功', ['url' => $result["code_url"], 'out_trade_no' => $out_trade_no, 'orderInfo' => $orderInfo]);
            } else {
                jsons('4000', '获取失败');
            }
        }
    }

    /**
     * 小程序订单支付状态查询功能【前端采用定时器访问该接口】
     */
    public function orderQuery()
    {
        Loader::import('wxpay.lib.WxPayApi', EXTEND_PATH);
        Loader::import('wxpay.log', EXTEND_PATH);

        $WxPayApi = new \WxPayApi();

        //用微信订单号来查询订单支付状态【暂时不用】
        if (isset($_REQUEST["transaction_id"]) && $_REQUEST["transaction_id"] != "") {
            $transaction_id = $_REQUEST["transaction_id"];
            $input = new \WxPayOrderQuery();
            $input->SetTransaction_id($transaction_id);
            //printf_info(WxPayApi::orderQuery($input));
            $result = $WxPayApi::orderQuery($input);
            echo $result['trade_state'];
            exit();
        }

        //用商户订单号来查询订单支付状态
        if (isset($_REQUEST["out_trade_no"]) && $_REQUEST["out_trade_no"] != "") {
            $out_trade_no = $_REQUEST["out_trade_no"];
            $input = new \WxPayOrderQuery();
            $input->SetOut_trade_no($out_trade_no);
            //printf_info(WxPayApi::orderQuery($input));
            $result = $WxPayApi::orderQuery($input);
            if ($result['trade_state'] == 'SUCCESS') {

                $type = Db::name('rent_order')->where('RentOrderID', $result['attach'])->value('Type');
                if ($type == 1) { //改变订单状态
                    $res = [
                        'PaidableTime' => strtotime($result['time_end']), //交易时间
                        'OpenID' => $result['openid'], //用户微信在商户中的唯一openid
                        'OutTradeNo' => $result['out_trade_no'], //商户订单号
                        'TransactionID' => $result['transaction_id'], //微信订单号
                        'PaidRent' => $result['total_fee'] / 100, //已支付
                        'UnpaidRent' => 0, //未支付
                        'Type' => 3, //修改状态为已支付状态
                    ];
                    Db::name('rent_order')->where('RentOrderID', $result['attach'])->update($res);
                }
            }
            return jsons('2000', '获取成功', ['trade_state' => $result['trade_state']]);
        }
    }

    /**
     * 小程序已缴且未打票的订单列表
     */
    public function orderNoTicketList()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
            $where = [
                'OrderDate' => date('Ym', time()),
                'InstitutionID' => $findOne['InstitutionID'],
                'IfBatchSign' => 0, //未打印订单
                'Type' => 3, //已缴费状态
            ];
            $rentList = Db::name('rent_order')->where($where)
                ->field('RentOrderID, BanAddress, OrderDate, ReceiveRent ,TenantName')
                ->paginate(config('paginate.list_rows'))
                ->toArray();

            foreach ($rentList['data'] as &$v) {
                $v['OrderDate'] = substr($v['OrderDate'], 0, 4) . '年' . substr($v['OrderDate'], 4, 2) . '月';
            }

            $rentList['total_page'] = ceil($rentList['total'] / $rentList['per_page']);
            return jsons('2000', '获取成功', $rentList);

        }
    }

    /**
     * 小程序订单打印详情信息
     */
    public function orderTicketInfo()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
        }
        $where = [
            'InstitutionID' => $findOne['InstitutionID'],
            'RentOrderID' => $data['RentOrderID'],
            'IfBatchSign' => 0,
            'Type' => 3,
        ];

        $orderInfo = Db::name('rent_order')->where($where)
            ->field('RentOrderID, BanAddress, TenantName, OrderDate, ReceiveRent')
            ->find();

        if ($orderInfo) {
            return jsons('2000', '获取成功', $orderInfo);
        } else {
            return jsons('4005', '订单信息有误');
        }

    }

    /**
     * 小程序订单打票返回标识接口
     */
    public function orderTicketChange()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!isset($data['number'])) {
                return jsons('4001', '参数错误');
            } else {
                $findOne = Db::name('admin_user')->where('Number', $data['number'])->field('InstitutionID,Role')->find();
                if (!$findOne) {
                    return jsons('4002', '用户不存在');
                }
                if ($findOne['InstitutionID'] < 4) {
                    return jsons('4003', '该用户不是房管员用户');
                }
            }
        }
        $where = [
            'InstitutionID' => $findOne['InstitutionID'],
            'RentOrderID' => $data['RentOrderID'],
            'Type' => 3,
        ];

        $flag = Db::name('rent_order')->where($where)->setField('IfBatchSign', 1);

        if ($flag) {
            return jsons('2000', '标记打印成功');
        } else {
            return jsons('4000', '标记打印失败');
        }
    }


}