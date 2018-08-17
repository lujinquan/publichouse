<?php
namespace app\ph\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;

/**
 * @title 使用权变更审核控制器
 * @author Mr.Lu
 * @description
 */
class LeaseAudit extends Base
{
    /**
     * @title 使用权变更审核主页
     * @author Mr.Lu
     * @description
     */
    public function index(){

        $data = model('ph/LeaseApply') -> get_all_lease_lst();

        //$leaseChanges = Db::name('use_change_type')->field('id, UseChangeTitle')->select();

        $this -> assign([    
            'leaseLst' => $data['arr'],
            'leaseLstObj' => $data['obj'],
            'leaseOption' => $data['option'],
            //'leaseChanges' => $
        ]);

        return $this->fetch();
    }

    
    /**
     * @title 查看明细
     * @author Mr.Lu
     * @description
     */
    public function detail(){

        $changeOrderID = input('ChangeOrderID'); //变更编号

        $res['detail'] = model('ph/LeaseAudit')->get_change_detail_info($changeOrderID);

        $res['config'] = model('ph/LeaseAudit')->process_status($changeOrderID);

        $res['urls'] = model('ph/LeaseAudit')->process_imgs_url($changeOrderID);

        $res['record'] = model('ph/LeaseAudit')->process_record($changeOrderID);

        return jsons('2000' ,'获取成功' ,$res);
    }

    /**
     * @title 审核(此处的审核有别与补充资料)
     * @author Mr.Lu
     * @description
     */
    public function process(){
   
        if($this->request->isPost()) {

            $data = $this->request->post();

            model('ph/LeaseAudit')->check_process($data['ChangeOrderID']);

            if(!isset($data['reson'])) $data['reson']='';
       
            $result = model('ph/LeaseAudit')->create_child_order($data['ChangeOrderID'], $data['reson']);

            if($result === true){

                return jsons('2000' ,'审核完成');
            }else{

                return jsons('4000' ,'审核异常');
            }
            
        }

    }

    /**
     * @title 租约打印
     * @author Mr.Lu
     * @description
     */
    public function leasePrint(){

        $ChangeOrderID = input('ChangeOrderID');

        model('ph/LeaseAudit')->check_process($ChangeOrderID);

        $findOne = Db::name('lease_change_order')->where('ChangeOrderID',$ChangeOrderID)->find();

        if($findOne['QrcodeUrl']){
            //删除过期的二维码
            @unlink($_SERVER['DOCUMENT_ROOT'].$findOne['QrcodeUrl']);
        }

        $re = Db::name('lease_change_order')->where('ChangeOrderID',$ChangeOrderID)->setInc('PrintTimes',1);

        $qrcodeUrl = model('ph/LeaseAudit')->qrcode();

        Db::name('lease_change_order')->where('ChangeOrderID',$ChangeOrderID)->update(['PrintTime'=>time(),'QrcodeUrl'=>$qrcodeUrl]);

        return $re?jsons('2000' ,'操作完成'):jsons('4000' ,'操作失败');

    }

    public function uploadSign(){

        if($this->request->isPost()) {

            $data = $this->request->post();

            $changeOrderID = $data['ChangeOrderID'];  //变更编号

            if(isset($_FILES) && $_FILES){ //由于目前前端的多文件上传一次只上传一个标题的多张图片，所以目前  $_FILES  只有一个元素，故 $ChangeImageIDS 只是一个字符串

                //在补充资料的时候，需要判断当前状态是否为补充资料阶段，即当前主订单的 Status == 2 ,如果不是，则返回提示信息不让补充
                $nowStatus = Db::name('use_change_order')->where('ChangeOrderID' ,'eq' ,$changeOrderID)->value('Status');
                if($nowStatus > 3 && $nowStatus <8){ return jsons('4001' ,'请注意检查当前流程状态');}
                foreach($_FILES as $k1 => $v1){
                    $ChangeImageIDS[] = model('ph/UserAudit') -> uploads($v1,$k1);
                }
                $ChangeImageIDS = implode(',', $ChangeImageIDS);  //返回的是使用权变更的影像资料id(多个以逗号隔开)
            }

            if(!isset($ChangeImageIDS)){
                return jsons('4001','请上传图片');
            }

            $oldChangeOrderID = Db::name('lease_change_order')->where('ChangeOrderID',$changeOrderID)->value('ChangeImageIDS');

            if($oldChangeOrderID){
                $newChangeOrderID = $oldChangeOrderID.','.$ChangeImageIDS;
            }else{
                $newChangeOrderID = $ChangeImageIDS;
            }

            $re = Db::name('lease_change_order')->where('ChangeOrderID',$changeOrderID)->setField('ChangeImageIDS',$newChangeOrderID);

            if($re){
                $result = model('ph/LeaseAudit')->create_child_order($data['ChangeOrderID'], '');
                return jsons('2000','上传成功');
            }else{
                return jsons('4000','上传失败');
            }


        }
    }
}