<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"D:\phpStudy\WWW\gf/application/ph/view/ban_info/modify.html";i:1496291753;}*/ ?>
<form action="<?php echo url('BanInfo/add'); ?>" method="post" id="modifyForm" class="am-form" data-am-validator style="display:none;margin-top:1.6rem;">

	  <fieldset style="width:900px;">
		<!--<legend>添加楼栋</legend>-->
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">楼栋编号：</label>
			  <div class="am-u-md-8">
				<input type="text" name="BanID" id="doc-vld-email-2" placeholder="楼栋编号" required/>
			  </div>
			</div>

		
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-2" class="label_style">机构名称：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="TubulationID" id="doc-select-2" >

					<?php foreach($instLst as $k10 => $v10){ if($v10['level'] == 1){; ?>

					  <optgroup label="<?php echo $v10['Institution'] ;?>">

						  <?php  foreach($instLst as $k11 => $v11){  if($v11['pid'] == $v10['id']){; ?>

						  		<option value="<?php echo $v11['id']; ?>" ><?php echo $v11['Institution']; ?></option>

						  <?php }}; ?>

					  </optgroup>

					<?php }}; ?>


				</select>

			  </div>
			</div>

			<div class="am-form-group am-u-md-12">

				<label for="doc-vld-email-2" class="label_style">产权证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanPropertyID" id="doc-vld-email-3" placeholder="产权证号" required/>
				</div>

			</div>


			<div class="am-form-group am-u-md-12">

			  <label for="doc-select-4" class="label_style">完损等级：</label>
			  <div  class="am-u-md-8" style="float:left;">
				<select name="DamageGrade" id="doc-select-4" >

					<?php foreach($damaLst as $k2 =>$v2){;?>

					<option value="<?php echo $k2+1; ?>"><?php echo $v2['DamageGrade']; ?></option>

					<?php }; ?>

				</select>

			  </div>
			</div>
			
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">是否改造产：</label>-->
			  <!--<div class="am-u-md-8" style="float:left;">-->
				<!--<select name="StructureType" id="doc-select-8" >-->
						<!--<?php foreach($struLst as $k4 =>$v4){;?>-->
						<!--<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>-->
						<!--<?php }; ?>-->
				<!--</select>-->
			  <!--</div>-->
			<!--</div>-->

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">土地证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanLandID" id="doc-vld-email-3" placeholder="土地证号" required/>
				</div>
			</div>			
			<div class="am-form-group am-u-md-12">
				<label for="doc-vld-email-2" class="label_style">不动产证号：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanFreeholdID" id="doc-vld-email-3" placeholder="不动产证号" required/>
				</div>
			</div>	
				
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">总户数：</label>
				<div class="am-u-md-8">
					<input type="text" name="TotalHouseholds" id="doc-vld-email-3" placeholder="总户数" required/>
				</div>
			</div>	
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">影像资料：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="TotalHouseholds" id="doc-vld-email-3" placeholder="上传插件" required/>-->
				<!--</div>-->
			<!--</div>			-->
			<!--<div class="am-form-group am-u-md-12">-->
			  <!--<label for="doc-select-8" class="label_style">附属设施：</label>-->
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" name="TotalHouseholds" id="doc-vld-email-3" placeholder="做成多选按钮" required/>-->
				<!--</div>-->
			<!--</div>-->
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">是否历史优秀建筑：</label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="HistoryIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="HistoryIf"> 否
					</label>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">产权是否分割：</label>
			  <div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="CutIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="CutIf"> 否
					</label>
				</div>
			</div>			
		</div>
		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">

			  <label for="doc-select-5" class="label_style">产别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="OwnerType" id="doc-select-5" >

					<?php foreach($owerLst as $k3 =>$v3){;?>

					<option value="<?php echo $k3+1; ?>"><?php echo $v3['OwnerType']; ?></option>

					<?php }; ?>

				</select>

			  </div>
			</div>

			<div class="am-form-group am-u-md-12">

				<label for="doc-vld-email-2" class="label_style">建成年份：</label>
				<!--<div class="am-u-md-8">-->
					<!--<input type="text" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="选择年份" data-am-datepicker readonly/>-->
				<!--</div>-->
				<div class="am-u-md-8" data-am-validator>
					<input type="text" name="BanYear" id="doc-vld-email-10" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="建成年份" required/>
				</div>
				<!--<input type="text" class="am-u-md-8" data-am-datepicker="{format: 'yyyy ', viewMode: 'years', minViewMode: 'years'}" placeholder="日历组件" data-am-datepicker readonly/>-->

			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-7" class="label_style">使用性质：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="UseNature" id="doc-select-7" >
					<option value="1">住宅</option>
					<option value="2">企事业</option>
					<option value="3">机关</option>
				</select>
			  </div>
			</div>

			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">结构类别：</label>
			  <div class="am-u-md-8" style="float:left;">
				<select name="StructureType" id="doc-select-8" >
						<?php foreach($struLst as $k4 =>$v4){;?>
						<option value="<?php echo $k4+1; ?>"><?php echo $v4['StructureType']; ?></option>
						<?php }; ?>
				</select>
			  </div>
			</div>
			<!--新加-->
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">单元数量：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanUnitNum" id="doc-vld-email-2" placeholder="单元数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">楼层数量：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanFloorNum" id="doc-vld-email-2" placeholder="总楼层数量" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">起始楼层：</label>
				<div class="am-u-md-8">
					<input type="text" name="BanFloorStart" id="doc-vld-email-2" placeholder="起始楼层数" required/>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
				<label class="label_style">是否改造产： </label>
				<div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ReformIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ReformIf"> 否
					</label>
				</div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-select-8" class="label_style">是否文物保护单位：</label>
			  <div class="am-u-md-8">
					<label class="am-radio-inline">
						<input type="radio"  value="1" name="ProtectculturalIf" checked="checked" required> 是
					</label>
					<label class="am-radio-inline">
						<input type="radio" value="0" name="ProtectculturalIf"> 否
					</label>
				</div>
			</div>	
			
		</div>

		<hr class="am-u-md-12"/>



		
		<div class="am-u-md-6">
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-name-2" class="label_style">企业建面：</label>
			  <div class="am-u-md-8">
				<input type="text" name="EnterpriseArea" id="doc-vld-name-2" minlength="1" placeholder="输入企业建面" required/>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-email-2" class="label_style">机关建面：</label>
			  <div class="am-u-md-8">
				<input type="text" name="PartyArea" id="doc-vld-email-2" placeholder="机关建面" required/>
			  </div>
			</div>

			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-url-2" class="label_style">民用建面：</label>
			  <div class="am-u-md-8">
				<input type="text" name="CivilArea" id="doc-vld-url-2" placeholder="民用建面" required/>
			  </div>
			</div>
			
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">使用面积：</label>
			  <div class="am-u-md-8">
				<input type="text" class=""  id="doc-vld-age-2" placeholder="使用面积" required />
			  </div>
			</div>
			<div class="am-form-group am-u-md-12">
			  <label for="doc-vld-age-2" class="label_style">规定租金：</label>
			  <div class="am-u-md-8">
				<input type="text" class="" name="PreRent" id="doc-vld-age-2" placeholder="规定租金" required />
			  </div>
			</div>
		</div>
		<hr class="am-u-md-12"/>

		<!--<div class="am-form-group am-u-md-12 padding_left">-->
			<!--<label for="doc-vld-age-2" class="label_style" style="width:150px;">经纬度（地图接口）：</label>-->
			<!--<div class="am-u-md-5">-->
				<!--<input type="text" class=""  id="doc-vld-age-4" placeholder="规定租金" required />-->

			<!--</div>-->

			<!--<button style="padding-right:0.7rem" class="am-btn am-btn-default label_style" type="button">坐标拾取</button>-->

		<!--</div>-->


		<div class="am-form-group am-u-md-12 padding_left">
			<label for="doc-vld-age-2" class="label_style" >楼栋地址：</label>

			<div class="am-u-md-9">
				<input type="text" class="" name="BanAddress" id="doc-vld-age-1" placeholder="楼栋地址" required />
			</div>
		</div>
		<div class="am-form-group am-u-md-12 padding_left">
			<label for="doc-vld-age-2" class="label_style">产权来源：</label>
			<div class="am-u-md-9">
				<input type="text" class="" name="PropertySource" id="doc-vld-age-3" placeholder="产权来源" required />
			</div>
		</div>

		<hr class="am-u-md-12"/>
		
		<div class="am-form-group am-u-md-12 padding_left">
		  <label>拆迁状态： </label>
		  <label class="am-radio-inline">
			<input type="radio"  value="1" checked="checked" name="RemoveStatus" required> 未拆迁
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="2" name="RemoveStatus"> 已拆迁，未下基数
		  </label>
		  <label class="am-radio-inline">
			<input type="radio" value="3" name="RemoveStatus">已拆迁，下基数
		  </label>
		</div>
		<!--
		<hr class="am-u-md-12"/>
		<div class="am-form-group am-u-md-6">
			<div class="am-u-md-12">
				<label for="doc-vld-age-2" class="label_style">2010年前：</label>
				<div class="am-u-md-7">
					<input type="text" class=""  id="doc-vld-age-2" placeholder="" required />
				</div>
			</div>

			<div class="am-u-md-12">
				<label for="doc-vld-age-2" class="label_style">2010-2015：</label>
				<div class="am-u-md-7">
					<input type="text" class=""  id="doc-vld-age-12" placeholder="" required />
				</div>

			</div>

			<div class="am-u-md-12">
				<label for="doc-vld-age-2" class="label_style">2016年：</label>
				<div class="am-u-md-7">
					<input type="text" class=""  id="doc-vld-age-13" placeholder="" required />
				</div>

			</div>

			<div class="am-u-md-12">
				<label for="doc-vld-age-2" class="label_style">2017年：</label>
				<div class="am-u-md-7">
					<input type="text" class=""  id="doc-vld-age-14" placeholder="" required />
				</div>

			</div>
		</div>

		<div class="am-form-group am-u-md-6">
		  <label for="doc-vld-ta-2">欠租原因：</label>
		  <textarea style="height:115px;" id="doc-vld-ta-2" minlength="10" maxlength="100"></textarea>
		</div>
		-->
		<div class="am-u-md-12" style="text-align:center;margin-top:2rem;">
			<button class="am-btn am-btn-secondary btn_big" type="submit">提交</button>
		</div>
	  </fieldset>

  </form>
